@extends('layouts.guest', ['kzLink' => 'forgot-password/', 'ruLink' => 'forgot-password/', 'enLink' => 'forgot-password/'])

@section('content')
    <div class="mt-[30px] md:mt-[70px] px-4">
        <div class="text-xl font-semibold text-custom-heading">
            {{ __('auth.forgot_your_password_enter_email') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <div class="mt-[24px]">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Address -->
                <div class="mb-[24px]">
                    <x-input-block label="{{ __('auth.email') }}" name="email" type="email"
                                   placeholder="{{ __('auth.enter_email') }}"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="">
                    <button type="submit"
                            class="w-full bg-custom-main border border-custom-main font-semibold py-[17px] text-center text-white rounded-[14px] hover:bg-custom-extra duration-300 transition-all">
                        {{ __('auth.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
