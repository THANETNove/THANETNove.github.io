<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurableArticles extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_DurableArticles',//รหัสครุภัณฑ์
        'group_class', // กลุ่ม/ประเภท
        'type_durableArticles', // ชนิด
        'group_count',
        'description', // รายละเอียด
        'durableArticles_name',//ชื่อ
        'durableArticles_number',//จำนวนครุภัณฑ์
        'remaining_amount',
        'name_durableArticles_count',//ชื่อเรียกจำนวนนับครุภัณฑ์
        'code_material_storage',//รหัสที่เก็บครุภัณฑ์
        'damaged_number',//ชำรุด
        'bet_on_distribution_number',//แทงจำหน่ายครุภัณฑ์
        'repair_number',//การซ่อม
        'status', //สถานะ on/ off
    ];
}