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
            $table->double("account1", 8, 2)->nullable()->comment("บัญชี1");
            $table->double("account2", 8, 2)->nullable()->comment("บัญชี2");
            $table->double("account3", 8, 2)->nullable()->comment("บัญชี3");
            $table->double("account4", 8, 2)->nullable()->comment("บัญชี4");
            $table->double("account5", 8, 2)->nullable()->comment("บัญชี5");
            $table->double("account6", 8, 2)->nullable()->comment("บัญชี6");
            $table->double("account7", 8, 2)->nullable()->comment("บัญชี7");
            $table->double("account8", 8, 2)->nullable()->comment("บัญชี8");
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
