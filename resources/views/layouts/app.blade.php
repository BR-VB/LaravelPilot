<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Content -->
    <div class="content">
        <div class="left">
            <div class="left-nav">
                <!-- Navigation left / main  -->
                @include('layouts.navigation')
            </div>
        </div>
        <div class="middle">
            <!-- Breadcrumb -->
            @include('layouts.breadcrumb')

            <!-- messages -->
            @include('layouts.messages')

            <!-- Main Content -->
            <div class="middle-content">
                <h1>@yield('headline')</h1>
                @yield('subpage_content')
                @include('layouts.custom_confirm')
            </div>
        </div>
        <div class="right">
            <div class="right-teaser">
                <!-- Teaser content -->
                @include('layouts.teaser')
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts at end of page -->
    @stack('scripts')
</body>

</html>