@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="flex justify-center text-3xl">Вход на сайт</h2>

    <!-- Login Form -->
    <div class="flex justify-center">
        <form class="w-80" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mt-4">
                <input id="email" type="email" placeholder="Email"
                       class="p-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent rounded-md @error('email') border-red-300 @enderror" name="email" value="{{ old('email') }}" required>

                @error('email')
                    <span class="text-red-400" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-2">
                <input id="password" type="password" placeholder="Пароль"
                       class="p-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent rounded-md" name="password" required>
            </div>

            <!-- Remember Me --->
            <div class="mt-2">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    Запомнить меня
                </label>
            </div>

            <!-- Login -->
            <div class="mt-2">
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-md text-white focus:outline-none">
                    Войти
                </button>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="text-indigo-600 ml-2" href="{{ route('password.request') }}">
                        Забыли пароль?
                    </a>
                @endif
            </div>
        </form>
    </div><!-- ./ Login Form -->

</div>
@endsection
