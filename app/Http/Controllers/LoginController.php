<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    public function index() {

        return view('login/login');
    }

    public function ProsesLogin(Request $request) {


        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $pass = $request->password;


        if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'super'])) {
            $user = users::where('username',$username)->get();
            Session::put('nama', $user[0]['name']);
            Session::put('name', $username);
            Session::put('level','Super');
            Session::put('id_user',$user[0]['id']);
            Session::put('login', TRUE);
            Session::flash('message', 'Admin Successfully Login!');
            return Redirect::intended('/datapenjaminanview');
            
        } 
        else if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'admin'])) {
            $user = users::where('username',$username)->get();
            Session::put('nama', $user[0]['name']);
            Session::put('name', $username);
            Session::put('level','Admin');
            Session::put('id_user',$user[0]['id']);
            Session::put('kd_user',$user[0]['kodeuser']);
            Session::put('login', TRUE);
            Session::flash('message', 'Admin Successfully Login!');
            return Redirect::intended('/datapenjaminanview');
            
        } 
        else if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'bpr'])) 
        {          
           
            $user = users::where('username',$username)
                    ->leftJoin('banks', 'banks.idbank', '=', 'users.idbank')
                    ->get();
            $idbank=$user[0]['idbank']; 
            $kodepusat=$user[0]['kodepusat']; 
            Session::put('name', $username);
            Session::put('user', $user[0]['user']);
            Session::put('nama', $user[0]['name']);
            Session::put('jenisbank', $user[0]['jenisbank']);
            Session::put('login', TRUE);
            Session::put('level','BPR');
            Session::put('idbank',$idbank);
            Session::put('kodepusat',$kodepusat);
            Session::flash('message', 'User Successfully Login!');
            return Redirect::intended('/bpr');
       
        } 
        else if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'koperasi'])) 
        {          
           
            $user = users::where('username',$username)
                    ->leftJoin('banks', 'banks.idbank', '=', 'users.idbank')
                    ->get();
            $idbank=$user[0]['idbank']; 
            $kodepusat=$user[0]['kodepusat']; 
            Session::put('name', $username);
            Session::put('user', $user[0]['user']);
            Session::put('nama', $user[0]['name']);
            Session::put('jenisbank', $user[0]['jenisbank']);
            Session::put('login', TRUE);
            Session::put('level','koperasi');
            Session::put('idbank',$idbank);
            Session::put('kodepusat',$kodepusat);
            Session::flash('message', 'User Successfully Login!');
            return Redirect::intended('/bpr');
       
        } 
        else if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'user'])) {
           
            $user = users::where('username',$username)
                    ->leftJoin('banks', 'banks.idbank', '=', 'users.idbank')
                    ->get();
            $idbank=$user[0]['idbank']; 
            $kodepusat=$user[0]['kodepusat']; 
            Session::put('name', $username);
            Session::put('user', $user[0]['user']);
            Session::put('nama', $user[0]['name']);
            Session::put('name', $username);
            Session::put('login', TRUE);
            Session::put('level','User');
            Session::put('idbank',$idbank);
            Session::put('kodepusat',$kodepusat);
            Session::flash('message', 'User Successfully Login!');
            return Redirect::intended('/bpr');
        }else if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'bntb'])) {            
            $user = users::where('username',$username)->get();
            $idbank=$user[0]['idbank']; 
            Session::put('name', $username);
            Session::put('login', TRUE); 
            Session::put('idbank',$idbank);
            Session::put('level','Bntb');
            Session::flash('message', 'User Successfully Login!');
            return Redirect::intended('/bpr');
        }  if (Auth::attempt(['username' => $username, 'password' => $pass, 'level' => 'direksi'])) {
            $user = users::where('username',$username)
                    ->get();
            Session::put('nama', $user[0]['name']);
            Session::put('name', $username);
            Session::put('level','Direksi');
            Session::put('login', TRUE);
            Session::flash('message', 'Admin Successfully Login!');
            return Redirect::intended('/datapenjaminanview#home1');
            
        } else {
            Session::flash('message', 'Wrong Username and or Password!!!');
            return Redirect::intended('/');
        }
    }

    public function doLogout() {
        session::flush();

        return Redirect::to('/');
    }

}
