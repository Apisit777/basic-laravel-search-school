<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class DiaryImport implements ToCollection, WithHeadingRow
{
    protected $docNo;

    public function __construct(string $docNo)
    {
        $this->docNo = $docNo;
    }

    public function collection(Collection $rows)
    {
        $conn = DB::connection('mysql_diary');

        foreach ($rows as $row) {
            // trn_diary2
            $conn->table('trn_diary2')->insert([
                'doc_no'     => $this->docNo,
                'seq'        => $row['seq'],
                'product_id' => $row['product_id'],
                'quantity'   => $row['quantity'],
            ]);

            // trn_diary1 - update branch_id ตาม location_id
            $conn->table('trn_diary1')
                ->where('doc_no', $this->docNo)
                ->update(['branch_id' => $row['location_id']]);
        }
    }
}
