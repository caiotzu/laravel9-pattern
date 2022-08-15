<!DOCTYPE html>
<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}"
>
  <head>
    <meta charset="utf-8">
    <link href="{{ asset('build/assets/images/logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Design pattern with laravel 9">
    <meta name="keywords" content="Pattern, Laravel 9, Tailwind">
    <meta name="author" content="Caio Costa">

    @yield('adminHead')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('adminCss')

    @vite('resources/css/app.css')
  </head>

  <body class="py-5 md:py-0">
    @switch($layout_scheme)
      @case('top-menu')
        @include('admin.layouts.top-menu')
        @break
      @case('simple-menu')
        @include('admin.layouts.simple-menu')
        @break
      @default
        @include('admin.layouts.side-menu')
    @endswitch

    <div class="invisible  xl:visible">
      @include('./admin/layouts/components/layout-mode-switcher')
      @include('./admin/layouts/components/dark-mode-switcher')
      @include('./admin/layouts/components/main-color-switcher')
    </div>

    <div class="sm:visible xl:invisible">
      @include('./admin/layouts/components/mobile-mode-switcher')
    </div>
    @vite('resources/js/app.js')

    @yield('adminJs')
  </body>
</html>
