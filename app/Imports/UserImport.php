<?php

namespace App\Imports;

use App\Models\User;
use App\Models\ManagePrice;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ManagePrice([
            'brand'     => $row['brand'],
            'product'    => $row['product'],
            // 'price'    => $row['price'],
            'cost'    => $row['cost'],
            'start_date' => Carbon::createFromFormat('d/m/Y', $row['start_date'])->format('Y-m-d H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
