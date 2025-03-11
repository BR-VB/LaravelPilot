@extends('layouts.app')

@section('headline', __('auth.login_title'))
@section('subpage_content')
<div class="model-form">
    <!-- Session Status -->
    <x-auth.session-status class="mb-4" :status="session('status')" />

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <!-- email -->
        <x-form.input-email
            label="{{ __('auth.login_email_label') }}"
            name="email"
            value=""
            :required="true"
            :disabled="false"
            :autofocus="true" />

        <!-- password-->
        <x-form.input-password
            label="{{ __('auth.login_password_label') }}"
            name="password"
            value=""
            :required="true"
            :disabled="false" />

        <!-- remember -->
        <x-form.input-checkbox
            label="{{ __('auth.login_remember_me_label') }}"
            name="remember"
            :checked="false"
            :required="false"
            :disabled="false" />

        <!-- password forgotten -->
        <div>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="small-gray-link">
                {{ __('auth.login_password_forgotten_label') }}
            </a>
            @endif
        </div>

        <!-- submit button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('auth.login_submit_label') }}</button>
        </div>
    </form>
</div>
@endsection