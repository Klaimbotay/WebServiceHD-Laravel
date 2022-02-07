@extends('layouts.app')

@section('content')
	@if (Auth::user()->sex === 1)
		@if (Auth::user()->goal === 1)
    		<h1 class="text-3xl">Чтобы набрать вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 + 350}} ккал. в сутки</h1>
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
          	<?php
    			$idUser =  Auth::user()->id;
    			$i = 0;
    			$arrayBlud[0] = 0;
					$arrayCategory[0] = 0;

    				$countedCcal = 0;
    				$needCcal = 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 + 350;
    				while($needCcal>0){
    					$random = rand(1,25);
    					$tableBludaObject = DB::table('bluda')->where('id_bluda',$random)->get()->toArray();

    					//echo "<br>";
    					if($needCcal - $tableBludaObject[0]->ccalories <= -350){
    						continue;
    					}
    					else{
								//Антиповтор
								if(in_array($tableBludaObject[0]->Id_bluda, $arrayBlud))
									continue;
								//Балансировка
								$arrayCategory[$i] = $tableBludaObject[0]->id_category;
								$arrayBlud[$i] = $tableBludaObject[0]->Id_bluda;
								$zavtrak = count(array_keys($arrayCategory, 1));
								$obed = count(array_keys($arrayCategory, 2));
								$uzhin = count(array_keys($arrayCategory, 3));
								if($zavtrak > 1 || $obed > 2 || $uzhin > 1) {
									array_pop($arrayCategory);
									array_pop($arrayBlud);
									continue;
								}
								//Добавление
    						$i = $i + 1;
    						$recipeObject = DB::table('recipes')->where('id_bluda',$tableBludaObject[0]->Id_bluda)->get()->toArray();
    						$countedCcal = $countedCcal + $tableBludaObject[0]->ccalories;
    						$needCcal = $needCcal - $tableBludaObject[0]->ccalories;
    						$name_bluda = $tableBludaObject[0]->name_bluda;
    						$recipe_bluda = $recipeObject[0]->recipe;
								if($arrayCategory[$i-1] === 1)
									$cat = "Завтрак";
								elseif ($arrayCategory[$i-1] === 2)
									$cat = "Обед";
								else
									$cat = "Ужин";
    						echo "<div class=\"each-frame border-box flex-none h-full\" title=\"$cat\">
								<div class=\"main flex w-full p-8\">
								<div class=\"subw-full my-auto\">
								<div class=\"head text-3xl font-bold mb-4\">$name_bluda</div>
								<div class=\"long-text text-lg\">$recipe_bluda.</div></div></div></div>";
    					}
    				}
    				echo "Я ПОДОБРАЛ ТЕБЕ РАЦИОН НА $countedCcal КАЛЛОРИЙ";

    			//var_dump($arrayBlud);
    		?>
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
    		<form action="{{ url('/diets') }}" method="POST">
    			@csrf
    			@method()
    			<div class="px-4 py-3 text-center sm:px-6">
    				<button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Сохранить рацион
    				</button>
    			</div>
    		</form>
    	@endif
    	@if (Auth::user()->goal === 0)
    		<h1 class="text-3xl">Чтобы сбросить вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 - 350}} ккал. в сутки</h1>
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
          	<?php
    			$idUser =  Auth::user()->id;
    			$i = 0;
    			$arrayBlud[0] = 0;
					$arrayCategory[0] = 0;

    				$countedCcal = 0;
    				$needCcal = 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age + 5 - 350;
    				while($needCcal>0){
    					$random = rand(1,25);
    					$tableBludaObject = DB::table('bluda')->where('id_bluda',$random)->get()->toArray();

    					//echo "<br>";
    					if($needCcal - $tableBludaObject[0]->ccalories <= -350){
    						continue;
    					}
    					else{
								//Антиповтор
								if(in_array($tableBludaObject[0]->Id_bluda, $arrayBlud))
									continue;
								//Балансировка
								$arrayCategory[$i] = $tableBludaObject[0]->id_category;
								$arrayBlud[$i] = $tableBludaObject[0]->Id_bluda;
								$zavtrak = count(array_keys($arrayCategory, 1));
								$obed = count(array_keys($arrayCategory, 2));
								$uzhin = count(array_keys($arrayCategory, 3));
								if($zavtrak > 1 || $obed > 2 || $uzhin > 1) {
									array_pop($arrayCategory);
									array_pop($arrayBlud);
									continue;
								}
								//Добавление
    						$i = $i + 1;
    						$recipeObject = DB::table('recipes')->where('id_bluda',$tableBludaObject[0]->Id_bluda)->get()->toArray();
    						$countedCcal = $countedCcal + $tableBludaObject[0]->ccalories;
    						$needCcal = $needCcal - $tableBludaObject[0]->ccalories;
    						$name_bluda = $tableBludaObject[0]->name_bluda;
    						$recipe_bluda = $recipeObject[0]->recipe;
								if($arrayCategory[$i-1] === 1)
									$cat = "Завтрак";
								elseif ($arrayCategory[$i-1] === 2)
									$cat = "Обед";
								else
									$cat = "Ужин";
    						echo "<div class=\"each-frame border-box flex-none h-full\" title=\"$cat\">
								<div class=\"main flex w-full p-8\">
								<div class=\"subw-full my-auto\">
								<div class=\"head text-3xl font-bold mb-4\">$name_bluda</div>
								<div class=\"long-text text-lg\">$recipe_bluda.</div></div></div></div>";

    						// echo $tableBludaObject[0]->name_bluda."<br>";
    						// echo "<br>РЕЦЕПТ<br>";
    						// echo $recipeObject[0]->recipe."<br><br>";
    					}
    				}
    				// echo "Я ПОДОБРАЛ ТЕБЕ РАЦИОН НА $countedCcal КАЛЛОРИЙ";

    			//var_dump($arrayBlud);
    		?>
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
    		<form action="{{ url('/diets') }}" method="GET">
    			@csrf
    			<div class="px-4 py-3 text-center sm:px-6">
    				<button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Сохранить рацион
    				</button>
    			</div>
    		</form>
    	@endif
    @endif
    @if (Auth::user()->sex === 0)
    	@if (Auth::user()->goal === 1)
    		<h1 class="text-3xl">Чтобы набрать вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 + 350}} ккал. в сутки</h1>
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
          	<?php
    			$idUser =  Auth::user()->id;
    			$i = 0;
    			$arrayBlud[0] = 0;
					$arrayCategory[0] = 0;

    				$countedCcal = 0;
    				$needCcal = 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 + 350;
    				while($needCcal>0){
    					$random = rand(1,25);
    					$tableBludaObject = DB::table('bluda')->where('id_bluda',$random)->get()->toArray();

    					//echo "<br>";
    					if($needCcal - $tableBludaObject[0]->ccalories <= -350){
    						continue;
    					}
    					else{
								//Антиповтор
								if(in_array($tableBludaObject[0]->Id_bluda, $arrayBlud))
									continue;
								//Балансировка
								$arrayCategory[$i] = $tableBludaObject[0]->id_category;
								$arrayBlud[$i] = $tableBludaObject[0]->Id_bluda;
								$zavtrak = count(array_keys($arrayCategory, 1));
								$obed = count(array_keys($arrayCategory, 2));
								$uzhin = count(array_keys($arrayCategory, 3));
								if($zavtrak > 1 || $obed > 2 || $uzhin > 1) {
									array_pop($arrayCategory);
									array_pop($arrayBlud);
									continue;
								}
								//Добавление
    						$i = $i + 1;
    						$recipeObject = DB::table('recipes')->where('id_bluda',$tableBludaObject[0]->Id_bluda)->get()->toArray();
    						$countedCcal = $countedCcal + $tableBludaObject[0]->ccalories;
    						$needCcal = $needCcal - $tableBludaObject[0]->ccalories;
    						$name_bluda = $tableBludaObject[0]->name_bluda;
    						$recipe_bluda = $recipeObject[0]->recipe;
								if($arrayCategory[$i-1] === 1)
									$cat = "Завтрак";
								elseif ($arrayCategory[$i-1] === 2)
									$cat = "Обед";
								else
									$cat = "Ужин";
    						echo "<div class=\"each-frame border-box flex-none h-full\" title=\"$cat\">
								<div class=\"main flex w-full p-8\">
								<div class=\"subw-full my-auto\">
								<div class=\"head text-3xl font-bold mb-4\">$name_bluda</div>
								<div class=\"long-text text-lg\">$recipe_bluda.</div></div></div></div>";

    						// echo $tableBludaObject[0]->name_bluda."<br>";
    						// echo "<br>РЕЦЕПТ<br>";
    						// echo $recipeObject[0]->recipe."<br><br>";
    					}
    				}
    				// echo "Я ПОДОБРАЛ ТЕБЕ РАЦИОН НА $countedCcal КАЛЛОРИЙ";

    			//var_dump($arrayBlud);
    		?>
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
    		<form action="{{ url('/diets') }}" method="GET">
    			@csrf
    			<div class="px-4 py-3 text-center sm:px-6">
    				<button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Сохранить рацион
    				</button>
    			</div>
    		</form>
    	@endif
    	@if (Auth::user()->goal === 0)
    		<h1 class="text-3xl">Чтобы сбросить вес, необходимо потреблять {{ 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 - 350}} ккал. в сутки</h1>
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
          	<?php
    			$idUser =  Auth::user()->id;
    			$i = 0;
    			$arrayBlud[0] = 0;
					$arrayCategory[0] = 0;

    				$countedCcal = 0;
    				$needCcal = 9.99 * Auth::user()->weight + 6.25 * Auth::user()->height - 4.92 * Auth::user()->age - 161 - 350;
    				while($needCcal>0){
    					$random = rand(1,25);
    					$tableBludaObject = DB::table('bluda')->where('id_bluda',$random)->get()->toArray();

    					//echo "<br>";
    					if($needCcal - $tableBludaObject[0]->ccalories <= -350){
    						continue;
    					}
    					else{
								//Антиповтор
								if(in_array($tableBludaObject[0]->Id_bluda, $arrayBlud))
									continue;
								//Балансировка
								$arrayCategory[$i] = $tableBludaObject[0]->id_category;
								$arrayBlud[$i] = $tableBludaObject[0]->Id_bluda;
								$zavtrak = count(array_keys($arrayCategory, 1));
								$obed = count(array_keys($arrayCategory, 2));
								$uzhin = count(array_keys($arrayCategory, 3));
								if($zavtrak > 1 || $obed > 2 || $uzhin > 1) {
									array_pop($arrayCategory);
									array_pop($arrayBlud);
									continue;
								}
								//Добавление
    						$i = $i + 1;
    						$recipeObject = DB::table('recipes')->where('id_bluda',$tableBludaObject[0]->Id_bluda)->get()->toArray();
    						$countedCcal = $countedCcal + $tableBludaObject[0]->ccalories;
    						$needCcal = $needCcal - $tableBludaObject[0]->ccalories;
    						$name_bluda = $tableBludaObject[0]->name_bluda;
    						$recipe_bluda = $recipeObject[0]->recipe;
								if($arrayCategory[$i-1] === 1)
									$cat = "Завтрак";
								elseif ($arrayCategory[$i-1] === 2)
									$cat = "Обед";
								else
									$cat = "Ужин";
    						echo "<div class=\"each-frame border-box flex-none h-full\" title=\"$cat\">
								<div class=\"main flex w-full p-8\">
								<div class=\"subw-full my-auto\">
								<div class=\"head text-3xl font-bold mb-4\">$name_bluda</div>
								<div class=\"long-text text-lg\">$recipe_bluda.</div></div></div></div>";

    						// echo $tableBludaObject[0]->name_bluda."<br>";
    						// echo "<br>РЕЦЕПТ<br>";
    						// echo $recipeObject[0]->recipe."<br><br>";
    					}
    				}
    				// echo "Я ПОДОБРАЛ ТЕБЕ РАЦИОН НА $countedCcal КАЛЛОРИЙ";

    			//var_dump($arrayBlud);
    		?>
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
    		<form action="{{ url('/diets') }}" method="GET">
    			@csrf
    			<div class="px-4 py-3 text-center sm:px-6">
    				<button type="submit" class="inline-flex justify-center py-2 px-4 borderborder-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2focus:ring-offset-2 focus:ring-indigo-500">Сохранить рацион
    				</button>
    			</div>
    		</form>
    	@endif
    @endif
@endsection
