<?php

namespace App\Http\Controllers\Front\Cart;

use App\Models\Cart;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;

class CartController extends Controller
{
    protected $cartService,$softDeleteService;

    public function __construct(CartService $cartService , SoftDeleteService $softDeleteService)
    {
        $this->cartService = $cartService;
        $this->softDeleteService = $softDeleteService;
    }

    /*****************************************************************************************************/

    public function index()
    {
        $carts = $this->cartService->get();
        $optionNames = Option::pluck('name', 'id');
        $optionValues = OptionValue::pluck('name', 'id');
        $cartCountRaws = $this->cartService->getCartCountRawForSpecificUser();
        // dd($cartCountRaws);


        return view('layouts.front.sections.cart',compact('carts','optionNames','optionValues','cartCountRaws'));

    }
    /*****************************************************************************************************/

    public function create()
    {
        //
    }

    /*****************************************************************************************************/

    public function store(Request $request)
    {
        // dd($request);
        $cart = $this->cartService->add($request);
        // dd($cart);
        return redirect()->back()->with('success','Product add to cart successfully');
    }

   /*****************************************************************************************************/

    public function show(string $id)
    {
        //
    }

    /*****************************************************************************************************/

    public function edit(string $id)
    {
        //
    }
    /*****************************************************************************************************/

    public function update($cartId, Request $request)
    {
        $this->cartService->update($cartId, $request);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        } else {
            return redirect()->back()->with('success', 'quantity updated successfully');
        }
    }

    /*****************************************************************************************************/

    public function destroy($cartId, Request $request)
    {
        $this->cartService->delete($cartId, $request);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        } else {
            return redirect()->back()->with('success', 'Item deleted successfully');
        }
    }

}
