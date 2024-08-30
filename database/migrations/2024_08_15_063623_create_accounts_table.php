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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->double("cost", 8, 2)->nullable()->comment("ต้นทุน");
            $table->double("perfume_tax", 8, 2)->nullable()->comment("ภาษีน้ำหอม");
            $table->double("cost_perfume_tax", 8, 2)->nullable()->comment("ต้นทุน + ภาษีน้ำหอม");
            $table->double("cost5percent", 8, 2)->nullable()->comment("ต้นทุน+5%");
            $table->double("cost10percent", 8, 2)->nullable()->comment("ต้นทุน+10%");
            $table->double("cost_other", 8, 2)->nullable()->comment("ต้นทุน+อื่นๆ");
            $table->double("sale_km", 8, 2)->nullable()->comment("ราคาขาย KM");
            $table->double("sale_km20percent", 8, 2)->nullable()->comment("ราคาขาย KM + 20%");
            $table->double("sale_km_other", 8, 2)->nullable()->comment("ราคาขาย KM+อื่นๆ");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
