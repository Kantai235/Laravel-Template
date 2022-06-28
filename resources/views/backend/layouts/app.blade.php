<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Kantai Developer')">
    @yield('meta')

    @stack('before-styles')
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')
</head>
<body>
    @include('backend.includes.sidebar')

    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        @include('backend.includes.header')
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        @include('includes.partials.announcements')

        <div class="body flex-grow-1 px-3">
            <div class="container-fluid fade-in">
                @include('includes.partials.messages')
                @yield('content')
            </div><!--container-fluid-->
        </div><!--body-->

        @include('backend.includes.footer')
    </div><!--wrapper-->

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <livewire:scripts />
    <script src="{{ mix('js/backend.js') }}"></script>
    @stack('after-scripts')
</body>
</html>
