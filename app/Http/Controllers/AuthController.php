<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request){
        if($request->session()->has('id')){
            return redirect()->route('home');
        }else{
            return view('auth.login');
        }
    }

    public function register(){
        return view('auth.signup');
    }

    public function signup(Request $request){
        $user = new User;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $user->save();

        return redirect()->route('login');
    }

    public function signin(Request $request){
        $email = $request->email;
        $password = $request->password;

        $temp = User::where('email', $email)->get();

        if (\Hash::check($password, $temp[0]['password'])) {
            // The passwords match...
            $request->session()->put('id', $temp[0]['id']);
            return redirect()->route('home');
        }else{
            return redirect()->route('login');
        }
    }

    public function logout(Request $request){
        $request->session()->forget('id');
        return redirect()->route('login');
    }
}
