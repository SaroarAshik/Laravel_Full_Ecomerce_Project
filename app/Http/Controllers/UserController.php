<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    public function index(){
        return view('user.home');
    }

    public function updateData(Request $request){
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ],[
                'name.required' => 'input your name',
            ]);

            User::findOrFail(Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'updated_at' => Carbon::now(),
            ]);

            $notification=array(
                'message'=>'Your Profile Updated',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification); 
    }

}
