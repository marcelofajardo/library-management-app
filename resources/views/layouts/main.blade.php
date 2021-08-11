<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'UniLib')</title>
    @include('partials.styles')
    @yield('additional_styles', '')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    
    @include('sweet::alert')

    <div class="wrapper">

        {{-- @include('partials.preloader') --}}
        @include('partials.navbar')
        @include('partials.sidebar')

        <div class="content-wrapper">
            @include('partials.content-header')    
            <section class="content">

                <div class="container-fluid">
                    @yield('content')
                </div>

            </section>
        </div>

        @include('partials.footer')

    </div>

    @include('partials.scripts')
    @yield('additional_scripts', '')

</body>