@extends('layouts.guest', ['kzLink' => 'verify-email/', 'ruLink' => 'verify-email/', 'enLink' => 'verify-email/'])

@section('content')
    <div class="mt-[30px] md:mt-[70px] px-4">
        <div class="mb-4 text-[18px] text-custom-heading font-semibold">
            {{ __('auth.thanks_for_signing_up') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-[14px] font-medium text-sm text-green-600">
                {{ __('auth.new_verification_link') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button class="px-[16px] py-[8px] bg-custom-main rounded-[12px] text-white font-semibold">
                        {{ __('auth.resend_verification_email') }}
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-[16px] py-[8px] bg-custom-secondary rounded-[12px] text-white font-semibold">
                    {{ __('auth.logout') }}
                </button>
            </form>
        </div>
    </div>
@endsection
