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
        Schema::create('durable_articles', function (Blueprint $table) {
            $table->id();
            $table->string('code_DurableArticles')->nullable()->comment('รหัสครุภัณฑ์');
            $table->string('group_class')->nullable()->comment('กลุ่ม/ประเภท');
            $table->string('type_durableArticles')->nullable()->comment('ชนิด');
            $table->string('description')->nullable()->comment('รายละเอียด');
            $table->string('durableArticles_name')->nullable()->comment('ชื่อ');
            $table->string('durableArticles_number')->nullable()->comment('จำนวนครุภัณฑ์');
            $table->string('remaining_amount')->nullable()->comment('จำนวนเหลือ');
            $table->string('name_durableArticles_count')->nullable()->comment('ชื่อเรียกจำนวนนับครุภัณฑ์');
            $table->string('code_material_storage')->nullable()->comment('รหัสที่เก็บครุภัณฑ์');
            $table->string('damaged_number')->nullable()->comment('จำนวนชำรุด');
            $table->string('bet_on_distribution_number')->nullable()->comment('จำนวน แทงจำหน่ายครุภัณฑ์');
            $table->string('repair_number')->nullable()->comment('จำนวนการซ่อม');
            $table->string('status')->nullable()->comment('สถานะ on/ off');
            $table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('durable_articles');
    }
};
