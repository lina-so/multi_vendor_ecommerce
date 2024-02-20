<x-front-layout title="cart">

    <x-slot:breadcrumb>
        <section class="breadcrumb breadcrumb_bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="breadcrumb_iner">
                            <div class="breadcrumb_iner_item">
                                <h2>Cart Products</h2>
                                <p>Home <span>-</span>Cart Products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </x-slot:breadcrumb>

    <x-alert.alert type="success" />
    <x-alert.alert type="info" />

    <!--================Cart Area =================-->
    <section class="cart_area padding_top">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($carts as $cart)
                                <tr>

                                    <td>
                                        <div class="media" id="{{ $cart->id }}">
                                            <div class="d-flex">
                                                <img src="{{ asset('storage/' . $cart->product->images->first()->path) }}"
                                                    alt="{{ $cart->product->name }}" width="100" height="100">
                                            </div>
                                            <div class="media-body">
                                                <h5>{{ $cart->product->slug }}</h5>

                                                @php $renderedOptions = []; @endphp

                                                @foreach ($cart->options as $option)
                                                    @if (!in_array($option->option->id, $renderedOptions))
                                                        <h6>
                                                            <span>{{ $option->option->name }} :</span>
                                                            <span>
                                                                @foreach ($cart->options->where('option_id', $option->option->id)->unique('option_value_id') as $nestedOption)
                                                                    {{ $nestedOption->optionValue->name }}

                                                                    @if (!$loop->last)
                                                                        ,
                                                                        <!-- Add a comma if it's not the last value -->
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        </h6>
                                                        @php $renderedOptions[] = $option->option->id; @endphp
                                                    @endif
                                                @endforeach



                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>${{ $cart->product->price }}</h5>
                                    </td>
                                    <td>
                                        <div class="product_count">

                                            <input class="input-number" type="number" value="{{ $cart->quantity }}"
                                                min="0" max="10">
                                        </div>
                                    </td>
                                    <td>
                                        <h5>${{ $cart->product->price * $cart->quantity }}</h5>
                                    </td>
                                    <td>
                                        {{-- delete btn --}}
                                        <a class="btn btn-sm btn-danger delete-from-cart" data-toggle="modal"
                                            data-target="#confirmDeleteModal" data-id="{{ $cart->id }}"
                                            title="حذف"> Delete</a>

                                    </td>
                                </tr>


                                <!-- delete modal-->
                                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this item?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmDelete()">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end delete modal-->
                            @endforeach

                        </tbody>

                    </table>

                    <div class="checkout_btn_inner  text-right " style="margin-right:20em">

                        <span>total : </span>

                    </div>

                    <div class="checkout_btn_inner float-left">

                        <a class="btn_1" href="{{ route('home') }}">Continue Shopping</a>
                        <a class="btn_1 checkout_btn_1" href="#">Proceed to checkout</a>

                    </div>

                </div>
            </div>
    </section>
    <!--================End Cart Area =================-->


    @push('scripts')
        <script>
            function confirmDelete() {
                var cartId = $('#confirmDeleteModal').data('id');
                $.ajax({
                    type: 'DELETE',
                    url: '/cart/remove/' + cartId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#' + cartId).fadeOut('slow', function() {
                                $(this).remove();
                            });
                            $('#confirmDeleteModal').modal('hide');
                        } else {
                            alert('Failed to remove the item from the cart.');
                        }
                    },
                    error: function() {
                        alert('Error occurred while making the request.');
                    }
                });
            }

            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var cartId = button.data('id');
                $('#confirmDeleteModal').data('id', cartId);
            });

            $('#confirmDeleteModal').on('hidden.bs.modal', function() {
                $('#confirmDeleteModal').removeData('bs.modal');
            });
        </script>
    @endpush



</x-front-layout>
