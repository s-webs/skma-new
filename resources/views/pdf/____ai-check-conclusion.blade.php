<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заключение по тестовым заданиям</title>
    <style>
        @page {
            margin: 50px 50px 80px 50px;
        }

        /* ВАЖНО: DejaVu Sans хорошо держит кириллицу */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        /* Верхний колонтитул — только на первой странице (в потоке документа) */
        .pdf-header {
            height: 80px;
            background-color: #fff;
            border-bottom: 2px solid #ddd;
            padding: 10px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .header-logo {
            max-width: 550px;
            object-fit: contain;
        }

        .header-content {
            flex: 1;
            text-align: center;
        }

        .header-title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            color: #111;
        }

        .header-subtitle {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }

        /* Основной контент */
        .content-wrapper {
            margin-top: 20px;
        }

        .section {
            margin-top: 40px;
            margin-bottom: 24px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 12px;
            color: #111;
            border-bottom: 2px solid #333;
            padding-bottom: 6px;
        }

        .subsection-title {
            font-size: 14px;
            font-weight: 700;
            margin: 16px 0 8px;
            color: #333;
        }

        .box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 16px;
            background-color: #fafafa;
        }

        .risk-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .risk-LOW {
            background-color: #d4edda;
            color: #155724;
        }

        .risk-MEDIUM {
            background-color: #fff3cd;
            color: #856404;
        }

        .risk-HIGH {
            background-color: #f8d7da;
            color: #721c24;
        }

        .severity-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            margin-right: 8px;
        }

        .severity-HIGH {
            background-color: #f8d7da;
            color: #721c24;
        }

        .severity-MEDIUM {
            background-color: #fff3cd;
            color: #856404;
        }

        .severity-LOW {
            background-color: #d4edda;
            color: #155724;
        }

        .finding-item {
            margin-bottom: 16px;
            padding: 12px;
            background-color: #fff;
            border-left: 4px solid #ddd;
            border-radius: 4px;
        }

        .finding-item.severity-HIGH {
            border-left-color: #dc3545;
        }

        .finding-item.severity-MEDIUM {
            border-left-color: #ffc107;
        }

        .finding-item.severity-LOW {
            border-left-color: #28a745;
        }

        .finding-title {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .finding-details {
            font-size: 11px;
            color: #555;
            line-height: 1.5;
        }

        .scores-grid {
            width: 100%;
            margin-top: 8px;
        }

        .score-row {
            display: block;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            font-family: DejaVu Sans, sans-serif;
        }

        .score-label {
            display: inline-block;
            width: 65%;
            padding-right: 8px;
            font-weight: 600;
            vertical-align: top;
            font-family: DejaVu Sans, sans-serif;
        }

        .score-value {
            display: inline-block;
            width: 30%;
            text-align: right;
            font-weight: 700;
            vertical-align: top;
            font-family: DejaVu Sans, sans-serif;
        }

        .error-pattern {
            margin-bottom: 16px;
            padding: 12px;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        .error-pattern-title {
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 6px;
            color: #dc3545;
        }

        .error-pattern-field {
            margin-bottom: 8px;
            font-size: 11px;
        }

        .error-pattern-field strong {
            color: #333;
        }

        .action-plan-item {
            margin-bottom: 12px;
            padding: 12px;
            background-color: #fff;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }

        .action-step {
            font-weight: 700;
            color: #007bff;
            margin-right: 8px;
        }

        .action-owner {
            display: inline-block;
            padding: 2px 6px;
            background-color: #e7f3ff;
            color: #004085;
            border-radius: 3px;
            font-size: 10px;
            margin-left: 8px;
        }

        .spot-check-info {
            margin-bottom: 12px;
            font-size: 11px;
        }

        .suspicious-item {
            margin-bottom: 8px;
            padding: 8px;
            background-color: #fff3cd;
            border-left: 3px solid #ffc107;
            border-radius: 3px;
            font-size: 11px;
        }

        .meta-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            margin-top: 24px;
            font-size: 10px;
            color: #666;
            padding-top: 12px;
            border-top: 1px solid #ddd;
        }

        /* Печать - фиксированная внизу справа */
        .stamp-container {
            position: fixed;
            bottom: 20px;
            right: 50px;
            text-align: center;
        }

        .stamp-image {
            max-width: 150px;
            max-height: 150px;
            object-fit: contain;
        }

        .stamp-text {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .text-content {
            line-height: 1.6;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>

<!-- Верхний колонтитул (только на первой странице) -->
<div class="pdf-header">
    <img src="{{ $headerImagePath }}" alt="Логотип" class="header-logo">
    <br>
    <br>
    <div class="header-content">
        <div class="header-title">Заключение по проверке тестовых заданий</div>
    </div>
    <div style="width: 200px;"></div> <!-- Spacer для симметрии -->
</div>

<!-- Печать (внизу справа) -->
<div class="stamp-container">
    <img src="{{ $stampImagePath }}" alt="Печать" class="stamp-image">
{{--    <div class="stamp-text">Печать</div>--}}
</div>
<!-- Основной контент -->
<div class="content-wrapper">
    <!-- Метаинформация -->
    <div class="meta-info">
        <strong>Дата формирования:</strong> {{ $generatedAt->format('d.m.Y H:i') }}<br>
        <strong>Файл:</strong> {{ $filename ?? '—' }}
    </div>

    <!-- Общая оценка -->
    <div class="section">
        <div class="section-title">Общая оценка</div>
        <div class="box">
            <div class="risk-badge risk-{{ strtoupper($data['risk_level'] ?? 'MEDIUM') }}">
                Уровень риска: {{ $data['risk_level'] ?? 'MEDIUM' }}
            </div>
            <div class="text-content">{{ $data['overall_assessment'] ?? 'Оценка не предоставлена' }}</div>
        </div>
    </div>

    <!-- Критические находки -->
    @if (!empty($data['major_findings']))
    <div class="section">
        <div class="section-title">Критические находки</div>
        @foreach ($data['major_findings'] as $finding)
        <div class="finding-item severity-{{ strtoupper($finding['severity'] ?? 'MEDIUM') }}">
            <div class="finding-title">
                <span class="severity-badge severity-{{ strtoupper($finding['severity'] ?? 'MEDIUM') }}">
                    {{ $finding['severity'] ?? 'MEDIUM' }}
                </span>
                {{ $finding['title'] ?? 'Без названия' }}
            </div>
            <div class="finding-details">{{ $finding['details'] ?? '' }}</div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Оценки качества: фиксированный порядок ключей из схемы n8n, подписи только из шаблона -->
    @if (!empty($data['quality_scores']))
    @php
        $qs = $data['quality_scores'];
        $scoreRows = [
            'clarity' => 'Ясность',
            'single_best_answer' => 'Один правильный ответ',
            'distractors' => 'Отвлекающие варианты',
            'no_clues' => 'Отсутствие подсказок',
            'language' => 'Язык',
            'structure_consistency' => 'Согласованность структуры',
        ];
    @endphp
    <div class="section">
        <div class="section-title">Оценки качества</div>
        <div class="box">
            <div class="scores-grid">
                @foreach ($scoreRows as $key => $label)
                <div class="score-row">
                    <span class="score-label">{{ $label }}</span><span class="score-value">{{ isset($qs[$key]) && is_numeric($qs[$key]) ? number_format($qs[$key], 1) : ($qs[$key] ?? '—') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Типичные ошибки -->
    @if (!empty($data['common_error_patterns']))
    <div class="section">
        <div class="section-title">Типичные ошибки</div>
        @foreach ($data['common_error_patterns'] as $pattern)
        <div class="error-pattern">
            <div class="error-pattern-title">{{ $pattern['pattern'] ?? 'Ошибка' }}</div>
            @if (!empty($pattern['why_bad']))
            <div class="error-pattern-field">
                <strong>Почему это плохо:</strong> {{ $pattern['why_bad'] }}
            </div>
            @endif
            @if (!empty($pattern['how_to_fix']))
            <div class="error-pattern-field">
                <strong>Как исправить:</strong> {{ $pattern['how_to_fix'] }}
            </div>
            @endif
            @if (!empty($pattern['example_rewrite_template']))
            <div class="error-pattern-field">
                <strong>Пример исправления:</strong> {{ $pattern['example_rewrite_template'] }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- План действий -->
    @if (!empty($data['action_plan']))
    <div class="section">
        <div class="section-title">План действий</div>
        @foreach ($data['action_plan'] as $action)
        <div class="action-plan-item">
            <div>
                <span class="action-step">Шаг {{ $action['step'] ?? '' }}</span>
                <span class="action-owner">{{ $action['owner'] ?? 'Не указан' }}</span>
            </div>
            <div style="margin-top: 6px; font-size: 11px;">
                <strong>Действие:</strong> {{ $action['action'] ?? '' }}
            </div>
            @if (!empty($action['expected_result']))
            <div style="margin-top: 24px; font-size: 11px; color: #555;">
                <strong>Ожидаемый результат:</strong> {{ $action['expected_result'] }}
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Выборочная проверка -->
    @if (!empty($data['spot_check']))
    <div class="section">
        <div class="section-title">Выборочная проверка</div>
        <div class="box">
            @if (!empty($data['spot_check']['sample_size']))
            <div class="spot-check-info">
                <strong>Размер выборки:</strong> {{ $data['spot_check']['sample_size'] }} вопросов
            </div>
            @endif

            @if (!empty($data['spot_check']['suspicious_question_numbers']))
            <div class="subsection-title">Подозрительные вопросы:</div>
            @foreach ($data['spot_check']['suspicious_question_numbers'] as $suspicious)
            <div class="suspicious-item">
                <strong>Вопрос №{{ $suspicious['number'] ?? '' }}:</strong> {{ $suspicious['reason'] ?? '' }}
            </div>
            @endforeach
            @endif
        </div>
    </div>
    @endif

    <div class="footer">
        Документ сформирован автоматически на основе загруженного файла и результатов анализа AI.
    </div>
</div>

</body>
</html>
