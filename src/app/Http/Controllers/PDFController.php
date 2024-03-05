<?php

namespace App\Http\Controllers;

use App\Models\contractequipment;
use App\Models\notes;
use App\Models\tbl_building;
use App\Models\tbl_equiptype;
use App\Models\tblequipment;
use App\Models\tbl_price;
use App\Models\User;
use App\Models\tbl_image;
use App\Models\tblcontracts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use DateInterval;

class PDFController extends Controller
{


    public function generate_C_PDF($ContractID)
    {
        $data = DB::table('tbl_contracts')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->select('*')
            ->where('tbl_contracts.ContractID', $ContractID)
            ->get();

        foreach ($data as $data) {
            $install = $data->NumInstallments;
            if ($install == 1) {
                $install = 'yearly';
            } else if ($install == 2) {
                $install = 'annually';
            } else if ($install == 3) {
                $install = 'biannually';
            }


            $year1 = number_format($data->Yr1Price, 2, '.', '');
            $year2 = number_format($data->Yr2Price, 2, '.', '');
            $TotalPrice = number_format($data->ActivePrice, 2, '.', '');
            $date = date("d/M/Y");
            $fields = array(

                //contract modify date 
                'Date' => $date,
                //Company Name (do not change the formate)
                'info'    => "$data->CompanyName 

$data->CustomerAddress, $data->CustomerPostal

$data->Phone

$data->Email",
                //SMP 
                'SMP'    => $data->SMPNum,
                //Building Reference 
                'Date_2'    => $data->BuildingAddress,
                //First Date 
                'first'    => Carbon::parse($data->ContractStartDate)->format('m/d/Y'),
                // End day 
                'first_2'    => Carbon::parse($data->ContractEndDate)->format('m/d/Y'),
                // Annual Charge 
                'second'    => "$ $TotalPrice",
                //installments
                'second_2'    => "$install",
                //First Year
                'second_3'    => "$ $year1 ",
                //Second Year
                'second_4'    => "$ $year2",
                //Name 
                'third'  => 'Matt',
                //Title
                'third2'  => 'Owner',
            );
        }

        $Pdf_file = public_path('pdf/SMP_template_Final.pdf');
        $pdf = new \FPDM($Pdf_file);
        $pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $pdf->Output();
        return back();
    }

    public function RenewalSMP($ContractID)
    {




        $data = DB::table('tbl_contracts')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->select('*')
            ->where('tbl_contracts.ContractID', $ContractID)
            ->get();




        foreach ($data as $data) {
            $install = $data->NumInstallments;
            if ($install == 1) {
                $install = 'annually';
            } else if ($install == 2) {
                $install = 'biannually';
            } else if ($install == 4) {
                $install = 'quarterly';
            }
            $year1 = number_format($data->Renewal1_2, 2, '.', '');
            $year2 = number_format($data->Renewal3_4, 2, '.', '');
            $year3 = number_format($data->Renewal5_6, 2, '.', '');

            $date = date("d/M/Y");
            $fields = array(

                //contract modify date 
                'date' => $date,
                'SMP' => "$data->SMPNum",
                //Company Name (do not change the formate)
                'info'    => "$data->CompanyName 

$data->CustomerAddress, $data->CustomerPostal

$data->Phone

$data->Email",

                'building'    => $data->BuildingAddress,

                'year1'    => "$ $year1",
                'year2'    => "$ $year2",
                'year3'    => "$ $year3",
                'start'    => Carbon::parse($data->ContractEndDate)->format('m/d/Y'),
                'end'    => Carbon::parse($data->RenewalDate)->format('m/d/Y'),
                'basis'    => "$install",
                'name_2' => 'Matt',


            );
        }

        $Pdf_file = public_path('pdf/Renewal_Template_v2_final.pdf');
        $pdf = new \FPDM($Pdf_file);
        $pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $pdf->Output();
        return back();
    }
    public function RequestPricing($ContractID)
    {
        $data = DB::table('tbl_contracts')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->select('*')
            ->where('tbl_contracts.ContractID', $ContractID)
            ->get();

        foreach ($data as $data) {
            $date = date("d M Y");
            $fields = array(
                //contract modify date 
                'Date' => $date,
                'SMP' => "$data->SMPNum",
                //Company Name (do not change the formate)

            );
        }

        $Pdf_file = public_path('pdf/Request_for_Pricing_template.pdf');
        $pdf = new \FPDM($Pdf_file);
        $pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $pdf->Output();
        return back();
    }
    public function BillMonthPDF()
    {

        // Term - which term we are in currently, update auto 
        // Update date - one month before the cicle end,  
        // send reminder to the customer the price will be change from 1000 -> 1900 for next term 
        // Renewal Date - Renew contract price from year1 price 1000 -> year 2 price 1900 
        // when the first term end 
        // NumInstallments - Payment per term $1000 year1 - 4 , monthly charge should be $250

        $current = Carbon::now();

        $data = DB::table('tbl_contracts')
            ->select('*', 'ContractStartDate', 'ContractEndDate')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->Where(function ($query) use ($current) {
                $query->where('ContractStartDate', '<=', $current)
                    ->where('ContractEndDate', '>=', $current);
            })
            ->get();
       

        // if this month is in term 2 and contracttype is 0 then get yr2 price 
        // else if term 2 and contractype is 1 then get renewal1_2 price
        global $total_pay;
        
        $payment_dates = array();

        foreach ($data as $monthdata) { 
            

            if ($monthdata->TermLength == 1 && $monthdata->contractType == 0) {
                $total_pay =  $monthdata->Yr1Price;
                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            } else if ($monthdata->TermLength == 1 && $monthdata->contractType == 1) {
                $total_pay =  $monthdata->Renewal1_2;

                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            } else if ($monthdata->TermLength == 2 && $monthdata->contractType == 0) {
                $total_pay =  $monthdata->Yr1Price;

                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            } else if ($monthdata->TermLength == 2 && $monthdata->contractType == 1) {
                $total_pay =  $monthdata->Renewal1_2;

                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            } else if ($monthdata->TermLength == 3 || $monthdata->TermLength == 4) {
                $total_pay =  $monthdata->Renewal3_4;

                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            } else if ($monthdata->TermLength == 5 || $monthdata->TermLength == 6) {
                $total_pay =  $monthdata->Renewal5_6;

                if ($monthdata->NumInstallments == 1) {
                    $month_pay = $total_pay;
                } else if ($monthdata->NumInstallments == 2) {
                    $month_pay = $total_pay / 2;
                } else if ($monthdata->NumInstallments == 4) {
                    $month_pay = $total_pay / 4;
                }
            }
            $payment_dates[] = [

                'SMP' => $monthdata->SMPNum,
                'customer' => $monthdata->FirstName . ' ' . $monthdata->LastName,
                'building' => $monthdata->BuildingAddress,
                'payment_date' => $monthdata->RenewalDate,
                'Term' => $monthdata->TermLength,
                'amount' => $total_pay,
                'billing_amount' => $month_pay,
                'installments' => $monthdata->NumInstallments,
                'ContractStartDate' => $monthdata->ContractStartDate,
                'ContractEndDate' =>  $monthdata->ContractStartDate,
                'UpdateDate' =>  $monthdata->ContractUpdate,
            ];
        } 
        // share data to view
        //yearly - 1, biannually 2, quarterly 3

        

       
        //return view('MonthlyBilling', ['payment_dates' => $payment_dates]);

        //view()->share('MonthlyBilling', ['payment_dates' => $payment_dates,'payment_dates2' => $filtered_data]);
        $pdf = PDF::loadView('MonthlyBilling', ['payment_dates' => $payment_dates]);
        //download PDF file with download method
        return $pdf->download('Monthly_billing.pdf');
    }

    public function EquipmentCheckPDF()
    {


        $current = Carbon::now();

        /*SELECT tbl_contracts.SMPNum,tbl_contracts.ContractStartDate,tbl_contracts.ContractEndDate, tbl_contractequipment.*, tbl_equipment.*
            FROM tbl_contracts
            Left JOIN tbl_contractequipment ON tbl_contracts.ContractID = tbl_contractequipment.ContractID_Fkey
            left JOIN tbl_equipment ON tbl_equipment.EquipmentID = tbl_contractequipment.EquipmentID_Fkey
            WHERE tbl_contracts.ContractStartDate <= CURDATE() and tbl_contracts.ContractEndDate >= CURDATE();

        */
        $month = date('n'); // Get the current month (1-12)

        $monthColumns = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];
        $columnName = $monthColumns[$month];

        //('getequipment','getequipment.getequiptype')
        $equipcontract = tblcontracts::with([

            'getequipment' => function ($query) use ($columnName) {
                $query->where("tbl_equipment.{$columnName}", 1);
            },

            'getequipment.getequiptype',


        ])
            //->join('tbl_customers', 'tbl_contracts.CustomerID_Fkey', '=', 'tbl_customers.CustomerID')
            ->where('tbl_contracts.ContractStartDate', '<=',  $current)
            ->where('tbl_contracts.ContractEndDate', '>=', $current)
            ->get();




        // SMP number 
        // first two goes up every year  38 next year will be 39 
        // last two per contract made by that year  01 
        // 3901-2



        $filter = DB::table('tbl_filter')
            ->get();
        $note = DB::table('tbl_notes')
            ->get();




        $pdf = PDF::loadView('MonthEquipment', ['equipcontract' => $equipcontract]);
        return $pdf->download('MonthEquipment.pdf');


        //return view('MonthEquipment', ['equipcontract' => $equipcontract]);
    }
}
