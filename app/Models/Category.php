<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',//รหัสครุภัณฑ์
        'category_code', // กลุ่ม/ประเภท
        'category_name', // กลุ่ม/ประเภท
    ];
}
