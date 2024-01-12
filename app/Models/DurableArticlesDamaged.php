<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurableArticlesDamaged extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'group_id',//รหัสครุภัณฑ์
        'durable_articles_id',//รหัสครุภัณฑ์
        'code_durable_articles', // กลุ่ม/ประเภท type
        'durable_articles_name', // ชื่อ
        'amount_damaged', // จำนวนที่ชำรุด
        'name_durable_articles_count', // ชื่อเรียกจำนวนนับครุภัณฑ์
        'damaged_detail', // รายละเอียดการชำรุด
        'status', //สถานะ on/ off
    ];
}
