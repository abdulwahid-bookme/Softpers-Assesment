<?php

namespace App\Exports;

use App\Models\FileColumn;
use App\Models\ExcelFileData;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;

class ExportExcelFileData implements FromCollection, WithHeadings, ShouldQueue
{
    use Exportable;
    protected $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $export_file = DB::table('data')
        ->leftJoin('columns', 'data.column_id', '=', 'columns.id')
        ->where('columns.file_id', $this->file->id)
        ->select('columns.headings','data.*')
        ->get('column_id')
        ->groupBy('headings')
        ->toArray();
        $temp_arr = [];
        foreach($export_file as $column){
            array_push($temp_arr,array_column($column, 'value'));
        }
        foreach($temp_arr as $key => $arr){
            for($i = 0; $i<count($arr); $i++){
            $sortData[$i] = array_column($temp_arr, $i);
            }
        }
        $collection = collect($sortData);
        return $collection;
    }
    public function headings(): array
    {
        return $this->file->columns()->pluck('headings')->toArray();
    }
}
