<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code_storage')->nullable()->comment('รหัสสถานที่เก็บ');
            $table->string('building_name')->nullable()->comment('ชื่ออาคาร');
            $table->string('floor')->nullable()->comment('ชั้น');
            $table->string('room_name')->nullable()->comment('ชื่อห้อง');
            $table->string('status')->nullable()->comment('on = ยังเปิดใช้งาน  off = ปิดการใช้งาน');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_locations');
    }
};
