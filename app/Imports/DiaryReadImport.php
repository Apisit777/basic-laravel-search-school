<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;

class DiaryReadImport implements ToCollection, WithChunkReading
{
    public int $totalQty = 0;
    public array $branches = [];

    private int $headerFound = -1;
    private int $qtyCol = -1;
    private int $locationCol = -1;
    private int $currentRow = 0;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->currentRow++;
            $arr = $row->toArray();

            // scan แถว 1-3 หา header ที่มีคำว่า "Quantity"
            if ($this->headerFound === -1) {
                if ($this->currentRow > 3) continue;
                foreach ($arr as $i => $val) {
                    if (is_string($val) && strtolower(trim($val)) === 'quantity') {
                        $this->headerFound = $this->currentRow;
                        foreach ($arr as $ci => $cv) {
                            $key = strtolower(trim($cv ?? ''));
                            if ($key === 'quantity') $this->qtyCol = $ci;
                            if ($key === 'location_id') $this->locationCol = $ci;
                        }
                        break;
                    }
                }
                continue;
            }

            // อ่านข้อมูลจริง
            $qty = (int) ($arr[$this->qtyCol] ?? 0);
            $branchId = $arr[$this->locationCol] ?? '';

            if ($qty === 0) continue;

            $this->totalQty += $qty;

            if (!isset($this->branches[$branchId])) {
                $this->branches[$branchId] = ['quantity' => 0];
            }
            $this->branches[$branchId]['quantity'] += $qty;
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
