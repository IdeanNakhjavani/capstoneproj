<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />


</head>

<body>

    <div class="container fluid">
        <nav class="navbar navbar-expand-lg navbar-light">
            <span class="navbar-brand" href="/">
                <a href="{{ url('/main') }}">
                    <img alt="logo" width="250" height="auto" src={{ url('../images/logo.png') }}
                        class="egg" />
                    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet">
                </a>
            </span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-tabs mr-auto" role="tablist" id="myTab">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/contractlist') }}"
                            data-toggle="false" role="tab" aria-controls="contractlist"
                            aria-selected="true">Contracts</a></li>
                    @if (Auth::check() && Auth::user()->user_type == '1')
                        <li class="nav-item"><a class="nav-link" href="{{ url('/employeelist') }}" data-toggle="false"
                                role="tab" aria-controls="employeelist" aria-selected="false">Employees</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/maintenance') }}" data-toggle="false"
                                role="tab" aria-controls="employeelist" aria-selected="false">Maintenance</a>
                        </li>
                    @endif

                </ul>

                @auth
                    <ul class="navbar-nav mr-100" style="margin-right: 100px">
                        <li class="nav-item dropdown">
                            <p style="text-align: center;"> {{ auth()->user()->Fname }}</p>
                            <a class="nav-link dropdown-toggle" href="/account" id="navbarDropdownMenuLink" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Account</a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item">Hi {{auth()->user()->username }}!</a>
                                    <a class="dropdown-item" href="{{url('/maintenance')}}"> Maintenance </a>
                                    <a class="dropdown-item" href="{{ url('/Accountsetting') }}">Settings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        
                                    </form>
                                </div>
                        </li>

                    </ul>
                @endauth

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="darkSwitch" />
                    <label class="custom-control-label" for="darkSwitch">High Contrast</label>
                </div>
            </div>
        </nav>
    </div>
    <div class="row">
        <form action="/insertcontract" method="post" class="form-group" style="width:70%; margin-left:15%;">
            @method('PUT')
            <div class="jumbotron">
                <div class="col-md-12">
                    <h3 style="text-align:center"><b>New Contract</b></h3>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 style="text-align: center"><b>Customer Details</b></h5>

                                <div class="form-group row">
                                    <div class="col-xs-3">
                                        <label for="firstname">First name:</label>
                                        <input type="text" name="FirstName" class="form-control" value=""
                                            placeholder="First name">
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="form-group col-xs-3">
                                        <label for="lastname">Last name:</label>
                                        <input type="text" name="LastName" class="form-control" value=""
                                            placeholder="Last name">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-xs-5">
                                        <label for="address">Building Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            placeholder="Address" value="">
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="form-group col-xs-5">
                                        <label for="CompanyName">CompanyName</label>
                                        <input type="text" name="CompanyName" id="CompanyName"
                                            class="form-control" placeholder="CompanyName" value="">
                                    </div>
                                    &nbsp;&nbsp;
                                    <div class="form-group col-xs-5">
                                        <label for="address">Building Description</label>
                                        <input type="text" name="BuildingDesc" id="BuildingDesc"
                                            class="form-control" placeholder="BuildingDesc" value="">
                                    </div>
                                    <div class="form-group col-xs-3">
                                        <label for="CityID">City:</label>
                                        <br>
                                        <select name="CityID_Fkey" id="cityDropDown">

                                            @foreach ($tbl_locations as $tbl_locations)
                                                <option value="{{ $tbl_locations->CityID }}">
                                                    {{ $tbl_locations->City }},
                                                    {{ $tbl_locations->ProvinceName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-XS-3">
                                        <label for="postal">Postal Code</label>
                                        <input type="text" name="BuildingPostal" class="form-control"
                                            value="" placeholder="Format: A1A 1A1">
                                    </div>

                                    &nbsp;&nbsp;
                                    <div class="form-group col-xs-5">
                                        <label for="address">Building Description</label>
                                        <input type="text" name="BuildingDesc" id="BuildingDesc"
                                            class="form-control" placeholder="BuildingDesc" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-xs-3">
                                        <label for="smp">SMP:</label>
                                        <input type="number" name="SMPNum" class="form-control" value=""
                                            placeholder="SMP number">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="quote">Quote:&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="SMPQuote"
                                            value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="active">Active:&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="SMPActive"
                                            value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="received">Received:&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="SMPReceived"
                                            value="1">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ContractStartDate">Start
                                        date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="date" name="ContractStartDate" value="">
                                </div>

                                <div class="form-group row">
                                    <label for="ContractEndDate">End
                                        date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="date" name="ContractEndDate" value="">
                                </div>

                                <div class="form-group row">
                                    <label class="form-label" for="renewaldate">Renewal month:&nbsp;</label>
                                    <select class="form-select w-50" id="renewaldate">
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="NumInstallments">Billing: </label>
                                    <select name="NumInstallments" id="NumInstallments">
                                        <option value="1"> Yearly</option>
                                        <option value="2"> Biannually</option>
                                        <option value="4"> Quarterly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 style="text-align: center"><b>Billing Details</b></h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contractType"
                                        id="contractType" value="0">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        2 year plan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="contractType"
                                        id="contractType" value="1">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        6 year plan
                                    </label>
                                </div>
                                <div class="form-row input-group mb-3">
                                    <label for="fyp">First Year Price:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="FirstYear" value="" min="0"
                                            step="0.01" data-number-to-fixed="2" data-number-stepfactor="100"
                                            class="form-control currency" id="c2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">CAD</span>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-row input mb-3'>
                                    <label for="">Notes:</label>
                                    <textarea class="form-control" name='Notes' placeholder="Add any notes about this contract"></textarea>
                                </div>

                                <div class="form-group mb-3" style="text-align:center">
                                    <button type="submit" class="btn btn-lg btn-success">Create Contract</button>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="col-md-4" style="justify-content: center;">
                                    <b>Billing Months:</b>
                                    <br>
                                    <div class="form-check form-check-inline" style="justify-content: center;">
                                        <input class="form-check-input" type="checkbox" name="BillJan">
                                        <label class="form-check-label" for="january1">Jan&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillJul">
                                        <label class="form-check-label"
                                            for="july1">Jul&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="BillFeb">
                                        <label class="form-check-label" for="february1">Feb&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillAug">
                                        <label class="form-check-label"
                                            for="august1">Aug&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="BillMar">
                                        <label class="form-check-label" for="march1">Mar&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillSep">
                                        <label class="form-check-label"
                                            for="september1">Sep&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="BillApr">
                                        <label class="form-check-label"
                                            for="april1">Apr&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillOct">
                                        <label class="form-check-label"
                                            for="october1">Oct&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="BillMay">
                                        <label class="form-check-label" for="may1">May&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillNov">
                                        <label class="form-check-label"
                                            for="november1">Nov&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="BillJun">
                                        <label class="form-check-label"
                                            for="june1">Jun&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input class="form-check-input" type="checkbox" name="BillDec">
                                        <label class="form-check-label"
                                            for="december1">Dec&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                </div>
                                <br>





                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"
        integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous">
    </script>
    <script src="js/dark-mode-switch.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
</body>

</html>
