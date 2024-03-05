<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <title>View Contract - Interior Energy & Air</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href={{ URL::asset('css/style.css') }} rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
                                <a class="dropdown-item">Hi {{ auth()->user()->username }}!</a>
                                <a class="dropdown-item" href="{{ url('/maintenance') }}"> Maintenance </a>
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
    <div class="row ">
        <div class="col-md-1">
        </div>
        <div class="col-md-10">

            <div class="jumbotron row">

                @if (Auth::check() && Auth::user()->user_type == '1')
                    <div class="row ">
                        <div class=" col-lg-12"style="text-align: center;">
                            @foreach ($tbl_contracts as $tbl_contracts)
                                <a class="btn btn-success btn-lg font-weight-bold ml-2 text-center mt-3"
                                    href="{{ URL::to('generate_C_PDF/' . $tbl_contracts->ContractID) }}"
                                    style="padding: 24px; text-align: center;">Generate SMP PDF</a>
                                <a class="btn btn-primary btn-lg font-weight-bold ml-2  text-center mt-3"
                                    href="{{ URL::to('RenewalSMP/' . $tbl_contracts->ContractID) }}"
                                    style="padding: 24px; text-align: center;">Generate Renewal PDF</a>
                                <a class="btn btn-warning btn-lg font-weight-bold ml-2  text-center mt-3"
                                    href="" style="padding: 24px; text-align: center;">Generate Pricing Request
                                    PDF</a>
                                <a class="btn btn-outline-success btn-lg font-weight-bold ml-2 text-center mt-3"
                                    href="{{ URL::to('createcontract2/' . $tbl_contracts->ContractID) }}"
                                    style="padding: 24px; text-align: center;">+ Additional Contract</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <br>
                    <h5>
                        <b><label for="formFileMultiple" class="form-label">Upload Photos</label></b>
                    </h5>

                    @if (Auth::check() && Auth::user()->user_type == '0')
                        @foreach ($tbl_contracts as $tbl_contracts)
                            <form action="{{ url('insertconImg/' . $tbl_contracts->ContractID) }}" method="POST"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <input type="file" name="image" id="inputImage"
                                        class="form-control @error('image') is-invalid @enderror">

                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success">Upload</button>
                                </div>
                            </form>
                        @endforeach
                    @endif
                    @if (Auth::check() && Auth::user()->user_type == '1')
                        <form action="{{ url('insertconImg/' . $tbl_contracts->ContractID) }}" method="POST"
                            enctype="multipart/form-data">

                            <div class="mb-3">
                                <input type="file" name="image" id="inputImage"
                                    class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="col-md-3">
                </div>
                <br>
                <br>

                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner " style="width:100%;">
                                @foreach ($tbl_images as $tbl_images)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <div class="slider-image text-center">
                                            <div class="containter">
                                                <img src="{{ asset('storage/' . $tbl_images->ImagePath) }}"
                                                    class="" alt=""
                                                    style="height: 500px; max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <br><br>

                        <style>
                            .carousel-inner {
                                width: 100%;
                                max-height: 800px;
                            }

                            .carousel-control {}

                            .carousel-item {
                                width: 100%;
                            }
                        </style>

                    </div>
                    <div class="col-md-3">
                    </div>
                </div>




                <form action="{{ url('updatecontract/' . $tbl_contracts->ContractID) }}" method="POST">

                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <h3 style="text-align:center"><b>Customer Details</b></h3><br>
                            <div class="row">
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="firstname">First name:</label>
                                        <input type="text" name="FirstName" class="form-control"
                                            value="{{ $tbl_contracts->FirstName }}" placeholder="First name">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="firstname">First name:</label>
                                        <input type="text" name="FirstName" class="form-control"
                                            value="{{ $tbl_contracts->FirstName }}" placeholder="First name"
                                            readonly>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Last name:</label>
                                        <input type="text" name="LastName" class="form-control"
                                            value="{{ $tbl_contracts->LastName }}" placeholder="Last name">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Last name:</label>
                                        <input type="text" name="LastName" class="form-control"
                                            value="{{ $tbl_contracts->LastName }}" placeholder="Last name" readonly>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="address">Address:</label>
                                        <input type="text" name="BuildingAddress" class="form-control"
                                            address="address" value="{{ $tbl_contracts->BuildingAddress }}"
                                            placeholder="Address">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="address">Address:</label>
                                        <input type="text" name="BuildingAddress" class="form-control"
                                            address="address" value="{{ $tbl_contracts->BuildingAddress }}"
                                            placeholder="Address" readonly>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="companyname">Company name:</label>
                                        <input type="text" name="CompanyName" class="form-control"
                                            value="{{ $tbl_contracts->CompanyName }}" placeholder="Company">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="companyname">Company name:</label>
                                        <input type="text" name="CompanyName" class="form-control"
                                            value="{{ $tbl_contracts->CompanyName }}" placeholder="Company" readonly>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="buildingname">Building description:</label>
                                        <input type="text" name="BuildingDescription" class="form-control"
                                            value="{{ $tbl_contracts->BuildingDesc }}" placeholder="Description">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="buildingname">Building description:</label>
                                        <input type="text" name="BuildingDescription" class="form-control"
                                            value="{{ $tbl_contracts->BuildingDesc }}" placeholder="Description"
                                            readonly>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="CityID">City:</label>
                                        <br>
                                        <select class="form-select form-select-sm w-75" name="CityID_Fkey"
                                            id="cityDropDown" aria-label=".form-select-sm example">

                                            @foreach ($tbl_locations as $tbl_location)
                                                <option value="{{ $tbl_location->CityID }}"
                                                    {{ $tbl_contracts->CityID_Fkey == $tbl_location->CityID ? 'selected' : '' }}>
                                                    {{ $tbl_location->City }}, {{ $tbl_location->ProvinceName }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>

                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="CityID">City:</label>
                                        <br>
                                        <select class="form-select form-select-sm w-75" name="CityID_Fkey"
                                            id="cityDropDown" aria-label=".form-select-sm example" disabled>

                                            @foreach ($tbl_locations as $tbl_locations)
                                                <option value="{{ $tbl_locations->CityID }}"
                                                    {{ $tbl_contracts->CityID_Fkey ? 'selected' : '' }}>
                                                    {{ $tbl_locations->City }},
                                                    {{ $tbl_locations->ProvinceName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="form-group col-md-6">
                                        <label for="postal">Postal Code:</label>
                                        <input type="text" name="BuildingPostal" class="form-control"
                                            value="{{ $tbl_contracts->BuildingPostal }}"
                                            placeholder="Format: A1A 1A1">
                                    </div>
                                @endif
                                @if (Auth::check() && Auth::user()->user_type == '0')
                                    <div class="form-group col-md-6">
                                        <label for="postal">Postal Code:</label>
                                        <input type="text" name="BuildingPostal" class="form-control"
                                            value="{{ $tbl_contracts->BuildingPostal }}"
                                            placeholder="Format: A1A 1A1" readonly>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-8">
                            <br>
                            <h3 style="text-align:center"><b>Contract Details</b></h3>
                            <br><br>
                            <div class="row">
                                <div class="overflow-auto rounded-lg shadow">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SMP</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Term</th>
                                                <th>Start date</th>
                                                <th>Stop date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($tbl_duplicate as $tbl_duplicate)
                                                <tr class="table-tr"
                                                    data-url="{{ url('/viewcontract/' . $tbl_duplicate->ContractID) }}">

                                                    <td>
                                                        {{ $tbl_duplicate->SMPNum }}
                                                    </td>
                                                    <td>{{ $tbl_duplicate->FirstName }}</td>
                                                    <td>{{ $tbl_duplicate->LastName }}</td>
                                                    <td>{{ $tbl_duplicate->TermLength }}</td>
                                                    <td>{{ Carbon\Carbon::parse($tbl_duplicate->ContractStartDate)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ Carbon\Carbon::parse($tbl_duplicate->ContractEndDate)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        <a href="" class="btn btn-warning btn-sm edit">Edit</a>
                                                        <a href="#" class="btn btn-danger btn-sm danger"
                                                            data-toggle="modal" data-target="">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-3">
                                    <br>
                                    @if (Auth::check() && Auth::user()->user_type == '1')
                                        <div class="mb-3">
                                            <label for="smp">SMP</label>
                                            <input type="text" name="SMPNum" class="form-control"
                                                value="{{ $tbl_contracts->SMPNum }}" placeholder="SMP number">
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '0')
                                        <div class="mb-3">
                                            <label for="smp">SMP</label>
                                            <input type="text" name="SMPNum" class="form-control"
                                                value="{{ $tbl_contracts->SMPNum }}" placeholder="SMP number"
                                                readonly>
                                        </div>
                                    @endif
                                    <br>
                                    @if (Auth::check() && Auth::user()->user_type == '1')
                                        <div class="form-check ">
                                            <label class="form-check-label"
                                                for="quote">Quote:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPQuote"
                                                {{ $tbl_contracts->SMPQuote == 1 ? 'checked' : '' }}>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"
                                                for="active">Active:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPActive"
                                                {{ $tbl_contracts->SMPActive == 1 ? 'checked' : '' }}>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"
                                                for="received">Received:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPReceived"
                                                {{ $tbl_contracts->SMPReceived == 1 ? 'checked' : '' }}>
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '0')
                                        <div class="form-check ">
                                            <label class="form-check-label"
                                                for="quote">Quote:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPQuote"
                                                {{ $tbl_contracts->SMPQuote == 1 ? 'checked' : '' }} disabled>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"
                                                for="active">Active:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPActive"
                                                {{ $tbl_contracts->SMPActive == 1 ? 'checked' : '' }} disabled>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label"
                                                for="received">Received:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="form-check-input" type="checkbox" name="SMPReceived"
                                                {{ $tbl_contracts->SMPReceived == 1 ? 'checked' : '' }} disabled>
                                        </div>
                                    @endif
                                    <br>

                                    @if (Auth::check() && Auth::user()->user_type == '1')
                                        <label for="startdate">Start date:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="date" name="startdate"
                                            value="{{ Carbon\Carbon::parse($tbl_contracts->ContractStartDate)->format('Y-m-d') }}">
                                        <br>

                                        <label for="enddate">End
                                            date:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="date" name="enddate"
                                            value="{{ Carbon\Carbon::parse($tbl_contracts->ContractEndDate)->format('Y-m-d') }}">
                                        <br>

                                        <div class="form-group-inline">
                                            <label class="form-label" for="renewaldate">Renewal month:</label>
                                            <select class="form-select w-75" id="renewaldate" name="renewaldate">
                                                <option value="01"
                                                    {{ $tbl_contracts->RenewalDate === 1 ? 'selected' : '' }}>January
                                                </option>
                                                <option value="02"
                                                    {{ $tbl_contracts->RenewalDate === 2 ? 'selected' : '' }}>February
                                                </option>
                                                <option value="03"
                                                    {{ $tbl_contracts->RenewalDate === 3 ? 'selected' : '' }}>March
                                                </option>
                                                <option value="04"
                                                    {{ $tbl_contracts->RenewalDate === 4 ? 'selected' : '' }}>April
                                                </option>
                                                <option value="05"
                                                    {{ $tbl_contracts->RenewalDate === 5 ? 'selected' : '' }}>May
                                                </option>
                                                <option value="06"
                                                    {{ $tbl_contracts->RenewalDate === 6 ? 'selected' : '' }}>June
                                                </option>
                                                <option value="07"
                                                    {{ $tbl_contracts->RenewalDate === 7 ? 'selected' : '' }}>July
                                                </option>
                                                <option value="08"
                                                    {{ $tbl_contracts->RenewalDate === 8 ? 'selected' : '' }}>August
                                                </option>
                                                <option value="09"
                                                    {{ $tbl_contracts->RenewalDate === 9 ? 'selected' : '' }}>September
                                                </option>
                                                <option value="10"
                                                    {{ $tbl_contracts->RenewalDate === 10 ? 'selected' : '' }}>October
                                                </option>
                                                <option value="11"
                                                    {{ $tbl_contracts->RenewalDate === 11 ? 'selected' : '' }}>November
                                                </option>
                                                <option value="12"
                                                    {{ $tbl_contracts->RenewalDate === 12 ? 'selected' : '' }}>December
                                                </option>
                                            </select>
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '0')
                                        <label for="startdate">Start
                                            date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="date" name="startdate"
                                            value="{{ Carbon\Carbon::parse($tbl_contracts->ContractStartDate)->format('Y-m-d') }}"
                                            disabled>


                                        <label for="enddate">End
                                            date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="date" name="enddate"
                                            value="{{ Carbon\Carbon::parse($tbl_contracts->ContractEndDate)->format('Y-m-d') }}"
                                            disabled>
                                        <div class="form-group-inline">
                                            <label class="form-label" for="renewaldate">Renewal month:</label>
                                            <select class="form-select w-50" id="renewaldate"disabled>
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
                                    @endif

                                    @if (Auth::check() && Auth::user()->user_type == '1')
                                        <div class="form-group">
                                            <br>
                                            <label for="NumInstallments">Billing: </label>
                                            <select name="NumInstallments" id="NumInstallments">
                                                <option value="1"
                                                    {{ $tbl_contracts->NumInstallments == '1' ? 'selected' : '' }}>
                                                    Yearly</option>
                                                <option value="2"
                                                    {{ $tbl_contracts->NumInstallments == '2' ? 'selected' : '' }}>
                                                    Biannually</option>
                                                <option value="4"
                                                    {{ $tbl_contracts->NumInstallments == '4' ? 'selected' : '' }}>
                                                    Quarterly</option>
                                            </select>
                                            <br>
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '0')
                                        <div class="form-group">
                                            <br>
                                            <label for="NumInstallments">Billing: </label>
                                            <select name="NumInstallments" id="NumInstallments" disabled>
                                                <option value="1"
                                                    {{ $tbl_contracts->NumInstallments == '1' ? 'selected' : '' }}>
                                                    Yearly</option>
                                                <option value="2"
                                                    {{ $tbl_contracts->NumInstallments == '2' ? 'selected' : '' }}>
                                                    Biannually</option>
                                                <option value="4"
                                                    {{ $tbl_contracts->NumInstallments == '4' ? 'selected' : '' }}>
                                                    Quarterly</option>
                                            </select>
                                            <br>
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '1')
                                        <div class="form-group">
                                            <label for="">Term: </label>
                                            <select name="Term" id="Term">
                                                <option value="1" {{ $currentTerm == '1' ? 'selected' : '' }}>1
                                                </option>
                                                <option value="2" {{ $currentTerm == '2' ? 'selected' : '' }}>2
                                                </option>
                                                <option value="3" {{ $currentTerm == '3' ? 'selected' : '' }}>3
                                                </option>
                                                <option value="4" {{ $currentTerm == '4' ? 'selected' : '' }}>4
                                                </option>
                                                <option value="5" {{ $currentTerm == '5' ? 'selected' : '' }}>5
                                                </option>
                                                <option value="6" {{ $currentTerm == '6' ? 'selected' : '' }}>6
                                                </option>
                                                <option value="7" {{ $currentTerm == '7' ? 'selected' : '' }}>7
                                                </option>
                                                <option value="8" {{ $currentTerm == '8' ? 'selected' : '' }}>8
                                                </option>

                                            </select>
                                        </div>
                                    @endif
                                    @if (Auth::check() && Auth::user()->user_type == '0')
                                        <div class="form-group">
                                            <label for="">Term: </label>
                                            <select name="Term" id="Term" disabled>
                                                <option value="1" {{ $currentTerm == '1' ? 'selected' : '' }}>1
                                                </option>
                                                <option value="2" {{ $currentTerm == '2' ? 'selected' : '' }}>2
                                                </option>
                                                <option value="3" {{ $currentTerm == '3' ? 'selected' : '' }}>3
                                                </option>
                                                <option value="4" {{ $currentTerm == '4' ? 'selected' : '' }}>4
                                                </option>
                                                <option value="5" {{ $currentTerm == '5' ? 'selected' : '' }}>5
                                                </option>
                                                <option value="6" {{ $currentTerm == '6' ? 'selected' : '' }}>6
                                                </option>
                                                <option value="7" {{ $currentTerm == '7' ? 'selected' : '' }}>7
                                                </option>
                                                <option value="8" {{ $currentTerm == '8' ? 'selected' : '' }}>8
                                                </option>

                                            </select>
                                        </div>
                                    @endif
                                    <br>
                                </div>
                                <div class="col-md-9">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-check form-check-inline">
                                                @if (Auth::check() && Auth::user()->user_type == '1')
                                                    <input class="form-check-input" type="radio"
                                                        name="contractType" id="contractType" value="0"
                                                        {{ $tbl_contracts->contractType == 0 ? 'checked' : '' }}>
                                                @endif
                                                @if (Auth::check() && Auth::user()->user_type == '0')
                                                    <input class="form-check-input" type="radio"
                                                        name="contractType" id="contractType" value="0"
                                                        {{ $tbl_contracts->contractType == 0 ? 'checked' : '' }}
                                                        disabled>
                                                @endif
                                                <label class="form-check-label" for="contractType1">
                                                    2 year plan
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @if (Auth::check() && Auth::user()->user_type == '1')
                                                    <input class="form-check-input" type="radio"
                                                        name="contractType" id="contractType2" value="1"
                                                        {{ $tbl_contracts->contractType == 1 ? 'checked' : '' }}>
                                                @endif
                                                @if (Auth::check() && Auth::user()->user_type == '0')
                                                    <input class="form-check-input" type="radio"
                                                        name="contractType" id="contractType2" value="1"
                                                        {{ $tbl_contracts->contractType == 1 ? 'checked' : '' }}
                                                        disabled>
                                                @endif
                                                <label class="form-check-label" for="contractType2">
                                                    6 year plan
                                                </label>
                                            </div>
                                            <div class="form" style="text-align:center">
                                                @if (Auth::check() && Auth::user()->user_type == '1')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-success btn-block">Apply Plan</button>
                                                @endif
                                                @if (Auth::check() && Auth::user()->user_type == '0')
                                                    <button type="submit" class="btn btn-sm btn-success btn-block"
                                                        disabled>Apply</button>
                                                @endif
                                            </div>
                                            <br>
                                            @if ($tbl_contracts->contractType == 1)
                                                <div class="form-row input-group mb-3">

                                                    <label for="1-2year">1-2 year Renewal Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="Renewal1_2"
                                                                value="{{ $tbl_contracts->Renewal1_2 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="Renewal1_2"
                                                                value="{{ $tbl_contracts->Renewal1_2 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row input-group mb-3">
                                                    <label for="3-4year">3-4 year Renewal Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="Renewal3_4"
                                                                value="{{ $tbl_contracts->Renewal3_4 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="Renewal3_4"
                                                                value="{{ $tbl_contracts->Renewal3_4 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row input-group mb-3">
                                                    <label for="5-6year">5-6 year Renewal Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="Renewal5_6"
                                                                value="{{ $tbl_contracts->Renewal5_6 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="Renewal5_6"
                                                                value="{{ $tbl_contracts->Renewal5_6 }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row input-group mb-3">
                                                    <label for="active">Active Renewal Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="ActivePrice"
                                                                value="{{ $tbl_contracts->ActivePrice }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="ActivePrice"
                                                                value="{{ $tbl_contracts->ActivePrice }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-row input-group mb-3">
                                                    <label for="fyp">1 Year Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="FirstYear"
                                                                value="{{ $tbl_contracts->Yr1Price }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="FirstYear"
                                                                value="{{ $tbl_contracts->Yr1Price }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row input-group mb-3">
                                                    <label for="syp">1 & 2 Year Price:</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->user_type == '1')
                                                            <input type="number" name="SecondYear"
                                                                value="{{ $tbl_contracts->Yr2Price }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2" />
                                                        @endif
                                                        @if (Auth::check() && Auth::user()->user_type == '0')
                                                            <input type="number" name="SecondYear"
                                                                value="{{ $tbl_contracts->Yr2Price }}"
                                                                min="0" step="0.01"
                                                                data-number-to-fixed="2" data-number-stepfactor="100"
                                                                class="form-control currency" id="c2"
                                                                readonly />
                                                        @endif
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">CAD</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <br>

                                        </div>
                                        <div class="col-md-7">
                                            <b>Billing Months:</b>
                                            <br>
                                            @if (Auth::check() && Auth::user()->user_type == '1')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJan"
                                                        {{ $tbl_contracts->BillJan == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="january1">Jan&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJul"
                                                        {{ $tbl_contracts->BillJul == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="july1">Jul</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillFeb"
                                                        {{ $tbl_contracts->BillFeb == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="february1">Feb&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillAug"
                                                        {{ $tbl_contracts->BillAug == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="august1">Aug</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillMar"
                                                        {{ $tbl_contracts->BillMar == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="march1">Mar&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillSep"
                                                        {{ $tbl_contracts->BillSep == 1 ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="september1">Sep</label>
                                                    <input class="form-check-input" type="checkbox" name="BillSep"
                                                        {{ $tbl_contracts->BillSep == 1 ? 'checked' : '' }}>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillApr"
                                                        {{ $tbl_contracts->BillApr == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="april1">Apr&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillOct"
                                                        {{ $tbl_contracts->BillOct == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="october1">Oct</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillMay"
                                                        {{ $tbl_contracts->BillMay == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="may1">May</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillNov"
                                                        {{ $tbl_contracts->BillNov == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="november1">Nov</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJun"
                                                        {{ $tbl_contracts->BillJun == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="june1">Jun&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillDec"
                                                        {{ $tbl_contracts->BillDec == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="december1">Dec</label>
                                                </div>
                                            @endif
                                            @if (Auth::check() && Auth::user()->user_type == '0')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJan"
                                                        {{ $tbl_contracts->BillJan == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="january1">Jan&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJul"
                                                        {{ $tbl_contracts->BillJul == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="july1">Jul</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillFeb"
                                                        {{ $tbl_contracts->BillFeb == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="february1">Feb&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillAug"
                                                        {{ $tbl_contracts->BillAug == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="august1">Aug</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillMar"
                                                        {{ $tbl_contracts->BillMar == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="march1">Mar&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillSep"
                                                        {{ $tbl_contracts->BillSep == 1 ? 'checked' : '' }} disabled>

                                                    <label class="form-check-label" for="september1">Sep</label>
                                                    <input class="form-check-input" type="checkbox" name="BillSep"
                                                        {{ $tbl_contracts->BillSep == 1 ? 'checked' : '' }} disabled>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillApr"
                                                        {{ $tbl_contracts->BillApr == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="april1">Apr&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillOct"
                                                        {{ $tbl_contracts->BillOct == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="october1">Oct</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillMay"
                                                        {{ $tbl_contracts->BillMay == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="may1">May</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillNov"
                                                        {{ $tbl_contracts->BillNov == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="november1">Nov</label>
                                                </div>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillJun"
                                                        {{ $tbl_contracts->BillJun == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="june1">Jun&nbsp;</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="BillDec"
                                                        {{ $tbl_contracts->BillDec == 1 ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="december1">Dec</label>
                                                </div>
                                            @endif
                                            <br>
                                            <div class="card border-primary mb-3">
                                                <div class="card-body overflow-auto rounded-lg shadow">
                                                    <table id="notestable"
                                                        class="table table-sm table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3">
                                                                    <h5 style="text-align:center"><b>Internal Notes</b>
                                                                    </h5>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Note
                                                                </th>
                                                                <th>Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($tbl_notes as $tbl_note)
                                                                <tr class="table-tr">
                                                                    <td>
                                                                        {{ $tbl_note->Notes }}
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($tbl_note->RecordDate)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td><a href="#"
                                                                            class="btn btn-danger btn-sm danger"
                                                                            data-toggle="modal"
                                                                            data-target="#deleteModal{{ $tbl_note->NoteID }}">Delete</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10">
                                @if (Auth::check() && Auth::user()->user_type == '1')
                                    <div class="overflow-auto rounded-lg shadow">
                                        <table class="table w-full table-sm table-hover">
                                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                                <tr style="text-align:center">
                                                    <th colspan="3" scope="colgroup">Equipment</th>
                                                    <th colspan="12" scope="colgroup">Work Months</th>
                                                </tr>
                                                <tr style="text-align:center">

                                                    <th>Model</th>
                                                    <th>Serial</th>
                                                    <th>Manufacturer</th>
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($tbl_equipment as $equipment)
                                                    <tr style="text-align:center" class="p3 text-sm text-gray-700">
                                                        <td>{{ $equipment->Model }} </td>
                                                        <td> {{ $equipment->Serial }} </td>
                                                        <td> {{ $equipment->ManufacturerName }} </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkJan]"
                                                                {{ $equipment->Jan == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkFeb]"
                                                                {{ $equipment->Feb == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkMar]"
                                                                {{ $equipment->Mar == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkApr]"
                                                                {{ $equipment->Apr == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkMay]"
                                                                {{ $equipment->May == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkJun]"
                                                                {{ $equipment->Jun == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkJul]"
                                                                {{ $equipment->Jul == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkAug]"
                                                                {{ $equipment->Aug == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkSep]"
                                                                {{ $equipment->Sep == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkOct]"
                                                                {{ $equipment->Oct == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkNov]"
                                                                {{ $equipment->Nov == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input class="form-check-inline" type="checkbox"
                                                                name="Work[{{ $equipment->EquipmentID }}][WorkDec]"
                                                                {{ $equipment->Dec == 1 ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('/viewequipment/' . $equipment->EquipmentID) }}"
                                                                class="btn btn-warning btn-sm edit">Edit</a>
                                                            <a href="#" class="btn btn-danger btn-sm danger"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal{{ $equipment->EquipmentID }}">Delete</a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <br>
                                <div class="form-group mb-3" style="text-align: center;">
                                    <button type="submit" class="btn btn-lg btn-success">Update changes</button>
                                    &nbsp;
                                    <button type="button" href="#" class="btn btn-outline-success btn-lg"
                                        data-toggle="modal"
                                        data-target="#insertequipment{{ $tbl_contracts->ContractID }}">+ Add
                                        Equipment</button>
                                    &nbsp;
                                    <button type="button" href="#" class="btn btn-outline-primary btn-lg "
                                        data-toggle="modal"
                                        data-target="#createnote{{ $tbl_contracts->ContractID }}">+ Add
                                        Note</button>


                                </div>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>

                </form>

            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>
    <div class="col-md-1">
    </div>
    @foreach ($tbl_notes as $tbl_note)
        <div class="modal fade" id="deleteModal{{ $tbl_note->NoteID }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete this note?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('deleteContractnote/' . $tbl_note->NoteID) }}" method="POST"
                        id="deleteForm">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="form-group">
                                <b>Date: </b>
                                <label for="exampleInputEmail1">
                                    {{ Carbon\Carbon::parse($tbl_note->RecordDate)->format('d/m/Y') }}</label>
                            </div>
                            <div class="form-group">
                                <b>Note: </b>
                                <label for="exampleInputEmail1">{{ $tbl_note->Notes }}</label>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger delete">Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach

    @foreach ($tbl_equipment as $equipment)
        <div class="modal fade" id="deleteModal{{ $equipment->EquipmentID }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete this Equipment?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('deleteequipment/' . $equipment->EquipmentID) }}" method="POST"
                        id="deleteForm">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="form-group">
                                <b>Model: </b>
                                <label for="exampleInputEmail1">{{ $equipment->Model }}</label>
                            </div>
                            <div class="form-group">
                                <b>Serial #: </b>
                                <label for="exampleInputEmail1">{{ $equipment->Serial }}</label>
                            </div>
                            <div class="form-group">
                                <b>Manufacturer: </b>
                                <label for="exampleInputEmail1">{{ $equipment->ManufacturerName }}</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger delete">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="createnote{{ $tbl_contracts->ContractID }}" tabindex="-1" role="dialog"
        aria-labelledby="createnote"aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">


                    <h5 class="modal-title" id="createnote"><b>Add Internal Note to Contract</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                </div>
                <form action="{{ url('insertnotes/' . $tbl_contracts->ContractID) }}" method="post"
                    class="form-group" style="width:70%; margin-left:15%;">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <br>
                        <textarea class="form-control" name='Notes' value="" placeholder="Notes"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add Note</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>


    <!-- create Equipment -->
    <div class="modal fade" id="insertequipment{{ $tbl_contracts->ContractID }}" tabindex="-1" role="dialog"
        aria-labelledby="insertequipment"aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">


                    <h5 class="modal-title text-center" id="insertequipment" style="text-align: center;">Add
                        Equipment to Contract</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>


                </div>

                <form action="{{ url('/insertequipment/' . $tbl_contracts->ContractID) }}" method="POST"
                    id="insertequipment">
                    @method('PUT')
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="UnitID">Unit ID/Room #:</label>
                                <input type="text" name="UnitID" class="form-control" value=""
                                    placeholder="Room #">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="btn-group col-md-12" role="group">
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm"
                                        onclick="addFilterRow()" style="margin-top: 8px;">+ Filter
                                    </button>
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm"
                                        onclick="addBeltRow()" style="margin-top: 8px;">+ Belt
                                    </button>
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm"
                                        onclick="addRefrigerantRow()" style="margin-top: 8px;">+ Refrigerant Code
                                    </button>
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm"
                                        style="margin-top: 8px;" onclick="addBatteryRow()">+ Battery Type Code
                                    </button>
                                </div>
                            </div>
                            <div id="filterRows">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="beltRows">
                                <div class="form-row">

                                    <div class="form-group col-md-3">
                                    </div>
                                </div>
                            </div>
                            <div id="refrigerantRows">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                    </div>
                                </div>

                            </div>
                            <div id="batteryRows">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function deleteRow(button) {
                                var row = button.parentNode;
                                row.parentNode.removeChild(row);
                            }

                            function addFilterRow() {
                                var container = document.getElementById("filterRows");

                                // Create a new form-row div
                                var row = document.createElement("div");
                                row.className = "form-row";

                                // Add the form fields
                                var filterSelect = document.createElement("select");
                                filterSelect.className = "form-select";
                                filterSelect.name = "filterID[]";
                                var filterOptionNA = document.createElement("option");
                                filterOptionNA.value = "N/A";
                                filterOptionNA.textContent = "N/A";
                                filterSelect.appendChild(filterOptionNA);
                                @foreach ($tbl_filter as $filter)
                                    var filterOption = document.createElement("option");
                                    filterOption.value = "{{ $filter->FilterTypeID }}";
                                    filterOption.textContent = "{{ $filter->FilterType }}";
                                    filterSelect.appendChild(filterOption);
                                @endforeach

                                var filterDiv = document.createElement("div");
                                filterDiv.className = "form-group-inline col-md-7";
                                var filterLabel = document.createElement("label");
                                filterLabel.htmlFor = "filterID";
                                filterLabel.textContent = "Filter: ";
                                var filterContainer = document.createElement("div");
                                filterContainer.className = "input-container";
                                filterContainer.appendChild(filterSelect);
                                filterDiv.appendChild(filterLabel);
                                filterDiv.appendChild(filterContainer);

                                var quantityInput = document.createElement("input");
                                quantityInput.className = "form-control form-group";
                                quantityInput.type = "number";
                                quantityInput.name = "filterID_quantity[]";
                                quantityInput.min = "0";
                                quantityInput.max = "10";
                                quantityInput.pattern = "[0-9]";
                                quantityInput.placeholder = "1-10";

                                var quantityDiv = document.createElement("div");
                                quantityDiv.className = "form-group col-md-2";
                                var quantityLabel = document.createElement("label");
                                quantityLabel.htmlFor = "filterID_quantity";
                                quantityLabel.textContent = "Quantity: ";
                                quantityDiv.appendChild(quantityLabel);
                                quantityDiv.appendChild(quantityInput);

                                row.appendChild(filterDiv);
                                row.appendChild(quantityDiv);

                                // Create a new delete button for additional rows
                                var deleteButton = document.createElement("button");
                                deleteButton.type = "button";
                                deleteButton.className = "btn btn-danger delete-btn";
                                deleteButton.textContent = "Delete";
                                deleteButton.style.height = "100%";
                                deleteButton.style.width = "180px";
                                deleteButton.style.marginTop = "32px";
                                deleteButton.onclick = function() {
                                    deleteRow(this);
                                };
                                row.appendChild(deleteButton);

                                container.appendChild(row);
                            }
                        </script>



                        <script>
                            function deleteRow(button) {
                                var row = button.parentNode;
                                row.parentNode.removeChild(row);
                            }

                            function addBeltRow() {
                                var container = document.getElementById("beltRows");

                                // Create a new form-row div
                                var row = document.createElement("div");
                                row.className = "form-row";

                                // Add the form fields
                                var beltSelect = document.createElement("select");
                                beltSelect.className = "form-select";
                                beltSelect.name = "BeltID[]";
                                var beltOptionNA = document.createElement("option");
                                beltOptionNA.value = "N/A";
                                beltOptionNA.textContent = "N/A";
                                beltSelect.appendChild(beltOptionNA);

                                @foreach ($tbl_belt as $belt)
                                    var beltOption = document.createElement("option");
                                    beltOption.value = "{{ $belt->BeltID }}";
                                    beltOption.textContent = "{{ $belt->BeltType }}";
                                    beltSelect.appendChild(beltOption);
                                @endforeach

                                var beltDiv = document.createElement("div");
                                beltDiv.className = "form-group-inline col-md-7";
                                var beltLabel = document.createElement("label");
                                beltLabel.htmlFor = "BeltID";
                                beltLabel.textContent = "Belt: ";
                                var beltContainer = document.createElement("div");
                                beltContainer.className = "input-container";
                                beltContainer.appendChild(beltSelect);
                                beltDiv.appendChild(beltLabel);
                                beltDiv.appendChild(beltContainer);

                                var quantityInput = document.createElement("input");
                                quantityInput.className = "form-control form-group";
                                quantityInput.type = "number";
                                quantityInput.name = "BeltID_quantity[]";
                                quantityInput.min = "0";
                                quantityInput.max = "10";
                                quantityInput.pattern = "[0-9]";
                                quantityInput.placeholder = "1-10";

                                var quantityDiv = document.createElement("div");
                                quantityDiv.className = "form-group col-md-2";
                                var quantityLabel = document.createElement("label");
                                quantityLabel.htmlFor = "BeltID_quantity";
                                quantityLabel.textContent = "Quantity: ";
                                quantityDiv.appendChild(quantityLabel);
                                quantityDiv.appendChild(quantityInput);

                                row.appendChild(beltDiv);
                                row.appendChild(quantityDiv);

                                // Create a new delete button for additional rows
                                var deleteButton = document.createElement("button");
                                deleteButton.type = "button";
                                deleteButton.className = "btn btn-danger delete-btn";
                                deleteButton.textContent = "Delete";
                                deleteButton.style.height = "100%";
                                deleteButton.style.width = "180px";
                                deleteButton.style.marginTop = "32px";
                                deleteButton.onclick = function() {
                                    deleteRow(this);
                                };
                                row.appendChild(deleteButton);

                                container.appendChild(row);
                            }
                        </script>


                        <script>
                            function deleteRow(button) {
                                var row = button.parentNode;
                                row.parentNode.removeChild(row);
                            }

                            function addBatteryRow() {
                                var container = document.getElementById("batteryRows");

                                // Create a new form-row div
                                var row = document.createElement("div");
                                row.className = "form-row";

                                // Add the form fields
                                var batterySelect = document.createElement("select");
                                batterySelect.className = "form-select";
                                batterySelect.name = "BatteryID[]";
                                var batteryOptionNA = document.createElement("option");
                                batteryOptionNA.value = "N/A";
                                batteryOptionNA.textContent = "N/A";
                                batterySelect.appendChild(batteryOptionNA);

                                @foreach ($tbl_battery as $battery)
                                    var batteryOption = document.createElement("option");
                                    batteryOption.value = "{{ $battery->BatteryTypeID }}";
                                    batteryOption.textContent = "{{ $battery->BatteryTypeCode }}";
                                    batterySelect.appendChild(batteryOption);
                                @endforeach

                                var batteryDiv = document.createElement("div");
                                batteryDiv.className = "form-group-inline col-md-7";
                                var batteryLabel = document.createElement("label");
                                batteryLabel.htmlFor = "BatteryID";
                                batteryLabel.textContent = "Battery: ";
                                var batteryContainer = document.createElement("div");
                                batteryContainer.className = "input-container";
                                batteryContainer.appendChild(batterySelect);
                                batteryDiv.appendChild(batteryLabel);
                                batteryDiv.appendChild(batteryContainer);

                                var quantityInput = document.createElement("input");
                                quantityInput.className = "form-control form-group";
                                quantityInput.type = "number";
                                quantityInput.name = "BatteryID_quantity[]";
                                quantityInput.min = "0";
                                quantityInput.max = "10";
                                quantityInput.pattern = "[0-9]";
                                quantityInput.placeholder = "1-10";

                                var quantityDiv = document.createElement("div");
                                quantityDiv.className = "form-group col-md-2";
                                var quantityLabel = document.createElement("label");
                                quantityLabel.htmlFor = "BatteryID_quantity";
                                quantityLabel.textContent = "Quantity: ";
                                quantityDiv.appendChild(quantityLabel);
                                quantityDiv.appendChild(quantityInput);

                                row.appendChild(batteryDiv);
                                row.appendChild(quantityDiv);

                                // Create a new delete button for additional rows
                                var deleteButton = document.createElement("button");
                                deleteButton.type = "button";
                                deleteButton.className = "btn btn-danger delete-btn";
                                deleteButton.textContent = "Delete";
                                deleteButton.style.height = "100%";
                                deleteButton.style.width = "180px";
                                deleteButton.style.marginTop = "32px";
                                deleteButton.onclick = function() {
                                    deleteRow(this);
                                };
                                row.appendChild(deleteButton);

                                container.appendChild(row);
                            }
                        </script>



                        <script>
                            function deleteRow(button) {
                                var row = button.parentNode;
                                row.parentNode.removeChild(row);
                            }

                            function addRefrigerantRow() {
                                var container = document.getElementById("refrigerantRows");

                                // Create a new form-row div
                                var row = document.createElement("div");
                                row.className = "form-row";

                                // Add the form fields
                                var refrigerantSelect = document.createElement("select");
                                refrigerantSelect.className = "form-select";
                                refrigerantSelect.name = "RefrigerantID[]";
                                var refrigerantOptionNA = document.createElement("option");
                                refrigerantOptionNA.value = "N/A";
                                refrigerantOptionNA.textContent = "N/A";
                                refrigerantSelect.appendChild(refrigerantOptionNA);

                                @foreach ($tbl_refrigeranttypes as $refrigerant)
                                    var refrigerantOption = document.createElement("option");
                                    refrigerantOption.value = "{{ $refrigerant->RefrigerantTypeID }}";
                                    refrigerantOption.textContent = "{{ $refrigerant->RefrigerantCode }}";
                                    refrigerantSelect.appendChild(refrigerantOption);
                                @endforeach

                                var refrigerantDiv = document.createElement("div");
                                refrigerantDiv.className = "form-group-inline col-md-7";
                                var refrigerantLabel = document.createElement("label");
                                refrigerantLabel.htmlFor = "RefrigerantID";
                                refrigerantLabel.textContent = "Refrigerant: ";
                                var refrigerantContainer = document.createElement("div");
                                refrigerantContainer.className = "input-container";
                                refrigerantContainer.appendChild(refrigerantSelect);
                                refrigerantDiv.appendChild(refrigerantLabel);
                                refrigerantDiv.appendChild(refrigerantContainer);

                                var quantityInput = document.createElement("input");
                                quantityInput.className = "form-control form-group";
                                quantityInput.type = "number";
                                quantityInput.name = "RefrigerantID_quantity[]";
                                quantityInput.min = "0";
                                quantityInput.max = "10";
                                quantityInput.pattern = "[0-9]";
                                quantityInput.placeholder = "1-10";

                                var quantityDiv = document.createElement("div");
                                quantityDiv.className = "form-group col-md-2";
                                var quantityLabel = document.createElement("label");
                                quantityLabel.htmlFor = "RefrigerantID_quantity";
                                quantityLabel.textContent = "Quantity: ";
                                quantityDiv.appendChild(quantityLabel);
                                quantityDiv.appendChild(quantityInput);

                                row.appendChild(refrigerantDiv);
                                row.appendChild(quantityDiv);

                                // Create a new delete button for additional rows
                                var deleteButton = document.createElement("button");
                                deleteButton.type = "button";
                                deleteButton.className = "btn btn-danger delete-btn";
                                deleteButton.textContent = "Delete";
                                deleteButton.style.height = "100%";
                                deleteButton.style.width = "180px";
                                deleteButton.style.marginTop = "32px";
                                deleteButton.onclick = function() {
                                    deleteRow(this);
                                };
                                row.appendChild(deleteButton);

                                container.appendChild(row);
                            }
                        </script>


                    </div>

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="Model">Model:</label>
                            <input type="text" name="Model" class="form-control" value=""
                                placeholder="Model name">
                        </div>
                        <div class="form-group">
                            <label for="serial">Serial number:</label>
                            <input type="text" name="Serial" class="form-control" value=""
                                placeholder="Serial number">
                        </div>
                        <div class="form-group form-group-inline">
                            <label class="form-label" for="ManufacturerID_Fkey">Manufacturer: </label>
                            <br>
                            <select class="form-select" name="ManufacturerID_Fkey" id="ManufacturerID_Fkey">
                                <option value="">N/A</option>
                                @foreach ($tbl_manufacturers as $tbl_manufacturers)
                                    <option value="{{ $tbl_manufacturers->ManufacturerID }}">
                                        {{ $tbl_manufacturers->ManufacturerName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group w-75">
                            <label for="InServiceStart">In-Service Start:</label>
                            <input type="date" class="form-control" name="InServiceStart" value="">

                        </div>
                        <div class="form-group w-75">
                            <label for="InServiceEnd">In-Service End:</label>
                            <input type="date" class="form-control" name="InServiceEnd" value="">

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Equipment</button>
                    </div>
                </form>

            </div>
        </div>
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>

    <script>
        $(document).on("click", "tr[data-url]", function() {
            window.location = $(this).data("url");
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#notestable').DataTable();
            table.on('click', '.delete', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                $('#NoteID').val(data[1]);
                $('#Notes').val(data[2]);
                $('#deleteForm').attr('action', '/deleteContractnote/' + data[0]);
                $('#deleteModal ').modal('show');
            });
        });
    </script>
</body>

</html>
