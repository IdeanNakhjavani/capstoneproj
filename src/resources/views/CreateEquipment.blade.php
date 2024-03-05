<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
    <title>New Equipment - Interior Energy & Air</title>
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
                <ul class="navbar-nav mr-auto">
					@if ( Auth::check() && Auth::user()->user_type == '1' )
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/contractlist') }}">Contracts</a></li>
					@endif 
                    <li class="nav-item"><a class="nav-link" href="{{ url('/equipmentlist') }}">Equipment</a>
                    </li>

					@if ( Auth::check() && Auth::user()->user_type == '1' )
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/employeelist') }}">Employees</a></li>
					@endif
					
                    <li class="nav-item active"><a class="nav-link active"
                            href="{{ url('/Buildinglist') }}">Locations</a></li>
                </ul>

				@auth 
                <ul class="navbar-nav mr-100" style="margin-right: 100px">
          
					<li class="nav-item dropdown" >
					  
					<p style="text-align: center;"> {{auth()->user()->Fname}}</p>  
					  <a class="nav-link dropdown-toggle" href="/account" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Account</a>
					  
					  
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
        <br>
    </div>
        <div class="row">
            <form action="/insertequipment" method="post" class="form-group" style="width:70%; margin-left:15%;">
                @method('PUT')
                @csrf
                <div class="jumbotron">
                        <div class="col-md-12">
                                <input type="hidden" name="_method" value="PUT">
                                <h3 style="text-align:center"><b>New Equipment</b></h3>
                                <br>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 style="text-align: center"><b>Location Details</b></h5>
                                        <div class="form-group">
                                            <div class="form-group col-xs-5">
                                                <label for="address">Address:</label>
                                                <input type="text" name="address" class="form-control" address="address" placeholder = "Address" value="">
                                            </div>
                                            <div class="form-group col-xs-3">
                                                <label for="buildingname">Building name:</label>
                                                <input type="text" name="BuildingName" class="form-control" value="" placeholder = "Building name">
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
                                        <div class="form-group col-XS-3">
                                            <label for="postal">Postal Code:</label>
                                            <input type="text" name="BuildingPostal" class="form-control"
                                                value="" placeholder ="Format: A1A 1A1">
                                        </div>
                                        <div class="form-group">
                                            <label for="unitid">Unit ID/Room #:</label>
                                            <input type="text" name="UnitID" class="form-control" value="" placeholder="Room #">
                                        </div>
                                        <div class="form-group">
                                            <label for="location">Location:</label>
                                            <input type="text" name="LocationRoom" class="form-control" value="" placeholder = "Location within room/area">
                                        </div>
                                        
                                        <br>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 style="text-align: center"><b>Equipment Details</b></h5>
                                        <div class="form-group">
                                            <label for="ManufacturerID_Fkey">Select Manufacturer: </label>
                                            <br>
                                            <select name="ManufacturerID_Fkey" id="ManufacturerID_Fkey">
                                                <option value =""> N/A</option>
                                                @foreach ($tbl_manufacturers as $tbl_manufacturers)
                                                    
                                                    <option value="{{ $tbl_manufacturers->ManufacturerID }}">
                                                        {{ $tbl_manufacturers->ManufacturerName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Model">Model:</label>
                                            <input type="text" name="Model" class="form-control" value="" placeholder="Model">
                                        </div>
                                        <div class="form-group">
                                            <label for="filterID_Fkey">Select Filter: </label>
                                            <br>
                                            <select name="filterID_Fkey" id="filterID_Fkey">
            
                                                @foreach ($tbl_filter as $tbl_filter)
                                                    <option value="{{ $tbl_filter->FilterTypeID }}">
                                                        {{ $tbl_filter->FilterType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="refrigerantID_Fkey">Select refrigerant: </label>
                                            <br>
                                            <select name="refrigerantID_Fkey" id="refrigerantID_Fkey">
            
                                                @foreach ($tbl_refrigeranttypes as $tbl_refrigeranttypes)
                                                    <option value="{{ $tbl_refrigeranttypes->RefrigerantTypeID }}">
                                                        {{ $tbl_refrigeranttypes->RefrigerationModel }}, 
                                                        Model: {{ $tbl_refrigeranttypes->RefrigerationSerial }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="batteryID_Fkey">Select Battery: </label>
                                            <br>
                                            <select name="batteryID_Fkey" id="batteryID_Fkey">
            
                                                @foreach ($tbl_battery as $tbl_battery)
                                                    <option value="{{ $tbl_battery->BatteryTypeID }}">
                                                         {{ $tbl_battery->BatteryTypeCode }},
                                                        Type: {{ $tbl_battery->BatteryType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="serial">Serial number:</label>
                                            <input type="text" name="Serial" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 style="text-align: center"><b>Service Details</b></h5>
                                        <div class="form-group">
                                            <label for="InServiceStart">In-Service Start:</label>
                                            <input type="date" class="form-control" name="InServiceStart"
                                                value="">
    
                                        </div>
                                        <div class="form-group">
                                            <label for="InServiceEnd">In-Service End:</label>
                                            <input type="date" class="form-control" name="InServiceEnd"
                                                value="">
                                        </div>                                        
                                        <h6><b>Notes:</b></h6>
                                        <textarea class="form-control" name='Notes' placeholder="Equipment notes"></textarea>
                                        <div class="form-group">
                                            <label for="value">Value:</label>
                                            <input type="text" id="value" class="form-control"
                                                 value="">
                                        </div>
    
                                        <div class="form-group">
                                            <label for="job">Job #:</label>
                                            <input type="text" id="job" name="JobNumber" class="form-control"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3" style="text-align:center">
                                    <button type="submit" class="btn btn-lg btn-success">Create Equipment</button>
                                </div>
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
