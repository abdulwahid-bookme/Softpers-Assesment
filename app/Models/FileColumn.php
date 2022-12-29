<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileColumn extends Model
{
  protected $table ='columns';

    use HasFactory, SoftDeletes;

    protected $fillable = ['file_id', 'headings'];

    protected $hidden = [
       'deleted_at', 'created_at', 'updated_at'
    ];

    public function excelFileData(){
        return $this->hasMany(ExcelFileData::class, 'column_id');
     }

     public function file(){
        return $this->belongsTo(File::class, 'file_id');
     }
}
