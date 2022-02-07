@extends('layouts.app')

@section('content')
<div class="p-4">
    <h2 class="flex justify-center text-3xl">Восстановить пароль</h2>

    <!-- Restore Form -->
    <div class="flex justify-center">
        <form class="w-80" method="POST" action="{{ route('password.email') }}">
            @csrf

            @if (session('status'))
                <div class="bg-green-500 text-white py-2 px-6 mt-2 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

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

            <!-- Restore Password -->
            <div class="mt-2">
                <button type="submit" class="bg-indigo-600 px-4 py-2 rounded-md text-white focus:outline-none">
                    Восстановить пароль
                </button>
            </div>
        </form>
    </div><!-- ./ Restore Form -->

</div>
@endsection
