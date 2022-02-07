<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use ArrayObject;
use Redirect;

class DietsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->guest()){
            $id = auth()->user()->id;
            $user = DB::select("select max(`id_menu`) as max from users_diets where `id_user` = $id");
            // Временные массивы, так надо
            $tempArray = new ArrayObject();
            $tempArrayName = new ArrayObject();
            $tempArrayCcal = new ArrayObject();
            $tempArrayProducts = new ArrayObject();
            $tempArrayProductsSec = new ArrayObject();
            $tempArrayProductsCount = new ArrayObject();
            $tempArrayProductsCountSec = new ArrayObject();
            $tempArrayProductsEd = new ArrayObject();
            $tempArrayProductsEdSec = new ArrayObject();
            // ID блюд
            $arrayBluda = new ArrayObject();
            // Костыль
            $arrayK = array();

            // Количество рационов сохраненных
            $howManySaves = DB::table("users_diets")->distinct(['id_user','id_menu'])->where("id_user", "$id")->count();
            // Названия блюд
            $arrayBludaNames = new ArrayObject();
            // Рецепты блюд
            $arrayBludaRecipes = new ArrayObject();
            // Количество блюд в рационе
            $arrayCount = new ArrayObject();
            $count = 0;
            // Каллории блюд
            $arrayCcal = new ArrayObject();
            // Ингредиенты ID
            $arrayProductsID = new ArrayObject();
            // Ингредиенты Кол-во и ед измерения
            $arrayProductsCount = new ArrayObject();
            $arrayProductsEd = new ArrayObject();
            $arrayProductsEdNames = new ArrayObject();
            // Ингредиенты названия
            $arrayProductsNames = new ArrayObject();


            // Получаем Id сохраненных блюд пользователя
            for($j = 0; $j < $howManySaves; $j++){
                $k = $j;
                while(DB::table('users_diets')->where('id_user',$id)->where('id_menu', $k)->doesntExist() || (DB::table('users_diets')->where('id_user',$id)->where('id_menu', $k)->exists() && in_array($k, $arrayK))){
                    $k++;
                }
                array_push($arrayK,$k);
                $bluda = DB::table('users_diets')->where('id_user',$id)->where('id_menu', $k)->get()->toArray();
                for($i = 0; $i < count($bluda); $i++){
                    $tempArray->append($bluda[$i]->id_bluda);
                }
                $arrayBluda->append($tempArray);
                unset($tempArray);
                $tempArray = new ArrayObject();
            }
            // Получаем Названия сохраненных блюд пользователя и ингредиенты ID
            for($i = 0; $i < count($arrayBluda); $i++){
                for($j = 0; $j < count($arrayBluda[$i]); $j++){
                    $id_blud = $arrayBluda[$i][$j];
                    $ingredients = DB::select("select `id_product`,`kolvo`,`code` from ingredients where `id_bluda` = $id_blud");
                    for($k = 0; $k < count($ingredients); $k++){
                        $tempArrayProducts->append($ingredients[$k]->id_product);
                        $tempArrayProductsCount->append($ingredients[$k]->kolvo);
                        if($ingredients[$k]->code === null)
                            $tempArrayProductsEd->append("0");
                        else
                            $tempArrayProductsEd->append($ingredients[$k]->code);
                    }
                    $name = DB::table('bluda')->where('Id_bluda', $arrayBluda[$i][$j])->get()->toArray();
                    $recipe = DB::table('recipes')->where('id_bluda', $arrayBluda[$i][$j])->get()->toArray();
                    $tempArrayName->append($name[0]->name_bluda);
                    $tempArrayCcal->append($name[0]->ccalories);
                    $tempArray->append($recipe[0]->recipe);
                    $tempArrayProductsSec->append($tempArrayProducts);
                    $tempArrayProductsEdSec->append($tempArrayProductsEd);
                    $tempArrayProductsCountSec->append($tempArrayProductsCount);

                    $count++;

                    // Очищаем временные массивы
                    unset($tempArrayProducts);
                    $tempArrayProducts = new ArrayObject();
                    unset($tempArrayProductsEd);
                    $tempArrayProductsEd = new ArrayObject();
                    unset($tempArrayProductsCount);
                    $tempArrayProductsCount = new ArrayObject();
                }

                $arrayProductsEd->append($tempArrayProductsEdSec);
                $arrayProductsCount->append($tempArrayProductsCountSec);
                $arrayProductsID->append($tempArrayProductsSec);
                $arrayCcal->append($tempArrayCcal);
                $arrayCount->append($count);
                $arrayBludaRecipes->append($tempArray);
                $arrayBludaNames->append($tempArrayName);
                $count = 0;

                // Очищаем временные массивы
                unset($tempArrayCcal);
                $tempArrayCcal = new ArrayObject();
                unset($tempArrayName);
                $tempArrayName = new ArrayObject();
                unset($tempArray);
                $tempArray = new ArrayObject();
                unset($tempArrayProductsSec);
                $tempArrayProductsSec = new ArrayObject();
                 unset($tempArrayProductsEdSec);
                $tempArrayProductsEdSec = new ArrayObject();
                unset($tempArrayProductsCountSec);
                $tempArrayProductsCountSec = new ArrayObject();
            }
            // Получаем названия ингредиентов блюд
            for($i = 0; $i < count($arrayProductsID); $i++){
                for($j = 0; $j < count($arrayProductsID[$i]); $j++){
                    for($k = 0; $k < count($arrayProductsID[$i][$j]); $k++){
                        $name = DB::table('ingredients_table')->where('id_product', $arrayProductsID[$i][$j][$k])->get()->toArray();
                        $code = DB::table('izmerenia')->where('code', $arrayProductsEd[$i][$j][$k])->get()->toArray();
                        if($code == null)
                            $tempArrayProductsEd->append("");
                        else
                            $tempArrayProductsEd->append($code[0]->ed_izmerenia);
                        $tempArrayProducts->append($name[0]->name);
                    }
                    $tempArrayProductsSec->append($tempArrayProducts);
                    $tempArrayProductsEdSec->append($tempArrayProductsEd);
                    unset($tempArrayProducts);
                    $tempArrayProducts = new ArrayObject();
                    unset($tempArrayProductsEd);
                    $tempArrayProductsEd = new ArrayObject();
                }
                $arrayProductsEdNames->append($tempArrayProductsEdSec);
                $arrayProductsNames->append($tempArrayProductsSec);
                unset($tempArrayProductsSec);
                $tempArrayProductsSec = new ArrayObject();
                unset($tempArrayProductsEdSec);
                $tempArrayProductsEdSec = new ArrayObject();
            }
            return view('diets.index',['names' => $arrayBludaNames, 'ccals' => $arrayCcal, 'recipes' => $arrayBludaRecipes, 'saves' => $howManySaves, 'count' => $arrayCount, 'ingredients' => $arrayProductsNames, 'count_ingredients' => $arrayProductsCount, 'ed_arr' => $arrayProductsEdNames, 'id_menus' => $arrayK]);
        }
        else {
            return view('auth.login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('diets.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        session_start();
        $id = auth()->user()->id;
        $new = $_SESSION['id_bludas'];
        $count = count($_SESSION['id_bludas']);

        $user = DB::table('users_diets')->where('id_user',$id)->get()->toArray();
        if(count($user)===0)
            $id_menu = 0;
        else{
            $id_menu = DB::table("users_diets")->distinct(['id_user','id_menu'])->where("id_user", "$id")->count()-1;
            if($id_menu > 2){
                return back()->withError('Вы достигли максимального количества сохранения рационов питания');
            }
            $user1 = DB::select("select max(`id_menu`) as max from users_diets where `id_user` = $id");
            $id_menu = $user1[0]->max;
            $id_menu = $id_menu + 1;        
        }


        for ($i = 0; $i<$count;$i++){
            DB::table('users_diets')->insert(['id_user' => $id, 'id_bluda' => $new[$i],'id_menu' => $id_menu]);
        }

        return Redirect::back()->with('message','Operation Successful !');

        //$user['sex'] = $request['sex']
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('users_diets')->where('id_menu', $id)->where('id_user', auth()->user()->id)->delete();

        // return view('diets.index');
        return Redirect::back()->with('message','Operation Successful !');

        //$this->index();
    }
}
