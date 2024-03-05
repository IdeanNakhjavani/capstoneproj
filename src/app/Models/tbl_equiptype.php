<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_equiptype extends Model
{
    use HasFactory;
    protected $table = 'tbl_contractequipment';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $primaryKey = 'ContractEquipmentID';

    
    protected $fillable = [
        'EquipmentID_Fkey',
        'ContractID_Fkey',
        

    ];

    public function equipment()
    {
        return $this->belongsTo(tblequipment::class,'EquipmentID_Fkey', 'EquipmentID');
    }

    
    public function getfilter()
    {
        return $this->belongsTo(tbl_filter::class,'filterID_Fkey', 'FilterTypeID');
    }
    public function getbelt()
    {
        return $this->belongsTo(tbl_belt::class,'beltID_Fkey', 'BeltID');
    }
    public function getbattery()
    {
        return $this->belongsTo(tbl_battery::class,'battery_FKey', 'BatteryTypeID');
    }
    public function getrefreg()
    {
        return $this->belongsTo(tbl_refrigeranttypes::class,'refrigeranttypes_Fkey', 'RefrigerantTypeID');
    }
}