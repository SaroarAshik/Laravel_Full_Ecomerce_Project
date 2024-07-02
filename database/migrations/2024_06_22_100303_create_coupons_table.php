<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->integer('coupon_discount');
            $table->string('coupon_validity');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('coupons');
    }
};
