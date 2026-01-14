@extends('layouts.public', ['kzLink' => 'ai-check/', 'ruLink' => 'ai-check/', 'enLink' => 'ai-check/'])

@section('content')
    <div class="container mx-auto px-4 bg-white py-14">
        <div class="max-w-[760px] mx-auto">
            <div class="bg-[var(--color-main)] rounded-[40px] px-8 py-10 md:px-12 md:py-12 shadow-xl">

                <div class="text-center">
                    <h1 class="text-[26px] md:text-xl leading-tight text-white font-semibold">
                        Проверка составленных тестовых заданий<br class="hidden md:block">
                        с помощью AI
                    </h1>

                    <div class="mt-6 h-[2px] w-full bg-white/60 rounded-full"></div>
                </div>

                <div class="mt-[30px]">
                    <form
                        action="{{ route('ai.check.submit') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        x-data="{ fileName: '', submitting: false }"
                        @submit="submitting = true"
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

                        {{-- Ошибка от n8n/запроса --}}
                        @if(!empty($errorDetails))
                            <div class="mb-4 rounded-2xl bg-white/10 p-4 text-white">
                                <div class="font-semibold mb-2">Ошибка обработки:</div>
                                <div class="text-sm text-white/90 whitespace-pre-wrap">{{ $errorDetails }}</div>
                            </div>
                        @endif

                        {{-- Результат --}}
                        @if(!empty($conclusion))
{{--                            <div class="mb-6 rounded-2xl bg-white p-5">--}}
{{--                                <div class="text-[var(--color-main)] font-semibold text-lg mb-2">Заключение</div>--}}
{{--                                <div class="text-sm text-gray-800 whitespace-pre-wrap">{{ $conclusion }}</div>--}}
{{--                            </div>--}}

                            <div class="my-[30px] w-full">
                                <a
                                    href="{{ route('ai.check.pdf') }}"
                                    class="block text-center rounded-full bg-[var(--color-halftone)] px-5 py-3 font-semibold text-[var(--color-main)]"
                                >
                                    Скачать заключение (PDF)
                                </a>
                            </div>

                        @endif

                        {{-- Спиннер/оверлей: показывается сразу после submit, пока сервер отвечает --}}
                        <div
                            x-cloak
                            x-show="submitting"
                            class="mb-6 rounded-2xl bg-white/10 p-4 text-white"
                        >
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 border-2 border-white/40 border-t-white rounded-full animate-spin"></div>
                                <div>
                                    <div class="font-semibold">Идёт анализ…</div>
                                    <div class="text-sm text-white/80">Не закрывайте окно, пока не получите результат.</div>
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
        <span class="block truncate"
              x-text="fileName || 'Загрузите TXT файл для проверки'"></span>
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
