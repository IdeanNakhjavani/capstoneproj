<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCHEDULED MAINTENANCE PROGRAM</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

</head>

<body>
    <h5 style="text-align: center;"><b>SCHEDULED MAINTENANCE PROGRAM</b></h5>
    @foreach ($tbl_contracts as $tbl_contracts)
        <p style="font-size: 16px;"><b>THIS AGREEMENT</b> made in triplicate this day of: </p>

        <p>Between:
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            and: <span style="font-size: 17px;"><b><u>______________________</u></b></span></p>
        <img width="250" height="auto" src="../public/images/logo.jpg"  />
        <p><b><span style="font-size: 16px;">Div. of: Interior Technical Services Ltd.</span>
            

            
            <br>
            
            <span style="font-size: 19px;">
            3573 Lansbury Way
            <br>
            West Kelowna, B.C.
            <br>
            V4T 1CS
            <br>
            250-870-9148
            <br></span></b><span style="font-size: 16px;">
            <a>interiorenergyandair.ca</a><br>
            <a>info@interiorenergyandair.ca</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;
                Building reference: </span><span style="font-size: 17px;"><b><u>{{ $tbl_contracts->BuildingAddress }}</u></b></span>
                
                    <img src="{{ public_path('images/' .$tbl_images->ImagePath) }}" height="100px" width="100px" />
                
            
                <br>
            (Hereafter referred to as the "Contractor")
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;
            (Hereafter referred to as the Customer)
        </p>
        <p style="font-size: 16px;">
            In consideration of the mutual agreements hereafter the customer and contractor agree to as follows:
            <br>
        
        <ol type="1">
            <li>During the term of this Agreement the contractor shall perform the services set out in Schedule "A" on those items of equipment described in Schedule "B" or any equipment installed in place thereof (hereinafter referred to as the "equipment"). The services shall be performed regularly at the intervals set out in Schedules "A B" and shall be carried out between the hours of 8:00 a.m. -4:00 p.m. Monday through Friday. All parts are extra to the agreement. The contractor shall at the customer's request in an emergency perform services outside of these hours and will be entitled to make an extra charge for the services based on its regular rates in effect.</li>
            <li>The Contractor will supply and provide the necessary materials for lubrication and clean up and may charge an additional amount for these items (MPC) as well as a Truck Service Charge (TSC).</li>
            <li>Immediately following each visit the Contractor shall provide the Customer with a verbal report of the equipment and any repairs deemed necessary or advisable and may obtain a Purchase Order for the recommended changes.</li>
            <li>The Contractor, at its expense, shall have all of its personnel, who perform the services, covered under the provisions of the Workman's Compensation Act or similar legislation and shall maintain adequate public liability and property damage insurance which shall protect the Customer against all claims for <p style="font-size: 17px; text-align: center;"></p>all damages or injury including death to any person or persons and for damage to any property of the Customer or any other public and private property resulting from performance of the services pursuant to this Agreement.</li>
            <li>The Contractor shall provide proper identification to its personnel who will be working in the Customer's premises.</li>
            <li>The Contractor shall in no way be responsible for any failure to perform any of the services set out herein caused by any act or neglect of the Customer or employees of the Customer or caused by strikes, lockouts, fire, unavoidable casualties or by any other cause of any kind whatsoever beyond the reasonable control of the Contractor.</li>
            <li>The term of this Agreement shall be for one or two years and shall commence on the first of
                <span style="font-size: 17px;"><b><u>{{ Carbon\Carbon::parse($tbl_contracts->ContractStartDate)->format('m-d-Y') }}</u></b></span>, and end on the last day of <span style="font-size: 17px;"><b><u>{{ Carbon\Carbon::parse($tbl_contracts->ContractEndDate)->format('m-d-Y') }}</u></b></span></li>
            <li>In consideration of the services performed the customer shall pay to the Contractor an annual charge of
                <span style="font-size: 17px;"><b><u>${{ $tbl_contracts->ActivePrice }}</u></b></span> payable by invoice in advance in equal
                <span style="font-size: 17px;"><b><u>{{ $tbl_contracts->NumInstallments }}</u></b></span> installments. PLUS GST.
                <span style="font-size: 17px;"><b><u>${{ $tbl_contracts->Yr1Price }}/year</u></b></span> for a 1 year service or <span style="font-size: 17px;"><b><u>${{ $tbl_contracts->Yr2Price }}/year</u></b></span> for a 2
                year service. Price good for 120 days form above date.</li>
            <li>The Customer shall operate the equipment in accordance with the manual published by the manufacturer / or
                the
                instructions of the contractor; and the owner shall advise the Contractor of any unusal operation
                conditions.</li>
            <li>Either party may terminate this Agreement at any time without obligation with (30) day's written notice
                to the other party. In the event the Agreement is terminated as aforesaid
                the Contractor shall refund to the Customer a portion of any service charge paid in advance which is
                reasonable under the circumstances.</li>
            <li>No amendment to this Agreement shall be effective unless it is written and executed by both parties.</li>
        </ol>
        @endforeach
        <br><br><br><br><br><br><br><br><br><br>
        <b>IN WITNESS WHEREOF</b> the Customer and the Contractor have executed this Agreement.
        </p>
        <br>

        <p style="font-size: 16px;">Accepted for the Contractor
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;
            Accepted for the Customer</p> 
        <p style="font-size: 16px;">Signature: ______________________
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Signature: ______________________</p> 
        <p style="font-size: 16px;"><b>Matthew ter Keurs, President
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            Name: ______________________
        </p>
        <p style="font-size: 16px;"><b>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Title: Owner</b>            
        </p>
        <b><span style="background-color: #FFFF00; font-size: 11px;">PLEASE FILL IN ITEMS 7 & 8, SIGN THE DOCUMENT AND RETURN THE ORIGINAL PAGES 1 & 2 TO OUR OFFICE. THANK YOU.</span></b>
        
        <p style="page-break-before: always;  text-align: center;  font-size: 17px;"><b>-3-
            <br>
            SCHEDULE "A"</b>
        </p>
    <ol type="1"  style="font-size: 17px;">
        <li>
            <b>CONDENSER - Air cooled</b>
            <br>
            Check clean condenser coil condition.
            <br>
            <b>CONDENSER - Water cooled</b>
            Check adjust all water and regulating valves for operating, scaling and corrosion. Check for condition of tube and shell, scaling and corrosion.
        </li>
        <li>
            <b>COOLING TOWERS AND EVAPORATIVE CONDENSERS</b>
            <br>
            Check float operation, condition of sump, fan and motor bearings; bleed off, nozzles, eliminators, and water strainers for leaks, nonsolubles in the system, general condition. Check water treatment and add if on site. Lubricate as required.
        </li>
        <li>
            <b>COILS - (Heating and cooling)</b>
            <br>
            Check condition of coil - condensate pan and drain. Check clear coil, pan and drain as required.
        </li>
        <li>
            <b>AIR SYSTEM</b>
            <br>
            Clean or replace filters. (As required) Block gaps around filters. Check supply and return registers for restricted airflow. Open as per proper air balance.
        </li>
        <li>
            <b>COMPRESSORS</b>
            <br>
            Check operation, condition, noise, vibration, oil pump operation and oil level, head, suction and oil pressures, and noncondensables in system. Make pump down capacity test. Change and add oil as required.
        </li>
        <li>
            <b>REFRIGERANT CIRCUIT</b>
            <br>
            Check for oil and refrigerant leaks and visual test. Check oil supply and refrigerant charge as per service instructions for equipment; operation of refrigerant controls; insulation, vibration and noise. Add refrigerant to top off charge once leak is found and repaired as well as refrigerant oil level checked.
        </li>
        <li>
            <b>CONTROLS - Cooling</b>
            <br>
            Check operation of: thermostats, relays, pressure switches, starters, contactors, dampers, linkages, damper motors, actuators, all safety controls and limits for proper operation, automatic valves and associated strainer(s), all wiring from disconnect switch to units, including fuses, heaters and relays. Fresh air dampers for maximum 10% fresh air during heating and cooling seasons. Make seasonal adjustments as required.
        </li>
        <li>
            <b>FANS AND FAN DRIVES - (Including all exhaust fans)</b>
            <br>
            Check and adjust the following: fan, motor bearings, motor housing, belt(s) condition and tension, alignment, drives and pulleys. Lubricate as required.
        </li>
        <li>
            <b>GAS BURNERS – (Heating and Pool)</b>
            <br>
            Check and clean as required the following: pilot orifice, main flame, burner, gas valve, and general operation.
        </li>
        <li>
            <b>FURNACES</b>
            <br>
            Check heat exchanger, stack, draft regulator, manifold pressure, pilot operation, fan and motor bearing, belts, pulleys, filter. Lubricate and make adjustments as required.
        </li>
        <p style="page-break-before: always; font-size: 17px; text-align: center;"><b>-4-</b>
        </p>
        <li>
            <b>BOILERS – (Heating and Pool)</b>
            <br>
            Check tubes for corrosion drain and pressurize cushion tank, gauges. Check water treatment-chemical feed pump, solution tank, time clock, by-pass feeder, and chemical stock. Add chemical if on site and in stock.
        </li>
        <li>
            <b>CONTROLS - (Heating)</b>
            <br>
            Check operation of thermostat, all operation safety controls, high/low limits, low water controls, pressure regulating, safety relief and motorized valves, strainers. Fresh air dampers for maximum 10% fresh air during heating and cooling season to be adjusted. Make seasonal adjustment as required.

        </li>
        <li>
            <b>PUMPS – (Heating and Pool)</b>
            <br>
            Check couplings, packing and adjust accordingly. Lubricate as required.
        </li>
      </ol>

      <p style="page-break-before: always; font-size: 17px; text-align: center;"><b>-5-
        <br>
        SCHEDULE "B"</b>
    </p>
    <p style="font-size: 16px;"><b>EQUIPMENT INCLUDED IN THIS AGREEMENT:</b>
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        1 &nbsp;&nbsp;&nbsp;&nbsp; Air Conditioner - air cool
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        1 &nbsp;&nbsp;&nbsp;&nbsp; Furnace
    </p>
    <p style="text-align: center, font-size: 16px;"><b>MONTHLY INSPECTIONS INDICATED BY A "Y" = YES</b></p>


    <table class="table table-sm table-hover table-bordered" style="font-size: 16px;">
        <thead>
            <tr>
                <th colspan="3" scope="colgroup"></th>
                <th colspan="12" scope="colgroup">Work Months</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Equipment</th>
                <th>Model</th>

                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($tbl_contractequipment as $tbl_contractequipment)
                <tr class="table">
                    <td> {{ $tbl_contractequipment->EquipmentID_Fkey }}</td>
                    <td> {{ $tbl_contractequipment->UnitID }} </td>
                    <td> {{ $tbl_contractequipment->Model }} </td>
                    <td>
                        &nbsp;&nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkJan"
                            {{ $tbl_contractequipment->WorkJan == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkFeb"
                            {{ $tbl_contractequipment->WorkFeb == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkMar"
                            {{ $tbl_contractequipment->WorkMar == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkApr"
                            {{ $tbl_contractequipment->WorkApr == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkMay"
                            {{ $tbl_contractequipment->WorkMay == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkJun"
                            {{ $tbl_contractequipment->WorkJun == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkJul"
                            {{ $tbl_contractequipment->WorkJul == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkAug"
                            {{ $tbl_contractequipment->WorkAug == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkSep"
                            {{ $tbl_contractequipment->WorkSep == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkOct"
                            {{ $tbl_contractequipment->WorkOct == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkNov"
                            {{ $tbl_contractequipment->WorkNov == 1 ? 'checked' : '' }}>
                    </td>
                    <td>
                        &nbsp;
                        <input class="form-check-inline" type="checkbox" name="WorkDec"
                            {{ $tbl_contractequipment->WorkDec == 1 ? 'checked' : '' }}>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="font-size: 16px;">
        <b>NOTE:</b>
        <br>
        We will come in during the months indicated above with a "Y", and do the appropriate check up and adjustments as required by the manufacture. We will change belts and filters as per this CONTRACT on an as needed basis. Belts and filters and any additional parts will be invoiced out accordingly. Also any service calls will be invoiced appropriately. If you have any questions please do not hesitate to call, fax or email our office anytime, <i>OFFICE: 250-870-9148</i> or <i>info@interiorenergyandair.ca</i>.
    </p>
</body>

</html>