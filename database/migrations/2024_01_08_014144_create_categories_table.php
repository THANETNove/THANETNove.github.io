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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id')->nullable()->comment('id หมวดหมู่  (1 = หมวดหมู่วัสดุ, 2=หมวดหมู่ครุภัณฑ์)');
            $table->string('category_name')->nullable()->comment('ชื่อเเผนก');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};