<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_manufacturers extends Model
{
    use HasFactory;
    protected $table = 'tbl_manufacturers';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'ManufacturerID',
        'ManufacturerName', 
        'NoteID_Fkey', 
    ];
}
