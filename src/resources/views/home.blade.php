<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <title>Home - Interior Energy & Air</title>
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
                <ul class="nav nav-tabs mr-auto" role="tablist" id="myTab">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contractlist') }}" data-toggle="false"
                            role="tab" aria-controls="contractlist" aria-selected="true">Contracts</a></li>
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
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
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

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        @if (count($contracts) > 0)
                            <div class="payment-reminder">
                                <p>Reminder: The following contracts need to be paid next month:</p>
                                <ul>
                                    @foreach ($contracts as $contract)
                                        <li>{{ $contract }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @auth
                            <h3 class="text-center">
                                <b>Hello {{ auth()->user()->username }}!</b>
                            </h3>

                        </div>
                        @if (Auth::check() && Auth::user()->user_type == '1')
                            <div class="col-md-1">
                            </div>

                            <div class="col-md-5 text-center">
                                <a class="btn btn-success btn-lg btn-block font-weight-bold mt-3"
                                    href="{{ url('/BillMonthPDF') }}" target="_blank" style="padding: 34px;">Monthly
                                    Billing Report</a>
                            </div>
                            <div class="col-md-5 text-center">
                                <a class="btn btn-info btn-lg btn-block font-weight-bold mt-3"
                                    href="{{ url('/EquipmentCheckPDF') }}" target="_blank"
                                    style="padding: 34px;">Monthly Equipment
                                    Report</a>
                            </div>

                            <div class="col-md-1">
                            </div>
                        @endif
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-5">

                            <br>
                            @if (Session::has('message'))
                                <p class="alert alert-info">{{ Session::get('message') }}</p>
                            @endif

                            <div class="card text-white bg-primary text-center">
                                <div class="card-body">
                                    <form action="{{ url('/contractlist') }}">
                                        <input type="submit" class="btn btn-primary btn-block btn-lg"
                                            value="Contracts" />
                                    </form>
                                </div>
                                <div class="card-footer">
                                    Access all contracts
                                </div>
                            </div>
                            <br>
                            @if (Auth::check() && Auth::user()->user_type == '1')
                                <div class="card bg-warning text-center">
                                    <div class="card-body">
                                        <form action="{{ url('/maintenance') }}">

                                            <input type="submit" class="btn btn-warning text-white btn-block btn-lg"
                                                value="System Maintenance" />
                                        </form>
                                    </div>
                                    <div class="card-footer text-white">
                                        Adjust System Settings
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-md-5">
                            <br>

                            @if (Auth::check() && Auth::user()->user_type == '1')
                                <div class="card text-white bg-dark text-center">
                                    <div class="card-body">
                                        <form action="{{ url('/employeelist') }}">

                                            <input type="submit" class="btn btn-dark btn-block btn-lg"
                                                value="Employees" />
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        Manage employees
                                    </div>
                                </div>
                                <br>
                            @endif


                            <div class="card bg-danger text-center">
                                <div class="card-body">
                                    <form action="{{ url('/Accountsetting') }}">


                                        <input type="submit" class="btn btn-danger text-white btn-block btn-lg"
                                            value="Account Settings" />
                                    </form>
                                </div>
                                <div class="card-footer text-white">
                                    Adjust Account Settings
                                </div>
                            </div>
                            <br>
                        @endauth
                    </div>
                    <div class="col-md-1">
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
    <script src="js/dark-mode-switch.min.js"></script>
</body>

</html>
