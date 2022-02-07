
@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="flex justify-center text-3xl">Сбросить пароль</h2>

    <!-- Restore Form -->
    <div class="flex justify-center">
        <form class="w-80" method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email -->
            <div class="mt-4">
                <input id="email" type="email" placeholder="Email"
                       class="p-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent rounded-md @error('email') border-red-300 @enderror" name="email" value="{{ request()->get('email') ?? old('email') }}" required>

                @error('email')
                    <span class="text-red-400" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-2">
                <input id="password" type="password" placeholder="Пароль"
                       class="p-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent rounded-md @error('password') border-red-300 @enderror" name="password" required>

                @error('password')
                    <span class="text-red-400" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password Confirm -->
            <div class="mt-2">
                <input id="password-confirm" type="password" placeholder="Подтверждение пароля"
                       class="p-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent rounded-md" name="password_confirmation" required>
            </div>

            <!-- Restore Password -->
            <div class="mt-2">
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-md text-white focus:outline-none">
                    Сбросить пароль
                </button>
            </div>
        </form>
    </div><!-- ./ Restore Form -->

</div>
@endsection
