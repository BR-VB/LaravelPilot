@extends('layouts.app')

@section('headline', __('auth.register_title'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('register') }}" method="POST">
        @csrf

        <!-- name -->
        <x-form.input-text
            label="{{ __('auth.register_name_label') }}"
            name="name"
            value=""
            :required="true"
            :disabled="false"
            :autofocus="true" />

        <!-- email -->
        <x-form.input-email
            label="{{ __('auth.login_email_label') }}"
            name="email"
            value=""
            :required="true"
            :disabled="false" />

        <!-- password-->
        <x-form.input-password
            label="{{ __('auth.login_password_label') }}"
            name="password"
            value=""
            :required="true"
            :disabled="false" />

        <!-- confirm password-->
        <x-form.input-password
            label="{{ __('auth.login_password_confirm_label') }}"
            name="password_confirmation"
            value=""
            :required="true"
            :disabled="false" />

        <!-- already registered -->
        <div>
            @if (Route::has('login'))
            <a href="{{ route('login') }}" class="small-gray-link">
                {{ __('auth.register_already_done') }}
            </a>
            @endif
        </div>

        <!-- submit button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('auth.register_submit_label') }}</button>
        </div>
    </form>
</div>
@endsection