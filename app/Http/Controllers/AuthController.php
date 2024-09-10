<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\Master;

class AuthController extends Controller
{
    const INFO_SUCCESS = 'Success';
    const INFO_FAILED = 'Failed';
    const CODE_SUCCESS = '00';
    const CODE_FAILED = '01';

    public function index(Request $request){
        return 'not authenticated';
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {
            // print_r(Auth::check());die;
            Session::put('id', Auth::user()->id);
            Session::put('email', Auth::user()->email);
            Session::put('username', Auth::user()->username);
            $request = [
                'code'    => self::CODE_SUCCESS,
                'info'    => self::INFO_SUCCESS,
                'data'    => null,
                 
            ];
        } else {
            $request = [
                'code'    => self::CODE_FAILED,
                'info'    => 'INVALID CREDENTIALS',
                'data'    => null,
                 
            ];
        }
        return $request;        
    }
    public function register(Request $request)
    {
        
        DB::beginTransaction();  
        $MasterClass    = new Master();
        $request        = request();
        $attributes     = [
            'email'     => $request->email,
            'username'  => $request->username,
            'password'  => $request->password,
            'created_at'=> date('Y-m-d H:i:s'),
        ];
        $attributes['password'] = bcrypt($attributes['password'] );
        $user = $MasterClass->saveGlobal('users', $attributes );
        $credentials = [
            "username"  =>  $request->username,
            "password"  =>  $request->password,
        ];

        Auth::attempt($credentials); 
        if(Auth::check() == true){
            DB::commit();
            Session::put('id', Auth::user()->id);
            Session::put('email', Auth::user()->email);
            Session::put('username', Auth::user()->username);
            $code = self::CODE_SUCCESS ;
            $info = self::INFO_SUCCESS ;
        }else{
            DB::rollback();
            $code = self::CODE_FAILED ;
            $info = self::INFO_FAILED ;
        }
        $results = [
            'code'  => $code,
            'info'  => $info,
            'data'  => null
        ];

        return $results ;
    }
}
