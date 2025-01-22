@extends('layouts.public', [
    'kzLink' => 'academy-structure/',
    'ruLink' => 'academy-structure/',
    'enLink' => 'academy-structure/'
])

@push('styles')
    <!-- Вставьте в ваш Blade-шаблон -->
    <link href="https://cdn.jsdelivr.net/npm/orgchart@2.1.1/dist/css/jquery.orgchart.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/orgchart@2.1.1/dist/js/jquery.orgchart.min.js"></script>

@endpush

@section('content')
    <h1 class="text-2xl text-center">Организационная структура ЮКМА</h1>
    <div id="chart-container"></div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orgData = @json($data); // Получаем данные из PHP

            const chart = new OrgChart({
                chartContainer: document.getElementById('chart-container'),
                data: orgData,
                nodeContent: 'description', // Отображать описание
                verticalLevel: 3, // После какого уровня переключиться на вертикальное представление
                createNode: (nodeElement, data) => {
                    // Если есть изображения, добавляем их
                    if (data.image) {
                        const img = document.createElement('img');
                        img.src = data.image;
                        img.alt = data.name;
                        img.style.width = '50px';
                        img.style.height = '50px';
                        img.style.borderRadius = '50%';
                        nodeElement.querySelector('.title').before(img);
                    }
                },
            });
        });
    </script>
@endpush
