{{--<!DOCTYPE html>--}}
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
{{--    <head>--}}
{{--        <meta charset="utf-8">--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--        <meta name="csrf-token" content="{{ csrf_token() }}">--}}

{{--        <title>{{ config('app.name', 'Laravel') }}</title>--}}

{{--        <!-- Fonts -->--}}
{{--        <link rel="preconnect" href="https://fonts.bunny.net">--}}
{{--        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />--}}

{{--        <!-- Scripts -->--}}
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
{{--    </head>--}}
{{--    <body class="font-sans antialiased">--}}
{{--        <div class="min-h-screen bg-gray-100">--}}
{{--            @include('layouts.navigation')--}}

{{--            <!-- Page Heading -->--}}
{{--            @if (isset($header))--}}
{{--                <header class="bg-white shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
{{--            @endif--}}

{{--            <!-- Page Content -->--}}
{{--            <main>--}}
{{--                {{ $slot }}--}}
{{--            </main>--}}
{{--        </div>--}}
{{--    </body>--}}
{{--</html>--}}

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />

    <title>@lang('layouts.app.app_name')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="fixed w-full">
        <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span
                        class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Менеджер задач</span>
                </a>

                @if (Route::has('login'))
                    <div class="flex items-center lg:order-2">
                        @auth
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Выход
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}"
                                  method="POST" style="display: none;">
                                @csrf
                            </form>
                        @else

                            <a href="{{ route('login') }}"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Вход
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register')}}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                    Регистрация
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="{{ route('tasks.index') }}"
                               class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Задачи </a>
                        </li>
                        <li>
                            <a href="{{ route('task_statuses.index') }}"
                               class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Статусы </a>
                        </li>
                        <li>
                            <a href="{{ route('labels.index') }}"
                               class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Метки </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="bg-white dark:bg-gray-900">

        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">

            @include('flash::message')

            <div class="grid col-span-full">
                @yield('content')
            </div>
        </div>
    </section>
</div>
</body>
</html>
