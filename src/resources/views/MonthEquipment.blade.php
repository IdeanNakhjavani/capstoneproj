<!DOCTYPE html>
<html>

<head>
    <title>Equipment Checklist</title>

    <style type='text/css'>
        @page {
            size: landscape;
        }
    
        @media print {
            body {
                transform: rotate(-90deg);
                transform-origin: left top;
                width: 100vw;
                height: 100vh;
                overflow: auto;
                page-break-after: always;
            }
    
            
        }
    
        thead {
            border-bottom: 3px solid rgb(0, 0, 0);
        }
        th {
            text-align: center;
        }
    
        td {
            text-align: center;
        }
        
        ul.dashed {
            list-style-type: none;
            padding-left: 0;
        }
    </style>
    
</head>

<body>
    <img alt="logo" width="250" height="auto" src="../public/images/logo.jpg" class="egg" />
    <h1 class="title" id="checklist-title" value = "Equipment Check for " + currentMonth></h1>
    <br>
    <span style="font-size: 11px"><b>&nbsp;&nbsp;&nbsp;&nbsp;
        Div. of: Interior Technical Services Ltd.</b>
</span>
    <h1 class="title" style="text-align: center;">Equipment Check for <?php echo date('F'); ?></h1>
    @foreach ($equipcontract as $equipcontract)
        @php
            $totalFilterQuantity = 0;
            $totalBeltQuantity = 0;
        @endphp

        <h3>SMP #: {{ $equipcontract->SMPNum }} &nbsp;&nbsp;&nbsp;</h3>
        <h3>Customer: {{ $equipcontract->getcustomer->FirstName }} {{ $equipcontract->getcustomer->LastName }}
            &nbsp;&nbsp;&nbsp;</h3>
        <table style="width:100%">
            <thead>
                <tr>
                    <th>Building Address:</th>
                    <th>Notes:</th>
                    <th>Unit ID #</th>
                    <th>Location</th>
                    <th>Unit Model #</th>
                    <th>Serial</th>
                    <th>Eq. Notes</th>
                    <th>Component</th>
                    <th>QTY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $equipcontract->getbuilding->BuildingAddress }}
                        {{ $equipcontract->getbuilding->BuildingPostal }}</td>
                    @foreach ($equipcontract->getnotes as $note)
                        <td>{{ $note->Notes }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid black;"></td>
                @foreach ($equipcontract->getequipment as $equipment1)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{$equipment1->UnitID}}</td>
                        <td>{{$equipment1->LocationRoom}}</td>
                        <td>{{$equipment1->Model}}</td>
                        <td>{{$equipment1->Serial}}</td>
                        <td></td>
                        <td style="font-weight:bold;font-size: 12px;">
                            @foreach ($equipment1->getequiptype as $filter)
                                <ul class = "dashed">
                                    @if ($filter->filterID_Fkey)
                                        <li>Filter: {{ $filter->getfilter->FilterType}}</li>
                                    @endif
                                    @if ($filter->beltID_Fkey)
                                        <li>Belt: {{ $filter->getbelt->BeltType }}</li>
                                    @endif
                                    @if ($filter->refrigeranttypes_Fkey)
                                        <li>Refrig: {{ $filter->getrefreg->RefrigerantCode }}</li>
                                    @endif
                                    @if ($filter->battery_FKey)
                                        <li>Battery: {{ $filter->getbattery->BatteryTypeCode }}</li>
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                        <td style="font-weight:bold;font-size: 12px;">
                            @foreach ($equipment1->getequiptype as $filter)
                                <ul>
                                    @if ($filter->filterID_Fkey)
                                        {{ $filter->filter_quantity }}
                                        @php
                                            $totalFilterQuantity += $filter->filter_quantity;
                                        @endphp
                                    @endif
                                    @if ($filter->beltID_Fkey)
                                        {{ $filter->belt_quantity }}
                                        @php
                                            $totalBeltQuantity += $filter->belt_quantity;
                                        @endphp
                                    @endif
                                    @if ($filter->refrigeranttypes_Fkey)
                                        {{ $filter->refri_quantity }}
                                    @endif
                                    @if ($filter->battery_FKey)
                                        {{ $filter->battery_quantity }}
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="7" style="border-top: 1px dashed black;"></td>
                    </tr>
                    <td></td>
                @endforeach
                <tr style="font-weight:bold;font-size: 13px;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Filter:</td>
                    <td>{{ $totalFilterQuantity }}</td>
                </tr>
                <tr style="font-weight:bold;font-size: 13px;">
                    <td></td>
                    <td></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td>Total Belt:</td>
                    <td>{{ $totalBeltQuantity }}</td>
                </tr>
                <tr>
                    <td colspan="9" style="border-top: 1px solid black;"></td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
