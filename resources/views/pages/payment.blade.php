@extends('layouts.app')

@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/styles/contact_styles.css')}}">
 
 @php

$setting=DB::table('settings')->first();
$charge=$setting->shipping_charge;

@endphp       

    <div class="contact_form">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 " style="border: 1px solid grey; padding: 20px;">
                    <div class="cart_container">
					 <div class="contact_form_title text-center">Cart Products</div>
					<div class="cart_items">
						<ul class="cart_list">

							@foreach($cart as $row)

							<li class="cart_item clearfix">
								
								<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
									<div class="cart_item_image"><img src="{{asset($row->options->image)}}" style="height: 70px;width: 70px;"></div>
									
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Name</div>
										<div class="cart_item_text">{{$row->name}}</div>
									</div>
									@if($row->options->color==NULL)
									@else
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Color</div>
										<div class="cart_item_text">{{$row->options->color}}</div>
									</div>
									@endif

									@if($row->options->size==NULL)
									@else
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Size</div>
										<div class="cart_item_text">{{$row->options->size}}</div>
									</div>
									@endif

									<div class="cart_item_quantity cart_info_col">
										<div class="cart_item_title">Quantity</div>
										{{$row->qty}}
									</div>
									<div class="cart_item_price cart_info_col">
										<div class="cart_item_title">Price</div>
										<div class="cart_item_text">${{$row->price}}</div>
									</div>
									<div class="cart_item_total cart_info_col">
										<div class="cart_item_title">Total</div>
										<div class="cart_item_text">${{$row->qty*$row->price}}</div>
									</div>
									
								</div>
							</li>

							@endforeach

						</ul>
					</div>

					<br><br><br>

					<!-- Order Total -->
					<div class="order_total">



				<div class="order_total_content text-md-right">
					<div class="order_total_title">Order Total:</div>
					@if(Session::has('coupon'))
					<div class="order_total_amount">${{Cart::Subtotal()}}</div><br>
					

					<div class="order_total_title">Coupon</div>
					<div class="order_total_amount">-{{Session::get('coupon')['discount']}}$ </div><br>

					@else
					<div class="order_total_amount">${{Cart::Subtotal()}}</div><br>
					@endif
					
					 @if(Session::has('coupon'))
					<div class="order_total_title">Vat(15%) after reducing coupon </div>
					<div class="order_total_amount">+${{(Cart::Subtotal()-Session::get('coupon')['discount'])*.15}}</div><br>
					@else
					<div class="order_total_title">Vat(15%) after reducing coupon </div>
					<div class="order_total_amount">+${{Cart::Subtotal()*.15}}</div><br>
					@endif

					<div class="order_total_title">Shipping Charge</div>
					<div class="order_total_amount">+${{$charge}}</div><br>
                   
                    @if(Session::has('coupon'))
					<div class="order_total_title">Total</div> 
					<div class="order_total_amount">${{(Cart::Subtotal()+$charge+Cart::Subtotal()*.15)-Session::get('coupon')['discount']}}</div><br>
					@else
					<div class="order_total_title">Total</div> 
					<div class="order_total_amount">${{Cart::Subtotal()+$charge+Cart::Subtotal()*.15}}</div>
					@endif
				</div>
						<div class="cart_buttons">

						
                        </div>
					</div>
					<br>
					<div class="cart_buttons">
						{{-- <div class="order_total_content text-sm-right">
							<a href="{{route('show.cart')}}" class="button cart_button_clear">back to cart</a>


							<a href="{{route('payment.step')}}" class="button cart_button_checkout">Final Step</a>
						</div> --}}
					</div>


				</div>
                </div>

                <div class="col-lg-5 " style="border: 1px solid grey; padding: 20px;">
                    <div class="contact_form_container">
                        <div class="contact_form_title text-center">Shipping Address</div>

                         <form action="{{route('payment.process')}}" id="contact_form" method="post">
                            @csrf
                            <div class="form-group">
                            <label for="exampleInputEmail1">Full Name </label>
                            <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Full Name" name="name" required="">  
                            </div>

                            <div class="form-group">
                            <label for="exampleInputEmail1">Phone </label>
                            <input type="text" class="form-control " name="phone" value="{{ old('phone') }}"  aria-describedby="emailHelp" placeholder="phone" required="">                           
                            </div>

                            <div class="form-group">
                            <label for="exampleInputEmail1">Email </label>
                            <input type="text" class="form-control " name="email" value="{{ old('email') }}"  aria-describedby="emailHelp" placeholder="Email"  required="">  
                            </div>
                            
                            <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="address" name="address" required="">                            
                            </div>

                            <div class="form-group">
                            <label for="exampleInputEmail1">City</label>
                            <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="City" name="city" required="">                            
                            </div>
                            
                            <div class="contact_form_title text-center">Payment By</div>
                            
                            <div class="form-group">
                             <ul class="logos_list" style="margin-left: 130px;">
                            <li><input type="radio" name="payment" value="stripe"><img src="{{asset('public/frontend/images/logos_1.png')}}" alt=""></li>
                            <li><input type="radio" name="payment" value="visa"><img src="{{asset('public/frontend/images/logos_2.png')}}" alt=""></li>
                            <li><input type="radio" name="payment" value="paypal"><img src="{{asset('public/frontend/images/logos_3.png')}}" alt=""></li>
                                    
                                </ul>                           
                            </div><br>

                            <div class="contact_form_button">
                                <button type="submit" class="btn btn-info" >Pay Now</button>
                            </div>
                        </form>

                        
                    </div>
                </div>

            </div>
        </div>
        <div class="panel"></div>
    </div>


@endsection
