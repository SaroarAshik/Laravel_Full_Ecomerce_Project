<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubsubCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Carbon\Carbon;
use App\Models\MultiImg;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;



class ProductController extends Controller{

    public function addProduct(){
        $categories = Category::latest()->get();
        $brands = Brand::all();
        return view('admin.product.create',compact('categories','brands'));
    }

   //get subsubcategory from subcategory id
   public function getSubSubCat($sub_cat){
        $subsubCat = SubsubCategory::where('subcategory_id',$sub_cat)->orderBy('subsubcategory_name_en','ASC')->get();
        return json_encode($subsubCat);
    }

    /// store product
   public function store(Request $request){

          $manager = new ImageManager(new Driver());
          $image = $request->file('product_thambnail');
          $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
          $img = $manager->read($request->file('product_thambnail'));
          $img=$img->resize(870,370);
          $img->toJpeg(80)->save(base_path('public/uploads/products/thambnail/'.$name_gen));
          $save_url = 'uploads/products/thambnail/'.$name_gen;

        $product_id =  Product::insertGetId([
                'user_id' => Auth::id(),
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'subsubcategory_id' => $request->subsubcategory_id,
                'product_name_en' => $request->product_name_en,
                'product_slug_en' => strtolower(str_replace(' ','-',$request->product_name_en)),
                'product_name_bn' => $request->product_name_bn,
                'product_slug_bn' => str_replace(' ','-',$request->product_name_bn),
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_tags_en' => $request->product_tags_en,
                'product_tags_bn' => $request->product_tags_bn,
                'product_size_en' => $request->product_size_en,
                'product_size_bn' => $request->product_size_bn,
                'product_color_en' => $request->product_color_en,
                'product_color_bn' => $request->product_color_bn,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_descp_en' => $request->short_descp_en,
                'short_descp_bn' => $request->short_descp_bn,
                'long_descp_en' => $request->long_descp_en,
                'long_descp_bn' => $request->long_descp_bn,
                'hot_deals' => $request->hot_deals,
                'featured' => $request->featured,
                'special_offer' => $request->special_offer,
                'special_deals' => $request->special_deals,
                'product_thambnail' => $save_url,
                'status' => 1,
                'created_at' => Carbon::now(),
    ]);



//////////////////// Multiple image upload start /////////////////////////////////


    $images = $request->file('multi_img');

    foreach ($images as $img) {

        $manager = new ImageManager(new Driver());
        $name_gen=hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $img1 = $manager->read($img);

        $img1->toJpeg(80)->save(base_path('public/uploads/products/thambnail/'.$name_gen));
        $save_url = 'uploads/products/thambnail/'.$name_gen;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $save_url,
                'created_at' => Carbon::now(),
            ]);
    }

    //////////////////// Multiple image uplod End /////////////////////////////////

    $notification=array(
        'message'=>'Product Added Success',
        'alert-type'=>'success'
    );
    return Redirect()->back()->with($notification);
}




// manage product
public function manageProduct(){
    $products = Product::latest()->get();
    return view('admin.product.index',compact('products'));
}


// edit product
public function edit($product_id){
    $product = Product::findOrFail($product_id);
    $categories = Category::latest()->get();
    $brands = Brand::latest()->get();
    $multiImgs = MultiImg::where('product_id',$product_id)->latest()->get();
    return view('admin.product.edit',compact('product','categories','brands','multiImgs'));
}


    // product update without image
    public function productDataUpdate(Request $request){
        $product_id = $request->product_id;

        $request->validate([
            'brand_id' => 'required',
            'subcategory_id' => 'required',
            'subsubcategory_id' => 'required',
        ]);

        Product::findOrFail($product_id)->update([
            'user_id' => Auth::id(),
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'product_name_en' => $request->product_name_en,
            'product_slug_en' => strtolower(str_replace(' ','-',$request->product_name_en)),
            'product_name_bn' => $request->product_name_bn,
            'product_slug_bn' => str_replace(' ','-',$request->product_name_bn),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags_en' => $request->product_tags_en,
            'product_tags_bn' => $request->product_tags_bn,
            'product_size_en' => $request->product_size_en,
            'product_size_bn' => $request->product_size_bn,
            'product_color_en' => $request->product_color_en,
            'product_color_bn' => $request->product_color_bn,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp_en' => $request->short_descp_en,
            'short_descp_bn' => $request->short_descp_bn,
            'long_descp_en' => $request->long_descp_en,
            'long_descp_bn' => $request->long_descp_bn,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => 1,
            'created_at' => Carbon::now(),
    ]);

    $notification=array(
        'message'=>'Product Update Success',
        'alert-type'=>'success'
    );
         return Redirect()->route('manage-product')->with($notification);
   }





    /////////////// product main thambnail update ////////////////////
    public function thambnailUpdate(Request $request){
        $pro_id = $request->product_id;
        $oldImage = $request->old_img;
        unlink($oldImage);

        $manager = new ImageManager(new Driver());
        $image = $request->file('product_thambnail');
        $name_gen=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $img = $manager->read($request->file('product_thambnail'));
        $img=$img->resize(870,370);
        $img->toJpeg(80)->save(base_path('public/uploads/products/thambnail/'.$name_gen));
        $save_url = 'uploads/products/thambnail/'.$name_gen;

        Product::findOrFail($pro_id)->update([
            'product_thambnail' => $save_url,
            'updated_at' => Carbon::now(),

        ]);

    $notification=array(
        'message'=>'Product Thambnail Update Success',
        'alert-type'=>'success'
    );
        return Redirect()->back()->with($notification);

    }



      /// multiple image update =============================

      public function multiImagUpdate(Request $request){
        $imgs = $request->multiImg;

        foreach ($imgs as $id => $img) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);

            $manager = new ImageManager(new Driver());
            $name_gen=hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $img1 = $manager->read($img);

            $img1->toJpeg(80)->save(base_path('public/uploads/products/thambnail/'.$name_gen));
            $save_url = 'uploads/products/thambnail/'.$name_gen;

           MultiImg::where('id',$id)->update([
            'photo_name' => $save_url,
            'updated_at' => Carbon::now(),
           ]);

        }

        $notification=array(
            'message'=>'Product Image Update Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

    }


      ////////////////////// Multi Image Delete ////////////////
      public function multiImageDelete($id){
        $oldimg = MultiImg::findOrFail($id);
        unlink($oldimg->photo_name);

        MultiImg::findOrFail($id)->delete();

        $notification=array(
            'message'=>'Product Image Dlete Success',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }


    // delete product
    public function delete($product_id){
        $product = Product::findOrFail($product_id);
        unlink($product->product_thambnail);

        Product::findOrFail($product_id)->delete();
        $images = MultiImg::where('product_id',$product_id)->get();
        foreach ($images as $img) {
            unlink($img->photo_name);
            MultiImg::where('product_id',$product_id)->delete();
         }

         $notification=array(
            'message'=>'Product Deleted',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

    }


    /////////////// product active and inactiv

    public function inactive($id){
        Product::findOrFail($id)->update(['status' => 0]);

        $notification=array(
            'message'=>'Product Inactivated',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function active($id){
        Product::findOrFail($id)->update(['status' => 1]);

        $notification=array(
            'message'=>'Product Activated',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

    }







}
