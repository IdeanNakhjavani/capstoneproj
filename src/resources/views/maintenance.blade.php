<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <title>Maintenance - Interior Energy & Air</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">


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
                <ul class="nav nav-tabs mr-auto" role="tablist" id="myTab">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contractlist') }}" data-toggle="false"
                            role="tab" aria-controls="contractlist" aria-selected="false">Contracts</a></li>
                    @if (Auth::check() && Auth::user()->user_type == '1')
                        <li class="nav-item"><a class="nav-link" href="{{ url('/employeelist') }}" data-toggle="false"
                                role="tab" aria-controls="employeelist" aria-selected="false">Employees</a>
                        </li>
                        <li class="nav-item"><a class="nav-link active" href="{{ url('/maintenance') }}"
                                data-toggle="false" role="tab" aria-controls="employeelist"
                                aria-selected="true">Maintenance</a>
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

        <div class="jumbotron">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">
                        <b>System Maintenance</b>
                    </h3><br>
                    <div class="row">
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-10">
                            <form action="/insertmanufacturers" method="post" class="form-group"
                                style="width:70%; margin-left:15%;">
                                @method('PUT')
                                @csrf
                                <div class="card text-white bg-info text-center">
                                    <h5 class="card-header">
                                        <b>Manufacturers</b>
                                    </h5>
                                    <div class="card-body">
                                        <table id="manufacturers" style="color:#e9ecef;"
                                            class="table table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        Manufacturer Name
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tbl_manufacturers as $manufacturers)
                                                    <tr class="">
                                                        <td>
                                                            {{ $manufacturers->ManufacturerName }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="card-footer" style="background-color: #117a8d8d">
                                            <h5 class="card-body">
                                                <b>Add Manufacturer</b>
                                            </h5>
                                            <div class="d-flex justify-content-center">
                                                <form role="form">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                name="ManufacturerName" value=""
                                                                placeholder="Manufacturer name" style="width: 250px;">
                                                        </div>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <div class="col">
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="submit" class="btn btn-success">
                                                                Submit
                                                            </button>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </form>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        All manufacturers stored in database
                                    </div>
                                </div>
                            </form>

                            <br>
                            <br>


                            <form action="/insert" method="post" class="form-group"
                                style="width:70%; margin-left:15%;">
                                @method('PUT')
                                @csrf
                                <div class="card text-black bg-outline-primary text-center">
                                    <h5 class="card-header">
                                        <b>Battery Types</b>
                                    </h5>
                                    <div class="card-body">
                                        <table id="Battery"
                                            class="table text-center table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        Battery Type Code
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tbl_battery as $battery)
                                                    <tr class="">
                                                        <td>
                                                            {{ $battery->BatteryTypeCode }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="card-footer" style="background-color: rgba(195, 194, 194, 0.388)">
                                            <h5 class="card-body">
                                                <b>Add Battery Type</b>
                                            </h5>
                                            <div class="d-flex justify-content-center">
                                                <form role="form">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                name="BatteryType" placeholder="Battery type"
                                                                value="" style="width: 300px;">
                                                        </div>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <div class="col">
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="submit" class="btn btn-success"
                                                                style="border: 1px solid black;">
                                                                Submit
                                                            </button>
                                                        </div>
                                                        <br>
                                                    </div>

                                                </form>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        All types of batteries stored in database
                                    </div>
                                </div>
                            </form>
                            <br>
                            <br>

                            <form action="/insertfilter" method="post" class="form-group"
                                style="width:70%; margin-left:15%;">
                                @method('PUT')
                                @csrf
                                <div class="card text-white bg-success text-center">
                                    <h5 class="card-header">
                                        <b>Filter Types</b>
                                    </h5>
                                    <div class="card-body">
                                        <table id="Filter"
                                            class="table text-white table-sm table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        Filter Type
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tbl_filter as $filter)
                                                    <tr class="">
                                                        <td>
                                                            {{ $filter->FilterType }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <div class="card-footer" style="background-color: #22743068">
                                            <h5 class="card-body">
                                                <b>Add Filter Type</b>
                                            </h5>
                                            <div class="d-flex justify-content-center">
                                                <form role="form">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                name="FilterType" value=""
                                                                placeholder="Filter type" style="width: 300px;">
                                                        </div>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <div class="col">
                                                            &nbsp;&nbsp;&nbsp;
                                                            <button type="submit" class="btn btn-warning"
                                                                style="border: 1px solid black;">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="card-footer">
                                            All types of filters stored in database
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <br>
                                <form action="/insert2" method="post" class="form-group"
                                    style="width:70%; margin-left:15%;">
                                    @method('PUT')
                                    @csrf
                                    <div class="card text-white bg-danger text-center">
                                        <h5 class="card-header">
                                            <b>Refrigerant Types</b>
                                        </h5>
                                        <div class="card-body">
                                            <table id="Refrigeration"
                                                class="table text-white table-sm table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Refrigerant Model
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tbl_refrigeranttypes as $refrigerant)
                                                        <tr class="">
                                                            <td>
                                                                {{ $refrigerant->RefrigerationModel }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="card-footer" style="background-color: #91212c8d">
                                                <h5 class="card-body">
                                                    <b>Add Refrigerant Type</b>
                                                </h5>
                                                <div class="d-flex justify-content-center">
                                                    <form role="form">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="text" class="form-control"
                                                                    name="RefrigerationModel" value=""
                                                                    placeholder="Refrigerant Type"
                                                                    style="width: 300px;">
                                                            </div>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <div class="col">
                                                                &nbsp;&nbsp;&nbsp;
                                                                <button type="submit" class="btn btn-success">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </form>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            All types of refrigerant types stored in database
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <br>

                                <form action="/insertlocation" method="post" class="form-group"
                                    style="width:70%; margin-left:15%;">
                                    @method('PUT')
                                    @csrf
                                    <div class="card text-black bg-warning text-center">
                                        <h5 class="card-header">
                                            <b>Cities</b>
                                        </h5>
                                        <div class="card-body">
                                            <table id="location"
                                                class="table text-black table-sm table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            City
                                                        </th>
                                                        <th>
                                                            Province
                                                        </th>
                                                        <th>
                                                            Country
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tbl_locations as $location)
                                                        <tr class="">
                                                            <td>
                                                                {{ $location->City }}
                                                            </td>
                                                            <td>
                                                                {{ $location->ProvinceName }}
                                                            </td>
                                                            <td>
                                                                {{ $location->CountryName }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="card-footer" style="background-color: #98750282">
                                                <h5 class="card-body">
                                                    <b>Add a city</b>
                                                </h5>
                                                <div style="text-align:left">
                                                    <form role="form">
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="City"
                                                                value="" placeholder="City">
                                                        </div>
                                                        <br>
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                name="ProvinceName" value=""
                                                                placeholder="Province">
                                                        </div>
                                                        <br>
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                name="CountryName" value=""
                                                                placeholder="Country">
                                                        </div>
                                                        <div class="col">
                                                            <br>
                                                            <button type="submit" class="btn btn-success">
                                                                Submit
                                                            </button>
                                                        </div>
                                                        <br>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            All cities stored in database
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <br>
                                <form action="/updateprice" method="post" class="form-group"
                                    style="width:70%; margin-left:15%;">
                                    @method('PUT')
                                    @csrf
                                    <div class="card text-white bg-danger text-center">
                                        <h5 class="card-header">
                                            <b>Price Percent Setting</b>
                                        </h5>
                                        <div class="card-body">
                                            <table id="price"
                                                class="table text-white table-sm table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Current Increment %
                                                        </th>
                                                        <th>
                                                            Current Discount %
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tbl_price as $tbl_price)
                                                        <tr class="">
                                                            <td>
                                                                {{ $tbl_price->IncrementPercent }}%
                                                            </td>
                                                            <td>
                                                                {{ $tbl_price->Discounts }}%
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="card-footer" style="background-color: #91212c8d">
                                                <h5 class="card-body">
                                                    <b>Change Price</b>
                                                </h5>
                                                <div class="d-flex justify-content-center">
                                                    <form role="form">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="text" class="form-control"
                                                                    name="IncrementPercent"
                                                                    value="{{ $tbl_price->IncrementPercent }}"
                                                                    placeholder="Increment %">

                                                            </div>
                                                            <div class="col">
                                                                <input type="text" class="form-control"
                                                                    name="Discounts"
                                                                    value="{{ $tbl_price->Discounts }}"
                                                                    placeholder="Discount %">

                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-success">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        <div class="col-md-1">

                        </div>
                    </div>

                </div>



            </div>
        </div>
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="js/dark-mode-switch.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#Battery, #Refrigeration, #Filter, #manufacturers, #location,#price').dataTable();
        });
        $("#Battery").dataTable({
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        });
    </script>
</body>

</html>
