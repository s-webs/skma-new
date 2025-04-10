@extends('layouts.public', ['kzLink' => 'ads/' . $item->slug_kz, 'ruLink' => 'ads/' . $item->slug_ru, 'enLink' => 'ads/' . $item->slug_en])

@section('content')
    <div class="container mx-auto px-4 mb-[60px]">
        <div class="mt-[40px]">
            <x-breadcrumbs :items="[
                ['title' => __('public.pageHome'), 'url' => route('home')],
                ['title' => __('public.ads'), 'url' => route('ads.index')],
                ['title' => $item->getProperty('short')],
            ]"/>
        </div>

        <div class="mt-[40px] pb-[50px] py-[50px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div class="flex items-center justify-end">
                <div class="flex items-center mr-[20px]">
                    <i class="fad fa-calendar-alt text-custom-secondary"></i><span
                        class="ml-[6px]">{{ $item->formatted_date }}</span>
                </div>
                <div class="flex items-center mr-[20px]">
                    <i class="fas fa-eye text-custom-secondary"></i><span
                        class="ml-[6px]">{{ $item->getProperty('views') }}</span>
                </div>
            </div>
            <div class="md:mt-[20px] border-t py-[10px] xl:py-[30px]">
                <x-page-title>{{ $item->getProperty('title') }}</x-page-title>
            </div>
            <div class="content mt-[30px] pt-[30px] border-t">
                <div class="table-wrapper">
                    {!! $item->getProperty('description') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .content p {
            font-size: 1.1rem;
        }

        .content img {
            height: auto !important;
            margin: 30px auto;
            text-align: center;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-wrapper th,
        .table-wrapper td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ccc;
        }

        /* Стилевое оформление для stacked view на мобильных */
        @media only screen and (max-width: 768px) {
            .table-wrapper table,
            .table-wrapper thead,
            .table-wrapper tbody,
            .table-wrapper th,
            .table-wrapper td,
            .table-wrapper tr {
                display: block;
            }

            .table-wrapper thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .table-wrapper tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
            }

            .table-wrapper td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table-wrapper td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 10px;
                white-space: normal !important;
                word-break: break-word;
                font-weight: bold;
                text-align: left;
            }


        }

        .table-wrapper table,
        .table-wrapper thead,
        .table-wrapper tbody,
        .table-wrapper th,
        .table-wrapper td,
        .table-wrapper tr {
            display: block;
        }

        .table-wrapper thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        /* Если нужно убрать лишние границы, можно снять их при stacked: */
        .table-wrapper td,
        .table-wrapper th {
            border: none !important;
        }

        /* Смещаем содержимое ячеек */
        .table-wrapper td {
            position: relative;
            padding-left: 50%;
            box-sizing: border-box;
            text-align: left; /* или right, в зависимости от макета */
            word-wrap: break-word;
            white-space: normal;
        }

        .table-wrapper td:before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            width: 40%; /* Уменьшите ширину, если текст «съезжает» на iPhone */
            font-weight: bold;
            white-space: normal;
            word-wrap: break-word;
        }

    </style>
@endpush



@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Найдем все таблицы внутри контейнера (например, с классом .table-wrapper)
            document.querySelectorAll('.table-wrapper table').forEach(function (table) {
                // Предполагаем, что первая строка (первый <tr>) содержит заголовки
                var headerCells = table.querySelector("tbody tr").querySelectorAll("td");
                var headers = [];
                headerCells.forEach(function (cell) {
                    headers.push(cell.textContent.trim());
                });

                // Проходим по всем строкам, кроме первой (заголовка)
                var rows = table.querySelectorAll("tbody tr:not(:first-child)");
                rows.forEach(function (row) {
                    var cells = row.querySelectorAll("td");
                    cells.forEach(function (cell, index) {
                        // Если data-label пустой, запишем в него заголовок из той же позиции
                        if (!cell.getAttribute("data-label") || cell.getAttribute("data-label").trim() === "") {
                            cell.setAttribute("data-label", headers[index] || "");
                        }
                    });
                });
            });
        });
    </script>
@endpush


