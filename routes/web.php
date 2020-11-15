<?php


//socialite

Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
 Route::get('/callback/{provider}', 'SocialController@callback');


Route::get('/', function () {return view('pages.index');});
//auth & user
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password-change', 'HomeController@changePassword')->name('password.change');
Route::post('/password-update', 'HomeController@updatePassword')->name('password.update');
Route::get('/user/logout', 'HomeController@Logout')->name('user.logout');

//admin=======
Route::get('admin/home', 'AdminController@index');
Route::get('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('admin', 'Admin\LoginController@login');
        // Password Reset Routes...
Route::get('admin/password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/reset/password/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/update/reset', 'Admin\ResetPasswordController@reset')->name('admin.reset.update');
Route::get('/admin/Change/Password','AdminController@ChangePassword')->name('admin.password.change');
Route::post('/admin/password/update','AdminController@Update_pass')->name('admin.password.update'); 
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');

//admin section------------
//categories---------

Route::get('admin/categories', 'Admin\Category\CategoryController@catgory')->name('categories');
Route::post('admin/store/category', 'Admin\Category\CategoryController@storecatgory')->name('store.category');
Route::get('delete/category/{id}','Admin\Category\CategoryController@Deletecategory');
Route::get('edit/category/{id}','Admin\Category\CategoryController@Editcategory');
Route::post('update/category/{id}','Admin\Category\CategoryController@Updatecategory');

//brands=====
Route::get('admin/brands', 'Admin\Category\CategoryController@brand')->name('brands');
Route::post('admin/store/brand', 'Admin\Category\CategoryController@storebrand')->name('store.brand');
Route::get('delete/brand/{id}','Admin\Category\CategoryController@DeleteBrand');
Route::get('edit/brand/{id}','Admin\Category\CategoryController@EditBrand');
Route::post('update/brand/{id}','Admin\Category\CategoryController@UpdateBrand');

//sub categories======
Route::get('admin/sub/category', 'Admin\Category\CategoryController@subcategories')->name('sub.categories');
Route::post('admin/store/subcat', 'Admin\Category\CategoryController@storesubcat')->name('store.subcategory');

Route::get('delete/subcategory/{id}','Admin\Category\CategoryController@DeleteSubCat');
Route::get('edit/subcategory/{id}','Admin\Category\CategoryController@EditSubCat');
Route::post('update/subcategory/{id}','Admin\Category\CategoryController@UpdateSubCat');

//coupon=========
Route::get('admin/sub/coupon', 'Admin\CouponController@Coupon')->name('admin.coupon');
Route::post('admin/store/coupon', 'Admin\CouponController@StoreCoupon')->name('store.coupon');

Route::get('delete/coupon/{id}','Admin\CouponController@DeleteCoupon');
Route::get('edit/coupon/{id}','Admin\CouponController@EditCoupon');
Route::post('update/coupon/{id}','Admin\CouponController@UpdateCoupon');

//newslater=======
Route::get('admin/newslater', 'Admin\CouponController@Newslater')->name('admin.newslater');
Route::get('delete/sub/{id}','Admin\CouponController@DeleteSub');

Route::get('admin/seo', 'Admin\CouponController@SEO')->name('admin.seo');
Route::post('admin/update/seo', 'Admin\CouponController@UpdateSEO')->name('update.seo');

//products Routes========
Route::get('admin/product/all', 'Admin\ProductController@index')->name('all.product');
Route::get('admin/product/add', 'Admin\ProductController@create')->name('add.product');
Route::post('admin/store/product', 'Admin\ProductController@store')->name('store.product');

Route::get('inactive/product/{id}','Admin\ProductController@Inactive');
Route::get('active/product/{id}','Admin\ProductController@Active');
Route::get('delete/product/{id}','Admin\ProductController@DeleteProduct');
Route::get('view/product/{id}','Admin\ProductController@ViewProduct');
Route::get('edit/product/{id}','Admin\ProductController@EditProduct');
Route::post('update/product/withoutphoto/{id}','Admin\ProductController@UpdateProductWithoutPhoto');
Route::post('update/product/photo/{id}','Admin\ProductController@UpdateProductPhoto');



   //backend blog routes
Route::get('admin/add/post', 'Admin\PostController@create')->name('add.blogpost');
Route::post('admin/store/post', 'Admin\PostController@store')->name('store.post');
Route::get('admin/all/post', 'Admin\PostController@index')->name('all.blogpost');
Route::get('delete/post/{id}','Admin\PostController@destroy');
Route::get('edit/post/{id}','Admin\PostController@edit');
Route::post('update/post/{id}','Admin\PostController@Update');


   //admin order routes
Route::get('admin/pending/order', 'Admin\OrderController@NewOrder')->name('admin.neworder');
Route::get('admin/view/order/{id}', 'Admin\OrderController@ViewOrder');

Route::get('admin/payment/accept/{id}', 'Admin\OrderController@PaymentAccept');
Route::get('admin/payment/cancel/{id}', 'Admin\OrderController@PaymentCancel');

Route::get('admin/accept/payment', 'Admin\OrderController@AcceptPaymentOrder')->name('admin.accept.payment');
Route::get('admin/progress/payment', 'Admin\OrderController@ProgressPaymentOrder')->name('admin.progress.payment');
Route::get('admin/success/payment', 'Admin\OrderController@SuccessPaymentOrder')->name('admin.success.payment');
Route::get('admin/cancel/payment', 'Admin\OrderController@CancelPaymentOrder')->name('admin.cancel.order');
Route::get('admin/delivery/progress/{id}', 'Admin\OrderController@DeliveryProgress');
Route::get('admin/delivery/done/{id}', 'Admin\OrderController@DeliveryDone');


 
   //order routes
Route::get('admin/today/order', 'Admin\ReportController@TodayOrder')->name('today.order');
Route::get('admin/today/deliverd', 'Admin\ReportController@TodayDelivered')->name('today.delivered');
Route::get('admin/this/month', 'Admin\ReportController@ThisMonth')->name('this.month');
Route::get('admin/search/report', 'Admin\ReportController@search')->name('search.report');
Route::post('admin/search/byyear', 'Admin\ReportController@searchByYear')->name('search.by.year');
Route::post('admin/search/bymonth', 'Admin\ReportController@searchByMonth')->name('search.by.month');
Route::post('admin/search/bydate', 'Admin\ReportController@searchByDate')->name('search.by.date');

//user role
Route::get('admin/create/role', 'Admin\ReportController@UserRole')->name('create.user.role');
Route::get('admin/create/admin', 'Admin\ReportController@UserCreate')->name('create.admin');
Route::post('admin/store/admin', 'Admin\ReportController@UserStore')->name('store.admin');
Route::get('delete/admin/{id}','Admin\ReportController@UserDelete');
Route::get('edit/admin/{id}','Admin\ReportController@UserEdit');
Route::post('admin/update/admin', 'Admin\ReportController@UserUpdate')->name('update.admin');


//Stock
Route::get('admin/product/stock', 'Admin\ReturnController@Stock')->name('admin.product.stock');


//site setting
Route::get('admin/site/setting', 'Admin\SettingController@SiteSetting')->name('admin.site.setting');
Route::post('admin/update/sitesetting', 'Admin\SettingController@UpdateSetting')->name('update.sitesetting');


   //get sub category by ajax
Route::get('/get/subcategory/{category_id}','Admin\ProductController@GetSubcat');


   //wishlists
Route::get('/add/wishlist/{id}','WishlistController@AddWishlist');

  
  //Cart
Route::get('add/to/cart/{id}','CartController@AddCart');
Route::get('check','CartController@check');

Route::get('products/cart','CartController@showCart')->name('show.cart');
Route::get('remove/cart/{rowId}','CartController@removeCart');
Route::post('update/cart/item','CartController@UpdateCart')->name('update.cartitem');

Route::get('cart/product/view/{id}','CartController@ViewProduct');

Route::post('insert/into/cart/','CartController@InsertCart')->name('insert.into.cart');

Route::get('user/checkout/','CartController@Checkout')->name('user.checkout');
Route::get('user/wishlist/','CartController@Wishlist')->name('user.wishlist');
Route::post('user/apply/coupon/','CartController@Coupon')->name('apply.coupon');

Route::get('coupon/remove/','CartController@CouponRemove')->name('coupon.remove');

Route::get('payment/page/','CartController@PaymentPage')->name('payment.step');


//payment methods
Route::post('user/payment/process/','PaymentController@Payment')->name('payment.process');
Route::post('user/stripe/charge/','PaymentController@StripeCharge')->name('stripe.charge');

Route::get('success/list/','PaymentController@SuccessList')->name('success.orderlist');

Route::get('request/return/{id}','PaymentController@RequestReturn');

  //Fronetend Blog routes are here

Route::get('blog/post','BlogController@blog')->name('blog.post');

Route::get('language/bangla','BlogController@Bangla')->name('language.bangla');
Route::get('language/english','BlogController@English')->name('language.english');




//frontend all routes are here.......
Route::post('store/newslater', 'FrontController@StoreNewslater')->name('store.newslater');


Route::get('product/details/{id}/{product_name}','ProductController@ProductView');

Route::post('cart/product/add/{id}','ProductController@AddCart');


Route::get('/products/{id}','ProductController@productsView');


//return products admin panel

Route::get('admin/return/request', 'Admin\ReturnController@request')->name('admin.return.request');
Route::get('admin/approve/return/{id}','Admin\ReturnController@ApproveReturn');
Route::get('admin/all/return', 'Admin\ReturnController@AllReturn')->name('admin.all.return');

//Order Tracking
Route::post('order/tracking', 'FrontController@OrderTracking')->name('order.tracking');

//product Search

Route::post('product/search', 'FrontController@ProductSearch')->name('product.search');

//customer profile related routes

//user panel route

Route::get('user/panel', 'Admin\SettingController@UserPanel')->name('user.panel');
/*Route::get('/admin', 'Admin\SettingController@AdminPanel');*/