@extends('layouts.app')

@section('content')
@for ($i = 0; $i < $saves; $i++)
<h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Рацион №{{$i+1}}</h1>
@for ($j = 0; $j < $count[$i]; $j++)
<section class="text-gray-600 body-font">
  <div class="container flex flex-wrap px-5 py-24 mx-auto items-center" style="padding-top: 0">
    <div class="md:w-1/2 md:pr-12 md:py-8 md:border-r md:border-b-0 mb-10 md:mb-0 pb-10 border-b border-gray-200">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">{{$names[$i][$j]}} - {{$ccals[$i][$j]}} ккал.</h1>
      <p class="leading-relaxed text-base">{{$recipes[$i][$j]}}</p>
    </div>
    <div class="flex flex-col md:w-1/2 md:pl-12">
      <h2 class="title-font font-semibold text-gray-800 tracking-wider text-sm mb-3">ИНГРЕДИЕНТЫ</h2>
      <nav class="flex flex-wrap list-none -mb-1">
      	@for ($k = 0; $k < count($ingredients[$i][$j]); $k++)
        <li class="lg:w-1/3 mb-1 w-1/2">
          <p class="text-gray-600 hover:text-gray-800">{{$ingredients[$i][$j][$k]}} - {{$count_ingredients[$i][$j][$k]}} {{$ed_arr[$i][$j][$k]}}</p>
        </li>
        @endfor
      </nav>
    </div>
  </div>
</section>
@endfor
<form action="{{ route('destroy', $id_menus[$i]) }}" method="POST">
    @csrf
    @method('post')    
    <div class="px-4 py-3 text-center sm:px-6">
    	<button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Удалить рацион
        </button>
    </div>
</form>
@endfor
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
