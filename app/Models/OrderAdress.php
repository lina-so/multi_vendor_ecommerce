<?php

namespace App\Models;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderAdress extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','type','first_name','last_name','email','phone_number',
        'street_address','city','postal_code','state','country',
    ];


  

}
