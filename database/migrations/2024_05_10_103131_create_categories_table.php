<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name_en');
            $table->string('category_name_bn');
            $table->string('category_slug_en');
            $table->string('category_slug_bn');
            $table->string('category_icon');
            $table->timestamps();
        });
    }


    public function down(): void{
        Schema::dropIfExists('categories');
    }
};
