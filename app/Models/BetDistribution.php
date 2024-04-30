<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetDistribution extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'group_id',
        'durable_articles_id',//รหัสครุภัณฑ์
        'code_durable_articles', // กลุ่ม/ประเภท type
        'durable_articles_name', // ชื่อ
        'amount_bet_distribution', // จำนวนที่เเทงจำหน่าย
        'name_durable_articles_count', // ชื่อเรียกจำนวนนับครุภัณฑ์
        'repair_detail', // รายละเอียดการเเทงจำหน่าย
        'status', //สถานะ on/ off
        'statusApproval', //สถานะ on/ off
        'commentApproval', //สถานะ on/ off
        'salvage_price', //สถานะ on/ off
        'url_pdf',
    ];
}
