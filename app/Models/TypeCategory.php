<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id',//รหัสครุภัณฑ์
        'type_code', // กลุ่ม/ประเภท
        'type_name', // กลุ่ม/ประเภท
    ];
}
