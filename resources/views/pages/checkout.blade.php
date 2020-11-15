@extends('layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/styles/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/frontend/styles/cart_responsive.css')}}">

@php

$setting=DB::table('settings')->first();
$charge=$setting->shipping_charge;

@endphp

<!-- Cart -->

<div class="cart_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 ">
				<div class="cart_container">
					<div class="cart_title">Checkout</div>
					<div class="cart_items">
						<ul class="cart_list">

							@foreach($cart as $row)

							<li class="cart_item clearfix">
								<div class="cart_item_image"><img src="{{asset($row->options->image)}}" style="height: 100px;"></div>
								<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
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
										<div class="cart_item_title">Quantity</div><br><br>
										<form method="post" action="{{route('update.cartitem')}}">
											@csrf
											<input type="hidden" name="productid" value="{{$row->rowId}}">
											<input type="number" name="qty" value="{{$row->qty}}" style="width: 50px;">
											<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-square"></i></button>
										</form>
									</div>
									<div class="cart_item_price cart_info_col">
										<div class="cart_item_title">Price</div>
										<div class="cart_item_text">${{$row->price}}</div>
									</div>
									<div class="cart_item_total cart_info_col">
										<div class="cart_item_title">Total</div>
										<div class="cart_item_text">${{$row->qty*$row->price}}</div>
									</div>
									<div class="cart_item_total cart_info_col">
										<div class="cart_item_title">Action</div><br><br>
										<a href="{{url('remove/cart/'.$row->rowId)}}" class="btn btn-sm btn-danger">X</a>
									</div>
								</div>
							</li>

							@endforeach

						</ul>
					</div>

					<!-- Order Total -->
					<div class="order_total">



				<div class="order_total_content text-md-right">
					<div class="order_total_title">Order Total:</div>
					@if(Session::has('coupon'))
					<div class="order_total_amount">${{Cart::Subtotal()}}</div><br>
					

					<div class="order_total_title">Coupon</div>
					<div class="order_total_amount">-{{Session::get('coupon')['discount']}}$ <a href="{{route('coupon.remove')}}" class="btn btn-danger btn-sm">X</a></div><br>

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

						<div class="order_total_content text-sm-right">
							<a href="{{route('show.cart')}}" class="button cart_button_clear">back to cart</a>


							<a href="{{route('payment.step')}}" class="button cart_button_checkout">Final Step</a>
						</div>
</div>
					</div>
					<br>
					<div class="cart_buttons">
						<div class="order_total_content text-md-left">
							@if(Session::has('coupon'))
							
							@else
							

							<h5>Apply Coupon <p style="font-size: 14px;">(demo coupon:learn5)</p></h5>
							<form action="{{route('apply.coupon')}}" method="post">
								@csrf
								<input type="text" style="height: 35px; font-size: 15px;" name="coupon" required="" placeholder="coupon code" ><br>
								<button type="submit" class="btn btn-info">Submit</button>
							</form>

							@endif	
						</div>
					</div>


				</div>

				<div>

				</div>
			</div>
		</div>
	</div>
</div>

<div>

</div>

<br><br><br><br><br><br><br><br>


<script src="{{asset('public/frontend/js/cart_custom.js')}}"></script>

@endsection