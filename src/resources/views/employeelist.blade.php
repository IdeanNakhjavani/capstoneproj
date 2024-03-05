<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- CSRF Token -->
    <title>Employees List - Interior Energy & Air</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="{{ asset('css/dark-mode.css') }}" rel="stylesheet" />
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contractlist') }}"
                            data-toggle="false" role="tab" aria-controls="contractlist"
                            aria-selected="false">Contracts</a></li>
                    @if (Auth::check() && Auth::user()->user_type == '1')
                        <li class="nav-item"><a class="nav-link active" href="{{ url('/employeelist') }}" data-toggle="false"
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

        <div class="jumbotron row">
            <div class="col-md-12">
                <h3 class="text-center">
                    <b>Employees</b>
                </h3>
                <br>
                <div style="text-align: right">
                    <form action="{{ route('register') }}">
                        
                        <input type="submit" class="btn btn-success" value="+ New Employee" />
                    </form>
                </div>

                <br />
                <div class="overflow-auto">
                    <table id="employeelist" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="table-tr">
                                    <td>{{ $user->user_type ? 'Admin' : 'Regular' }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm edit" data-toggle="modal"
                                            data-target="#editModal{{ $user->id }}">Edit</a>

                                        <a href="#" class="btn btn-danger btn-sm danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $user->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($users as $user)
        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Permission?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>




                    <form action="{{ url('updateemployee/' . $user->id) }}" method="POST" id="editForm">
                        

                        <div class="modal-body">
                            <div class="form-group">
                                <b>User Name: </b>
                                <label for="exampleInputEmail1">{{ $user->username }}</label>
                            </div>
                            <div class="form-group">
                                <b>User Email: </b>
                                <label for="exampleInputEmail1">{{ $user->email }}</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="option1" name="user_type" value=0
                                    {{ $user->user_type == 0 ? 'checked' : '' }}> Regular </label>
                                <input type="radio" id="option2" name="user_type" value=1
                                    {{ $user->user_type == 1 ? 'checked' : '' }}> Admin</label>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success edit">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach

    <!--Modal 2 (delete user)-->

    @foreach ($users as $user)
        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete this employee?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('deleteemployee/' . $user->id) }}" method="POST" id="deleteForm">
                       

                        <div class="modal-body">
                            <div class="form-group">
                                <b>Username: </b>
                                <label for="exampleInputEmail1">{{ $user->username }}</label>
                            </div>
                            <div class="form-group">
                                <b>User Email: </b>
                                <label for="exampleInputEmail1">{{ $user->email }}</label>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#employeelist').DataTable();
            table.on('click', '.edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);

                $('#username').val(data[1]);
                $('#email').val(data[2]);
                $('#user_type').val(data[3]);

                $('#editForm').attr('action', '/updateemployee/' + data[0]);
                $('#editModal ').modal('show');
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#employeelist').DataTable();
            table.on('click', '.delete', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);

                $('#username').val(data[1]);
                $('#email').val(data[2]);
                $('#user_type').val(data[3]);

                $('#deleteForm').attr('action', '/deleteemployee/' + data[0]);
                $('#deleteModal ').modal('show');
            });
        });
    </script>

</body>

</html>
