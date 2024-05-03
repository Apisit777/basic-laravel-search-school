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
        Schema::create('trn_dona_totambons', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('doc_datetime', $precision = 0)->nullable()->comment('วันเวลาที่บริจาค');
            $table->string('doc_no', 50)->nullable()->comment('เลขที่รายการ');
            $table->string('event', 50)->nullable()->comment('รูปแบบการบริจาค');
            $table->string('doc_refer', 50)->nullable()->comment('เลขที่กิจกรรมบริจาค');
            $table->string('flag', 5)->nullable()->comment('ยกเลิก');
            $table->dateTime('cancel_date', $precision = 0)->nullable()->comment('วันที่ยกเลิก');
            $table->string('cancel_user', 30)->nullable()->comment('ผู้ยกเลิก');
            $table->string('member_id', 50)->nullable()->comment('รหัสสมาชิก');
            $table->decimal('do_befor', $precision = 12, $scale = 2)->nullable()->comment('ยอดบริจาคเริ่ม');
            $table->decimal('do_reedem', $precision = 12, $scale = 2)->nullable()->comment('ยอดบริจาคใช้');
            $table->decimal('do_balance', $precision = 12, $scale = 2)->nullable()->comment('ยอดบริจาคคงเหลือ');
            $table->decimal('donation_use', $precision = 12, $scale = 2)->nullable()->comment('บริจากให้ รร');
            $table->string('tb_id', 20)->nullable()->comment('รหัสตำบล');
            $table->string('school_id', 50)->nullable()->comment('รหัส รร.=กองทุนโรงเรียน/center=กองกลาง');
            $table->string('remark', 200)->nullable()->comment('หมายเหตุ');
            $table->string('type_member', 5)->nullable()->comment('กลุ่มผู้ร่วมบริจาค');
            $table->string('reg_user', 50)->nullable()->comment('รหัสผู้สร้างrecord');
            $table->dateTime('reg_time', $precision = 0)->nullable()->comment('วันเวลาสร้างrecord');
            $table->string('upd_user', 50)->nullable()->comment('รหัสผู้update record');
            $table->dateTime('upd_time', $precision = 0)->nullable()->comment('วันเวลาผู้update record');
            $table->timestamp('time_up')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('วันเวลาเปลี่ยนแปลงล่าสุด');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_dona_totambons');
    }
};
