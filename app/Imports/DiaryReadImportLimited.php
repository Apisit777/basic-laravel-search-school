<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithColumnLimit;

/**
 * สำหรับ .xlsx / .csv — จำกัดอ่านแค่ column A-F (เร็วกว่า)
 * .xls ใช้ DiaryReadImport แทน (WithColumnLimit ไม่รองรับ .xls)
 */
class DiaryReadImportLimited extends DiaryReadImport implements WithColumnLimit
{
    public function endColumn(): string
    {
        return 'F';
    }
}
