@extends('layouts.public', ['kzLink' => 'news/', 'ruLink' => 'news/', 'enLink' => 'news/'])

@section('content')
    <div class="container mx-auto">
        <div class="mt-[60px]">
            Главная > Новости
        </div>
        <div class="mt-[30px]">
            <h1>Новости</h1>
        </div>
        <div>
            <div>
                <select name="cars" id="cars">
                    <option value="">Volvo</option>
                    <option value="">Saab</option>
                    <option value="">Mercedes</option>
                    <option value="">Audi</option>
                </select>
            </div>
        </div>

        <div></div>
    </div>
@endsection
