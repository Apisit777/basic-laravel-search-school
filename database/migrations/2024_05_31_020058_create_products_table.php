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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('brand_id')->nullable()->comment('รหัสแบรนด์');
            $table->integer('product_id')->nullable()->comment('รหัสสินค้า');
            $table->string('name', 255)->nullable()->comment('ชื่อสินค้า');
            $table->string('company_products', 255)->nullable()->comment('สินค้าของบริษัท');
            $table->string('seq', 100)->nullable()->comment('ลำดับ');
            $table->tinyInteger('status')->default(1)->comment('0 = รออนุมัติ, 1 = อนุมัติ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
