<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
    <title>Building List - Interior Energy & Air</title>
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
                <ul class="navbar-nav mr-auto">
					@if ( Auth::check() && Auth::user()->user_type == '1' )
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/contractlist') }}">Contracts</a></li>
					@endif 
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/equipmentlist') }}">Equipment</a>
                    </li>

					@if ( Auth::check() && Auth::user()->user_type == '1' )
                    <li class="nav-item active"><a class="nav-link" href="{{ url('/employeelist') }}">Employees</a></li>
					@endif
					
                    <li class="nav-item"><a class="nav-link" href="{{ url('/Buildinglist') }}">Locations</a></li>
                </ul>

				@auth 
                <ul class="navbar-nav mr-100" style="margin-right: 100px">
          
					<li class="nav-item dropdown" >
					  
					<p style="text-align: center;"> {{auth()->user()->Fname}}</p>  
					  <a class="nav-link dropdown-toggle" href="/account" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Account</a>
					  
					  
					  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						
					  <a class="dropdown-item"> {{auth()->user()->username}} </a>
					  <a class="dropdown-item" href="{{url('/maintenance')}}"> Maintenance </a>
					  <a class="dropdown-item" href="{{ route('logout.perform') }}"> Log Out </a>
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
	<div class="jumbotron row">
		<div class="col-md-12">
			<h3 class="text-center">
				<b>Locations</b>
			</h3>
			<div style="text-align:right">
				<form action="{{url('/createBuilding')}}">
                    
							
					<input type="submit" class="btn btn-success" value="+ New Building"/>
				</form>
			</div>
			<br>
			<table id = "location" class="table table-hover table-sm">
				<thead>
					<tr>
						<th>ID</th>
						<th>Company </th>
						<th>Building Address</th>
						<th>Building Description</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tbl_buildings as $tbl_buildings)
						<tr class="table-tr" data-url="{{ url('/viewlocation/' . $tbl_buildings->BuildingID) }}">
							<td>{{ $tbl_buildings->BuildingID }}</td>
							<td>{{ $tbl_buildings-> CompanyName}}</td>
							<td>{{ $tbl_buildings-> BuildingAddress }}</td>
							<td>{{ $tbl_buildings-> BuildingDesc }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
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
        $(document).on("click", "tr[data-url]", function() {
            window.location = $(this).data("url");
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#location').dataTable();
        });
        $("#location").dataTable({
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }]
        });
    </script>
</body>

</html>