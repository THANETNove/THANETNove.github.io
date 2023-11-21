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
        'material_number_pack_dozen', //จำนวนวัสดุ เเพค/โหลด
        'name_material_count',//ชื่อเรียกจำนวนนับวัสดุ
        'code_material_storage',//รหัสที่เก็บวัสดุ
        'wasteful_number', //สิ้นเปลือง
        'status', //สถานะ on/ off
    ];
}
