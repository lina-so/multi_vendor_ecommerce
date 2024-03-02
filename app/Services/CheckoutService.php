<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAdress;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

class CheckoutService
{
/********************************************************************************************/

    public function confirmOrder($requestData,$items)
    {

        $request = $requestData->validated();

        DB::beginTransaction();
        try{
            foreach($items as $store_id => $cart_items)
            {
                foreach($cart_items as $item)
                {
                    $order = Order::create([
                        'user_id'=>Auth::id(),
                        'store_id'=>$store_id,
                        'payment_method'=>'PayPal',
                        'total'=>$item->quantity * $item->product->price,

                    ]);

                    $order_item = OrderItem::create([
                        'order_id'=>$order->id,
                        'product_id'=>$item->product_id,
                        'product_name'=>$item->product->name,
                        'price'=>$item->product->price,
                        'quantity'=>$item->quantity,
                        'options'=>$item->options,
                    ]);

                       // انقاص كمية المنتح
                    $product = $item->product;
                    if($product->quantity>0)
                    {
                        $new_quantity = $product->quantity - $item->quantity;
                        $product->update(['quantity' => $new_quantity]);
                    }
                }

                $rawStreetAddress = $requestData->shipping ? ['add3'=>$requestData->add3] : [
                    'add1' => $requestData->add3,
                    'add2' => $requestData->add2,
                ];

                $streetAddress = json_encode($rawStreetAddress, JSON_UNESCAPED_UNICODE);

                $orderAddress = OrderAdress::create([
                    'order_id' => $order->id,
                    'type' => $requestData->shipping ? 'shipping' : 'billing',
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    'phone_number' => $request['phone_number'],
                    'street_address' => $streetAddress,
                    'city' => $request['city'],
                    'country' => $request['country'],
                    'postal_code' => $request['postal_code'],
                ]);



            }
            foreach ($items as $storeItems) {
                foreach ($storeItems as $item) {
                    $item->delete();
                }
            }


         DB::commit();

        }catch(Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
