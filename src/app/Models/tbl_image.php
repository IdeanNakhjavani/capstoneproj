<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_image extends Model
{
    use HasFactory;
    protected $table = 'tbl_images';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'ImagePath',
        'primarypath',
        'RecordDate',
        'contractImg',
       
    ];
}
