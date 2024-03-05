<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_battery extends Model
{
    use HasFactory;
    protected $table = 'tbl_battery';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'BatteryTypeID', 
        'BatteryTypeCode', 
        'BatteryType', 
        'BatteryQty',
    ];
}
