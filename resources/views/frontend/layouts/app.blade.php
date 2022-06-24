<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ appName() }} | @yield('title')</title>

    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'kantai.developer@gmail.com')">

    <meta name="application-name" content="{{ appName() }}">

    @stack('before-styles')
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    @stack('after-styles')
</head>

<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>

    @stack('before-scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/frontend.js') }}"></script>
    @stack('after-scripts')
</body>

</html>
