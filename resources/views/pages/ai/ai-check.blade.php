@extends('layouts.public', ['kzLink' => 'ai-check/', 'ruLink' => 'ai-check/', 'enLink' => 'ai-check/'])

@section('content')
    <div class="container mx-auto px-4 bg-white py-14">
        <div class="max-w-[760px] mx-auto">
            <div class="bg-[var(--color-main)] rounded-[40px] px-8 py-10 md:px-12 md:py-12 shadow-xl">

                <div class="text-center">
                    <h1 class="text-[26px] md:text-xl leading-tight text-white font-semibold">
                        {{ __('public.checking_compiled_test_tasks_using_ai') }}
                    </h1>

                    <div class="mt-6 h-[2px] w-full bg-white/60 rounded-full"></div>
                </div>

                <div class="mt-[30px]">
                    <form
                        action="{{ route('ai.check.submit') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        x-data="{
                            fileName: '',
                            submitting: false,
                            phase: 'analysis',
                            jobId: null,
                            toastVisible: false,
                            resultUrl: '',
                            errorDetails: @js($errorDetails ?? ''),
                            statusUrlTemplate: @js(route('ai.check.status', ['job' => '__JOB__'])),
                            resultUrlTemplate: @js(route('ai.check.result', ['job' => '__JOB__'])),
                            async pollStatus() {
                                if (!this.jobId) return;
                                try {
                                    const url = this.statusUrlTemplate.replace('__JOB__', this.jobId);
                                    const r = await fetch(url, { headers: { 'Accept': 'application/json' } });
                                    const data = await r.json().catch(() => ({}));
                                    if (!r.ok) {
                                        this.errorDetails = data.message || data.error || 'Ошибка при проверке статуса';
                                        this.submitting = false;
                                        return;
                                    }
                                    if (data.status === 'done' && data.has_result) {
                                        this.submitting = false;
                                        this.toastVisible = true;
                                        this.resultUrl = this.resultUrlTemplate.replace('__JOB__', this.jobId);
                                        return;
                                    }
                                    if (data.status === 'failed') {
                                        this.submitting = false;
                                        this.errorDetails = data.error_message || 'Ошибка обработки';
                                        return;
                                    }
                                    // пока не готово — повторим запрос через несколько секунд
                                    setTimeout(() => this.pollStatus(), 8000);
                                } catch (err) {
                                    this.errorDetails = err.message || 'Ошибка сети при проверке статуса';
                                    this.submitting = false;
                                }
                            },
                            async runCheck(e) {
                                const form = e.target;
                                if (!form.document?.files?.length) { this.errorDetails = 'Выберите файл'; return; }
                                this.submitting = true;
                                this.phase = 'analysis';
                                this.errorDetails = '';
                                try {
                                    const r = await fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
                                    const data = await r.json().catch(() => ({}));
                                    if (!r.ok) { this.errorDetails = data.message || data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : '') || 'Ошибка'; this.submitting = false; return; }
                                    if (data.success === false) { this.errorDetails = data.error || 'Ошибка'; this.submitting = false; return; }
                                    if (!data.job_id) { this.errorDetails = 'Не удалось создать задачу проверки'; this.submitting = false; return; }
                                    this.jobId = data.job_id;
                                    this.phase = 'analysis';
                                    this.pollStatus();
                                } catch (err) {
                                    this.errorDetails = err.message || 'Ошибка сети';
                                    this.submitting = false;
                                }
                            }
                        }"
                        @submit.prevent="runCheck($event)"
                    >
                        @csrf

                        {{-- Toast о готовности результата --}}
                        <div
                            x-cloak
                            x-show="toastVisible"
                            class="mb-4 rounded-2xl bg-white text-[var(--color-main)] p-4 shadow-lg"
                        >
                            <div class="font-semibold mb-2">Проверка завершена</div>
                            <div class="text-sm mb-3">
                                Результат проверки готов. Вы можете просмотреть текст заключения и скачать PDF.
                            </div>
                            <a
                                :href="resultUrl"
                                class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-semibold bg-[var(--color-main)] text-white hover:bg-[var(--color-extra)] transition"
                            >
                                Перейти к результату
                            </a>
                        </div>

                        {{-- Ошибки валидации --}}
                        @if ($errors->any())
                            <div class="mb-4 rounded-2xl bg-white/10 p-4 text-white">
                                <div class="font-semibold mb-2">Проверьте файл:</div>
                                <ul class="list-disc pl-5 text-sm text-white/90">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            {{-- Ошибка от сервиса проверки (сервер и AJAX) --}}
                        <div
                            x-cloak
                            x-show="errorDetails"
                            class="mb-4 rounded-2xl bg-white/10 p-4 text-white"
                        >
                            <div class="font-semibold mb-2">Ошибка обработки:</div>
                            <div class="text-sm text-white/90 whitespace-pre-wrap" x-text="errorDetails"></div>
                        </div>

                        {{-- Спиннер: «Идёт анализ…» затем «Генерация отчёта» --}}
                        <div
                            x-cloak
                            x-show="submitting"
                            class="mb-6 rounded-2xl bg-white/10 p-4 text-white"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></div>
                                <div>
                                    <div class="font-semibold" x-text="phase === 'analysis' ? 'Идёт анализ…' : 'Генерация отчёта'"></div>
                                    <div class="text-sm text-white/80">Не закрывайте окно и не обновляйте страницу, пока
                                        не получите результат.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <p class="text-white/70 text-sm">
                                Поддерживаемые форматы документа:
                                <span class="font-semibold">.doc</span> и
                                <span class="font-semibold">.docx</span>,
                                допустимый размер до <span class="font-medium">50 МБ</span>
                            </p>

                            <div class="mt-4">
                                <input
                                    id="doc"
                                    type="file"
                                    name="document"
                                    accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    class="hidden"
                                    @change="fileName = $event.target.files?.[0]?.name || ''"
                                    required
                                />

                                <label
                                    for="doc"
                                    class="block w-full cursor-pointer select-none rounded-full
                                       bg-[var(--color-extra)]
                                       py-[12px]
                                       text-center text-lg font-medium
                                       text-[var(--color-halftone)]
                                       transition"
                                    :class="submitting ? 'opacity-60 cursor-not-allowed' : ''"
                                >
                                    <span
                                        class="block text-sm truncate"
                                        x-text="fileName || 'Загрузите DOC или DOCX файл для проверки'"
                                    ></span>
                                </label>
                            </div>

                            <div class="mt-[30px]">
                                <button
                                    type="submit"
                                    class="w-full rounded-full
                                           bg-[var(--color-halftone)] hover:bg-[var(--color-extra)]
                                           px-6 py-4 md:py-5
                                           text-[18px] md:text-[20px] font-semibold
                                           text-[var(--color-main)]
                                           transition"
                                    :disabled="submitting"
                                    :class="submitting ? 'opacity-60 cursor-not-allowed' : ''"
                                >
                                    <span x-show="!submitting">Отправить на проверку</span>
                                    <span x-cloak x-show="submitting">Отправлено… ожидаем результат</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
