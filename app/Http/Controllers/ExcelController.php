<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileColumn;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Exports\ExportExcelFileData;
use App\Imports\ImportExcelFileData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\HeadingRowImport;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::get();
        return view('index', ['files' => $files]);
    }



    public function upload(ExcelRequest $request)
    {
        try {
            $file_data = File::create([
                'name' => request()->file('file')->getClientOriginalName(),
            ]);
            $data = (new HeadingRowImport)->toArray($request->file)[0][0];
            $data = array_filter($data, 'is_string');
            foreach ($data as $data_item) {
                FileColumn::create([
                    'file_id' => $file_data->id,
                    'headings' => ucfirst(str_replace('_', ' ', $data_item)),
                ]);
            }
            Excel::import(new ImportExcelFileData, $request->file);
            DB::commit();
            return redirect()->back()->with('success', 'File Uploaded');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e);
        }
    }

    public function file(File $file)
    {
        $data['file_name'] = $file->name;
        $data['headings'] = $file->columns->toArray();
        $data['cells'] = $file->excelFiles()->orderBy('id', 'asc')->orderBy('column_id', 'asc')->get()->toArray();
        return view('view-file', $data);
    }

    public function get_files()
    {
        return view('importFile');
    }

    public function export(File $file)
    {
        return Excel::download(new ExportExcelFileData($file), $file->name);
    }

    public function __destruct()
    {
        cache::pull('columns');
    }
}
