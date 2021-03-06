<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Cart;
use Session;
use Mail;
use App\Mail\InvoiceMail;

class PaymentController extends Controller

{
	 public function __construct()
    {
        $this->middleware('auth');
    }


    public function Payment(Request $request)
    {
      $data=array();
      $data['name']=$request->name;
      $data['email']=$request->email;
      $data['phone']=$request->phone;
      $data['address']=$request->address;
      $data['city']=$request->city;
      $data['payment']=$request->payment;


      if ($request->payment=='stripe') {

      	//stripe payment pages

      	return view('pages.payment.stripe',compact('data'));
      	
      }
      elseif ($request->payment=='paypal') {
      	
      }
      elseif ($request->payment=='visa') {
      	
      }else{
      	echo "hand cash";
      }

    }


    public function StripeCharge(Request $request)
    {
      
      $email=Auth::user()->email;

      $total=$request->total;


        // Set your secret key. Remember to switch to your live secret key in production!
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey('sk_test_51HdGOyChanPK9VjgEHH1nP0erTTXqGt337A7xYjZulBvgAEFeWViJEOBz4l6KrGA65cqnR5TWbiyV6h0PWjiWkU600TbmWjC2g');

		// Token is created using Checkout or Elements!
		// Get the payment token ID submitted by the form:
		$token = $_POST['stripeToken'];

		$charge = \Stripe\Charge::create([
		  'amount' => $total*100,
		  'currency' => 'usd',
		  'description' => 'one tech details',
		  'source' => $token,
		  'metadata' => ['order_id' => uniqid()],
		]);

      $data=array();

      $data['user_id']=Auth::id();
      $data['payment_id']=$charge->payment_method;
      $data['paying_amount']=$charge->amount/100;
      $data['blnc_transection']=$charge->balance_transaction;
      $data['stripe_order_id']=$charge->metadata->order_id;
      $data['shipping']=$request->shipping;
      $data['vat']=$request->vat;
      $data['total']=$request->total;
      $data['payment_type']=$request->payment_type;
      
      

      if (Session::has('coupon')) {
       $data['subtotal']=(Cart::Subtotal()-Session::get('coupon')['discount']);
      }
      else{
        $data['subtotal']=Cart::Subtotal();
      }

      $data['status']=0;
      $data['date']=date('d-m-y');
      $data['month']=date('F');
      $data['year']=date('Y');
      $data['status_code']=mt_rand(10000,99999);

      
      $order_id=DB::table('orders')->insertGetId($data);

      Mail::to($email)->send(new InvoiceMail($data)); //mail send to user
      //insert shipping details table
      
      $shipping=array();
      $shipping['order_id']=$order_id;
      $shipping['ship_name']=$request->ship_name;
      $shipping['ship_email']=$request->ship_email;
      $shipping['ship_phone']=$request->ship_phone;
      $shipping['ship_address']=$request->ship_address;
      $shipping['ship_city']=$request->ship_city;

      DB::table('shipping')->insert($shipping);

      //insert data into order details
       $content=Cart::content();
       $details=array();

       foreach ($content as $row) {
         $details['order_id']=$order_id;
         $details['product_id']=$row->id;
         $details['product_name']=$row->id;
         $details['color']=$row->options->color;
         $details['size']=$row->options->size;
         $details['quantity']=$row->qty;
         $details['singleprice']=$row->price;
         $details['totalprice']=$row->qty*$row->price;
         
         DB::table('order_details')->insert($details);

       }

       


       Cart::destroy();
        if (Session::has('coupon')) {
         Session::forget('coupon');
      }

      $notification=array(
                    'messege'=>'Successfully purchased',
                     'alert-type'=>'info'
               );
            return redirect()->to('/')->with($notification);

    }

    public function SuccessList()
    {
      $order=DB::table('orders')
      ->where('user_id', Auth::id())->where('status',3)->orderBy('id','DESC')->limit(10)->get();

      return view('pages.returnorder',compact('order'));
    }

    public function RequestReturn($id)
    {
       DB::table('orders')->where('id',$id)->update(['return_order'=>1]);

       $notification=array(
                    'messege'=>'Order Return Request Done Please Wait For Our Confirmation Email',
                     'alert-type'=>'info'
               );
            return redirect()->back()->with($notification);
    }         


}
