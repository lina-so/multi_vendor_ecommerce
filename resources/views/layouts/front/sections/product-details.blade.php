<x-front-layout title="Product Details">


<x-alert.alert type="success"/>
<x-alert.alert type="info"/>

    <x-slot:breadcrumb>
        <section class="breadcrumb breadcrumb_bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="breadcrumb_iner">
                            <div class="breadcrumb_iner_item">
                                <h2>Product Details</h2>
                                <p>Home <span>-</span>Product Details</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot:breadcrumb>


    <!--================Single Product Area =================-->
    <div class="product_image_area section_padding">
        <div class="container">
            <div class="row s_product_inner justify-content-between">
                <div class="col-lg-7 col-xl-7">
                    <div class="product_slider_img">
                        <div id="vertical">
                            @foreach ($product->images as $image)
                                <div data-thumb="{{ asset('storage/' . $image->path) }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                        width="500" height="200" />
                                </div>
                                <br/>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">

                    <div class="s_product_text">
                        <h5>previous <span>|</span> next</h5>
                        <h3>{{ $product->name }}</h3>
                        <h2>${{ $product->price }}</h2>
                        <ul class="list">
                            <li>
                                <a class="active" href="#">
                                    <span>Brand</span> : {{ $product->brand->name }}</a>
                            </li>
                            <li>
                                <a href="#"> <span>Availibility</span>
                                    @if ($product->quantity > 0)
                                        : In Stock
                                    @else
                                        : insufficient
                                    @endif
                                </a>
                            </li>
                        </ul>
                        <p>
                            {{ $product->description }}
                        </p>
                        {{-- add to cart form --}}
                        <div class="card_area d-flex justify-content-between align-items-center">
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <div class="product_count">
                                    <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                                    <input class="input-number" type="number" value="1" min="0"
                                        name="quantity" max="{{ $product->quantity }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <span class="number-increment"> <i class="ti-plus"></i></span>
                                </div>

                                {{-- options & value for product --}}
                                <div class="form-group">
                                    @foreach ($optionsWithValues as $option_name => $values)
                                        <label>Select {{ $option_name }}:</label>
                                        <select name="selected_options[{{ $values->first()->option->id }}][]" class="form-control form-select" multiple>
                                            <option value="" disabled selected >Select {{ $option_name }}(s)</option>

                                            @foreach ($values as $value)
                                                <option value="{{ $value->id }}" class="nice-select ">{{ $value->optionValue->name }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                    @endforeach
                                </div>




                                 @if ($product->quantity > 0)
                                    <button class="btn_3" type="submit">add to cart</button>
                                @else
                                    <button class="btn_3" type="submit" disabled>add to cart</button>
                                @endif

                            </form>

                            <a href="#" class="like_us"> <i class="ti-heart"></i> </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->


</x-front-layout>
