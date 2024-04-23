<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyShop extends Model
{
    use HasFactory;
    protected $fillable = [
        'buy_id',//รหัสครุภัณฑ์
        'status_buy', //สถานะ on/ off
        'required_quantity',
        'amount_received',
    ];
}
