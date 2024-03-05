<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_locations extends Model
{
    use HasFactory;
    protected $table = 'tbl_locations';

    public $timestamps = false;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'CityID',
        'City', 
        'ProvinceName', 
        'CountryName',
        'Active',
    ];
}
