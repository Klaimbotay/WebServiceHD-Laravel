<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class CalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!auth()->guest()){
            $idUser =  auth()->user()->id;
            $i = 0;
            $arrayBlud[0] = 0;
            $arrayCategory[0] = 0;
            $countedCcal = 0;

            if (auth()->user()->sex === 1 && auth()->user()->goal === 1)
                $needCcal = 9.99 * auth()->user()->weight + 6.25 * auth()->user()->height - 4.92 * auth()->user()->age + 5 + 350;
            elseif (auth()->user()->sex === 0 && auth()->user()->goal === 1)
                $needCcal = 9.99 * auth()->user()->weight + 6.25 * auth()->user()->height - 4.92 * auth()->user()->age - 161 + 350;
            elseif (auth()->user()->sex === 1 && auth()->user()->goal === 0)
                $needCcal = 9.99 * auth()->user()->weight + 6.25 * auth()->user()->height - 4.92 * auth()->user()->age + 5 - 350;
            else
                $needCcal = 9.99 * auth()->user()->weight + 6.25 * auth()->user()->height - 4.92 * auth()->user()->age - 161 - 350;
            while($needCcal>0){
                $random = rand(1,count(DB::table('bluda')->get()));
                $tableBludaObject = DB::table('bluda')->where('id_bluda',$random)->get()->toArray();

                //echo "<br>";
                if($needCcal - $tableBludaObject[0]->ccalories <= -500){
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
                    $recipeObject = DB::table('recipes')->where('id_bluda',$tableBludaObject[0]->Id_bluda)->get()->toArray();
                    $countedCcal = $countedCcal + $tableBludaObject[0]->ccalories;
                    $needCcal = $needCcal - $tableBludaObject[0]->ccalories;
                    $name_bluda[$i] = $tableBludaObject[0]->name_bluda;
                    $recipe_bluda[$i] = $recipeObject[0]->recipe;
                    $i = $i + 1;
                    if($arrayCategory[$i-1] === 1)
                        $cat[$i-1] = "Завтрак";
                    elseif ($arrayCategory[$i-1] === 2)
                        $cat[$i-1] = "Обед";
                    else
                        $cat[$i-1] = "Ужин";
                }
            }
            return view('calc.index',['bludas' => $name_bluda,'recipes' => $recipe_bluda, 'cats' => $cat, 'count' => $i, 'id_bluda' => $arrayBlud]);
        }
        else
            return view('auth.login');
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
        return view('calc.index');
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
       //

        //var_dump($request);
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
        //
    }
}
