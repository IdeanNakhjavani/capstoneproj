@extends('layouts.app-master')

@section('content')
    <div class="col-md-12">
        @auth
        <h3 class="text-center">
            <b>Welcome User</b>
        </h3>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" placeholder = "Search..."> 
            <button class="btn btn-primary my-2 my-sm-0" type="submit">
                Search
            </button>
            
        </form>
        @endauth

        @guest
        <h3 class="text-center ">
            <b>Welcome</b>
        </h3>
        <form class="form-inline ">
            <input class="form-control mr-sm-2 " type="text" placeholder = "Search..."> 
            <button class="btn btn-primary my-2 my-sm-0" type="submit">
                Search
            </button>
        </form>
        @endguest
    </div>
@endsection
