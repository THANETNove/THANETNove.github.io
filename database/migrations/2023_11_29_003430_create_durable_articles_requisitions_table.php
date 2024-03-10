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
        Schema::create('durable_articles_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('id_user')->nullable()->comment('id user');
            $table->string('durable_articles_id')->nullable()->comment('รหัสครุภัณฑ์');
            $table->string('code_durable_articles')->nullable()->comment('กลุ่ม/ประเภท type');
            $table->string('group_id')->nullable()->comment('id ประเภท ครุภัณฑ์');
            $table->string('group_withdraw')->nullable()->comment('group การเบิก');
            $table->string('amount_withdraw')->nullable()->comment('จำนวนที่เบิก');
            $table->string('name_type')->nullable()->comment('name_type');
            $table->string('name_durable_articles_count')->nullable()->comment('ชื่อเรียก');
            $table->string('statusApproval')->nullable()->comment('สถานะการอนุมัติ');
            $table->string('commentApproval')->nullable()->comment('รายละเอียด');
            $table->string('status')->nullable()->comment('สถานะ on/ off');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durable_articles_requisitions');
    }
};
