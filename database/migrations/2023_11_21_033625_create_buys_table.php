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
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->string('code_buy')->nullable()->comment('รหัสซื้อ');
            $table->string('type')->nullable()->comment('ประเภท');
            $table->string('buy_name')->nullable()->comment('ชื่อ');
            $table->string('quantity')->nullable()->comment('จำนวน');
            $table->string('counting_unit')->nullable()->comment('หน่วยนับ');
            $table->string('price_per_piece')->nullable()->comment('ราคาหน่วย');
            $table->string('total_price')->nullable()->comment('ราคารวม');
            $table->text('details')->nullable()->comment('รายละเอียด');
            $table->string('status')->nullable()->comment('สถานะ 0 = ขอซื้อ 1 =ซื้อเเล้ว  2 ยกการซื้อ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
