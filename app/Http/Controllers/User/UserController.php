<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

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


    // imag page
    public function imagePage(){
        return view('user.change-image');
    }

    //update image
    public function updateImage(Request $request){
        $old_image = $request->old_image;
        if (User::findOrFail(Auth::id())->image == 'fontend/media/avatar.png') {
            $manager = new ImageManager(new Driver());
            $image = $request->file('image');
            $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img=$img->resize(370,246);
            $img->toJpeg(80)->save(base_path('public/fontend/media/'.$name_gen));
            $save_url='fontend/media/'.$name_gen;

            User::findOrFail(Auth::id())->Update([
                'image' => $save_url
            ]);
            $notification=array(
                'message'=>'Image Successfully Updated',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }
        else{
            unlink($old_image);
            $manager = new ImageManager(new Driver());
            $image = $request->file('image');
            $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img=$img->resize(370,246);
            $img->toJpeg(80)->save(base_path('public/fontend/media/'.$name_gen));
            $save_url='fontend/media/'.$name_gen;

            User::findOrFail(Auth::id())->Update([
                'image' => $save_url
            ]);
            $notification=array(
                'message'=>'Image Successfully Updated',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }

    }


    public function updatePassPage(){
        return view('user.password');
    }

    //store password
    public function storePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
        ]);

        $db_pass = Auth::user()->password;
        $current_password = $request->old_password;
        $newpass = $request->new_password;
        $confirmpass = $request->password_confirmation;

       if (Hash::check($current_password,$db_pass)) {
          if ($newpass === $confirmpass) {
              User::findOrFail(Auth::id())->update([
                'password' => Hash::make($newpass)
              ]);

              Auth::logout();
              $notification=array(
                'message'=>'Your Password Change Success. Now Login With New Password',
                'alert-type'=>'success'
            );
            return Redirect()->route('login')->with($notification);

          }else {

            $notification=array(
                'message'=>'New Password And Confirm Password Not Same',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
          }
       }else {
        $notification=array(
            'message'=>'Old Password Not Match',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
       }
    }

}
