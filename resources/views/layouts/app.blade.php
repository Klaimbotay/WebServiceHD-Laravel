<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>{{ config('app.name') }}</title>

</head>
<body class="bg-gray-100">
    <div id="app">
        <!-- Navbar -->
        <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg bg-indigo-500 mb-3 shadow-sm">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
                <a href="{{ url('/home') }}" class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white">
                    Домашняя
                </a>
                <a href="{{ route('profile.index') }}" class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white">
                    Профиль
                </a>
                <a href="{{ route('calc.index') }}" class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white">
                    Генератор
                </a>
                <a href="{{ url('/diets') }}" class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-no-wrap uppercase text-white">
                    Моя диета
                </a>
                <button class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button">
                    <span class="block relative w-6 h-px rounded-sm bg-white"></span>
                    <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>
                    <span class="block relative w-6 h-px rounded-sm bg-white mt-1"></span>
                </button>
                </div>
                <div class="lg:flex flex-grow items-center" id="example-navbar-warning">
                  <ul class="flex flex-col lg:flex-row list-none ml-auto">
                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75 {{ request()->is('login') ? 'bg-indigo-600 rounded-md' : ''}}">
                            Вход
                            </a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75 {{ request()->is('register') ? 'bg-indigo-600 rounded-md' : ''}}">
                            Регистрация
                            </a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="{{ route('profile.index') }}">
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                               class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                                Выйти
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    @endguest
                  </ul>
                </div>
            </div>
        </nav><!-- ./ Navbar -->

        <!-- Content -->
        <main class="container mx-auto px-4">
            @yield('content')
        </main><!-- ./ Content -->

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
