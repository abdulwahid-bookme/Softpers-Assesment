<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

     protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
     ];

     public function columns(){
       return $this->hasMany(FileColumn::class, 'file_id');
     }

     public function excelFiles(){
        return $this->hasManyThrough(ExcelFileData::class, FileColumn::class, 'file_id', 'column_id', 'id', 'id');
      }

 
}
