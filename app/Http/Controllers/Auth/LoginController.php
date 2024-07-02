<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller{
    
    use AuthenticatesUsers;

    protected $redirectTo = '/home';
    
    protected function redirectTo(){
        if (Auth()->user()->role_id !=2 ) {
            return route('admin.dashboard');

        }elseif (Auth()->user()->role_id ==2 ) {
        return route('user.dashboard');
        }
    }

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
}
