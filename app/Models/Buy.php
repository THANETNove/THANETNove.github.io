<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_buy',//รหัสครุภัณฑ์
        'group_id',//รหัสครุภัณฑ์
        'typeBuy', // กลุ่ม/ประเภท
        'code_number',
        'buy_name', // ชื่อ
        'quantity', // จำนวน
        'counting_unit',//หน่วนับ
        'price_per_piece',//ราคาชิ้น
        'total_price',//ราคารวม
        'details',//รายละเอียด
        'status', //สถานะ on/ off
        'date_enter', //สถานะ on/ off
    ];
}
