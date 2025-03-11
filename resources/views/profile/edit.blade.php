@extends('layouts.app')

@section('headline', __('auth.profile_title'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('patch')

        <!-- name -->
        <x-form.input-text
            label="{{ __('auth.register_name_label') }}"
            name="name"
            :value="$user->name"
            :required="true"
            :disabled="false" />

        <!-- email -->
        <x-form.input-email
            label="{{ __('auth.login_email_label') }}"
            name="email"
            :value="$user->email"
            :required="true"
            :disabled="false" />

        <!-- submit button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('auth.profile_submit_label') }}</button>
        </div>
    </form>
</div>
@endsection