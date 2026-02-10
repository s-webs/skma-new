@extends('layouts.public', ['kzLink' => 'ai-check/', 'ruLink' => 'ai-check/', 'enLink' => 'ai-check/'])

@section('content')
    <div class="container mx-auto px-4 bg-white py-14">
        <div class="max-w-[900px] mx-auto">
            <div class="mb-6">
                <a href="{{ route('ai.check') }}"
                   class="inline-flex items-center text-[var(--color-main)] hover:underline text-sm">
                    ← Вернуться к проверке
                </a>
            </div>

            <div class="bg-[var(--color-main)] rounded-[40px] px-8 py-10 md:px-10 md:py-12 shadow-xl text-white">
                <div class="mb-6">
                    <h1 class="text-[26px] md:text-2xl leading-tight font-semibold">
                        Результат проверки тестов
                    </h1>
                    <p class="mt-2 text-sm text-white/80">
                        Файл: <span class="font-semibold">{{ $job->source_filename }}</span>
                    </p>
                </div>

                @if($assessment)
                    @php
                        $locale = app()->getLocale();
                        if ($locale === 'kz') {
                            $patternLabels = [
                                'pattern' => 'Үлгі',
                                'why_bad' => 'Неліктен дұрыс емес',
                                'how_to_fix' => 'Қалай түзету керек',
                                'example_rewrite_template' => 'Қайта жазу үлгісі',
                            ];
                            $stepLabels = [
                                'step' => 'Қадам',
                                'action' => 'Әрекет',
                                'owner' => 'Жауапты',
                                'expected_result' => 'Күтілетін нәтиже',
                            ];
                        } elseif ($locale === 'ru') {
                            $patternLabels = [
                                'pattern' => 'Паттерн',
                                'why_bad' => 'Почему это плохо',
                                'how_to_fix' => 'Как исправить',
                                'example_rewrite_template' => 'Пример формулировки',
                            ];
                            $stepLabels = [
                                'step' => 'Шаг',
                                'action' => 'Действие',
                                'owner' => 'Ответственный',
                                'expected_result' => 'Ожидаемый результат',
                            ];
                        } else {
                            $patternLabels = [
                                'pattern' => 'Pattern',
                                'why_bad' => 'Why bad',
                                'how_to_fix' => 'How to fix',
                                'example_rewrite_template' => 'Example rewrite template',
                            ];
                            $stepLabels = [
                                'step' => 'Step',
                                'action' => 'Action',
                                'owner' => 'Owner',
                                'expected_result' => 'Expected result',
                            ];
                        }
                    @endphp

                    <div class="space-y-6 text-sm md:text-base">
                        <section class="bg-white/5 rounded-3xl p-5">
                            <h2 class="font-semibold mb-2 text-white">
                                Общая оценка
                            </h2>
                            <p class="text-white/90 whitespace-pre-line">
                                {{ $assessment['overall_assessment'] ?? '' }}
                            </p>
                        </section>

                        <section class="bg-white/5 rounded-3xl p-5">
                            <h2 class="font-semibold mb-2 text-white">
                                Уровень риска
                            </h2>
                            <p class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                @if(($assessment['risk_level'] ?? 'MEDIUM') === 'HIGH') bg-red-500/80
                                @elseif(($assessment['risk_level'] ?? 'MEDIUM') === 'LOW') bg-emerald-500/80
                                @else bg-amber-500/80 @endif
                            ">
                                {{ $assessment['risk_level'] ?? 'N/A' }}
                            </p>
                        </section>

                        @if(!empty($assessment['major_findings']))
                            <section class="bg-white/5 rounded-3xl p-5">
                                <h2 class="font-semibold mb-2 text-white">
                                    Основные выводы
                                </h2>
                                <ul class="list-disc pl-5 space-y-1 text-white/90">
                                    @foreach($assessment['major_findings'] as $item)
                                        @if(is_array($item))
                                            <li class="space-y-1">
                                                @foreach($item as $key => $value)
                                                    <div>
                                                        <span class="font-semibold">
                                                            {{ ucfirst(str_replace('_', ' ', $key)) }}:
                                                        </span>
                                                        {{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}
                                                    </div>
                                                @endforeach
                                            </li>
                                        @else
                                            <li>{{ $item }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if(!empty($assessment['common_error_patterns']))
                            <section class="bg-white/5 rounded-3xl p-5">
                                <h2 class="font-semibold mb-2 text-white">
                                    Типичные ошибки
                                </h2>
                                <ul class="space-y-4 text-white/90">
                                    @foreach($assessment['common_error_patterns'] as $item)
                                        @php
                                            $pattern = is_array($item) ? $item : (array) $item;
                                        @endphp
                                        <li class="bg-white/5 rounded-2xl p-4 space-y-1">
                                            @if(!empty($pattern['pattern']))
                                                <div>
                                                    <span class="font-semibold">{{ $patternLabels['pattern'] }}:</span>
                                                    {{ $pattern['pattern'] }}
                                                </div>
                                            @endif
                                            @if(!empty($pattern['why_bad']))
                                                <div>
                                                    <span class="font-semibold">{{ $patternLabels['why_bad'] }}:</span>
                                                    {{ $pattern['why_bad'] }}
                                                </div>
                                            @endif
                                            @if(!empty($pattern['how_to_fix']))
                                                <div>
                                                    <span class="font-semibold">{{ $patternLabels['how_to_fix'] }}:</span>
                                                    {{ $pattern['how_to_fix'] }}
                                                </div>
                                            @endif
                                            @if(!empty($pattern['example_rewrite_template']))
                                                <div>
                                                    <span class="font-semibold">{{ $patternLabels['example_rewrite_template'] }}:</span>
                                                    {{ $pattern['example_rewrite_template'] }}
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if(!empty($assessment['action_plan']))
                            <section class="bg-white/5 rounded-3xl p-5">
                                <h2 class="font-semibold mb-2 text-white">
                                    Рекомендации по доработке
                                </h2>
                                <ul class="space-y-4 text-white/90">
                                    @foreach($assessment['action_plan'] as $item)
                                        @php
                                            $step = is_array($item) ? $item : (array) $item;
                                        @endphp
                                        <li class="bg-white/5 rounded-2xl p-4 space-y-1">
                                            @if(!empty($step['step']))
                                                <div>
                                                    <span class="font-semibold">{{ $stepLabels['step'] }}:</span>
                                                    {{ $step['step'] }}
                                                </div>
                                            @endif
                                            @if(!empty($step['action']))
                                                <div>
                                                    <span class="font-semibold">{{ $stepLabels['action'] }}:</span>
                                                    {{ $step['action'] }}
                                                </div>
                                            @endif
                                            @if(!empty($step['owner']))
                                                <div>
                                                    <span class="font-semibold">{{ $stepLabels['owner'] }}:</span>
                                                    {{ $step['owner'] }}
                                                </div>
                                            @endif
                                            @if(!empty($step['expected_result']))
                                                <div>
                                                    <span class="font-semibold">{{ $stepLabels['expected_result'] }}:</span>
                                                    {{ $step['expected_result'] }}
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </div>
                @endif

                <div class="mt-8 border-t border-white/10 pt-6">
                    <h2 class="font-semibold mb-3 text-white">
                        Скачать заключение в формате PDF
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $hasRu = !empty($job->pdf_ru_path);
                            $hasKk = !empty($job->pdf_kk_path);
                            $hasEn = !empty($job->pdf_en_path);
                        @endphp

                        @if($hasRu)
                            <a href="{{ route('ai.check.result.pdf', [$job->id, 'ru']) }}"
                               class="inline-flex items-center justify-center rounded-full bg-[var(--color-halftone)] px-5 py-2 text-sm font-semibold text-[var(--color-main)] hover:bg-[var(--color-extra)] transition">
                                PDF (RU)
                            </a>
                        @endif

                        @if($hasKk)
                            <a href="{{ route('ai.check.result.pdf', [$job->id, 'kk']) }}"
                               class="inline-flex items-center justify-center rounded-full bg-[var(--color-halftone)] px-5 py-2 text-sm font-semibold text-[var(--color-main)] hover:bg-[var(--color-extra)] transition">
                                PDF (KK)
                            </a>
                        @endif

                        @if($hasEn)
                            <a href="{{ route('ai.check.result.pdf', [$job->id, 'en']) }}"
                               class="inline-flex items-center justify-center rounded-full bg-[var(--color-halftone)] px-5 py-2 text-sm font-semibold text-[var(--color-main)] hover:bg-[var(--color-extra)] transition">
                                PDF (EN)
                            </a>
                        @endif

                        @unless($hasRu || $hasKk || $hasEn)
                            <p class="text-sm text-white/80">
                                PDF‑файлы отсутствуют.
                            </p>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

