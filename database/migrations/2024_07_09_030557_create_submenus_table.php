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
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->comment('รหัสเมนู');
            $table->string('name', 255)->nullable()->comment('ชื่อเมนูย่อย');
            $table->integer('seq')->default(0)->comment('ลำดับเมนูย่อย');
            $table->integer('view')->nullable()->default(null)->comment('action');
            $table->integer('create')->nullable()->default(null)->comment('action');
            $table->integer('edit')->nullable()->default(null)->comment('action');
            $table->integer('delete')->nullable()->default(null)->comment('action');
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
        Schema::dropIfExists('submenus');
    }
};
