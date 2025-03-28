@extends('layouts.guest', ['kzLink' => 'register/', 'ruLink' => 'register/', 'enLink' => 'register/'])

@section('content')
    <div class="mt-[30px] md:mt-[70px] px-4">
        <div class="mb-[24px] flex items-center">
            <a href="{{ route('login') }}" class="text-[28px] mr-[12px] translate-y-[3px] text-custom-main"><i
                    class="fas fa-angle-left"></i></a>
            <h1 class="text-[24px] md:text-[44px] font-bold">{{ __('auth.registration') }}</h1>
        </div>
        <div class="">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.full_name') }}" name="name" type="text" placeholder="{{ __('auth.enter_full_name') }}"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.email') }}" name="email" type="email" placeholder="{{ __('auth.enter_email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.password_label') }}" name="password" type="password" placeholder="{{ __('auth.enter_password') }}"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.repeat_password') }}" name="password_confirmation" type="password"
                                   placeholder="{{ __('auth.repeat_password') }}"/>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>
                <div class="">
                    <button type="submit"
                            class="w-full bg-custom-main border border-custom-main font-semibold py-[17px] text-center text-white rounded-[14px] hover:bg-custom-extra duration-300 transition-all">
                        {{ __('auth.register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
