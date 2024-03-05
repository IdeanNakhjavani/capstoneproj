<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>View Location - Interior Energy & Air</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />


</head>

<body>

    <div class="container">
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
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/equipmentlist') }}">Equipment</a>
                    </li>

					@if ( Auth::check() && Auth::user()->user_type == '1' )
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/employeelist') }}">Employees</a></li>
					@endif
					
                    <li class="nav-item "><a class="nav-link "
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
                            @csrf
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
        <div class="jumbotron row">
            <div class="row">
                <div class="col-md-12">
                    <h5>
                        <b><label for="formFileMultiple" class="form-label">Upload Photos</label></b>
                    </h5>
                    <form class="form-inline">
                        <input class="form-control btn-outline-success btn" type="file" id="formFileMultiple"
                            multiple style="background-color: rgba(255, 255, 255, 0)" />
                        &nbsp;<button class="btn btn-success my-2 my-sm-0" type="submit">
                            Submit
                        </button>
                    </form>
                    <br>
                    <br>
                    @foreach ($tbl_buildings as $tbl_buildings)
                        <form action="{{ url('updatelocation/' . $tbl_buildings->BuildingID) }}" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"><input type="hidden"
                                name="_token" value="<?php echo csrf_token(); ?>">
                    @endforeach
                    @csrf
                    @method('PUT')
                    <h3 class="text-center">
                        <b>Location Details</b>
                    </h3>
                    <br>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" name="BuildingAddress" class="form-control" placeholder="Address"
                                value="{{ $tbl_buildings->BuildingAddress }}">
                            
                        </div>

                        <div class="form-group col-md-6">
                            <label for="CityID_Fkey">City</label>
                            <br>
                            <select name="CityID_Fkey" id="CityID_Fkey">

                                @foreach ($tbl_locations as $tbl_locations)
                                    <option value="{{ $tbl_locations->CityID }}"
                                        {{ $tbl_buildings->CityID_Fkey == $tbl_locations->CityID ? 'selected' : '' }}>
                                        {{ $tbl_locations->City }},   
                                        {{ $tbl_locations->ProvinceName }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="form-group col-md-6">
                            <label for="postal">Postal Code</label>
                            <input type="text" name="BuildingPostal" class="form-control" placeholder="Format: A1A 1A1"
                                value="{{ $tbl_buildings->BuildingPostal }}">
                            

                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="address"> Company </label>
                            <br>

                            <select name="CustomerID_Fkey" id="CustomerID_Fkey">

                                @foreach ($tbl_customers as $tbl_customers)
                                    <option value="{{ $tbl_customers->CustomerID }}"
                                        {{ $tbl_buildings->CustomerID_Fkey == $tbl_customers->CustomerID ? 'selected' : '' }}>
                                        {{ $tbl_customers->CompanyName }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="business">Building Description</label>
                            <input type="text" name="BuildingDesc" class="form-control" placeholder="Describe the building"
                                value="{{ $tbl_buildings->BuildingDesc }}">
                            </div>
                        <div class="form-group col-md-6">
                            <label for="notes">Notes</label>
                            <input type="text" name="Notes" class="form-control" placeholder="Leave any notes"
                                notes="notes" value="Unit needs replacing ASAP">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="firstname">First name</label>
                            <input type="text" name="" class="form-control" placeholder="First name"
                                value="{{ $tbl_buildings->FirstName }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name</label>
                            <input type="text" name="" class="form-control" placeholder="Last name"
                                value="{{ $tbl_buildings->LastName }}">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="details">Record Date</label>
                            <input type="date" name="BuildingRecordDate" class="form-control"
                                value="{{ Carbon\Carbon::parse($tbl_buildings->RecordDate)->format('Y-m-d') }}">
                        </div>
                    </div>
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Notes: </th>
                                <th>Date: </th>
                                <th>Action: </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($tbl_notes as $tbl_notes)
                                <tr class="table">
                                    <td>
                                        {{ $tbl_notes->Notes }}
                                    </td>
                                    <td> 
                                        {{Carbon\Carbon::parse($tbl_notes->RecordDate)->format('d-m-Y')}}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-danger btn-sm danger" data-toggle="modal" 
                                        data-target="">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group mb-3" style="text-align:center">
                        <button type="submit" class="btn btn-lg btn-success">Update changes</button>
                    </div>
                </div>
                
            </div>
            
            </form>
        </div>
        <br>
        <div class = "jumbotron row">
            <div class="modal-content">

            <form action="{{ url('insertnotesbuilding/' . $tbl_buildings->BuildingID) }}" method="post" class="form-group"
                style="width:70%; margin-left:15%;">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"><input type="hidden"
                    name="_token" value="<?php echo csrf_token(); ?>">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title"><b>Add Internal Notes</b></h5>
                </div>

                <div class="form-group">
                    <br>
                    <textarea class="form-control" name='Notes' value="" placeholder="Notes"></textarea>
                </div>

                <div class="modal-footer">
                   
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
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
    <script src="../js/dark-mode-switch.min.js"></script>
</body>

</html>
