<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Fontend\IndexController;
Use App\Http\Controllers\Admin\BrandController;
Use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Fontend\LanguageController;
use App\Http\Controllers\Fontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ShippingAreaController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;



Route::get('/', [IndexController::class,'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//=============================Admin Routes===============================
Route::group(['prefix'=>'admin','middleware' =>['admin','auth']], function(){
     Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');

     Route::get('profile',[AdminController::class,'profile'])->name('profile');
     Route::post('update/info',[AdminController::class,'updateInfo'])->name('update-data');

     Route::get('update/image-page',[AdminController::class,'updateImgPage'])->name('admin-image');
     Route::post('image/store',[AdminController::class,'imgStore'])->name('store-image');

     Route::get('change-password',[AdminController::class,'changePass'])->name('change-password');
     Route::post('change-password-store',[AdminController::class,'changePassStore'])->name('change-password-store');

     //brand routes
     Route::get('all-brands',[BrandController::class,'index'])->name('brands');
     Route::post('brand/store',[BrandController::class,'brandStore'])->name('brand-store');
     Route::get('brand-edit/{brand_id}',[BrandController::class,'edit']);
     Route::post('brand/update',[BrandController::class,'brandUpdate'])->name('update-brand');
     Route::get('/brand-delete/{brand_id}',[BrandController::class,'delete']);

     //category
     Route::get('category',[CategoryController::class,'index'])->name('category');
     Route::post('category/store',[CategoryController::class,'categoryStore'])->name('category-store');
     Route::get('/category-edit/{cat_id}',[CategoryController::class,'edit']);
     Route::post('category/update',[CategoryController::class,'catUpdate'])->name('update-category');
     Route::get('/category-delete/{cat_id}',[CategoryController::class,'delete']);

     //subcategory
     Route::get('sub-category',[CategoryController::class,'subIndex'])->name('sub-category');
     Route::post('sub-category/store',[CategoryController::class,'subCategoryStore'])->name('subcategory-store');
     Route::get('sub-category-edit/{subcat_id}',[CategoryController::class,'subEdit']);
     Route::post('sub-category/update',[CategoryController::class,'subCatUpdate'])->name('update-sub-category');
     Route::get('sub-category-delete/{subcat_id}',[CategoryController::class,'subDelete']);

     //sub-subcategory
     Route::get('sub-sub-category',[CategoryController::class,'subSubIndex'])->name('sub-sub-category');
     Route::get('subcategory/ajax/{cat_id}',[CategoryController::class,'getSubCat']);
     Route::post('sub-sub-category/store',[CategoryController::class,'subSubCategoryStore'])->name('sub-subcategory-store');
     Route::get('sub-sub-category-edit/{subsubcat_id}',[CategoryController::class,'subSubEdit']);
     Route::post('sub-subcategory/update',[CategoryController::class,'subSubCatUpdate'])->name('update-sub-subcategory');
     Route::get('sub-sub-category-delete/{subsubcat_id}',[CategoryController::class,'subSubDelete']);

     //Product
     Route::get('add-product',[ProductController::class,'addProduct'])->name('add-product');
     Route::get('sub-subcategory/ajax/{subcat_id}',[ProductController::class,'getSubSubCat']);
     Route::post('product/store',[ProductController::class,'store'])->name('store-product');
     Route::get('manage-product',[ProductController::class,'manageProduct'])->name('manage-product');
     Route::get('/product-edit/{product_id}',[ProductController::class,'edit']);
     Route::post('product/data-update',[ProductController::class,'productDataUpdate'])->name('update-product-data');
     Route::get('/product-delete/{product_id}',[ProductController::class,'delete']);
     Route::post('product/thambnail/update',[ProductController::class,'thambnailUpdate'])->name('update-product-thambnail');
     Route::post('product/multi-image/update',[ProductController::class,'multiImagUpdate'])->name('update-product-image');
     Route::get('product/multiimg/delete/{id}',[ProductController::class,'multiImageDelete']);
     Route::get('product-inactive/{id}',[ProductController::class,'inactive']);
     Route::get('product-active/{id}',[ProductController::class,'active']);

     //sliders
     Route::get('slider',[SliderController::class,'index'])->name('sliders');
     Route::post('slider/store',[SliderController::class,'store'])->name('slider-store');
     Route::get('slider-edit/{id}',[SliderController::class,'edit']);
     Route::post('slider/update',[SliderController::class,'update'])->name('update-slider');
     Route::get('slider/delete/{id}',[SliderController::class,'destroy']);
     Route::get('slider-inactive/{id}',[SliderController::class,'inactive']);
     Route::get('slider-active/{id}',[SliderController::class,'active']);

     //coupon
    Route::get('coupon',[CouponController::class,'create'])->name('coupon');
    Route::post('coupon/store',[CouponController::class,'store'])->name('coupon-store');
    Route::get('coupon-edit/{id}',[CouponController::class,'edit']);
    Route::post('coupon/update',[CouponController::class,'update'])->name('coupon-update');
    Route::get('coupon-delete/{id}',[CouponController::class,'destroy']);

    //shipping area
    //division
    Route::get('division',[ShippingAreaController::class,'createDivision'])->name('division');
    Route::post('division/store',[ShippingAreaController::class,'divisionStore'])->name('division-store');
    Route::get('division-edit/{id}',[ShippingAreaController::class,'divisionEdit']);
    Route::post('division/update',[ShippingAreaController::class,'divisionUpdate'])->name('division-update');
    Route::get('division-delete/{id}',[ShippingAreaController::class,'divisionDestroy']);
    //district
    Route::get('district',[ShippingAreaController::class,'districtCreate'])->name('district');
    Route::post('district/store',[ShippingAreaController::class,'districtStore'])->name('district-store');
    Route::get('district-edit/{id}',[ShippingAreaController::class,'districtEdit']);
    Route::post('district/update',[ShippingAreaController::class,'districtUpdate'])->name('district-update');
    Route::get('district-delete/{id}',[ShippingAreaController::class,'districtDestroy']);
    //state
    Route::get('state',[ShippingAreaController::class,'stateCreate'])->name('state');
    Route::get('district-get/ajax/{division_id}',[ShippingAreaController::class,'getDistrictAjax']);
    Route::post('state/store',[ShippingAreaController::class,'stateStore'])->name('state-store');
    Route::get('state-edit/{id}',[ShippingAreaController::class,'stateEdit']);
    Route::post('state/update',[ShippingAreaController::class,'stateUpdate'])->name('state-update');
    Route::get('state-delete/{id}',[ShippingAreaController::class,'stateDestroy']);

});










//=============================User Routes=================================
Route::group(['prefix'=>'user','middleware' =>['user','auth']], function(){
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::post('update/data',[UserController::class,'updateData'])->name('update-profile');

    Route::get('image',[UserController::class,'imagePage'])->name('user-image');
    Route::post('update/image',[UserController::class,'updateImage'])->name('update-image');

    Route::get('update/password',[UserController::class,'updatePassPage'])->name('update-password');
    Route::post('store/password',[UserController::class,'storePassword'])->name('password-store');


    //wishlist
    Route::get('wishlist',[WishlistController::class,'create'])->name('wishlist');
    Route::get('/get-wishlist-product',[WishlistController::class,'readAllProduct']);
    Route::get('/wishlist-remove/{id}',[WishlistController::class,'destory']);

    //checkout
    Route::get('district-get/ajax/{division_id}',[CheckoutController::class,'getDistrictWithAjax']);
    Route::get('state-get/ajax/{district_id}',[CheckoutController::class,'getStateWithAjax']);
    Route::post('payment',[CheckoutController::class,'storeCheckout'])->name('user.checkout.store');

    //stripe payment
    Route::post('stripe/order-complete',[StripeController::class,'store'])->name('stripe.order');


});








// ====================================== Fontend Routes =====================================
Route::get('language/bangla',[LanguageController::class,'bangla'])->name('bangla.language');
Route::get('language/english',[LanguageController::class,'english'])->name('english.language');

Route::get('single/product/{id}/{slug}',[IndexController::class,'singleProduct']);

//product tags
Route::get('product/tag/{tag}',[IndexController::class,'tagWiseProduct']);

//subcategory wise product show
Route::get('subcategory/product/{subcat_id}/{slug}',[IndexController::class,'subCatWiseProduct']);
Route::get('sub/subcategory/product/{subsubcat_id}/{slug}',[IndexController::class,'subSubCatWiseProduct']);


//product view modal with ajax
Route::get('product/view/modal/{id}',[IndexController::class,'productViewAjax']);


// add to cart
Route::post('/cart/data/store/{id}',[CartController::class,'addToCart']);


//mini cart
Route::get('product/mini/cart',[CartController::class,'miniCart']);
//mini cart remove
Route::get('/minicart/product-remove/{rowId}',[CartController::class,'miniCartRemove']);


//wishlist
Route::post('/add-to-wishlist/{product_id}',[CartController::class,'addToWishlist']);

//cart
Route::get('my-cart',[CartController::class,'create'])->name('cart');
Route::get('/get-cart-product',[CartController::class,'getAllCart']);
Route::get('/cart-remove/{rowId}',[CartController::class,'destory']);

Route::get('/cart-increment/{rowId}',[CartController::class,'cartIncrement']);
Route::get('/cart-decrement/{rowId}',[CartController::class,'cartDecrement']);

 //coupon
 Route::post('/coupon-apply',[CartController::class,'couponApply']);
 Route::get('coupon-calculation',[CartController::class,'couponCalcaultion']);
 Route::get('coupon-remove',[CartController::class,'removeCoupon']);


//checkout
Route::get('user/checkout',[CartController::class,'checkoutCreate'])->name('checkout');

