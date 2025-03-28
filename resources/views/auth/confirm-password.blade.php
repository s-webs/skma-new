@extends('layouts.guest', ['kzLink' => 'confirm-password/', 'ruLink' => 'confirm-password/', 'enLink' => 'confirm-password/'])

@section('content')
    <div class="mt-[30px] md:mt-[70px] px-4">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.confirm_your_password_before_continuing') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-[24px]">
                <x-input-block label="{{ __('auth.password_label') }}" name="password" type="password" placeholder="{{ __('auth.enter_password') }}"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="">
                <button type="submit"
                        class="w-full bg-custom-main border border-custom-main font-semibold py-[17px] text-center text-white rounded-[14px] hover:bg-custom-extra duration-300 transition-all">
                    {{ __('auth.confirm') }}
                </button>
            </div>
        </form>
    </div>
@endsection
