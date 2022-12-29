<?php

namespace App\Imports;

use App\Models\File;
use App\Models\FileColumn;
use App\Models\ExcelFileData;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportExcelFileData implements ToModel, WithChunkReading, ShouldQueue, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $get_columns = Cache::remember('columns', 10, function () {
            return FileColumn::where('file_id', File::orderBy('id', 'desc')->first()->id)->get()->modelKeys();
        });
        for ($i = 0; $i < count($get_columns); $i++) {
            ExcelFileData::create([
                'column_id' => (int) $get_columns[$i],
                'value' => $row[$i] ?? '',
            ]);
        }
    }

    public function startRow(): int
    {
         return 2;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
