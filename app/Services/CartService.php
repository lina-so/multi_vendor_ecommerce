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

        return Cart::with('product','options')->where('cookie_id',$this->getCookieId())->get();
    }

/********************************************************************************************/
public function add(Request $request)
{
    DB::beginTransaction();
    try {
        $cart = Cart::where('product_id', $request->product_id)
            ->where('cookie_id', $this->getCookieId())
            ->first();

        // إذا كانت السلة غير موجودة، قم بإنشاء سلة جديدة
        if (!$cart) {
            $cart = Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => 0, // Set initial quantity to 0
            ]);
        }

        $selectedOptions = $request->input('selected_options', []);
        $selectedOptionValues = [];

        // Build an array of selected option values
        foreach ($selectedOptions as $optionId => $values) {
            foreach ($values as $value) {
                $selectedOptionValues[] = $value;
            }
        }

        // Check if the same set of options already exists in the cart
        $cartOptionValues = $cartOptions->options->pluck('option_value_id', 'option_id')->toArray();

        sort($existingOptions);
        sort($selectedOptionValues);

        if ($existingOptions == $selectedOptionValues) {
            // The same set of options already exists, update the quantity
            $cart->increment('quantity', $request->quantity);
        } else {
            // Different set of options, create a new cart entry
            $cart = Cart::create([
                'cookie_id' => $this->getCookieId(),
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            // Attach options to the new cart
            foreach ($selectedOptions as $optionId => $values) {
                $cart->options()->attach($values);
            }
        }

        DB::commit();
        return $cart;
    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }
}


/********************************************************************************************/
    public function update($id,$request){
        // dd($this->getCookieId());
        // Cart::where('product_id','=',$product->id)
        // ->where('cookie_id','=',$this->getCookieId())
        // ->update([
        //     'quantity'=>$quantity,
        // ]);
    }
/********************************************************************************************/

    public function delete($cartId , $request){
        // Cart::where('product_id','=',$request->product_id)
        // ->where('cookie_id','=',$this->getCookieId())
        // ->where('quantity','=',$request->quantity)
        // ->delete();
        Cart::where('id', '=', $cartId)->delete();
        return response()->json(['success' => true]);
    }

/*********************************************************************************************/
    public function empty(){
        Cart::where('cookie_id','=',$this->getCookieId())
        ->delete();
    }
/*********************************************************************************************/
public function total() : float{
    return (float) Cart::where('cookie_id',$this->getCookieId())
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

