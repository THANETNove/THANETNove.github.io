<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', //user
        'id_group',
        'material_id',
        'code_requisition', //รหัสครุภัณฑ์
        'material_name', //ชื่อ
        'amount_withdraw', // ที่ต้องเบิก
        'name_material_count', // ชื่อเรียกจำนวนนับวัสดุ
        'status', //สถานะ on/ off
        'status_approve', // สถานะอนุมัติ
        'commentApproval' // หมายเหตุ
    ];
}
