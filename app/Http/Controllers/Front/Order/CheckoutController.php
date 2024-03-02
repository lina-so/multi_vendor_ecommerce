<?php

namespace App\Http\Controllers\Front\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAdress;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\DB;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function __construct(CartService $cartService , SoftDeleteService $softDeleteService ,CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->softDeleteService = $softDeleteService;
        $this->checkoutService = $checkoutService;
    }
/*********************************************************************************************************/
    public function index()
    {
        $carts = $this->cartService->get();

        return view('layouts.front.sections.checkout',compact('carts'));
    }
/*********************************************************************************************************/

    public function create()
    {
        //
    }

/*********************************************************************************************************/

    public function store(CheckoutRequest $requestData)
    {
        $items = $this->cartService->get()->groupBy('product.store_id')->all();
        $order = $this->checkoutService->confirmOrder($requestData,$items);
        return redirect()->route('home')->with('success','order processing successfully!');

    }


    /*********************************************************************************************************/

    public function show(string $id)
    {
        //
    }

   /*********************************************************************************************************/

    public function edit(string $id)
    {
        //
    }

    /*********************************************************************************************************/

    public function update(Request $request, string $id)
    {
        //
    }

    /*********************************************************************************************************/

    public function destroy(string $id)
    {
        //
    }
}
