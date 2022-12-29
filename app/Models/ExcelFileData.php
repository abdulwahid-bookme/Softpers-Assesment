<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExcelFileData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ='data';

    protected $fillable = [
        'column_id', 'value'
    ];

     protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
     ];

     public function column(){
        return $this->belongsTo(FileColumn::class, 'column_id');
     }
}
