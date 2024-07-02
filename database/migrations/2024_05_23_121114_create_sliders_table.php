<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title_en')->nullable();
            $table->string('title_bn')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }


    public function down(): void{
        Schema::dropIfExists('sliders');
    }
};
