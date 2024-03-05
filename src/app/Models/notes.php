<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;
    protected $table = 'tbl_notes';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $primaryKey = 'NoteID';
    protected $fillable = [
        'NoteID', 
        'NotesDate', 
        'Notes', 
        'Active',
        'ContractID_Fkey', 
        'BuildingID_Fkey',
        'EquipmentID_Fkey'
    ];
}