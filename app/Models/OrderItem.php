<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderAdress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable =['order_id','product_id','product_name','price','quantity','options'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => $this->product_name
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


}

