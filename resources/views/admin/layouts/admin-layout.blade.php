<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <title>@yield('title')</title>

        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        @include('admin.layouts.admin-css')
        @yield('custom-css')
    </head>

    <body class="d-flex flex-column min-vh-100">

        @include('admin.layouts.admin-header')
        @include('admin.layouts.admin-sidebar')

        <main id="main" class="flex-grow-1">@yield('content')</main>

        @include('admin.layouts.admin-footer')

        <a href="#" id="scroll-up-admin" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        @include('admin.layouts.admin-js')
        @yield('custom-js')

    </body>

</html>
