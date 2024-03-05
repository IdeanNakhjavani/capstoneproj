<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    use HasFactory;
    protected $table = 'tbl_customers';
    protected $primaryKey = 'CustomerID';
    public $timestamps = false;

    protected $fillable = [
        'CompanyName',
        'FirstName',
        'LastName',
        'Title',
        'CustomerAddress',
        'CustomerPostal',
        'CityID_Fkey',
        'Email',
        'Phone',
        'Other',
        'Fax',
        'NoteID_Fkey',
        'Active',
        'RecordDate',
        'OLDRecordNum',
    ];

    // Define any relationships or additional methods here
}
