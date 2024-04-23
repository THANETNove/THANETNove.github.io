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
        Schema::create('buy_shops', function (Blueprint $table) {
            $table->id();
            $table->string('buy_id')->nullable()->comment('id วัสดุ');
            $table->string('status_buy')->nullable()->comment('สถานะการซ้อ 0 = รอซื้อ ,1 =  ซื้อเเล้ว');
            $table->string('required_quantity')->nullable()->comment('จำนวนที่ต้องการ');
            $table->string('amount_received')->nullable()->comment('จำนวนที่ได้รับ');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_shops');
    }
};
