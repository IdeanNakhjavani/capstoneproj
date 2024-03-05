<?php

namespace App\Services;

use App\Models\tblcontracts;
use Carbon\Carbon;

class SMPNumberService
{
    public static function generateSMPNumber()
    {
        $currentYear = Carbon::now()->format('y');
        $lastContract = tblcontracts::latest()->first();

        if ($lastContract) {
            $lastSMPNumber = $lastContract->SMPNum;

            $lastYear = substr($lastSMPNumber, 0, 2);
            $lastCounter = intval(substr($lastSMPNumber, 2, 2));

            if ($lastYear == $currentYear) {
                $newCounter = $lastCounter + 1;
            } else {
                $newCounter = 1;
            }
        } else {
            $newCounter = 1;
        }

        return $currentYear . str_pad($newCounter, 2, '0', STR_PAD_LEFT);
    }
}
    