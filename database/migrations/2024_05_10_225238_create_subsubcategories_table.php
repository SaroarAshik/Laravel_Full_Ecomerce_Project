<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('subsubcategories', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('subsubcategory_name_en');
            $table->string('subsubcategory_name_bn');
            $table->string('subsubcategory_slug_en');
            $table->string('subsubcategory_slug_bn');
            $table->timestamps();
        });
    }


    public function down(): void{
        Schema::dropIfExists('subsubcategories');
    }
};
