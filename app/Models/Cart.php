<?php

namespace App\Models;

use App\Models\Option;
use App\Models\CartOption;
use App\Models\OptionValue;
use Illuminate\Support\Str;
use App\Models\ProductOptionValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['cookie_id','user_id','product_id','quantity','options','shipping'];

    //Events(observers)
    // creating , created ,updating , updated , saving ,saved ,
    //deleting ,deleted , restoring , restored ,retrieved

    // protected static function booted()
    // {
    //     // static::observe(CartObserver::class);
    //     static::creating(function(Cart $cart)
    //     {
    //         $cart->id = Str::uuid();
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'=> 'Anonymos',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'cart_options', 'cart_id', 'product_option_value_id');
    }


    public function cartOption()
    {
        return $this->hasMany(CartOption::class);
    }

}
