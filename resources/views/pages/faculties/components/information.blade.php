<div class="border-b pb-[20px]">
    <x-page-title>{{ $item->getProperty('name') }}</x-page-title>
</div>

@if($item->preview)
    <div class="mt-[60px] mb-[60px]">
        <img src="/{{ $item->preview }}" alt="{{ $item->getProperty('name') }}"
             class="w-full lg:w-[70%] rounded-[15px] mx-auto">
    </div>
@endif

<div class="mt-[30px] w-full content">
    <div class="table-wrapper">
        {!! $item->getProperty('description') !!}
    </div>
</div>

@if(!empty(json_decode($item->getProperty('contacts'))))
    <div class="mb-[10px] mt-[60px]">
        <x-inner-heading>{{ __('public.contacts') }}</x-inner-heading>
    </div>

    @foreach(json_decode($item->getProperty('contacts')) as $contact)
        <div>
            <span class="font-semibold">{{ $contact->key }}</span>
            <span>{{ $contact->value }}</span>
        </div>
    @endforeach
@endif

@push('styles')
    <style>
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
    </style>
@endpush



@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            // Найдем все таблицы внутри контейнера (например, с классом .table-wrapper)
            document.querySelectorAll('.table-wrapper table').forEach(function(table) {
                // Предполагаем, что первая строка (первый <tr>) содержит заголовки
                var headerCells = table.querySelector("tbody tr").querySelectorAll("td");
                var headers = [];
                headerCells.forEach(function(cell) {
                    headers.push(cell.textContent.trim());
                });

                // Проходим по всем строкам, кроме первой (заголовка)
                var rows = table.querySelectorAll("tbody tr:not(:first-child)");
                rows.forEach(function(row) {
                    var cells = row.querySelectorAll("td");
                    cells.forEach(function(cell, index) {
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
