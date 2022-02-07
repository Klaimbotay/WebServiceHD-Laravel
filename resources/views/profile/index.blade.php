@extends('layouts.app')

@section('content')
  <!--
  This example requires Tailwind CSS v2.0+ 
  
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ]
  }
  ```
-->
<div class="hidden sm:block" aria-hidden="true">
  <div class="py-5">
    <div class="border-t border-gray-200"></div>
  </div>
</div>

<div class="mt-10 sm:mt-0">
  <div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Информация о пользователе</h3>
      </div>
    </div>
    @foreach ($users as $user)
    <div class="mt-5 md:mt-0 md:col-span-2">
      <form action="{{ url('/profile') }}" method="POST">
      	@method('put')
      	@csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-8 gap-8">
              <div class="col-span-6 sm:col-span-3">
                <label for="first_name" class="block text-sm font-medium text-gray-700">Имя</label>
                <input type="text" name="first_name" id="first_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{$user->name}}">
              </div>
              <div class="col-span-6 sm:col-span-3">
                <label for="last_name" class="block text-sm font-medium text-gray-700">Фамилия</label>
                <input type="text" name="last_name" id="last_name" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{$user->surname}}">
              </div>
              
              <div class="col-span-6 sm:col-span-4">
                <label for="email_address" class="block text-sm font-medium text-gray-700">Почта</label>
                <input type="text" name="email_address" id="email_address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{$user->email}}" disabled>
              </div>

              <div class="col-span-6 sm:col-span-2">
                <label for="country" class="block text-sm font-medium text-gray-700">Пол</label>
                <form-radio>
                	@if ($user->sex === 1)
                		<input type="radio" name="sex" value="1" id="sexChoiceMale" checked>
                		<label for="sexChoiceMale">Мужчина</label>
                		<br>
                		<input type="radio" name="sex" value="0" id="sexChoiceFemale">
                		<label for="sexChoiceFemale">Женщина</label>
                	@endif
                	@if ($user->sex === 0)
                		<input type="radio" name="sex" value="1" id="sexChoiceMale">
                		<label for="sexChoiceMale">Мужчина</label>
                		<br>
                		<input type="radio" name="sex" value="0" id="sexChoiceFemale"checked>
                		<label for="sexChoiceFemale">Женщина</label>
                	@endif
                </form-radio>
              </div>

              <div class="col-span-6 sm:col-span-4">
                <label for="age" class="block text-sm font-medium text-gray-700">Возраст</label>
                <input type="number" name="age" id="age" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" style="width: 75px; margin-right: 0px" min="1" max="100" value="{{$user->age}}">
              </div>

              <div class="col-span-6 sm:col-span-4">
                <label for="height" class="block text-sm font-medium text-gray-700">Рост</label>
                <input type="number" name="height" id="height" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" style="width: 75px; margin-left: 0px" min="50" max="250" value="{{$user->height}}">
              </div>

              <div class="col-span-6 sm:col-span-4">
                <label for="weight" class="block text-sm font-medium text-gray-700">Вес</label>
                <input type="number" name="weight" id="weight" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" style="width: 75px" min="5" max="300" value="{{$user->weight}}">
              </div>

              <div class="col-span-6 sm:col-span-5">
                <label for="country" class="block text-sm font-medium text-gray-700">Цель</label>
                <form-radio>
                	@if ($user->goal === 1)
                		<input type="radio" name="cel" value="1" id="celPersonUp" checked>
                		<label for="celPersonUp">Набрать</label>
                		<br>
                		<input type="radio" name="cel" value="0" id="celPersonDown">
                		<label for="celPersonDown">Сбросить</label>
                	@endif
                	@if ($user->goal === 0)
                		<input type="radio" name="cel" value="1" id="celPersonUp">
                		<label for="celPersonUp">Набрать</label>
                		<br>
                		<input type="radio" name="cel" value="0" id="celPersonDown" checked>
                		<label for="celPersonDown">Сбросить</label>
                	@endif	
                </form-radio>
              </div>
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Сохранить
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<div class="hidden sm:block" aria-hidden="true">
  <div class="py-5">
    <div class="border-t border-gray-200"></div>
  </div>
</div>

<!---<div class="mt-10 sm:mt-0">
  <div class="md:grid md:grid-cols-3 md:gap-6">
    <div class="md:col-span-1">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Account Information</h3>
        <p class="mt-1 text-sm text-gray-600">
          Here you can change your password.
        </p>
      </div>
    </div>
    <div class="mt-5 md:mt-0 md:col-span-2">
      <form action="{{ url('/password') }}" method="GET">
      	@method('get')
      	@csrf
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-1 gap-3">
              <div class="col-span-2 sm:col-span-1">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Current password</label>
                <input type="password" name="current_password" id="current_password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label for="password" class="block text-sm font-medium text-gray-700">New password</label>
                <input type="password" name="password" id="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm new password</label>
                <input type="password" name="password-confirm" id="password-confirm" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Update
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
//</div>
!--->
<footer class="text-gray-600 body-font">
  <div class="bg-gray-100">
    <div class="container px-5 py-6 mx-auto flex items-center sm:flex-row flex-col">
      <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        <span class="ml-3 text-xl">Healthy meal</span>
      </a>
      <p class="text-sm text-gray-500 sm:ml-6 sm:mt-0 mt-4">© 2021  Healthy meal—
        <a href="https://twitter.com/knyttneve" rel="noopener noreferrer" class="text-gray-600 ml-1" target="_blank">lexa.2tri@yandex.ru</a>
      </p>
      <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
        <a class="text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
            <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
            <circle cx="4" cy="4" r="2" stroke="none"></circle>
          </svg>
        </a>
      </span>
    </div>
  </div>
</footer>
@endsection
