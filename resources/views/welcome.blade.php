<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app_welcome.css'])
</head>

<body>

    <!-- Header -->
    @include('layouts.header')

    <!-- messages -->
    @include('layouts.messages')

    <!-- Content -->
    <div class="content-welcome">
        <!-- left column -->
        <x-welcome.welcome-column
            :heading="__('welcome.column_01', ['projectTitle' => $projectTitle])"
            :explain="__('welcome.column_01_explain')"
            :scopes="$scopesLeft" />

        <!-- right column, with task description -->
        <x-welcome.welcome-column
            :heading="__('welcome.column_02')"
            :explain="__('welcome.column_02_explain')"
            :scopes="$scopesRight"
            :showDescription="true" />
    </div>

    <!-- Footer -->
    @include('layouts.footer')

</body>

</html>