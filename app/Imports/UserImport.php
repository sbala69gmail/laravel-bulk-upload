<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Exceptions\ReportValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class UserImport implements ToArray, WithStartRow, WithHeadingRow, WithMultipleSheets
{

    public $data ;
    /**
    * @param Collection $collection
    */
    public function array(array $rows)
    {
        // dd($rows[0]);
        $data = [];
        foreach($rows as $row){
            $data[] = $row;
        }
        $this->data = $data;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }


}
