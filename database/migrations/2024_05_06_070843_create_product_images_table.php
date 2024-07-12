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
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->comment('ชื่อไฟล์');
            $table->string('image_path', 255)->nullable()->comment('ชื่อพาร์ท');
            $table->integer('seq')->default(0)->comment('ลำดับไฟล์');
            $table->tinyInteger('status')->default(1)->comment('1= active 0= deactive');
            $table->integer('created_by')->nullable()->comment('Created by');
            $table->integer('updated_by')->nullable()->comment('Updated by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
