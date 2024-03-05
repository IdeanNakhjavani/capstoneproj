<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_belt extends Model
{
    use HasFactory;

    protected $table = 'tbl_belt'; // Assuming the table name is 'belts'
    protected $primaryKey = 'BeltID'; // Assuming the primary key column is 'BeltID'
    public $timestamps = false; // Assuming the table doesn't have created_at and updated_at columns

    protected $fillable = [
        'BeltType',
    ];

    public function has_equiptype()
    {
        return $this->hasMany(Equipment::class, 'beltID_Fkey');
    }
}
