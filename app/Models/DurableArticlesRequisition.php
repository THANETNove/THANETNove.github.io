<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurableArticlesRequisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'group_id',
        'durable_articles_id',//รหัสครุภัณฑ์
        'code_durable_articles', // กลุ่ม/ประเภท type
        'durable_articles_name', // ชื่อ
        'amount_withdraw', // จำนวนที่เบิก
        'name_durable_articles_count', // ชื่อเรียก
        'name_type',
        'statusApproval', // สถานะการอนุมัติ
        'commentApproval', // รายละเอียดการอนุมัติ
        'status', //สถานะ on/ off
    ];
}
