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
                        data-prepare-pdf-url="{{ route('ai.check.prepare-pdf') }}"
                        x-data="{
                            fileName: '',
                            submitting: false,
                            phase: 'analysis',
                            errorDetails: @js($errorDetails ?? ''),
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
                                    this.phase = 'pdf';
                                    const r2 = await fetch(form.dataset.preparePdfUrl, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': form.querySelector('[name=_token]').value, 'Content-Type': 'application/json' } });
                                    const data2 = await r2.json().catch(() => ({}));
                                    if (!r2.ok) { this.errorDetails = data2.error || 'Ошибка генерации PDF'; this.submitting = false; return; }
                                    if (data2.success === false) { this.errorDetails = data2.error || 'Ошибка'; this.submitting = false; return; }
                                    window.location.reload();
                                } catch (err) {
                                    this.errorDetails = err.message || 'Ошибка сети';
                                    this.submitting = false;
                                }
                            }
                        }"
                        @submit.prevent="runCheck($event)"
                    >
                        @csrf

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

                        {{-- Ошибка от n8n/запроса (сервер и AJAX) --}}
                        <div
                            x-cloak
                            x-show="errorDetails"
                            class="mb-4 rounded-2xl bg-white/10 p-4 text-white"
                        >
                            <div class="font-semibold mb-2">Ошибка обработки:</div>
                            <div class="text-sm text-white/90 whitespace-pre-wrap" x-text="errorDetails"></div>
                        </div>

                        {{-- Результат: ссылка на PDF и кнопка удаления отчёта --}}
                        @if(!empty($conclusion))
                            <div class="my-[30px] w-full">
                                <div class="flex items-center gap-3 justify-between flex-wrap">
                                    <a
                                        href="{{ route('ai.check.pdf') }}"
                                        class="flex-1 min-w-0 text-center rounded-full bg-[var(--color-halftone)] px-5 py-3 font-semibold text-[var(--color-main)]"
                                    >
                                        Скачать заключение (PDF)
                                    </a>
                                    <a
                                        href="{{ route('ai.check.clear') }}"
                                        class="shrink-0 w-10 h-10 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 text-white transition"
                                        title="Удалить отчёт"
                                        aria-label="Удалить отчёт"
                                    >
                                        <span class="text-lg leading-none">×</span>
                                    </a>
                                </div>
                            </div>
                        @endif

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
                                Поддерживаемый формат документа: <span class="font-semibold">.txt</span>,
                                допустимый размер до <span class="font-medium">10 МБ</span>
                            </p>

                            <div class="mt-4">
                                <input
                                    id="doc"
                                    type="file"
                                    name="document"
                                    accept=".txt,text/plain"
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
                                    <span class="block text-sm truncate" x-text="fileName || 'Загрузите TXT файл для проверки'"></span>
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
