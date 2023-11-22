<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_material',//รหัสวัสดุ
        'group_class', // กลุ่ม/ประเภท
        'type_durableArticles', // ชนิด
        'description', // รายละเอียด
        'material_name',//ชื่อ
        'material_number',//จำนวนวัสดุชิ้น
        'remaining_amount',//จำนวนเหลือ
        'material_number_pack_dozen', //จำนวนวัสดุ เเพค/โหลด
        'name_material_count',//ชื่อเรียกจำนวนนับวัสดุ
        'wasteful_number', //สิ้นเปลือง
        'status', //สถานะ on/ off
    ];
}
