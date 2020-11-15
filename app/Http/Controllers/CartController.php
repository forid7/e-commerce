<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Response;
use DB;
use Auth;
use Session;
class CartController extends Controller
{
    //


    public function AddCart($id)
    {
    	$product=DB::table('products')->where('id',$id)->first();

    	$data=array();

    	if ($product->discount_price==NULL) {
    		$data['id']=$product->id;
    	    $data['name']=$product->product_name;
    	    $data['qty']=1;
    	    $data['price']=$product->selling_price;
    	    $data['weight']=1;
    	    $data['options']['image']=$product->image_one;
            $data['options']['color']=$product->product_color;
            $data['options']['size']=$product->product_size;

            

    	    Cart::add($data);
    	    return \Response::json(['success' => 'Successfully Added to your cart']);

    	}else{
    		$data['id']=$product->id;
    	    $data['name']=$product->product_name;
    	    $data['qty']=1;
    	    $data['price']=$product->discount_price;
    	    $data['weight']=1;
    	    $data['options']['image']=$product->image_one;
            $data['options']['color']=$product->product_color;
            $data['options']['size']=$product->product_size;
    	    
    	    Cart::add($data);
    	    return \Response::json(['success' => 'Successfully Added to your cart']);

            
    	}

    }


    public function check()
    {
    	$content=Cart::content();
        
       echo "<pre>";
        print_r($content);
    	
    }


    public function showCart()
    {   
        $cart=Cart::content();

        return view('pages.cart',compact('cart'));
    }

    public function removeCart($rowId)
    {
        Cart::remove($rowId);
        $notification=array(
                        'messege'=>'Successfully Removed from cart!',
                        'alert-type'=>'success'
                         );
        return redirect()->back()->with($notification);
    }


    public function UpdateCart(Request $request)
    {
        $rowId=$request->productid;
         
        $qty=$request->qty;

        Cart::update($rowId,$qty);

        $notification=array(
                        'messege'=>'Successfully quantity Updated!',
                        'alert-type'=>'success'
                         );
        return redirect()->back()->with($notification);
    }

    public function ViewProduct($id)
    {
       $product=DB::table('products')
                              ->join('categories','products.category_id','categories.id')
                              ->join('subcategories','products.subcategory_id','subcategories.id')
                              ->join('brands','products.brand_id','brands.id')
                              ->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')
                              ->where('products.id',$id)->first();



                  $color=$product->product_color;
                  $product_color=explode(',', $color);

                  $size=$product->product_size;
                  $product_size=explode(',', $size);

               //   return response()->json($product_color);

           
           //return view('pages.product_details', compact('product','product_color','product_size')); 
           
           /*echo "<pre>";
           print_r($product);*/
        //   return response()->json($product);

            return response::json(array(
                'product' => $product,
                'color' => $product_color,
                 'size' => $product_size,
         ));



         /*  return response()->json($product);

           return response()->json($product_size);*/

    }

    public function InsertCart(Request $request)
    {
        $id=$request->product_id;
        
        $product=DB::table('products')->where('id',$id)->first();

        $data=array();

        if ($product->discount_price==NULL) {
            $data['id']=$product->id;
            $data['name']=$product->product_name;
            $data['qty']=$request->qty;
            $data['price']=$product->selling_price;
            $data['weight']=1;
            $data['options']['image']=$product->image_one;
            $data['options']['color']=$request->color;
            $data['options']['size']=$request->size;

            /*echo "<pre>";
            print_r($data);*/

            Cart::add($data);
            $notification=array(
                        'messege'=>'Successfully Product Added to Cart!',
                        'alert-type'=>'success'
                         );
        return redirect()->back()->with($notification);

        }else{
            $data['id']=$product->id;
            $data['name']=$product->product_name;
            $data['qty']=$request->qty;
            $data['price']=$product->discount_price;
            $data['weight']=1;
            $data['options']['image']=$product->image_one;
            $data['options']['color']=$request->color;
            $data['options']['size']=$request->size;

            /*echo "<pre>";
            print_r($data);*/
            
            Cart::add($data);
            $notification=array(
                        'messege'=>'Successfully Product Added to Cart!',
                        'alert-type'=>'success'
                         );
        return redirect()->back()->with($notification);
        }
    }


    public function Checkout()
    {
        if (Auth::check()) {
            $cart=Cart::content();

            return view('pages.checkout',compact('cart'));
        }
        else{

            $notification=array(
                        'messege'=>'At First Login Your Account',
                        'alert-type'=>'success'
                         );
       

            return redirect()->route('login')->with($notification);
        }
    }

    public function Wishlist()
    {   
        $userid=Auth::id();
        $product=DB::table('wishlists')->join('products','wishlists.product_id','products.id')
                ->select('products.*','wishlists.user_id')
                ->where('wishlists.user_id',$userid)
                ->get();
           
           return view('pages.wishlist',compact('product'));

    }


       public function Coupon(Request $request)
    {
        $coupon=$request->coupon;
        $check=DB::table('coupons')->where('coupon',$coupon)->first();
        if ($check) {
              session::put('coupon',[
                  'name' => $check->coupon,
                  'discount' => $check->discount,
                 // 'balance' => Cart::Subtotal() - $check->discount
              ]);
              $notification=array(
                              'messege'=>'Successfully Coupon Applied',
                               'alert-type'=>'success'
                         );
            return redirect()->back()->with($notification);
        }else{
            $notification=array(
                              'messege'=>'Invalid Coupon',
                               'alert-type'=>'error'
                         );
            return redirect()->back()->with($notification);
        }

    }


    public function CouponRemove()
    {
        session::forget('coupon');
        $notification=array(
                              'messege'=>'Coupon Removed',
                               'alert-type'=>'info'
                         );
            return redirect()->back()->with($notification);

    }

    public function PaymentPage()
    {
      $cart=Cart::content();
      return view('pages.payment',compact('cart'));
    }


}
