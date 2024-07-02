<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller{

    use RegistersUsers;
    protected $redirectTo = '/home';

    protected function redirectTo(){
        if (Auth()->user()->role_id !=2 ) {
            return route('admin.dashboard');

        }elseif (Auth()->user()->role_id ==2 ) {
            return route('user.dashboard');
        }
    }


    public function __construct(){
        $this->middleware('guest');
    }


    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', ],
        ]);
    }

    protected function create(array $data){
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'image' => 'fontend/media/avatar.png',
            'password' => Hash::make($data['password']),
        ]);
    }
}
