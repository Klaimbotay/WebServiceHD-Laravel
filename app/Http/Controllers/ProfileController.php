<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class ProfileController extends Controller
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
            return view('profile.index', ['users' => DB::table('users')->where('id',$id)->get()]);
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
        $id = auth()->user()->id;
        $user = DB::table('users')->where('id',$id)->get();


        Validator::make($request, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $request) {
            if (! isset($request['current_password']) || ! Hash::check($request['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePassword');

        DB::table('users')->where('id',$id)->update(['password' => Hash::make($request['password'])]);

        //$user->forceFill([
         //   'password' => Hash::make($request['password']),
        //])->save();

        //$user['sex'] = $request['sex']

        return view('profile.index', ['users' => DB::table('users')->where('id',$id)->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('profile.index');
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
        $id = auth()->user()->id;
        $user = DB::table('users')->where('id',$id)->update(['surname' => $request->get('last_name'), 'sex' =>  $request->get('sex'),
                                                            'age' =>  $request->get('age'),'height' =>  $request->get('height'),
                                                             'weight' =>  $request->get('weight'), 'goal' => $request->get('cel')]);

        return view('profile.index', ['users' => DB::table('users')->where('id',$id)->get()]);


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
