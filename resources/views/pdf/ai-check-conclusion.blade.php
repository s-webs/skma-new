<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заключение по тестовым заданиям</title>
    <style>
        /* ВАЖНО: DejaVu Sans хорошо держит кириллицу */
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 16px; }
        .title { font-size: 18px; font-weight: 700; margin: 0 0 6px; }
        .meta { font-size: 11px; color: #555; }
        .box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; }
        .section-title { font-size: 13px; font-weight: 700; margin: 0 0 10px; }
        .conclusion { white-space: pre-wrap; line-height: 1.45; }
        .footer { margin-top: 18px; font-size: 10px; color: #666; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Заключение по проверке тестовых заданий</div>
    <div class="meta">
        Дата формирования: {{ $generatedAt->format('d.m.Y H:i') }}<br>
        Файл: {{ $filename ?? '—' }}
    </div>
</div>

<div class="box">
    <div class="section-title">Заключение</div>
    <div class="conclusion">{{ $conclusion }}</div>
</div>

<div class="footer">
    Документ сформирован автоматически на основе загруженного файла и результатов анализа AI.
</div>

</body>
</html>
