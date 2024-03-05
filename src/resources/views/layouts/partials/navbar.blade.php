<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

<header class="p-3 ">
  <div class="container">
		<nav class="navbar navbar-expand-lg navbar-light">
			<span class="navbar-brand" href="/">
			<img alt="Bootstrap Image Preview" width="250" height="auto" src="https://interiorenergyandair.ca/wp-content/uploads/2021/09/IEA-logo.bmp">
			</span>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				<li class="nav-item active"><a class="nav-link" href="{{url('/contractlist')}}">Contracts</a></li>
        
				<li class="nav-item active"><a class="nav-link" href="{{url('/equipmentlist')}}">Equipment</a></li>

				<li class="nav-item active"><a class="nav-link" href="{{url('/employeelist')}}">Employees</a></li>

				<li class="nav-item active"><a class="nav-link active" href="{{url('/locationlist')}}">Locations</a></li>
				</ul>

        
				@auth
        {{auth()->user()->name}}
        <div class="text-end">

          <ul class="navbar-nav mr-100" style="margin-right: 100px">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="/account" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Account</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{url('/accountsettings')}}"> Settings </a>
              <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
              <a class="dropdown-item" href="{{ route('logout.perform') }}"> Log Out </a>
              </div>
            </li>
          </ul>

          
          
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-dark me-2">Login</a>
        </div>
      @endguest

			</div>
		</nav>
	</div>

</header>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
	