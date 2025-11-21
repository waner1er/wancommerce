<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex-col">
    @livewire('cart-slideover')

    <header class="sticky top-0 z-50 bg-teal-500 dark:bg-[#0a0a0a] shadow-md w-full">
        <div class="">
            <div class="container mx-auto p-0 flex items-center justify-end gap-4">
                @if (Route::has('login'))
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] rounded-sm text-sm leading-normal"
                        >
                            {{__('Dashboard')}}
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] rounded-sm text-sm leading-normal"
                        >
                            {{__('auth.login')}}
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] rounded-sm text-sm leading-normal">
                                {{__('auth.register')}}
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
         @livewire('main-navigation')


    </header>
<main class="container w-full mx-auto px-6 lg:px-8 py-6">
    {{ $slot }}
</main>
</body>
</html>
