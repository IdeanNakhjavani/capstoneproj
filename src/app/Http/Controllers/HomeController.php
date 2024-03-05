<?php

namespace App\Http\Controllers;

use App\Services\SMPNumberService;
use App\Models\contractequipment;
use App\Models\notes;
use App\Models\tbl_building;
use App\Models\tbl_equiptype;
use App\Models\tblcontracts;
use App\Models\tblequipment;
use App\Models\tbl_price;
use App\Models\User;
use App\Models\tbl_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $currentDate = Carbon::now()->addMonth(); // Get the current date plus one month

        $contracts = DB::table('tbl_contracts')
            ->where('RenewalDate', $currentDate->format('n')) // Compare the renewal month with the current month
            ->pluck('ContractID');


        return view('home', ['contracts' => $contracts]);
    }
    public function main()
    {
        $currentDate = Carbon::now()->addMonth(); // Get the current date plus one month

        $contracts = DB::table('tbl_contracts')
            ->where('RenewalDate', $currentDate->format('n')) // Compare the renewal month with the current month
            ->pluck('ContractID');

        return view('main', ['contracts' => $contracts]);
    }



    //contracts List
    public function tblcontracts()
    {
        $tblcontracts = DB::table('tbl_contracts')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->where('tbl_contracts.OldRecordNum', '=', 0)
            ->select('*')
            ->get();

        return view('contractlist', ['tbl_contracts' => $tblcontracts]);
    }



    //view contracts 
    public function viewcontract($ContractID)
    {
        $img = DB::table('tbl_images')
            ->where('contractImg', $ContractID)
            ->get();

        $contractTable = DB::table('tbl_contracts')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->select('*')
            ->where('tbl_contracts.ContractID', $ContractID)
            ->get();

        $notes = DB::table('tbl_notes')
            ->where('ContractID_Fkey', $ContractID)
            ->get();

        $RecordSMP = tblcontracts::find($ContractID);
        $oldSMP = $RecordSMP->SMPNum;

        $OldRecord = tblcontracts::where('tbl_contracts.OldRecordNum', $oldSMP)
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->get();

        $equipment1 = DB::table('tbl_equipment')
            ->leftJoin('tbl_manufacturers', 'tbl_manufacturers.ManufacturerID', 'tbl_equipment.ManufacturerID_Fkey')
            ->where('contractID_FKey', $ContractID)
            ->get();

        $contract = tblcontracts::findOrFail($ContractID);
        $currentTerm = $contract->getCurrentTerm();

        $location = DB::table('tbl_locations')
            ->get();
        $refrigerant = DB::table('tbl_refrigeranttypes')
            ->get();
        $building = DB::table('tbl_buildings')
            ->get();
        $tbl_manufacturers = DB::table('tbl_manufacturers')
            ->get();
        $Filter = DB::table('tbl_filter')
            ->get();
        $battery = DB::table('tbl_battery')
            ->get();
        $belt = DB::table('tbl_belt')
            ->get();


        return view('viewcontract', [
            'tbl_contracts' => $contractTable,
            'currentTerm' => $currentTerm,
            'tbl_duplicate' => $OldRecord,
            'tbl_equipment' => $equipment1,
            'tbl_locations' => $location,
            'tbl_buildings' => $building,
            'tbl_notes' => $notes,
            'tbl_images' => $img,
            'tbl_manufacturers' => $tbl_manufacturers,
            'tbl_filter' => $Filter,
            'tbl_battery' => $battery,
            'tbl_refrigeranttypes' => $refrigerant,
            'tbl_belt' => $belt,
        ]);
    }

    //update contract data
    public function updatecontract(Request $request, $ContractID)
    {

        $percent = DB::table('tbl_price')
            ->select('*')
            ->where('priceid', '=', 1)
            ->get();


        $contractTable = DB::table('tbl_contracts')
            ->select('*')
            ->where('tbl_contracts.ContractID', $ContractID)
            ->get();



        foreach ($contractTable as $contractTable) {




            if ($contractTable->contractType == 0) {


                $Yr2Price = $request->input('SecondYear');
                foreach ($percent as $percent1) {

                    if (empty($contractTable->Yr2Price)) {
                        $Yr2Price = ceil(($contractTable->Yr1Price *  (1 - ($percent1->Discounts / 100))) / 5) * 5;
                    }
                }

                //tblbuilding::where('Contract_Fkey', $ContractID)
                //    ->update()
                tblcontracts::where('ContractId', $ContractID)
                    ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
                    ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
                    ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
                    ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
                    ->update([
                        'FirstName' => $request->input('FirstName'),
                        'LastName' => $request->input('LastName'),
                        'CompanyName' => $request->input('CompanyName'),
                        'tbl_buildings.BuildingAddress' => $request->input('BuildingAddress'),
                        'tbl_buildings.BuildingPostal' => $request->input('BuildingPostal'),
                        'tbl_buildings.BuildingDesc' => $request->input('BuildingDescription'),
                        'SMPNum' => $request->input('SMPNum'),
                        'SMPQuote' => $request->input('SMPQuote') == true ? '1' : '0',
                        'SMPActive' => $request->input('SMPActive') == true ? '1' : '0',
                        'SMPReceived' => $request->input('SMPReceived') == true ? '1' : '0',
                        'tbl_customers.CityID_Fkey' => $request->input('CityID_Fkey'),
                        'tbl_contracts.ContractStartDate' => $request->input('startdate'),
                        'tbl_contracts.ContractEndDate' => $request->input('enddate'),
                        'tbl_contracts.RenewalDate' => $request->input('renewaldate'),
                        'NumInstallments' => $request->input('NumInstallments'),
                        'TermLength' => $request->input('Term'),
                        'ContractUpdate' => $request->input('ContractUpdate'),
                        'Yr1Price' => $request->input('FirstYear'),
                        'Yr2Price' => $Yr2Price,
                        'ActivePrice' => $request->input('ActivePrice'),
                        'contractType' => $request->input('contractType') == true ? '1' : '0',
                        'BillJan' => $request->input('BillJan') == true ? '1' : '0',
                        'BillFeb' => $request->input('BillFeb') == true ? '1' : '0',
                        'BillMar' => $request->input('BillMar') == true ? '1' : '0',
                        'BillApr' => $request->input('BillApr') == true ? '1' : '0',
                        'BillMay' => $request->input('BillMay') == true ? '1' : '0',
                        'BillJun' => $request->input('BillJun') == true ? '1' : '0',
                        'BillJul' => $request->input('BillJul') == true ? '1' : '0',
                        'BillAug' => $request->input('BillAug') == true ? '1' : '0',
                        'BillSep' => $request->input('BillSep') == true ? '1' : '0',
                        'BillOct' => $request->input('BillOct') == true ? '1' : '0',
                        'BillNov' => $request->input('BillNov') == true ? '1' : '0',
                        'BillDec' => $request->input('BillDec') == true ? '1' : '0',
                        'ModifiedDate' => $request->input('ModifiedDate'),
                        'tbl_contracts.RecordDate' => $request->input('RecordDate'),
                        'AgreedTo' => $request->input('AgreedTo'),
                    ]);
            } else {

                $Renewal1_2 = $request->input('Renewal1_2');
                $Renewal3_4 = $request->input('Renewal3_4');
                $Renewal5_6 = $request->input('Renewal5_6');

                foreach ($percent as $percent1) {
                    if (empty($contractTable->Renewal3_4) && empty($contractTable->Renewal5_6)) {

                        $Renewal3_4 = ceil(($Renewal1_2 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
                        $Renewal5_6 = ceil(($Renewal3_4 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
                    } elseif (empty($contractTable->Renewal3_4)) {

                        $Renewal3_4 = ceil(($Renewal1_2 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
                    } elseif (empty($contractTable->Renewal5_6)) {
                        $Renewal5_6 = ceil(($Renewal3_4 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
                    }
                }


                tblcontracts::where('ContractId', $ContractID)
                    ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
                    ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
                    ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
                    ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
                    ->update([
                        'FirstName' => $request->input('FirstName'),
                        'LastName' => $request->input('LastName'),
                        'BuildingAddress' => $request->input('BuildingAddress'),
                        'BuildingPostal' => $request->input('BuildingPostal'),
                        'tbl_buildings.BuildingDesc' => $request->input('BuildingDescription'),
                        'SMPNum' => $request->input('SMPNum'),
                        'SMPQuote' => $request->input('SMPQuote') == true ? '1' : '0',
                        'SMPActive' => $request->input('SMPActive') == true ? '1' : '0',
                        'SMPReceived' => $request->input('SMPReceived') == true ? '1' : '0',
                        'tbl_customers.CityID_Fkey' => $request->input('CityID_Fkey'),
                        'tbl_contracts.ContractStartDate' => $request->input('startdate'),
                        'tbl_contracts.ContractEndDate' => $request->input('enddate'),
                        'tbl_contracts.RenewalDate' => $request->input('renewaldate'),
                        'NumInstallments' => $request->input('NumInstallments'),
                        'TermLength' => $request->input('Term'),
                        'ContractUpdate' => $request->input('ContractUpdate'),
                        'Renewal1_2' => $Renewal1_2,
                        'Renewal3_4' => $Renewal3_4,
                        'Renewal5_6' => $Renewal5_6,
                        'ActivePrice' => $request->input('ActivePrice'),
                        'contractType' => $request->input('contractType'),
                        'BillJan' => $request->input('BillJan') == true ? '1' : '0',
                        'BillFeb' => $request->input('BillFeb') == true ? '1' : '0',
                        'BillMar' => $request->input('BillMar') == true ? '1' : '0',
                        'BillApr' => $request->input('BillApr') == true ? '1' : '0',
                        'BillMay' => $request->input('BillMay') == true ? '1' : '0',
                        'BillJun' => $request->input('BillJun') == true ? '1' : '0',
                        'BillJul' => $request->input('BillJul') == true ? '1' : '0',
                        'BillAug' => $request->input('BillAug') == true ? '1' : '0',
                        'BillSep' => $request->input('BillSep') == true ? '1' : '0',
                        'BillOct' => $request->input('BillOct') == true ? '1' : '0',
                        'BillNov' => $request->input('BillNov') == true ? '1' : '0',
                        'BillDec' => $request->input('BillDec') == true ? '1' : '0',
                        'ModifiedDate' => $request->input('ModifiedDate'),
                        'tbl_contracts.RecordDate' => $request->input('RecordDate'),
                        'AgreedTo' => $request->input('AgreedTo'),
                    ]);
            }
        }


        $workData = $request->input('Work');
        if (!is_null($workData) && is_array($workData)) {


            foreach ($workData as $id => $work) {
                $equipment = tblequipment::find($id);
                if ($equipment) {
                    $equipment->Jan = isset($work['WorkJan']) ? 1 : 0;
                    $equipment->Feb = isset($work['WorkFeb']) ? 1 : 0;
                    $equipment->Mar = isset($work['WorkMar']) ? 1 : 0;
                    $equipment->Apr = isset($work['WorkApr']) ? 1 : 0;
                    $equipment->May = isset($work['WorkMay']) ? 1 : 0;
                    $equipment->Jun = isset($work['WorkJun']) ? 1 : 0;
                    $equipment->Jul = isset($work['WorkJul']) ? 1 : 0;
                    $equipment->Aug = isset($work['WorkAug']) ? 1 : 0;
                    $equipment->Sep = isset($work['WorkSep']) ? 1 : 0;
                    $equipment->Oct = isset($work['WorkOct']) ? 1 : 0;
                    $equipment->Nov = isset($work['WorkNov']) ? 1 : 0;
                    $equipment->Dec = isset($work['WorkDec']) ? 1 : 0;
                    $equipment->save();
                }
            }
        }
        // Save changes to the database
        //$tbl_contractequipment->save();

        return back()->with('status', 'Contract data Updated Successfully');
    }

    //Equipment List
    public function tblequipment()
    {
        $tblequipment = DB::table('tbl_equipment')
            ->leftjoin('tbl_buildings', 'tbl_equipment.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->get();
        return view('equipmentlist', ['tbl_equipment' => $tblequipment]);
    }

    public function viewequipment($equipmentID)
    {
        $img = DB::table('tbl_images')
            ->where('primarypath', $equipmentID)
            ->get();

        $tbl_contractequipment_filter = DB::table('tbl_contractequipment')
            ->where('EquipmentID_Fkey', $equipmentID)
            ->whereNotNull('filterID_FKey')
            ->get();
        $tbl_contractequipment_belt = DB::table('tbl_contractequipment')
            ->where('EquipmentID_Fkey', $equipmentID)
            ->whereNotNull('beltID_Fkey')
            ->get();
        $tbl_contractequipment_battery = DB::table('tbl_contractequipment')
            ->where('EquipmentID_Fkey', $equipmentID)
            ->whereNotNull('battery_Fkey')
            ->get();
        $tbl_contractequipment_refrigerant = DB::table('tbl_contractequipment')
            ->where('EquipmentID_Fkey', $equipmentID)
            ->whereNotNull('refrigeranttypes_Fkey')
            ->get();
        $location = DB::table('tbl_locations')
            ->get();
        $refrigerant = DB::table('tbl_refrigeranttypes')
            ->get();
        $building = DB::table('tbl_buildings')
            ->get();
        $tbl_manufacturers = DB::table('tbl_manufacturers')
            ->get();
        $Filter = DB::table('tbl_filter')
            ->get();
        $battery = DB::table('tbl_battery')
            ->get();
        $belt = DB::table('tbl_belt')
            ->get();

        $equipment = DB::table('tbl_equipment')
            ->leftjoin('tbl_buildings', 'tbl_buildings.BuildingID', '=', 'tbl_equipment.BuildingID_Fkey')
            ->leftjoin('tbl_manufacturers', 'tbl_manufacturers.manufacturerID', '=', 'tbl_equipment.manufacturerID_Fkey')
            ->leftjoin('tbl_filter', 'tbl_filter.FilterTypeID', '=', 'tbl_equipment.FilterID_Fkey')
            ->leftjoin('tbl_notes', 'tbl_notes.noteID', '=', 'tbl_equipment.noteID_Fkey')
            ->leftjoin('tbl_refrigeranttypes', 'tbl_refrigeranttypes.RefrigerantTypeID', '=', 'tbl_equipment.refrigerantID_Fkey')
            ->leftjoin('tbl_battery', 'tbl_battery.BatteryTypeID', '=', 'tbl_equipment.BatteryID_Fkey')
            ->select('*')
            ->where('EquipmentID', $equipmentID)
            ->get();

        $notes = DB::table('tbl_notes')
            ->where('EquipmentID_Fkey', $equipmentID)
            ->get();



        return view('viewequipment', [
            'tbl_notes' => $notes,
            'tbl_equipment' => $equipment,
            'tbl_manufacturers' => $tbl_manufacturers,
            'tbl_filter' => $Filter,
            'tbl_locations' => $location,
            'tbl_contractequipment_filter' => $tbl_contractequipment_filter,
            'tbl_contractequipment_belt' => $tbl_contractequipment_belt,
            'tbl_contractequipment_battery' => $tbl_contractequipment_battery,
            'tbl_contractequipment_refrigerant' => $tbl_contractequipment_refrigerant,
            'tbl_buildings' => $building,
            'tbl_battery' => $battery,
            'tbl_refrigeranttypes' => $refrigerant,
            'tbl_images' => $img,
            'tbl_belt' => $belt
        ]);
    }

    public function updateequipment(Request $request, $equipmentID)
    {
        $getcontractID =  DB::table('tbl_equipment')
            ->where('equipmentID', $equipmentID)
            ->first();

        $UcontractID = $getcontractID->contractID_FKey;


        //filter edit
        $filterData = $request->input('filterData');
        if (is_array($filterData) || is_object($filterData)) {
            foreach ($filterData as $filterId => $data) {
                // Find the filter record
                $filter = tbl_equiptype::findOrFail($filterId);

                // Update the filter type
                $filter->filterID_Fkey = $data['filterID'];

                // Update the quantity
                $filter->filter_quantity = $data['quantity'];

                $filter->save();
            }
        }
        //belt edit
        $beltData = $request->input('beltID');

        if (is_array($beltData) || is_object($beltData)) {
            foreach ($beltData as $contractEquipmentId => $data) {
                // Find the belt record
                $belt = tbl_equiptype::findOrFail($contractEquipmentId);

                // Update the belt ID
                $belt->beltID_Fkey = $data['beltID'];

                // Update the quantity
                $belt->belt_quantity = $data['belt_quantity'];

                $belt->save();
            }
        }
        //battery edit
        $batteryData = $request->input('batteryID');


        if (is_array($batteryData) || is_object($batteryData)) {
            foreach ($batteryData as $batteryId => $data) {
                // Find the filter record
                $battery = tbl_equiptype::findOrFail($batteryId);

                // Update the filter type
                $battery->battery_FKey = $data['batteryID'];

                // Update the quantity
                $battery->battery_quantity = $data['battery_quantity'];

                $battery->save();
            }
        }
        //refrig edit
        $refrigData = $request->input('refrigerantid');

        if (is_array($refrigData) || is_object($refrigData)) {
            foreach ($refrigData as $refrigID => $data) {
                // Find the filter record
                $refrigData = tbl_equiptype::findOrFail($refrigID);

                // Update the filter type
                $refrigData->refrigeranttypes_Fkey = $data['refrigerantid'];

                // Update the quantity
                $refrigData->refri_quantity = $data['quantity'];

                $refrigData->save();
            }
        }
        $validatedData = $request->validate([
            'BeltID' => 'array',
            'BeltID.*' => 'nullable', // Adjust the validation rule as needed
            'BeltID_quantity' => 'array',
            'BeltID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'filterID' => 'array',
            'filterID.*' => 'nullable', // Adjust the validation rule as needed
            'filterID_quantity' => 'array',
            'filterID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'RefrigerantID' => 'array',
            'RefrigerantID.*' => 'nullable', // Adjust the validation rule as needed
            'RefrigerantID_quantity' => 'array',
            'RefrigerantID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'BatteryID' => 'array',
            'BatteryID.*' => 'nullable', // Adjust the validation rule as needed
            'BatteryID_quantity' => 'array',
            'BatteryID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        if (isset($validatedData['filterID'])) {
            $filters = $validatedData['filterID'];
            $quantities = $validatedData['filterID_quantity'];

            // Perform the necessary actions with the filter data
            // For example, you can loop through the filters and quantities
            foreach ($filters as $key => $filter) {
                $quantity = $quantities[$key];

                // Create and associate the filter record with the equipment
                $equipmentFilter = new tbl_equiptype();
                $equipmentFilter->EquipmentID_Fkey = $equipmentID;
                $equipmentFilter->ContractID_Fkey = $UcontractID;
                $equipmentFilter->filterID_Fkey = $filter;
                $equipmentFilter->filter_quantity = $quantity;
                $equipmentFilter->save();
            }
        }

        if (isset($validatedData['BeltID'])) {
            $belts = $validatedData['BeltID'];
            $beltQuantities = $validatedData['BeltID_quantity'];

            // Perform the necessary actions with the belt data
            // For example, you can loop through the belts and quantities
            foreach ($belts as $key => $belt) {
                $quantity = $beltQuantities[$key];

                // Create and associate the belt record with the equipment
                $equipmentBelt = new tbl_equiptype();
                $equipmentBelt->EquipmentID_Fkey = $equipmentID;
                $equipmentBelt->ContractID_Fkey = $UcontractID;
                $equipmentBelt->beltID_Fkey = $belt;
                $equipmentBelt->belt_quantity = $quantity;
                $equipmentBelt->save();
            }
        }

        if (isset($validatedData['RefrigerantID'])) {
            $refrigerants = $validatedData['RefrigerantID'];
            $quantities = $validatedData['RefrigerantID_quantity'];

            // Loop through the refrigerants and quantities
            foreach ($refrigerants as $key => $refrigerant) {
                $quantity = $quantities[$key];

                // Create and associate the refrigerant record with the equipment
                $equipmentRefrigerant = new tbl_equiptype();
                $equipmentRefrigerant->EquipmentID_Fkey = $equipmentID;
                $equipmentRefrigerant->ContractID_Fkey = $UcontractID;
                $equipmentRefrigerant->refrigeranttypes_Fkey = $refrigerant;
                $equipmentRefrigerant->refri_quantity = $quantity;
                $equipmentRefrigerant->save();
            }
        }

        if (isset($validatedData['BatteryID'])) {
            $batteries = $validatedData['BatteryID'];
            $quantities = $validatedData['BatteryID_quantity'];

            // Loop through the batteries and quantities
            foreach ($batteries as $key => $battery) {
                $quantity = $quantities[$key];

                // Create and associate the battery record with the equipment
                $equipmentBattery = new tbl_equiptype();
                $equipmentBattery->EquipmentID_Fkey = $equipmentID;
                $equipmentBattery->ContractID_Fkey = $UcontractID;
                $equipmentBattery->battery_FKey = $battery;
                $equipmentBattery->battery_quantity = $quantity;
                $equipmentBattery->save();
            }
        }



        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        tblequipment::where('equipmentID', $equipmentID)
            ->leftjoin('tbl_buildings', 'tbl_buildings.BuildingID', '=', 'tbl_equipment.BuildingID_Fkey')
            ->leftjoin('tbl_manufacturers', 'tbl_manufacturers.manufacturerID', '=', 'tbl_equipment.manufacturerID_Fkey')
            ->leftjoin('tbl_filter', 'tbl_filter.FilterTypeID', '=', 'tbl_equipment.FilterID_Fkey')
            ->leftjoin('tbl_notes', 'tbl_notes.noteID', '=', 'tbl_equipment.noteID_Fkey')
            ->leftjoin('tbl_refrigeranttypes', 'tbl_refrigeranttypes.RefrigerantTypeID', '=', 'tbl_equipment.refrigerantID_Fkey')
            ->update([
                'UnitID' => $request->input('UnitID'),
                'Model' => $request->input('Model'),
                'Serial' => $request->input('Serial'),
                'EquipType' => $request->input('EquipType'),
                'InServiceStart' => $request->input('InServiceStart'),
                'InServiceEnd' => $request->input('InServiceEnd'),
                'LocationRoom' => $request->input('LocationRoom'),
                'tbl_equipment.RecordDate' => $request->input('RecordDate'),
                'EquipmentValue' => $request->input('EquipmentValue'),
                'JobNumber' => $request->input('JobNumber'),
                'ManufacturerID_Fkey' => $request->input('ManufacturerID_Fkey'),
                'refrigerantID_Fkey' => $request->input('refrigerantID_Fkey'),
                'filterID_Fkey' => $request->input('filterID_Fkey'),
                'tbl_equipment.BuildingID_Fkey' => $request->input('BuildingID_Fkey'),
                'tbl_equipment.NoteID_Fkey' => $request->input('NoteID_Fkey'),
                'batteryID_Fkey' => $request->input('batteryID_Fkey')


            ]);

        return back()->with('status', 'Contract data Updated Successfully');
    }

    //employee list
    public function employeelist()
    {
        $users = DB::table('users')
            ->get();
        return view('employeelist', ['users' => $users]);
    }
    public function updateemployee(Request $request, $id)
    {

        User::where('id', $id)
            ->update([
                'user_type' => $request->input('user_type'),
            ]);

        return redirect("employeelist")->with('success', 'employee Role changed');
    }
    public function deleteemployee($id)
    {

        User::where('id', $id)->delete();


        return redirect("employeelist")->with('success', 'Employee successfully deleted');
    }
    public function deleteequipment($id)
    {

        tbl_equiptype::where('EquipmentID_Fkey', $id)->delete();

        tblequipment::where('EquipmentID', $id)->delete();


        return back()->with('success', ' successfully deleted');
    }
    public function deleteFilter(Request $request)
    {
        $filterId = $request->input('filterId');
        $filter = tbl_equiptype::findOrFail($filterId);
        $filter->delete();

        return redirect()->back()->with('success', 'Filter deleted successfully');
    }
    public function deletecontract($id)
    {
        tblequipment::where('contractID_FKey', $id)->delete();
        notes::where('ContractID_Fkey', $id)->delete();
        tbl_equiptype::where('ContractID_Fkey', $id)->delete();
        tblcontracts::where('ContractID', $id)->delete();

        return back()->with('success', 'Employee successfully deleted');
    }
    public function deletemulticontract($id)
    {

        $getid = tblcontracts::where('ContractID', $id)->first();
        $getSMP = $getid->SMPNum;




        /*tblcontracts::where('tbl_contracts.OldRecordNum', $getSMP)
            ->join('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->join('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->join('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->Join('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->delete();
        */

        //related table 
        tblequipment::where('contractID_FKey', $id)->delete();

        notes::where('ContractID_Fkey', $id)->delete();

        tbl_equiptype::where('ContractID_Fkey', $id)->delete();
        //tbl_building::where('ContractID_Fkey', $id)->delete();



        // contract table 
        tblcontracts::where('ContractID', $id)->delete();
        //tblcontracts::where('OldRecordNum', $getSMP)->delete();

        return back()->with('success', 'Employee successfully deleted');
    }

    public function deleteContractnote($contractid)
    {

        notes::where('NoteID', $contractid)->delete();

        return redirect("contractlist")->with('success', 'Employee successfully deleted');
    }



    //Building list
    public function Buildinglist()
    {
        $building = DB::table('tbl_buildings')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_buildings.CustomerID_Fkey')
            ->get();
        return view('Buildinglist', ['tbl_buildings' => $building]);
    }

    public function viewlocation($BuildingID)
    {
        $customer = DB::table('tbl_customers')
            ->get();
        $locations = DB::table('tbl_locations')
            ->get();


        $Building = DB::table('tbl_buildings')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_buildings.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_buildings.CityID_Fkey')
            ->leftjoin('tbl_images', 'tbl_images.ImageID', '=', 'tbl_buildings.ImageID_Fkey')
            ->leftjoin('tbl_notes', 'tbl_notes.noteID', '=', 'tbl_buildings.noteID_Fkey')
            ->select('*')
            ->where('BuildingID', $BuildingID)
            ->get();

        $customer = DB::table('tbl_customers')
            ->get();
        $locations = DB::table('tbl_locations')
            ->get();

        $notes = DB::table('tbl_notes')
            ->where('BuildingID_Fkey', $BuildingID)
            ->get();

        return view('viewlocation', [
            'tbl_customers' => $customer,
            'tbl_locations' => $locations,
            'tbl_buildings' => $Building,
            'tbl_notes' => $notes
        ]);
    }

    public function updatelocation(Request $request, $BuildingID)
    {

        tbl_building::where('BuildingID', $BuildingID)
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_buildings.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_buildings.CityID_Fkey')
            ->leftjoin('tbl_images', 'tbl_images.ImageID', '=', 'tbl_buildings.ImageID_Fkey')
            ->leftjoin('tbl_notes', 'tbl_notes.noteID', '=', 'tbl_buildings.noteID_Fkey')
            ->update([
                'CustomerID_Fkey' => $request->input('CustomerID_Fkey'),
                'BuildingDesc' => $request->input('BuildingDesc'),
                'BuildingAddress' => $request->input('BuildingAddress'),
                'tbl_buildings.CityID_Fkey' => $request->input('CityID_Fkey'),
                'BuildingPostal' => $request->input('BuildingPostal'),
                'tbl_buildings.ImageID_Fkey' => $request->input('ImageID_Fkey'),
                'tbl_buildings.RecordDate' => $request->input('RecordDate'),
            ]);

        return redirect("Buildinglist")->with('status', 'data Updated Successfully');
    }

    public function createBuilding()
    {
        $building = DB::table('tbl_buildings')
            ->get();
        $customer = DB::table('tbl_customers')
            ->get();
        $tbl_locations = DB::table('tbl_locations')
            ->get();

        return view('CreateBuilding', [
            'tbl_customers' => $customer,
            'tbl_buildings' => $building,
            'tbl_locations' => $tbl_locations
        ]);
    }
    public function insertbuilding(Request $request)
    {

        $CustomerID_Fkey = $request->input('CustomerID_Fkey');
        $BuildingDesc = $request->input('BuildingDesc');
        $BuildingAddress = $request->input('BuildingAddress');
        $CityID_Fkey = $request->input('CityID_Fkey');
        $BuildingPostal = $request->input('BuildingPostal');
        $ImageID_Fkey = $request->input('ImageID_Fkey');
        $RecordDate = $request->input('RecordDate');

        $building = array(
            'CustomerID_Fkey' => $CustomerID_Fkey,
            'BuildingDesc' => $BuildingDesc,
            'BuildingAddress' => $BuildingAddress,
            'CityID_Fkey' => $CityID_Fkey,
            'BuildingPostal' => $BuildingPostal,
            'RecordDate' => $RecordDate,
        );

        DB::table('tbl_buildings')->insert($building);

        return redirect("Buildinglist")->with('status', 'data Updated Successfully');
    }
    public function maintenance()
    {
        $tbl_battery = DB::table('tbl_battery')
            ->get();
        $tbl_Refrigeranttypes = DB::table('tbl_refrigeranttypes')
            ->get();
        $tbl_filter = DB::table('tbl_filter')
            ->get();
        $tbl_manufacturers = DB::table('tbl_manufacturers')
            ->get();
        $tbl_locations = DB::table('tbl_locations')
            ->get();
        $tbl_price = DB::table('tbl_price')
            ->get();


        return view('maintenance', [
            'tbl_battery' => $tbl_battery, 'tbl_refrigeranttypes' => $tbl_Refrigeranttypes, 'tbl_filter' => $tbl_filter,
            'tbl_manufacturers' => $tbl_manufacturers, 'tbl_locations' => $tbl_locations, 'tbl_price' => $tbl_price,
        ]);
    }

    public function insert(Request $request)
    {

        $BatteryTypeCode = $request->input('BatteryTypeCode');
        $BatteryType = $request->input('BatteryType');
        $BatteryQty = $request->input('BatteryQty');
        $data = array('BatteryTypeCode' => $BatteryTypeCode, 'BatteryType' => $BatteryType, 'BatteryQty' => $BatteryQty);
        DB::table('tbl_battery')->insert($data);

        $RefrigerantModel = $request->input('RefrigerationModel');
        $RefrigerationSerial = $request->input('RefrigerationSerial');

        $data2 = array('RefrigerationModel' => $RefrigerantModel, 'RefrigerationSerial' => $RefrigerationSerial);
        DB::table('tbl_refrigeranttypes')->insert($data2);

        return redirect("maintenance")->with('status', 'Contract data Updated Successfully');
    }
    public function insert2(Request $request)
    {

        $RefrigerantModel = $request->input('RefrigerationModel');
        $RefrigerationSerial = $request->input('RefrigerationSerial');

        $data2 = array('RefrigerationModel' => $RefrigerantModel, 'RefrigerationSerial' => $RefrigerationSerial);
        DB::table('tbl_refrigeranttypes')->insert($data2);

        return redirect("maintenance")->with('status', 'Contract data Updated Successfully');
    }
    public function insertfilter(Request $request)
    {

        $FilterType = $request->input('FilterType');
        $EquipmentFilter = $request->input('EquipmentFilter');
        $FilterQty = $request->input('FilterQty');

        $data2 = array('FilterType' => $FilterType, 'EquipmentFilter' => $EquipmentFilter, 'FilterQty' => $FilterQty);
        DB::table('tbl_filter')->insert($data2);

        return redirect("maintenance")->with('status', 'Contract data Updated Successfully');
    }
    public function insertmanufacturers(Request $request)
    {

        $ManufacturerName = $request->input('ManufacturerName');
        $NoteID_Fkey = $request->input('NoteID_Fkey');

        $data2 = array('ManufacturerName' => $ManufacturerName, 'NoteID_Fkey' => $NoteID_Fkey);
        DB::table('tbl_manufacturers')->insert($data2);

        return redirect("maintenance")->with('status', 'Contract data Updated Successfully');
    }
    public function insertlocation(Request $request)
    {

        $City = $request->input('City');
        $ProvinceName = $request->input('ProvinceName');
        $CountryName = $request->input('CountryName');


        $data2 = array('City' => $City, 'ProvinceName' => $ProvinceName, 'CountryName' => $CountryName);
        DB::table('tbl_locations')->insert($data2);

        return redirect("maintenance")->with('status', 'Contract data Updated Successfully');
    }

    public function insertcontractequipment(Request $request, $ContractID)
    {

        $BuildingID_Fkey = $request->input('BuildingID_Fkey');
        $EquipmentID_Fkey = $request->input('EquipmentID_Fkey');


        $data2 = array('ContractID_Fkey' => $ContractID, 'BuildingID_Fkey' => $BuildingID_Fkey, 'EquipmentID_Fkey' => $EquipmentID_Fkey);
        DB::table('tbl_contractequipment')->insert($data2);

        return back()->with('status', 'Contract data Updated Successfully');
    }
    public function insertnotes(Request $request, $ContractID)
    {
        $Notes = $request->input('Notes');

        $data = array('ContractID_Fkey' => $ContractID, 'Notes' => $Notes);


        DB::table('tbl_notes')->insert($data);

        return back()->with('status', 'Contract data Updated Successfully');
    }
    public function insertnotesequipment(Request $request, $EquipmentID)
    {
        $Notes = $request->input('Notes');

        $data = array('EquipmentID_Fkey' => $EquipmentID, 'Notes' => $Notes);


        DB::table('tbl_notes')->insert($data);

        return back()->with('status', 'Contract data Updated Successfully');
    }
    public function insertnotesbuilding(Request $request, $BuildingID)
    {
        $Notes = $request->input('Notes');

        $data = array('BuildingID_Fkey' => $BuildingID, 'Notes' => $Notes);

        DB::table('tbl_notes')->insert($data);

        return back()->with('status', 'Contract data Updated Successfully');
    }

    public function CreateContract()
    {

        $tbl_contract = DB::table('tbl_contracts')
            ->get();

        $location = DB::table('tbl_locations')
            ->get();
        $building = DB::table('tbl_buildings')
            ->get();
        $customer = DB::table('tbl_customers')
            ->get();
        $equipment1 = DB::table('tbl_equipment')
            ->get();
        $contractequipment = DB::table('tbl_contractequipment')
            ->get();

        return view('CreateContract', [
            'tbl_equipment' => $equipment1,
            'tbl_customers' => $customer,
            'tbl_locations' => $location,
            'tbl_buildings' => $building,
            'tbl_contracts' => $tbl_contract,
            'tbl_contractequipment' => $contractequipment
        ]);
    }



    public function insertcontract(Request $request)
    {




        $percent = DB::table('tbl_price')
            ->select('*')
            ->where('priceid', '=', 1)
            ->get();
        $nextcustomer = DB::table('tbl_customers')
            ->count('CustomerID');
        $nextbuilding = DB::table('tbl_buildings')
            ->count('BuildingID');

        $CustomerID_Fkey = $nextcustomer + 1;
        $BuildingID_Fkey = $nextbuilding + 1;


        // Customer Table 
        $FirstName = $request->input('FirstName');
        $LastName = $request->input('LastName');
        $CompanyName = $request->input('CompanyName');

        $city = $request->input('CityID_Fkey');


        $customerdata = array(
            'FirstName' => $FirstName,
            'LastName' => $LastName,
            'CityID_Fkey' => $city,
            'CompanyName' => $CompanyName,

        );
        DB::table('tbl_customers')->insert($customerdata);

        // Building Table
        $buildingaddress = $request->input('address');
        $buildingdesc = $request->input('BuildingDesc');
        $buildingPostal = $request->input('BuildingPostal');
        $buildingdata = array(
            'CustomerID_Fkey' => $CustomerID_Fkey,
            'BuildingAddress' => $buildingaddress,
            'BuildingPostal' => $buildingPostal,
            'CityID_Fkey' => $city,
            'BuildingDesc' => $buildingdesc,
        );


        DB::table('tbl_buildings')->insert($buildingdata);


        // Contract Table 

        $SMPNum = SMPNumberService::generateSMPNumber();
        $OldRecord = 0;
        $SMPQuote = $request->input('SMPQuote') == true ? '1' : '0';
        $SMPActive = $request->input('SMPActive') == true ? '1' : '0';
        $SMPReceived = $request->input('SMPReceived') == true ? '1' : '0';
        $NumInstallments = $request->input('NumInstallments');
        $TermLength = $request->input('Term');
        $ContractStartDate = $request->input('ContractStartDate');
        $ContractEndDate = $request->input('ContractEndDate');
        $RenewalDate = $request->input('RenewalDate');
        $contractType = $request->input('contractType');
        $Yr1Price = $request->input('FirstYear');

        foreach ($percent as $percent1) {
            $Yr2Price = ceil(($Yr1Price *  (1 - ($percent1->Discounts / 100))) / 5) * 5;
            $Renewal1_2 = ceil(($Yr2Price * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
            $Renewal3_4 = ceil(($Renewal1_2 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
            $Renewal5_6 = ceil(($Renewal3_4 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
        }



        $ActivePrice = $request->input('ActivePrice');
        $BillJan = $request->input('BillJan') == true ? '1' : '0';
        $BillFeb = $request->input('BillFeb') == true ? '1' : '0';
        $BillMar = $request->input('BillMar') == true ? '1' : '0';
        $BillApr = $request->input('BillApr') == true ? '1' : '0';
        $BillMay = $request->input('BillMay') == true ? '1' : '0';
        $BillJun = $request->input('BillJun') == true ? '1' : '0';
        $BillJul = $request->input('BillJul') == true ? '1' : '0';
        $BillAug = $request->input('BillAug') == true ? '1' : '0';
        $BillSep = $request->input('BillSep') == true ? '1' : '0';
        $BillOct = $request->input('BillOct') == true ? '1' : '0';
        $BillNov = $request->input('BillNov') == true ? '1' : '0';
        $BillDec = $request->input('BillDec') == true ? '1' : '0';
        $ModifiedDate = $request->input('ModifiedDate');
        $AgreedTo = $request->input('AgreedTo');



        $contractdata = array(
            'CustomerID_Fkey' => $CustomerID_Fkey,
            'BuildingID_Fkey' => $BuildingID_Fkey,
            'SMPNum' => $SMPNum,
            'OldRecordNum' => $OldRecord,
            'SMPQuote' => $SMPQuote,
            'SMPActive' => $SMPActive,
            'SMPReceived' => $SMPReceived,
            'NumInstallments' => $NumInstallments,
            'ContractStartDate' => $ContractStartDate,
            'ContractEndDate' => $ContractEndDate,
            'RenewalDate' => $RenewalDate,
            'TermLength' => $TermLength,
            'Yr1Price' => $Yr1Price,
            'Yr2Price' => $Yr2Price,
            'Renewal1_2' => $Renewal1_2,
            'Renewal3_4' => $Renewal3_4,
            'Renewal5_6' => $Renewal5_6,
            'contractType' => $contractType,
            'ActivePrice' => $ActivePrice,
            'BillJan' => $BillJan,
            'BillFeb' => $BillFeb,
            'BillMar' => $BillMar,
            'BillApr' => $BillApr,
            'BillMay' => $BillMay,
            'BillJun' => $BillJun,
            'BillJul' => $BillJul,
            'BillAug' => $BillAug,
            'BillSep' => $BillSep,
            'BillOct' => $BillOct,
            'BillNov' => $BillNov,
            'BillDec' => $BillDec,
            'ModifiedDate' => $ModifiedDate,
            'AgreedTo' => $AgreedTo
        );
        DB::table('tbl_contracts')->insert($contractdata);



        return redirect("contractlist")->with('status', 'Contract data Create Successfully');
    }
    public function createcontract2($contractID)
    {

        $contractTable = DB::table('tbl_contracts')
            ->leftjoin('tbl_buildings', 'tbl_contracts.BuildingID_Fkey', '=', 'tbl_buildings.BuildingID')
            ->leftjoin('tbl_customers', 'tbl_customers.CustomerID', '=', 'tbl_contracts.CustomerID_Fkey')
            ->leftjoin('tbl_locations', 'tbl_locations.CityID', '=', 'tbl_customers.CityID_Fkey')
            ->leftJoin('tbl_notes', 'tbl_notes.noteID', 'tbl_contracts.noteID_Fkey')
            ->select('*')
            ->where('tbl_contracts.ContractID', $contractID)
            ->get();

        $location = DB::table('tbl_locations')
            ->get();
        $building = DB::table('tbl_buildings')
            ->get();
        $customer = DB::table('tbl_customers')
            ->get();
        $equipment1 = DB::table('tbl_equipment')
            ->get();


        return view('createcontract2', [
            'tbl_equipment' => $equipment1,
            'tbl_customers' => $customer,
            'tbl_locations' => $location,
            'tbl_buildings' => $building,
            'tbl_contracts' => $contractTable,
        ]);
    }


    public function insertcontract2(Request $request, $contractID)
    {

        $percent = DB::table('tbl_price')
            ->select('*')
            ->where('priceid', '=', 1)
            ->get();
        $nextcustomer = DB::table('tbl_customers')
            ->count('CustomerID');
        $nextbuilding = DB::table('tbl_buildings')
            ->count('BuildingID');

        $CustomerID_Fkey = $nextcustomer + 1;
        $BuildingID_Fkey = $nextbuilding + 1;


        // Customer Table 
        $FirstName = $request->input('FirstName');
        $LastName = $request->input('LastName');
        $CompanyName = $request->input('CompanyName');

        $city = $request->input('CityID_Fkey');


        $customerdata = array(
            'FirstName' => $FirstName,
            'LastName' => $LastName,
            'CityID_Fkey' => $city,
            'CompanyName' => $CompanyName,

        );
        DB::table('tbl_customers')->insert($customerdata);

        // Building Table
        $buildingaddress = $request->input('address');
        $buildingdesc = $request->input('BuildingDesc');
        $buildingPostal = $request->input('BuildingPostal');
        $buildingdata = array(
            'CustomerID_Fkey' => $CustomerID_Fkey,
            'BuildingAddress' => $buildingaddress,
            'BuildingPostal' => $buildingPostal,
            'CityID_Fkey' => $city,
            'BuildingDesc' => $buildingdesc,
        );


        DB::table('tbl_buildings')->insert($buildingdata);




        // Contract Table 
        // use sql count to determine how many duplicates 


        $oldSMP = tblcontracts::where('ContractID', '=', $contractID)->first();
        $Record = $oldSMP->SMPNum;
        $Record2 = $oldSMP->OldRecordNum;
        $DuplicateContract = tblcontracts::where('OldRecordNum', '=', $Record)
            ->count('OldRecordNum');

        if ($Record2 == 0) {
            $NewSMP = $Record . '-' .  $DuplicateContract + 1;
            $ReportOldSMP = $oldSMP->SMPNum;
        } else {
            $NewSMP = $Record2 . '-' .  $DuplicateContract + 1;
            $ReportOldSMP = $oldSMP->OldRecordNum;
        }

        $SMPQuote = $request->input('SMPQuote') == true ? '1' : '0';
        $SMPActive = $request->input('SMPActive') == true ? '1' : '0';
        $SMPReceived = $request->input('SMPReceived') == true ? '1' : '0';
        $NumInstallments = $request->input('NumInstallments');
        $TermLength = $request->input('Term');
        $ContractStartDate = $request->input('ContractStartDate');
        $ContractEndDate = $request->input('ContractEndDate');
        $RenewalDate = $request->input('RenewalDate');
        $contractType = $request->input('contractType');
        $Yr1Price = $request->input('FirstYear');

        foreach ($percent as $percent1) {
            $Yr2Price = ceil(($Yr1Price *  (1 - ($percent1->Discounts / 100))) / 5) * 5;
            $Renewal1_2 = ceil(($Yr2Price * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
            $Renewal3_4 = ceil(($Renewal1_2 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
            $Renewal5_6 = ceil(($Renewal3_4 * (1 + ($percent1->IncrementPercent / 100))) / 5) * 5;
        }



        $ActivePrice = $request->input('ActivePrice');
        $BillJan = $request->input('BillJan') == true ? '1' : '0';
        $BillFeb = $request->input('BillFeb') == true ? '1' : '0';
        $BillMar = $request->input('BillMar') == true ? '1' : '0';
        $BillApr = $request->input('BillApr') == true ? '1' : '0';
        $BillMay = $request->input('BillMay') == true ? '1' : '0';
        $BillJun = $request->input('BillJun') == true ? '1' : '0';
        $BillJul = $request->input('BillJul') == true ? '1' : '0';
        $BillAug = $request->input('BillAug') == true ? '1' : '0';
        $BillSep = $request->input('BillSep') == true ? '1' : '0';
        $BillOct = $request->input('BillOct') == true ? '1' : '0';
        $BillNov = $request->input('BillNov') == true ? '1' : '0';
        $BillDec = $request->input('BillDec') == true ? '1' : '0';
        $ModifiedDate = $request->input('ModifiedDate');
        $AgreedTo = $request->input('AgreedTo');



        $contractdata = array(
            'CustomerID_Fkey' => $CustomerID_Fkey,
            'BuildingID_Fkey' => $BuildingID_Fkey,
            'OldRecordNum' => $ReportOldSMP,
            'SMPNum' => $NewSMP,
            'SMPQuote' => $SMPQuote,
            'SMPActive' => $SMPActive,
            'SMPReceived' => $SMPReceived,
            'NumInstallments' => $NumInstallments,
            'ContractStartDate' => $ContractStartDate,
            'ContractEndDate' => $ContractEndDate,
            'RenewalDate' => $RenewalDate,
            'TermLength' => $TermLength,
            'Yr1Price' => $Yr1Price,
            'Yr2Price' => $Yr2Price,
            'Renewal1_2' => $Renewal1_2,
            'Renewal3_4' => $Renewal3_4,
            'Renewal5_6' => $Renewal5_6,
            'contractType' => $contractType,
            'ActivePrice' => $ActivePrice,
            'BillJan' => $BillJan,
            'BillFeb' => $BillFeb,
            'BillMar' => $BillMar,
            'BillApr' => $BillApr,
            'BillMay' => $BillMay,
            'BillJun' => $BillJun,
            'BillJul' => $BillJul,
            'BillAug' => $BillAug,
            'BillSep' => $BillSep,
            'BillOct' => $BillOct,
            'BillNov' => $BillNov,
            'BillDec' => $BillDec,
            'ModifiedDate' => $ModifiedDate,
            'AgreedTo' => $AgreedTo
        );
        DB::table('tbl_contracts')->insert($contractdata);



        return redirect("contractlist")->with('status', 'Contract data Create Successfully');
    }

    public function CreateEquipment()
    {

        $location = DB::table('tbl_locations')
            ->get();
        $refrigerant = DB::table('tbl_refrigeranttypes')
            ->get();
        $building = DB::table('tbl_buildings')
            ->get();
        $tbl_manufacturers = DB::table('tbl_manufacturers')
            ->get();
        $Filter = DB::table('tbl_filter')
            ->get();
        $battery = DB::table('tbl_battery')
            ->get();
        $belt = DB::table('tbl_belt')
            ->get();

        function getBeltTypes()
        {
            $beltTypes = DB::table('tbl_belt')
                ->select('BeltID', 'BeltType')
                ->get();

            return response()->json($beltTypes);
        }

        return view('CreateEquipment', [
            'tbl_manufacturers' => $tbl_manufacturers,
            'tbl_filter' => $Filter,
            'tbl_locations' => $location,
            'tbl_buildings' => $building,
            'tbl_battery' => $battery,
            'tbl_refrigeranttypes' => $refrigerant,
            'tbl_belt' => $belt,
        ]);
    }
    public function getBeltTypes()
    {
        $beltTypes = DB::table('tbl_belt')
            ->select('BeltID', 'BeltType')
            ->get();

        return response()->json($beltTypes);
    }
    public function insertequipment(Request $request, $contractID)
    {
        $nextequip =  DB::table('tbl_equipment')
            ->select('equipmentID')
            ->orderByDesc('equipmentID')
            ->first();
        $equipment = $nextequip->equipmentID;

        $building = tblcontracts::where('ContractID', $contractID)
            ->select('BuildingID_Fkey')
            ->first();



        $buildingID = $building->BuildingID_Fkey;
        $EquipType = $request->input('EquipType');
        $UnitID = $request->input('UnitID');
        $ManufacturerID_Fkey = $request->input('ManufacturerID_Fkey');
        $Model = $request->input('Model');
        $Serial = $request->input('Serial');
        $LocationRoom = $request->input('LocationRoom');
        $InServiceStart = $request->input('InServiceStart');
        $InServiceEnd = $request->input('InServiceEnd');
        $RecordDate = $request->input('RecordDate');
        $EquipmentValue = $request->input('EquipmentValue');
        $JobNumber = $request->input('JobNumber');
        $FilterID_Fkey = $request->input('FilterID_Fkey');
        $refrigerantID_Fkey = $request->input('refrigerantID_Fkey');
        $btteryID_Fkey = $request->input('batteryID_Fkey');


        $validatedData = $request->validate([
            'BeltID' => 'array',
            'BeltID.*' => 'nullable', // Adjust the validation rule as needed
            'BeltID_quantity' => 'array',
            'BeltID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'filterID' => 'array',
            'filterID.*' => 'nullable', // Adjust the validation rule as needed
            'filterID_quantity' => 'array',
            'filterID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'RefrigerantID' => 'array',
            'RefrigerantID.*' => 'nullable', // Adjust the validation rule as needed
            'RefrigerantID_quantity' => 'array',
            'RefrigerantID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
            'BatteryID' => 'array',
            'BatteryID.*' => 'nullable', // Adjust the validation rule as needed
            'BatteryID_quantity' => 'array',
            'BatteryID_quantity.*' => 'nullable|integer|min:0|max:10', // Adjust the validation rule as needed
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        if (isset($validatedData['filterID'])) {
            $filters = $validatedData['filterID'];
            $quantities = $validatedData['filterID_quantity'];

            // Perform the necessary actions with the filter data
            // For example, you can loop through the filters and quantities
            foreach ($filters as $key => $filter) {
                $quantity = $quantities[$key];

                // Create and associate the filter record with the equipment
                $equipmentFilter = new tbl_equiptype();
                $equipmentFilter->EquipmentID_Fkey = $equipment + 1;
                $equipmentFilter->ContractID_Fkey = $contractID;
                $equipmentFilter->filterID_Fkey = $filter;
                $equipmentFilter->filter_quantity = $quantity;
                $equipmentFilter->save();
            }
        }

        if (isset($validatedData['BeltID'])) {
            $belts = $validatedData['BeltID'];
            $beltQuantities = $validatedData['BeltID_quantity'];

            // Perform the necessary actions with the belt data
            // For example, you can loop through the belts and quantities
            foreach ($belts as $key => $belt) {
                $quantity = $beltQuantities[$key];

                // Create and associate the belt record with the equipment
                $equipmentBelt = new tbl_equiptype();
                $equipmentBelt->EquipmentID_Fkey = $equipment + 1;
                $equipmentBelt->ContractID_Fkey = $contractID;
                $equipmentBelt->beltID_Fkey = $belt;
                $equipmentBelt->belt_quantity = $quantity;
                $equipmentBelt->save();
            }
        }

        if (isset($validatedData['RefrigerantID'])) {
            $refrigerants = $validatedData['RefrigerantID'];
            $quantities = $validatedData['RefrigerantID_quantity'];

            // Loop through the refrigerants and quantities
            foreach ($refrigerants as $key => $refrigerant) {
                $quantity = $quantities[$key];

                // Create and associate the refrigerant record with the equipment
                $equipmentRefrigerant = new tbl_equiptype();
                $equipmentRefrigerant->EquipmentID_Fkey = $equipment + 1;
                $equipmentRefrigerant->ContractID_Fkey = $contractID;
                $equipmentRefrigerant->refrigeranttypes_Fkey = $refrigerant;
                $equipmentRefrigerant->refri_quantity = $quantity;
                $equipmentRefrigerant->save();
            }
        }

        if (isset($validatedData['BatteryID'])) {
            $batteries = $validatedData['BatteryID'];
            $quantities = $validatedData['BatteryID_quantity'];

            // Loop through the batteries and quantities
            foreach ($batteries as $key => $battery) {
                $quantity = $quantities[$key];

                // Create and associate the battery record with the equipment
                $equipmentBattery = new tbl_equiptype();
                $equipmentBattery->EquipmentID_Fkey = $equipment + 1;
                $equipmentBattery->ContractID_Fkey = $contractID;
                $equipmentBattery->battery_FKey = $battery;
                $equipmentBattery->battery_quantity = $quantity;
                $equipmentBattery->save();
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');


        $equipment = array(
            'contractid_FKey' => $contractID,
            'BuildingID_Fkey' => $buildingID,
            'UnitID' => $UnitID,
            'ManufacturerID_Fkey' => $ManufacturerID_Fkey,
            'Model' => $Model,
            'Serial' => $Serial,
            'LocationRoom' => $LocationRoom,
            'InServiceStart' => $InServiceStart,
            'InServiceEnd' => $InServiceEnd,
            'RecordDate' => $RecordDate,
            'EquipmentValue' => $EquipmentValue,
            'JobNumber' => $JobNumber,
            'FilterID_Fkey' => $FilterID_Fkey,
            'refrigerantID_Fkey' => $refrigerantID_Fkey,
            'batteryID_Fkey' => $btteryID_Fkey,
            'EquipType' => $EquipType,
        );
        DB::table('tbl_equipment')->insert($equipment);

        //DB::table('tbl_contractequipment')->insert($contractEquipment);



        return back()->with('status', 'Contract data Create Successfully');
    }

    public function Accountsetting()
    {
        $userid = auth()->user()->id;
        $account = DB::table('users')
            ->select('*')
            ->where('id', $userid)
            ->get();

        return view('Accountsettings', [
            'users' => $account,

        ]);
    }
    public function updateAccount(Request $request)
    {
        $userid = auth()->user()->id;
        User::where('id', $userid)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'phone_number' => $request->input('phone_number'),
            ]);
        return redirect('/Accountsetting');
    }

    public function updateprice(Request $request)
    {

        tbl_price::where('priceid', 1)

            ->update([
                'IncrementPercent' => $request->input('IncrementPercent'),
                'Discounts' => $request->input('Discounts'),
            ]);

        return redirect('/maintenance');
    }

    public function insertconImg(Request $request, $ContractID)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $imageName);


        $save = new tbl_image();
        $save->ImagePath = $imageName;
        $save->contractImg = $ContractID;
        $save->save();

        return back()
            ->with('success', 'You have successfully uploaded image.')
            ->with('image', $imageName);
    }
    public function insertfiltertype(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'filterID' => 'required|array',
            'filterID.*' => 'required', // Each element of the array must be present
            'filterID_quantity' => 'required|array',
            'filterID_quantity.*' => 'required|numeric|min:0|max:10',
        ]);

        // Retrieve the filterID and filterID_quantity arrays from the request
        $filterIDs = $request->input('filterID');
        $quantities = $request->input('filterID_quantity');

        // Loop through each filterID and quantity pair
        foreach ($filterIDs as $index => $filterID) {
            $quantity = $quantities[$index];

            // Create a new ContractEquipment model instance
            $contractEquipment = new tbl_equiptype();
            $contractEquipment->filterID = $filterID;
            $contractEquipment->quantity = $quantity;

            // Save the new contract equipment record to the database
            $contractEquipment->save();
        }

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Filter(s) added successfully!');
    }
    // change password for account setting page 
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
