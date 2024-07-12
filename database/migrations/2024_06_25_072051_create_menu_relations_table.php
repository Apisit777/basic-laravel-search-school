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
        Schema::create('menu_relations', function (Blueprint $table) {
            $table->id();
            $table->integer('position_id')->comment('รหัสตำแหน่ง');
            $table->integer('menu_id')->comment('รหัสเมนู');
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
        Schema::dropIfExists('menu_relations');
    }
};
