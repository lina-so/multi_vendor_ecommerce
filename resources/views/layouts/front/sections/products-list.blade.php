  <!-- product_list start-->
  <section class="product_list section_padding">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-lg-12">
                  <div class="section_tittle text-center">
                      <h2>awesome <span>shop</span></h2>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <div class="product_list_slider d-flex justify-content-between">
                      <div class="single_product_list_slider">
                          <div class="row align-items-center justify-content-between">

                              @foreach ($products as $product)
                                  <div class="col-lg-3 col-sm-6">
                                      <div class="single_product_item">

                                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">

                                        {{-- @foreach ($product->images as $image) --}}
                                        {{-- <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}"> --}}
                                        {{-- @endforeach --}}

                                          <div class="single_product_text">
                                              <h4>{{ $product->name }}</h4>
                                              <h3>${{ $product->price }}</h3>
                                              <a href="{{ route('product-details',$product->id) }}" class="add_cart">+ add to cart<i
                                                      class="ti-heart"></i></a>
                                          </div>
                                      </div>
                                  </div>
                              @endforeach

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- product_list part start-->
