<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <title>View Equipment - Interior Energy & Air</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href={{ URL::asset('css/dark-mode.css') }} rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <style>
        @media (max-width: 768px) {
            .refrigerant-mobile {
                display: inline-block;
            }

            .refrigerant-desktop {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .refrigerant-mobile {
                display: none;
            }

            .refrigerant-desktop {
                display: inline-block;
            }
        }
    </style>
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

        <br>
        <br>
        <div class="jumbotron row">
            <div class="col-md-12">
                <h5>
                    <b><label for="formFileMultiple" class="form-label">Upload Photos</label></b>
                </h5>
                @foreach ($tbl_equipment as $tbl_equipment)
                    <form action="{{ url('image-upload/' . $tbl_equipment->EquipmentID) }}" method="POST"
                        enctype="multipart/form-data">
                @endforeach


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
                <br>


                <div class="row">

                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner ">
                                @foreach ($tbl_images as $tbl_images)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <div class="slider-image text-center">
                                            <img src="{{ url('../images/' . $tbl_images->ImagePath) }}"
                                                class="d-block w-100" alt="">
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

                    </div>
                    <div class="col-md-3">
                    </div>

                </div>


            </div>
            <br>

            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST"
                    action="{{ url('/updateequipment/' . $tbl_equipment->EquipmentID) }}">
                    @method('PUT')
                    <br>
                    <h3 class="text-center">
                        <b>Equipment Details</b>
                    </h3>
                    <br>
                    <div class="row">
                        <div class="col-md-7">
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
                                        style="margin-top: 8px;" onclick="addBatteryRow()">+ Battery
                                    </button>
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm refrigerant-desktop"
                                        onclick="addRefrigerantRow()" style="margin-top: 8px;">+ Refrigerant
                                    </button>
                                    <button type="button"
                                        class="form-control form-group btn btn-outline-primary btn-sm refrigerant-mobile"
                                        onclick="addRefrigerantRow()" style="margin-top: 8px;">+ Refrig.
                                    </button>
                                </div>
                            </div>
                            <div id="filterRows">
                                @foreach ($tbl_contractequipment_filter as $filter)
                                    <div class="form-row">
                                        <div class="form-group-inline col-md-7">
                                            <b><label for="filterID">Filter: </label></b>
                                            <div class="input-container">
                                                <select class="form-select"
                                                    name="filterData[{{ $filter->ContractEquipmentID }}][filterID]">
                                                    <option value="N/A">N/A</option>
                                                    @foreach ($tbl_filter as $filterOption)
                                                        <option value="{{ $filterOption->FilterTypeID }}"
                                                            {{ $filter->filterID_Fkey == $filterOption->FilterTypeID ? 'selected' : '' }}>
                                                            {{ $filterOption->FilterType }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="filterID_quantity">Quantity: </label>
                                            <input class="form-control form-group" type="number"
                                                name="filterData[{{ $filter->ContractEquipmentID }}][quantity]"
                                                min="0" max="10" pattern="[0-10]" placeholder="1-10"
                                                value="{{ $filter->filter_quantity }}">
                                        </div>

                                        <button class="btn btn-danger delete-filter"
                                            data-filter-id="{{ $filter->ContractEquipmentID }}"
                                            style="height: 38px; margin-top: 32px;">Delete</button>

                                    </div>
                                @endforeach
                            </div>



                            <div id="beltRows">
                                @foreach ($tbl_contractequipment_belt as $tbl_contractequipment_belt)
                                    <div class="form-row">
                                        <div class="form-group-inline col-md-7">
                                            <b><label for="beltID">Belt: </label></b>
                                            <div class="input-container">
                                                <select class="form-select"
                                                    name="beltID[{{ $tbl_contractequipment_belt->ContractEquipmentID }}][beltID]">
                                                    <option value="N/A">N/A</option>
                                                    @foreach ($tbl_belt as $belt)
                                                        <option value="{{ $belt->BeltID }}"
                                                            {{ $tbl_contractequipment_belt->beltID_Fkey == $belt->BeltID ? 'selected' : '' }}>
                                                            {{ $belt->BeltType }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="belt_quantity">Quantity: </label>
                                            <input class="form-control form-group" type="number"
                                                name="beltID[{{ $tbl_contractequipment_belt->ContractEquipmentID }}][belt_quantity]"
                                                min="0" max="10" pattern="[0-10]" placeholder="1-10"
                                                value={{ $tbl_contractequipment_belt->belt_quantity }}>
                                        </div>
                                        <button class="btn btn-danger delete-filter"
                                            data-filter-id="{{ $tbl_contractequipment_belt->ContractEquipmentID }}"
                                            style="height: 38px; margin-top: 32px;">Delete</button>
                                    </div>
                                @endforeach
                            </div>
                            <div id="batteryRows">
                                @foreach ($tbl_contractequipment_battery as $tbl_contractequipment_battery)
                                    <div class="form-row">
                                        <div class="form-group-inline col-md-7">
                                            <b><label for="batteryID">Battery: </label></b>
                                            <div class="input-container">
                                                <select class="form-select"
                                                    name="batteryID[{{ $tbl_contractequipment_battery->ContractEquipmentID }}][batteryID]">
                                                    <option value="N/A">N/A</option>
                                                    @foreach ($tbl_battery as $battery)
                                                        <option value="{{ $battery->BatteryTypeID }}"
                                                            {{ $tbl_contractequipment_battery->battery_FKey == $battery->BatteryTypeID ? 'selected' : '' }}>
                                                            {{ $battery->BatteryTypeCode }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="battery_quantity">Quantity: </label>
                                            <input class="form-control form-group" type="number"
                                                name="batteryID[{{ $tbl_contractequipment_battery->ContractEquipmentID }}][battery_quantity]"
                                                min="0" max="10" pattern="[0-10]" placeholder="1-10"
                                                value={{ $tbl_contractequipment_battery->battery_quantity }}>
                                        </div>
                                        <button class="btn btn-danger delete-filter"
                                            data-filter-id="{{ $tbl_contractequipment_battery->ContractEquipmentID }}"
                                            style="height: 38px; margin-top: 32px;">Delete</button>
                                    </div>
                                @endforeach
                            </div>
                            <div id="refrigerantRows">
                                @foreach ($tbl_contractequipment_refrigerant as $tbl_contractequipment_refrigerant)
                                    <div class="form-row">
                                        <div class="form-group-inline col-md-7">
                                            <b><label for="refrigerantid">Refrigerant: </label></b>
                                            <div class="input-container">
                                                <select class="form-select"
                                                    name="refrigerantid[{{ $tbl_contractequipment_refrigerant->ContractEquipmentID }}][refrigerantid]">
                                                    <option value="N/A">N/A</option>
                                                    @foreach ($tbl_refrigeranttypes as $refrigerant)
                                                        <option value="{{ $refrigerant->RefrigerantTypeID }}"
                                                            {{ $tbl_contractequipment_refrigerant->refrigeranttypes_Fkey == $refrigerant->RefrigerantTypeID ? 'selected' : '' }}>
                                                            {{ $refrigerant->RefrigerantCode }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="belt_quantity">Quantity: </label>
                                            <input class="form-control form-group" type="number"
                                                name="refrigerantid[{{ $tbl_contractequipment_refrigerant->ContractEquipmentID }}][quantity]"
                                                min="0" max="10" pattern="[0-10]" placeholder="1-10"
                                                value={{ $tbl_contractequipment_refrigerant->refri_quantity }}>
                                        </div>
                                        <button class="btn btn-danger delete-filter"
                                            data-filter-id="{{ $tbl_contractequipment_refrigerant->ContractEquipmentID }}"
                                            style="height: 38px; margin-top: 32px;">Delete</button>
                                    </div>
                                @endforeach
                            </div>
                            <div id="filterRows1">
                            </div>
                            <div id="beltRows">
                                <div class="form-row">

                                </div>
                            </div>
                            <div id="refrigerantRows">
                                <div class="form-row">
                                </div>

                            </div>
                            <div id="batteryRows">
                                <div class="form-row">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-5">
                            <div class="form-group w-75">
                                <label for="unitid">Unit ID:</label>
                                <input type="text" name="UnitID" class="form-control"
                                    value="{{ $tbl_equipment->UnitID }}">
                            </div>
                            <div class="form-group w-75">
                                <label for="LocationRoom">Location/Room:</label>
                                <input type="text" name="LocationRoom" class="form-control"
                                    value="{{ $tbl_equipment->LocationRoom }}">
                            </div>
                            <div class="form-group w-75">
                                <label for="Model">Model:</label>
                                <input type="text" name="Model" class="form-control"
                                    value="{{ $tbl_equipment->Model }}">
                            </div>
                            <div class="form-group w-75">
                                <label for="serial">Serial number:</label>
                                <input type="text" name="Serial" class="form-control"
                                    value="{{ $tbl_equipment->Serial }}">
                            </div>
                            <div class="form-group-inline">
                                <label class="form-label" for="ManufacturerID_Fkey">Manufacturer: </label>
                                <br>
                                <select class="form-select w-75" name="ManufacturerID_Fkey" id="ManufacturerID_Fkey">
                                    @foreach ($tbl_manufacturers as $tbl_manufacturers)
                                        <option value="{{ $tbl_manufacturers->ManufacturerID }}"
                                            {{ $tbl_equipment->ManufacturerID_Fkey == $tbl_manufacturers->ManufacturerID ? 'selected' : '' }}>
                                            {{ $tbl_manufacturers->ManufacturerName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group w-75">
                                <label for="InServiceStart">In-Service Start:</label>
                                <input type="date" class="form-control" name="InServiceStart"
                                    value="{{ Carbon\Carbon::parse($tbl_equipment->InServiceStart)->format('Y-m-d') }}">

                            </div>
                            <div class="form-group w-75">
                                <label for="InServiceEnd">In-Service End:</label>
                                <input type="date" class="form-control" name="InServiceEnd"
                                    value="{{ Carbon\Carbon::parse($tbl_equipment->InServiceEnd)->format('Y-m-d') }}">

                            </div>

                            <table class="table table-sm table-hover table-bordered" style="text-align:center">
                                <thead>
                                    <tr>
                                        <th colspan="3">
                                            <h5><b>Internal Notes</b>
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

                                    @foreach ($tbl_notes as $tbl_notes)
                                        <tr class="table-tr" style="text-align:center">
                                            <td>
                                                {{ $tbl_notes->Notes }}
                                            </td>
                                            <td>
                                                {{ Carbon\Carbon::parse($tbl_notes->RecordDate)->format('d/m/Y') }}
                                            </td>
                                            <td><a href="#" class="btn btn-danger btn-sm danger"
                                                    data-toggle="modal"
                                                    data-target="#deleteModal{{ $tbl_notes->NoteID }}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-lg btn-success">Update changes</button>
                    </div>
            </div>
        </div>


        </form>


        <div class="jumbotron row">
            <div class="modal-content">
                <form action="{{ url('insertnotesequipment/' . $tbl_equipment->EquipmentID) }}" method="post"
                    class="form-group" style="width:70%; margin-left:15%;">
                    @method('PUT')
                    @csrf
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
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this ?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="{{ url('/deleteequiptype') }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="filterId" id="deleteFilterId" value="">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Capture the click event on the delete filter button
        $(document).on('click', '.btn-delete-filter', function() {
            var filterId = $(this).data('filter-id');

            // Remove the filter row from the DOM
            $(this).closest('.form-row').remove();

            // Store the deleted filter ID in the hidden input field
            var deletedFilters = $('#deletedFilters').val();
            if (deletedFilters === '') {
                deletedFilters = filterId;
            } else {
                deletedFilters += ',' + filterId;
            }
            $('#deletedFilters').val(deletedFilters);
        });
    </script>
    <script>
        // Get all delete buttons
        var deleteButtons = document.querySelectorAll('.delete-filter');

        // Attach click event listener to each delete button
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Get the filter ID from the data attribute
                var filterId = button.getAttribute('data-filter-id');

                // Show confirmation modal
                $('#deleteModal').modal('show');

                // Set the filter ID as the value of the hidden input field in the modal
                $('#deleteFilterId').val(filterId);
            });
        });
    </script>

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
            filterLabel.innerHTML = "<b>Filter:</b> ";

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
            deleteButton.style.width = "73px";
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
            beltLabel.innerHTML = "<b>Belt:</b> ";
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
            deleteButton.style.width = "73px";
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
            batteryLabel.innerHTML = "<b>Battery:</b> ";
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
            deleteButton.style.width = "73px";
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
            refrigerantLabel.innerHTML = "<b>Refrigerant:</b> ";
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
            deleteButton.style.width = "73px";
            deleteButton.style.marginTop = "32px";
            deleteButton.onclick = function() {
                deleteRow(this);
            };
            row.appendChild(deleteButton);

            container.appendChild(row);
        }
    </script>



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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>

</body>

</html>
