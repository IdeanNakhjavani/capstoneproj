<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tbl_equiptype;

class ContractEquipmentController extends Controller
{
    //


    public function insertfiltertype(Request $request,$contractId)
    {
        $filterIds = $request->input('filterID');
        $quantities = $request->input('filterID_quantity');
    
        // Ensure the arrays have the same length
        if (count($filterIds) !== count($quantities)) {
            return redirect()->back()->with('error', 'Invalid data submitted.');
        }
    
        // Iterate over the submitted data and store each row in the database
        for ($i = 0; $i < count($filterIds); $i++) {
            $filterId = $filterIds[$i];
            $quantity = $quantities[$i];
    
            // Create a new ContractEquipment instance
            $contractEquipment = new tbl_equiptype();
            $contractEquipment->ContractID_Fkey = $contractId;
            $contractEquipment->filterID_Fkey = $filterId;
            $contractEquipment->Quantity = $quantity;
    
            // Save the ContractEquipment instance to the database
            $contractEquipment->save();
        }
    
        // Optionally, you can perform additional actions or redirect the user
        return redirect()->back()->with('success', 'Data has been stored successfully.');
    }
}
