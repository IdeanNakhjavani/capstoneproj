<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblequipment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tbl_equipment';
    protected $primaryKey = 'EquipmentID';
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'EquipmentID',
        'UnitID',
        'Model',
        'Serial',
        'InServiceStart',
        'InServiceEnd',
        'LocationRoom',
        'Notes',
        'Active',
        'tbl_equipment.RecordDate',
        'EquipmentValue',
        'tbl_equipment.FullDetails',
        'JobNumber',
        'contractID_FKey',
        'EquipType',
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
    ];

    public function getequiptype()
    {
        return $this->hasMany(tbl_equiptype::class, 'EquipmentID_Fkey');
    }
    public function contracts()
    {
        return $this->belongsTo(tblcontracts::class, 'contractID_FKey', 'ContractID');
    }
    public function notes()
    {
        return $this->hasMany(notes::class, 'EquipmentID_Fkey');
    }
    
}
