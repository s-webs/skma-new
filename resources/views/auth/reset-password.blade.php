@extends('layouts.guest', ['kzLink' => 'reset-password/', 'ruLink' => 'reset-password/', 'enLink' => 'reset-password/'])

@section('content')
    <div class="mt-[30px] md:mt-[70px] px-4">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                    {{ __('auth.reset_password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
