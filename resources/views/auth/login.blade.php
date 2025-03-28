@extends('layouts.guest', ['kzLink' => 'login/', 'ruLink' => 'login/', 'enLink' => 'login/'])

@section('content')

    <div class="mt-[30px] md:mt-[70px] px-4">
        <div>
            <x-page-title>{{ __('auth.sign_in_cabinet') }}</x-page-title>
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <div class="mt-[36px]">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.email') }}" name="email" type="email" placeholder="{{ __('auth.enter_email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.password_label') }}" name="password" type="password" placeholder="{{ __('auth.enter_password') }}"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mb-[24px] flex items-center justify-between flex-wrap">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-custom-main shadow-sm focus:ring-custom-main"
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif
                </div>
                <div class="">
                    <button type="submit"
                            class="w-full bg-custom-main border border-custom-main font-semibold py-[17px] text-center text-white rounded-[14px] hover:bg-custom-extra duration-300 transition-all">
                        {{ __('auth.sign_in') }}
                    </button>
                </div>
            </form>
            <div class="flex items-center my-[24px]">
                <span class="flex-1 h-[1px] bg-[#E2E2E2]"></span>
                <span class="mx-[6px] -translate-y-[1px] text-[#9492B6]">{{ __('auth.or') }}</span>
                <span class="flex-1 h-[1px] bg-[#E2E2E2]"></span>
            </div>
            <div>
                <a href="{{ route('register') }}"
                   class="block w-full text-center text-custom-heading border border-[#E2E2E2] font-semibold py-[17px] rounded-[14px] hover:bg-custom-main hover:text-white duration-300 transition-all">
                    {{ __('auth.register') }}
                </a>
            </div>
            <div class="mb-[24px]">
            </div>
        </div>
    </div>
@endsection
