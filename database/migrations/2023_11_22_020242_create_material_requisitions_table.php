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
        Schema::create('material_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable()->comment('user');
            $table->string('material_id')->nullable()->comment('material_id');
            $table->string('code_requisition')->nullable()->comment('รหัสวัสดุ');
            $table->string('material_name')->nullable()->comment('ชื่อ');
            $table->string('amount_withdraw')->nullable()->comment('จำนวนที่ต้องเบิก');
            $table->string('name_material_count')->nullable()->comment('ชื่อเรียกจำนวนนับวัสดุ');
            $table->string('status')->nullable()->comment('สถานะ on/ off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_requisitions');
    }

};
