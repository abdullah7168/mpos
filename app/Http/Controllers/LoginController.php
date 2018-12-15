<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getLogin(){
        return view('auth.login');
    }

    public function postLogin(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            return redirect('/')
                    ->with('message','Welome! '.$user->name);
        }

        return redirect()
                ->back()
                ->withInput($request->only('email'))
                ->with(
                    'message',
                    '<p class="alert alert-danger">Invalid email or password</p>'
                );
    }

    public function logout(){
        Auth::logout();
        return redirect('/login')
                ->with('message','<p class="alert alert-info">Logged out!<p>');
    }
}
