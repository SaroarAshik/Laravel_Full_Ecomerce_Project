<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Carbon\Carbon;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class BrandController extends Controller{
    public function index(){
        $brands = Brand::latest()->get();
        $date = Carbon::now();
        return view('admin.brand.index',compact('brands'));
    }

     // store brand
   public function brandStore(Request $request){
    $request->validate([
         'brand_name_en' => 'required',
         'brand_name_bn' => 'required',
         'brand_image' => 'required',
    ],[
        'brand_name_en.required' => 'input English brand name',
        'brand_name_bn.required' => 'input bangla brand name'
    ]);


        $manager = new ImageManager(new Driver());
        $image = $request->file('brand_image');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($request->file('brand_image'));
        $img=$img->resize(70,46);
        $img->toJpeg(80)->save(base_path('public/fontend/media/'.$name_gen));
        $save_url='fontend/media/'.$name_gen;

         Brand::insert([
             'brand_name_en' => $request->brand_name_en,
             'brand_name_bn' => $request->brand_name_bn,
             'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_en)),
             'brand_slug_bn' => str_replace(' ','-',$request->brand_name_bn),
             'brand_image' => $save_url,
             'created_at' => Carbon::now(),
         ]);

         $notification=array(
             'message'=>'Brand Upload Success',
             'alert-type'=>'success'
         );
         return Redirect()->back()->with($notification);

    }


    //editdata
    public function edit($brand_id){
        $brand = Brand::findOrFail($brand_id);
        return view('admin.brand.edit',compact('brand'));
    }


     //update Brand
   public function brandUpdate(Request $request){
    $brand_id = $request->id;
    $old_img = $request->old_image;

    if ($request->file('brand_image')) {
         unlink($old_img);

          $manager = new ImageManager(new Driver());
          $image = $request->file('brand_image');
          $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($request->file('brand_image'));
          $img=$img->resize(70,46);
          $img->toJpeg(80)->save(base_path('public/fontend/media/'.$name_gen));
          $save_url='fontend/media/'.$name_gen;

         Brand::findOrFail($brand_id)->update([
             'brand_name_en' => $request->brand_name_en,
             'brand_name_bn' => $request->brand_name_bn,
             'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_en)),
             'brand_slug_bn' => str_replace(' ','-',$request->brand_name_bn),
             'brand_image' => $save_url,
             'created_at' => Carbon::now(),
         ]);

         $notification=array(
             'message'=>'Brand Update Success',
             'alert-type'=>'success'
         );
         return Redirect()->route('brands')->with($notification);
    }else {
     Brand::findOrFail($brand_id)->update([
         'brand_name_en' => $request->brand_name_en,
         'brand_name_bn' => $request->brand_name_bn,
         'brand_slug_en' => strtolower(str_replace(' ','-',$request->brand_name_en)),
         'brand_slug_bn' => str_replace(' ','-',$request->brand_name_bn),
         'created_at' => Carbon::now(),
     ]);

     $notification=array(
         'message'=>'Brand Update Success',
         'alert-type'=>'success'
     );
     return Redirect()->route('brands')->with($notification);
    }
}


   //delete brand
   public function delete($brand_id){
        $brand = Brand::findOrFail($brand_id);
        $img = $brand->brand_image;
        unlink($img);
        Brand::findOrFail($brand_id)->delete();
        $notification=array(
            'message'=>'Brand Delete Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

}
