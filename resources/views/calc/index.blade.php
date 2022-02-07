@extends('layouts.app')


@section('content')
	@if (Auth::user()->sex === 1)
		@if (Auth::user()->goal === 1)
      <?php 
        session_start();

        $_SESSION['id_bludas'] = $id_bluda;
      ?>
    		<h1 class="text-3xl text-center">Чтобы набрать вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 + 350}} ккал. в сутки</h1>
    		<div class="gallery border-2 rounded mx-auto m-5 bg-white" style="width:850px">
        <div class="top flex p-2 border-b select-none">
          <div class="heading text-gray-800 w-full pl-3 font-semibold my-auto"></div>
          <div class="buttons ml-auto flex text-gray-600 mr-1">
            <svg action="prev" class="w-7 border-2 rounded-l-lg p-1 cursor-pointer border-r-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="prev" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <svg action="next" class="w-7 border-2 rounded-r-lg p-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="next" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
          </div>
        </div>
        <div class="content-area w-full h-98 overflow-hidden">
          <div class="platform shadow-xl h-full flex">
            @for ($i = 0; $i < $count; $i++)
    						<div class="each-frame border-box flex-none h-full" title="{{$cats[$i]}}">
								<div class="main flex w-full p-8">
								<div class="subw-full my-auto">
								<div class="head text-3xl font-bold mb-4">{{$bludas[$i]}}</div>
								<div class="long-text text-lg">{{$recipes[$i]}}</div></div></div></div>
            @endfor
          </div>
        </div>
      </div>
      <style>
          .platform{
              position: relative;
              transition:right 0.3s;
          }
          .body{background-color:white !important;}
          </style>

      <script>
          function gallery(){
              this.index=0;
              this.load=function(){
                this.rootEl = document.querySelector(".gallery");
                this.platform = this.rootEl.querySelector(".platform");
                this.frames = this.platform.querySelectorAll(".each-frame");
                this.contentArea = this.rootEl.querySelector(".content-area");
                this.width = parseInt(this.rootEl.style.width);
                this.limit = {start:0,end:this.frames.length-1};
                this.frames.forEach(each=>{each.style.width=this.width+"px";});
                this.goto(this.index);
              }
              this.set_title = function(){this.rootEl.querySelector(".heading").innerText=this.frames[this.index].getAttribute("title");}
              this.next = function(){this.platform.style.right=this.width * ++this.index + "px";this.set_title();}
              this.prev = function(){this.platform.style.right=this.width * --this.index + "px";this.set_title();}
              this.goto = function(index){this.platform.style.right = this.width * index + "px";this.index=index;this.set_title();}
              this.load();
          }
          var G = new gallery();
            G.rootEl.addEventListener("click",function(t){
                var val = t.target.getAttribute("action");
                if(val == "next" && G.index != G.limit.end){G.next();}
                if(val == "prev" && G.index != G.limit.start){G.prev();}
                if(val == "goto"){
                    let rv = t.target.getAttribute("goto");
                    rv = rv == "end" ? G.limit.end:rv;
                    G.goto(parseInt(rv));
                }
            });
            document.addEventListener("keyup",function(t){
                var val = t.keyCode;
                if(val == 39 && G.index != G.limit.end){G.next();}
                if(val == 37 && G.index != G.limit.start){G.prev();}
            });

            // run G.load() if new data loaded with ajax

        </script>
    	@endif
    	@if (Auth::user()->goal === 0)
    		<h1 class="text-3xl text-center">Чтобы сбросить вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 - 350}} ккал. в сутки</h1>
				<div class="gallery border-2 rounded mx-auto m-5 bg-white" style="width:850px">
        <div class="top flex p-2 border-b select-none">
          <div class="heading text-gray-800 w-full pl-3 font-semibold my-auto"></div>
          <div class="buttons ml-auto flex text-gray-600 mr-1">
            <svg action="prev" class="w-7 border-2 rounded-l-lg p-1 cursor-pointer border-r-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="prev" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <svg action="next" class="w-7 border-2 rounded-r-lg p-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="next" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
          </div>
        </div>
        <div class="content-area w-full h-96 overflow-hidden">
          <div class="platform shadow-xl h-full flex">
            @for ($i = 0; $i < $count; $i++)
                <div class="each-frame border-box flex-none h-full" title="{{$cats[$i]}}">
                <div class="main flex w-full p-8">
                <div class="subw-full my-auto">
                <div class="head text-3xl font-bold mb-4">{{$bludas[$i]}}</div>
                <div class="long-text text-lg">{{$recipes[$i]}}</div></div></div></div>
            @endfor
          </div>
        </div>
      </div>
      <style>
          .platform{
              position: relative;
              transition:right 0.3s;
          }
          .body{background-color:white !important;}
      		</style>

      <script>
          function gallery(){
              this.index=0;
              this.load=function(){
                this.rootEl = document.querySelector(".gallery");
                this.platform = this.rootEl.querySelector(".platform");
                this.frames = this.platform.querySelectorAll(".each-frame");
                this.contentArea = this.rootEl.querySelector(".content-area");
                this.width = parseInt(this.rootEl.style.width);
                this.limit = {start:0,end:this.frames.length-1};
                this.frames.forEach(each=>{each.style.width=this.width+"px";});
                this.goto(this.index);
              }
              this.set_title = function(){this.rootEl.querySelector(".heading").innerText=this.frames[this.index].getAttribute("title");}
              this.next = function(){this.platform.style.right=this.width * ++this.index + "px";this.set_title();}
              this.prev = function(){this.platform.style.right=this.width * --this.index + "px";this.set_title();}
              this.goto = function(index){this.platform.style.right = this.width * index + "px";this.index=index;this.set_title();}
              this.load();
          }
          var G = new gallery();
            G.rootEl.addEventListener("click",function(t){
                var val = t.target.getAttribute("action");
                if(val == "next" && G.index != G.limit.end){G.next();}
                if(val == "prev" && G.index != G.limit.start){G.prev();}
                if(val == "goto"){
                    let rv = t.target.getAttribute("goto");
                    rv = rv == "end" ? G.limit.end:rv;
                    G.goto(parseInt(rv));
                }
            });
            document.addEventListener("keyup",function(t){
                var val = t.keyCode;
                if(val == 39 && G.index != G.limit.end){G.next();}
                if(val == 37 && G.index != G.limit.start){G.prev();}
            });

            // run G.load() if new data loaded with ajax

</script>
    	@endif
    @endif
    @if (Auth::user()->sex === 0)
    	@if (Auth::user()->goal === 1)
    		<h1 class="text-3xl text-center">Чтобы набрать вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 + 350}} ккал. в сутки</h1>
				<div class="gallery border-2 rounded mx-auto m-5 bg-white" style="width:850px">
        <div class="top flex p-2 border-b select-none">
          <div class="heading text-gray-800 w-full pl-3 font-semibold my-auto"></div>
          <div class="buttons ml-auto flex text-gray-600 mr-1">
            <svg action="prev" class="w-7 border-2 rounded-l-lg p-1 cursor-pointer border-r-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="prev" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <svg action="next" class="w-7 border-2 rounded-r-lg p-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="next" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
          </div>
        </div>
        <div class="content-area w-full h-96 overflow-hidden">
          <div class="platform shadow-xl h-full flex">
            @for ($i = 0; $i < $count; $i++)
                <div class="each-frame border-box flex-none h-full" title="{{$cats[$i]}}">
                <div class="main flex w-full p-8">
                <div class="subw-full my-auto">
                <div class="head text-3xl font-bold mb-4">{{$bludas[$i]}}</div>
                <div class="long-text text-lg">{{$recipes[$i]}}</div></div></div></div>
            @endfor
          </div>
        </div>
      </div>
      <style>
          .platform{
              position: relative;
              transition:right 0.3s;
          }
          .body{background-color:white !important;}
      		</style>

      <script>
          function gallery(){
              this.index=0;
              this.load=function(){
                this.rootEl = document.querySelector(".gallery");
                this.platform = this.rootEl.querySelector(".platform");
                this.frames = this.platform.querySelectorAll(".each-frame");
                this.contentArea = this.rootEl.querySelector(".content-area");
                this.width = parseInt(this.rootEl.style.width);
                this.limit = {start:0,end:this.frames.length-1};
                this.frames.forEach(each=>{each.style.width=this.width+"px";});
                this.goto(this.index);
              }
              this.set_title = function(){this.rootEl.querySelector(".heading").innerText=this.frames[this.index].getAttribute("title");}
              this.next = function(){this.platform.style.right=this.width * ++this.index + "px";this.set_title();}
              this.prev = function(){this.platform.style.right=this.width * --this.index + "px";this.set_title();}
              this.goto = function(index){this.platform.style.right = this.width * index + "px";this.index=index;this.set_title();}
              this.load();
          }
          var G = new gallery();
            G.rootEl.addEventListener("click",function(t){
                var val = t.target.getAttribute("action");
                if(val == "next" && G.index != G.limit.end){G.next();}
                if(val == "prev" && G.index != G.limit.start){G.prev();}
                if(val == "goto"){
                    let rv = t.target.getAttribute("goto");
                    rv = rv == "end" ? G.limit.end:rv;
                    G.goto(parseInt(rv));
                }
            });
            document.addEventListener("keyup",function(t){
                var val = t.keyCode;
                if(val == 39 && G.index != G.limit.end){G.next();}
                if(val == 37 && G.index != G.limit.start){G.prev();}
            });

            // run G.load() if new data loaded with ajax

</script>
    	@endif
    	@if (Auth::user()->goal === 0)
    		<h1 class="text-3xl text-center">Чтобы сбросить вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 - 350}} ккал. в сутки</h1>
				<div class="gallery border-2 rounded mx-auto m-5 bg-white" style="width:850px">
        <div class="top flex p-2 border-b select-none">
          <div class="heading text-gray-800 w-full pl-3 font-semibold my-auto"></div>
          <div class="buttons ml-auto flex text-gray-600 mr-1">
            <svg action="prev" class="w-7 border-2 rounded-l-lg p-1 cursor-pointer border-r-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="prev" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            <svg action="next" class="w-7 border-2 rounded-r-lg p-1 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path action="next" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
          </div>
        </div>
        <div class="content-area w-full h-96 overflow-hidden">
          <div class="platform shadow-xl h-full flex">
            @for ($i = 0; $i < $count; $i++)
                <div class="each-frame border-box flex-none h-full" title="{{$cats[$i]}}">
                <div class="main flex w-full p-8">
                <div class="subw-full my-auto">
                <div class="head text-3xl font-bold mb-4">{{$bludas[$i]}}</div>
                <div class="long-text text-lg">{{$recipes[$i]}}</div></div></div></div>
            @endfor
          </div>
        </div>
      </div>
      <style>
          .platform{
              position: relative;
              transition:right 0.3s;
          }
          .body{background-color:white !important;}
      		</style>

      <script>
          function gallery(){
              this.index=0;
              this.load=function(){
                this.rootEl = document.querySelector(".gallery");
                this.platform = this.rootEl.querySelector(".platform");
                this.frames = this.platform.querySelectorAll(".each-frame");
                this.contentArea = this.rootEl.querySelector(".content-area");
                this.width = parseInt(this.rootEl.style.width);
                this.limit = {start:0,end:this.frames.length-1};
                this.frames.forEach(each=>{each.style.width=this.width+"px";});
                this.goto(this.index);
              }
              this.set_title = function(){this.rootEl.querySelector(".heading").innerText=this.frames[this.index].getAttribute("title");}
              this.next = function(){this.platform.style.right=this.width * ++this.index + "px";this.set_title();}
              this.prev = function(){this.platform.style.right=this.width * --this.index + "px";this.set_title();}
              this.goto = function(index){this.platform.style.right = this.width * index + "px";this.index=index;this.set_title();}
              this.load();
          }
          var G = new gallery();
            G.rootEl.addEventListener("click",function(t){
                var val = t.target.getAttribute("action");
                if(val == "next" && G.index != G.limit.end){G.next();}
                if(val == "prev" && G.index != G.limit.start){G.prev();}
                if(val == "goto"){
                    let rv = t.target.getAttribute("goto");
                    rv = rv == "end" ? G.limit.end:rv;
                    G.goto(parseInt(rv));
                }
            });
            document.addEventListener("keyup",function(t){
                var val = t.keyCode;
                if(val == 39 && G.index != G.limit.end){G.next();}
                if(val == 37 && G.index != G.limit.start){G.prev();}
            });

            // run G.load() if new data loaded with ajax

      </script>
    	@endif
    @endif
    <form action="{{ url('/diets') }}" method="POST">
      @method('put')      
      @csrf
      <div class="px-4 py-3 text-center sm:px-6">
        <button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Сохранить рацион
        </button>
      </div>
    </form>
    @if (session('error'))
  <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
  <strong class="font-bold">О нееет!</strong>
  <span class="block sm:inline">Кажется, вы достигли максимально разрешенного сохранения рационов.</span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
</div>
@endif
    <div class="hidden sm:block" aria-hidden="true">
  <div class="py-5">
    <div class="border-t border-gray-200"></div>
  </div>
</div>
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
