<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_storage',
        'building_name',
        'floor',
        'room_name',
        'status',
    ];
}
