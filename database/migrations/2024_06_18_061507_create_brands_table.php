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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255)->nullable()->comment('ชื่อบริษัท');
            $table->tinyInteger('status')->default(1)->comment('0 = รออนุมัติ, 1 = อนุมัติ');
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
        Schema::dropIfExists('brands');
    }
};
