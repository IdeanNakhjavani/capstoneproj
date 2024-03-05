<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class tblcontracts extends Model
{
    use HasFactory;
    protected $table = 'tbl_contracts';

    public $timestamps = false;
    protected $primaryKey = 'ContractID';
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'ContractID',
        'SMPNum',
        'SMPQuote',
        'SMPActive',
        'SMPReceived',
        'ContractStartDate',
        'ContractEndDate',
        'RenewalDate',
        'NumInstallments',
        'TermLength',
        'ContractUpdate',
        'Yr1Price',
        'Yr2Price',
        'Renewal1_2',
        'Renewal3_4',
        'Renewal5_6',
        'ActivePrice',
        'BillJan',
        'BillFeb',
        'BillMar',
        'BillApr',
        'BillMay',
        'BillJun',
        'BillJul',
        'BillAug',
        'BillSep',
        'BillOct',
        'BillNov',
        'BillDec',
        'ModifiedDate',
        'RecordDate',
        'OldRecordNum',
        'AgreedTo',
        'NoteID_Fkey',
        'contractType'
    ];
    public function getcustomer()
    {
        return $this->belongsTo(customers::class, 'CustomerID_Fkey', 'CustomerID');
    }
    public function getbuilding()
    {
        return $this->belongsTo(tbl_building::class, 'BuildingID_Fkey', 'BuildingID');
    }

    public function getequipment()
    {
        return $this->hasMany(tblequipment::class, 'contractID_FKey');
    }
    public function getnotes()
    {
        return $this->hasMany(notes::class, 'ContractID_Fkey');
    }

    public function getCurrentTerm()
    {
        $currentDate = Carbon::now();
        $contractStartDate = Carbon::parse($this->ContractStartDate);
        $renewalMonth = $this->RenewalDate;

        // Calculate the term length in months
        $termLength = $this->TermLength * 12;

        // Calculate the number of months since the contract start date
        $monthsSinceStart = $contractStartDate->diffInMonths($currentDate);

        // Adjust the number of months based on the renewal month
        if ($renewalMonth > $contractStartDate->month) {
            $monthsSinceStart -= ($renewalMonth - $contractStartDate->month);
        } elseif ($renewalMonth < $contractStartDate->month) {
            $monthsSinceStart += (12 - ($contractStartDate->month - $renewalMonth));
        }

        // Check if the term length is zero
        if ($termLength == 0) {
            return 0; // Or handle the case when the term length is zero
        }

        // Calculate the current term
        $currentTerm = floor($monthsSinceStart / $termLength) + 1;

        return $currentTerm;
    }
}
