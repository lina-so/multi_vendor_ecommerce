<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductOptionValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class CartService
{
/********************************************************************************************/

    public function get()
    {

        return Cart::with('product')->where('user_id',Auth::id())->get();
    }

/********************************************************************************************/
    public function getCartCountRawForSpecificUser()
    {

        return Cart::with('product')->where('user_id',Auth::id())->count();
    }

/********************************************************************************************/


public function add(Request $request)
{
    DB::beginTransaction();

    try {
        $user_id = Auth::id();
        $cookie_id = $this->getCookieId();
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $options = [];

        foreach ($request->selected_options as $option_id => $option_values) {
            foreach ($option_values as $option_value) {
                // إضافة لون وحجم إلى المصفوفة
                $options[$option_id] = $option_value;
            }
        }

        // تحويل المصفوفة إلى تنسيق JSON
        $options_json = json_encode($options);

        $cart = Cart::where('product_id', $product_id)
            ->where('cookie_id', $cookie_id)
            ->where('options', $options_json)
            ->where('user_id', $user_id)
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'cookie_id' => $cookie_id,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'options' => $options_json,
                'shipping'=>50,
            ]);
        } else {
            $cart->increment('quantity', $quantity);
        }

        // dd($cart);
        DB::commit();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


/********************************************************************************************/
    public function update($id,$request){
        // dd($request);
        $quantity = $request->input('quantity');
        $cart = Cart::find($id);
        $cart->update([ 'quantity'=>$quantity]);
    }
/********************************************************************************************/

    public function delete($cartId , $request){
        Cart::where('id', '=', $cartId)->delete();
        return response()->json(['success' => true]);
    }

/*********************************************************************************************/
    public function empty(){
        Cart::where('user_id',Auth::id())
        ->delete();
    }
/*********************************************************************************************/
public function total() : float{
    return (float) Cart::where('user_id',Auth::id())
                 ->join('products','products.id','=','carts.product_id')
                 ->selectRaw('SUM(products.price * carts.quantity) as total')
                 ->value('total');
}
/*********************************************************************************************/
    public function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id = Str::uuid();
            Cookie::queue('cart_id',$cookie_id, 30 * 24 * 60);
        }
        return $cookie_id;
    }
/*********************************************************************************************/

}

