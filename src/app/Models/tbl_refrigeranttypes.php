<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_refrigeranttypes extends Model
{
    use HasFactory;
    protected $table = 'tbl_refrigeranttypes';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'refrigerantTypeId',
        'refrigerantModel', 
        'RefrigerationSerial', 
       
    ];
}
