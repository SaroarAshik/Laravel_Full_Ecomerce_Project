<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\Carbon;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class SliderController extends Controller{

    public function index(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index',compact('sliders'));
   }

    // slider store
    public function store(Request $request){
        $request->validate([
            'image' => 'required',
        ]);

        $manager = new ImageManager(new Driver());
        $image = $request->file('image');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($request->file('image'));
        $img=$img->resize(870,370);
        $img->toJpeg(80)->save(base_path('public/uploads/slider/'.$name_gen));
        $save_url='uploads/slider/'.$name_gen;


            Slider::insert([
                'title_en' => $request->title_en,
                'title_bn' => $request->title_bn,
                'description_en' => $request->description_en,
                'description_bn' => $request->description_bn,
                'image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification=array(
                'message'=>'Slider Upload Success',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);

       }
      // edit slider
        public function edit($id){
            $slider = Slider::findOrFail($id);
            return view('admin.slider.edit',compact('slider'));
        }



    //slider upated
    public function update(Request $request){
    $id = $request->id;
    $old_img = $request->old_image;

    if ($request->file('image')){
        unlink($old_img);

        $manager = new ImageManager(new Driver());
        $image = $request->file('image');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($request->file('image'));
        $img=$img->resize(870,370);
        $img->toJpeg(80)->save(base_path('public/uploads/slider/'.$name_gen));
        $save_url='uploads/slider/'.$name_gen;

         Slider::findOrFail($id)->update([
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'description_en' => $request->description_en,
            'description_bn' => $request->description_bn,
            'image' => $save_url,
            'created_at' => Carbon::now(),
         ]);

         $notification=array(
             'message'=>'Slider Update Success',
             'alert-type'=>'success'
         );
         return Redirect()->route('sliders')->with($notification);
     }else{

        Slider::findOrFail($id)->update([
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'description_en' => $request->description_en,
            'description_bn' => $request->description_bn,
            'created_at' => Carbon::now(),
         ]);

         $notification=array(
             'message'=>'Slider Update Success',
             'alert-type'=>'success'
         );
         return Redirect()->route('sliders')->with($notification);
     }

   }

     ////////////////////// Slider Delete ////////////////
     public function destroy($id){
        $oldimg = Slider::findOrFail($id);
        unlink($oldimg->image);
        Slider::findOrFail($id)->delete();

        $notification=array(
            'message'=>'Slider Dlete Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }


    ////////// product active and inactive ///////////
        public function inactive($id){
            Slider::findOrFail($id)->update(['status' => 0]);
            $notification=array(
                'message'=>'Slider Inactivated',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }

        public function active($id){
            Slider::findOrFail($id)->update(['status' => 1]);
            $notification=array(
                'message'=>'Slider Activated',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
        }



}
