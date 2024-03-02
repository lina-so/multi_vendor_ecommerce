<x-front-layout title="checkout">

    <x-slot:breadcrumb>
        <section class="breadcrumb breadcrumb_bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="breadcrumb_iner">
                            <div class="breadcrumb_iner_item">
                                <h2>Producta Checkout</h2>
                                <p>Home <span>-</span> Shop Single</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot:breadcrumb>

    <x-alert.alert type="success" />
    <x-alert.alert type="info" />

    <!--================Checkout Area =================-->
    <section class="checkout_area padding_top">
        <div class="container">
            <div class="returning_customer">
                <div class="check_title">
                    <h2>
                        Returning Customer?
                        <a href="#">Click here to login</a>
                    </h2>
                </div>
                <p>
                    If you have shopped with us before, please enter your details in the
                    boxes below. If you are a new customer, please proceed to the
                    Billing & Shipping section.
                </p>
                <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                    <div class="col-md-6 form-group p_star">
                        <input type="text" class="form-control" id="name" name="name" value=" " />
                        <span class="placeholder" data-placeholder="Username or Email"></span>
                    </div>
                    <div class="col-md-6 form-group p_star">
                        <input type="password" class="form-control" id="password" name="password" value="" />
                        <span class="placeholder" data-placeholder="Password"></span>
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" value="submit" class="btn_3">
                            log in
                        </button>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option" name="selector" />
                            <label for="f-option">Remember me</label>
                        </div>
                        <a class="lost_pass" href="#">Lost your password?</a>
                    </div>
                </form>
            </div>
            <div class="cupon_area">
                <div class="check_title">
                    <h2>
                        Have a coupon?
                        <a href="#">Click here to enter your code</a>
                    </h2>
                </div>
                <input type="text" placeholder="Enter coupon code" />
                <a class="tp_btn" href="#">Apply Coupon</a>
            </div>
            {{-- billing --}}
            <form action="{{ route('checkout.store') }}" method="post">
                @csrf
                <div class="billing_details">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Billing Details</h3>
                            <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                                <div class="col-md-5 form-group p_star">
                                    <input type="text" class="form-control" id="first" name="first_name" />
                                    <span class="placeholder" data-placeholder="First name"></span>
                                </div>
                                <div class="col-md-5 form-group p_star">
                                    <input type="text" class="form-control" id="last" name="last_name" />
                                    <span class="placeholder" data-placeholder="Last name"></span>
                                </div>

                                <div class="col-md-5 form-group p_star">
                                    <input type="text" class="form-control" id="number" name="phone_number" />
                                    <span class="placeholder" data-placeholder="Phone number"></span>
                                </div>
                                <div class="col-md-5 form-group p_star">
                                    <input type="text" class="form-control" id="email" name="email" />
                                    <span class="placeholder" data-placeholder="Email Address"></span>
                                </div>

                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="add1" name="add1" />
                                    <span class="placeholder" data-placeholder="Address line 01"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="add2" name="add2" />
                                    <span class="placeholder" data-placeholder="Address line 02"></span>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="city" name="city" />
                                    <span class="placeholder" data-placeholder="Town/City"></span>
                                </div>


                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="country" name="country" />
                                    <span class="placeholder" data-placeholder="country"></span>
                                </div>


                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" id="zip" name="postal_code"
                                        placeholder="Postcode/ZIP" />
                                </div>


                            {{-- shipping --}}
                                <div class="col-md-12 form-group">
                                    <div class="creat_account">
                                        <h3>Shipping Details</h3>
                                        <input type="checkbox" id="f-option3" name="shipping" />
                                        <label for="f-option3">Ship to a different address?</label>
                                        <div class="col-md-12 form-group p_star">
                                            <input type="text" class="form-control" id="add3" name="add3" />
                                            <span class="placeholder" data-placeholder="Address line 03"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Your Order</h2>
                                <ul class="list">
                                    <li>
                                        <a href="#">Product
                                            <span>Total</span>
                                        </a>
                                    </li>
                                    @php
                                        $Subtotal = 0;
                                    @endphp
                                    @foreach ($carts as $cart)
                                        <li>
                                            <a href="#">{{ $cart->product->name }}
                                                <span class="middle">x {{ $cart->quantity }}</span>
                                                <span
                                                    class="last">${{ number_format($cart->quantity * $cart->product->price, 2) }}</span>
                                            </a>
                                        </li>
                                        @php
                                            $Subtotal += $cart->quantity * $cart->product->price; // Increment the sum
                                        @endphp
                                    @endforeach
                                </ul>
                                <ul class="list list_2">
                                    <li>
                                        <a href="#">Subtotal
                                            <span>${{ number_format($Subtotal, 2) }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Shipping
                                            <span>Flat rate: ${{ $cart->shipping }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">Total
                                            <span>${{ number_format($Subtotal + $cart->shipping, 2) }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="payment_item">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option5" name="selector" />
                                        <label for="f-option5">Check payments</label>
                                        <div class="check"></div>
                                    </div>
                                    <p>
                                        Please send a check to Store Name, Store Street, Store Town,
                                        Store State / County, Store Postcode.
                                    </p>
                                </div>
                                <div class="payment_item active">
                                    <div class="radion_btn">
                                        <input type="radio" id="f-option6" name="selector" />
                                        <label for="f-option6">Paypal </label>
                                        <img src="img/product/single-product/card.jpg" alt="" />
                                        <div class="check"></div>
                                    </div>
                                    <p>
                                        Please send a check to Store Name, Store Street, Store Town,
                                        Store State / County, Store Postcode.
                                    </p>
                                </div>
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option4" name="selector" />
                                    <label for="f-option4">I’ve read and accept the </label>
                                    <a href="#">terms & conditions*</a>
                                </div>
                                <button class="btn_3" href="#" type="submit">submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!--================End Checkout Area =================-->



@push('styles')
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endpush
</x-front-layout>
