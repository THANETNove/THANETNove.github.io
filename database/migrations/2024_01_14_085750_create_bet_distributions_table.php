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
        Schema::create('bet_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable()->comment('id user');
            $table->string('group_id')->nullable()->comment('group_id');
            $table->string('durable_articles_id')->nullable()->comment('รหัสครุภัณฑ์');
            $table->string('code_durable_articles')->nullable()->comment('กลุ่ม/ประเภท type');
            $table->string('durable_articles_name')->nullable()->comment('ชื่อ');
            $table->string('amount_bet_distribution')->nullable()->comment('จำนวนที่เเทงจำหน่าย');
            $table->string('name_durable_articles_count')->nullable()->comment('ชื่อเรียก');
            $table->string('repair_detail')->nullable()->comment('รายละเอียดการซ่อม');
            $table->string('status')->nullable()->comment('สถานะ on/ off');
            $table->string('statusApproval')->nullable()->comment('สถานะการอนุมัติ 0 = รอการอนุมัติ 1 = อนุมัติ 2 = ไม่อนุมัติ');
            $table->string('commentApproval')->nullable()->comment('รายละเอียดการไม่อนุมัติ');
            $table->string('salvage_price')->nullable()->comment('ราคาซาก');
            $table->string('url_pdf')->nullable()->comment('url_pdf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet_distributions');
    }
};
