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
        Schema::create('durable_articles_repairs', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable()->comment('id user');
            $table->string('durable_articles_id')->nullable()->comment('รหัสครุภัณฑ์');
            $table->string('code_durable_articles')->nullable()->comment('กลุ่ม/ประเภท type');
            $table->string('durable_articles_name')->nullable()->comment('ชื่อ');
            $table->string('amount_repair')->nullable()->comment('จำนวนที่ซ่อม');
            $table->string('name_durable_articles_count')->nullable()->comment('ชื่อเรียก');
            $table->string('repair_detail')->nullable()->comment('รายละเอียดการซ่อม');
            $table->string('status')->nullable()->comment('สถานะ on/ off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durable_articles_repairs');
    }
};
