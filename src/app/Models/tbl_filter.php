<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_filter extends Model
{
    use HasFactory;
    protected $table = 'tbl_filter';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'FilterTypeID',
        'FilterType', 
        'EquipmentFilter', 
        'FilterQty',
        'equipmentID_Fkey'
    ];

    public function has_equiptype()
    {
        return $this->hasMany(Equipment::class, 'filterID_Fkey');
    }
}
