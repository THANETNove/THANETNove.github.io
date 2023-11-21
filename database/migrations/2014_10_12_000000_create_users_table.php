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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('employee_id')->nullable()->comment('รหัสพนักงาน');
            $table->string('prefix')->nullable()->comment('คำนำหน้า');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('provinces')->nullable();
            $table->string('districts')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('status')->nullable()->comment('0 = ผู้เบิก  1 = เจ้าหน้าที่วัสดุ  2 = หัวหน้าวัสดุ');
            $table->string('statusEmployee')->nullable()->comment('on = ยังเป็นพนักงาน  off = ไม่ได้เป็นพนักงานเเล้ว');
            $table->string('statusNewPassword')->nullable()->comment('NULL = ยังไม่เปลี่ยน  1 = เคยเปลี่ยน');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
