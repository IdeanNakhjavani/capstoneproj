<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_building extends Model
{
    use HasFactory;
    protected $table = 'tbl_buildings';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'BuildingID', 
        'CustomerID_Fkey', 
        'BuildingDesc', 
        'BuildingAddress',
        'CityID_Fkey', 
        'BuildingPostal', 
        'ImageID_Fkey', 
        'NoteID_Fkey', 
        'Active', 
        'RecordDate',
    ];

    public function notes()
    {
        return $this->hasMany(notes::class, 'BuildingID_Fkey');
    }
}
