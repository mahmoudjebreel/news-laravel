@extends('cms.index')

@section('title','Dashboard')

@section('styles')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('cms/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admins</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Admins</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Admins</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td>{{$admin->id}}</td>
                                        <td>{{$admin->first_name}}</td>
                                        <td>{{$admin->last_name}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->mobile}}</td>
                                        <td>{{$admin->age}}</td>
                                        <td>{{$admin->gender}}</td>
                                        @if($admin->status == 'Active')
                                            <td style="color: green">{{$admin->status}}</td>
                                        @else
                                            <td style="color: red">{{$admin->status}}</td>
                                        @endif
                                        <td>{{$admin->created_at}}</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="{{route('admins.edit',[$admin->id])}}">Edit</a>
                                                </li>
                                                @if($admin->id != Auth()->user()->id)
                                                    <li>
                                                        <a href="#" onclick="deleteAdmin('{{$admin->id}}')"
                                                           style="color: red">Delete</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Settings</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="{{asset('cms/plugins/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('cms/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('cms/dist/js/demo.js')}}"></script>
    <!-- page script -->
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>

    <script>
        function deleteAdmin(id) {
            console.log("ID: " + id);
            ///admins/{id} // admins/1
            axios.delete('/admins/' + id)
                .then(function (response) {
                    console.log(response);
                    console.log(response.data);
                    showMessage(response.data,'/admins/');
                })
                .catch(function (error) {
                    //showMessage(error.response.data);
                    if (error.response.data.errors !== undefined) {
                        // the array is defined and has at least one element
                        console.log(error.response.data.errors);
                    } else {
                        showMessage(error.response.data);
                    }
                })
                .then(function () {
                    // always executed
                });
        }

        function showMessage(data, redirectRoute) {
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.type,
                timer: 3000,
                showConfirmButton: false
            }).then(
                function () {
                    if (redirectRoute) {
                        window.location = redirectRoute;
                    }
                }
            );
        }
    </script>
@endsection
