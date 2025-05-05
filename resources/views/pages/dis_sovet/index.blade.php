@extends('layouts.public', ['kzLink' => 'dis-sovet/', 'ruLink' => 'dis-sovet/', 'enLink' => 'dis-sovet/'])

@section('content')
    <div class="container mx-auto px-4 mb-[60px]">
        <div class="mt-[60px] pb-[50px] py-[20px] xl:pb-[100px] bg-white shadow-md rounded-[15px] px-4 2xl:px-28">
            <div>
                <x-page-title>Диссертационный совет</x-page-title>
            </div>
            <div class="mt-[70px]">
                <div class="mt-[20px]">
                    <a href="##"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">Документы дисертационного совета</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="##"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">Информация для претендентов</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="##"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">Состав диссертационного совета</span>
                    </a>
                </div>
                <div class="mt-[20px]">
                    <a href="##"
                       class="p-[29px] bg-[var(--color-halftone)] rounded-[30px] flex items-center group hover:bg-[var(--color-main)] transition-all duration-300">
                        <div
                            class="bg-[var(--color-main)] w-[26px] h-[26px] rounded-full mr-[13px] group-hover:bg-white transition-all duration-300"></div>
                        <span class="font-semibold group-hover:text-white transition-all duration-300">Объявления о защитах диссертации</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
