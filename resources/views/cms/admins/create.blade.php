@extends('cms.index')

@section('title','Dashboard')

@section('styles')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .custom-error-class {
            color: #FF0000; /* red */
        }

        .custom-valid-class {
            color: #00CC00; /* green */
        }
    </style>
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Admin</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Admin</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Create new Admin</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="create_admin_form" role="form" method="post"
                                      action="{{route('admins.store')}}">
                                    @csrf
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(session()->has('status') && session()->has('message'))
                                        @if(session()->get('status'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{session()->get('message')}}
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @else
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{session()->get('message')}}
                                                <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input name="first_name" value='{{old('first_name')}}'
                                                       type="text" class="form-control"
                                                       placeholder="Enter first name...">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input name="last_name" value='{{old('last_name')}}'
                                                       type="text" class="form-control"
                                                       placeholder="Enter last name...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input name="email" value='{{old('email')}}'
                                                       type="email" class="form-control"
                                                       placeholder="Enter email...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input name="mobile" value='{{old('mobile')}}'
                                                       type="tel" class="form-control"
                                                       placeholder="Enter mobile...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input name="age" value='{{old('age')}}'
                                                       type="number" class="form-control"
                                                       placeholder="Enter age...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input name="password" value='{{old('password')}}'
                                                       type="password" class="form-control"
                                                       placeholder="Enter password...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="Male" type="radio"
                                                           name="gender">
                                                    <label class="form-check-label">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="Female" type="radio"
                                                           name="gender">
                                                    <label class="form-check-label">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                        <!-- general form elements disabled -->
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <!-- bs-custom-file-input -->
    <script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('cms/dist/js/demo.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>

    <script type="text/javascript" src="{{asset('js/jquery-1.11.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/additional-methods.min.js')}}"></script>

    <script>
        $('#create_admin_form').validate({
            errorClass: "custom-error-class",
            validClass: "custom-valid-class",
            rules: {
                first_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                last_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 10,
                },
                email: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                mobile: {
                    required: true,
                },
                age: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                first_name: {
                    required: "Please, enter first name",
                    minlength: "Please, name must be at min 3 characters",
                    maxlength: "Please, name must be at max 10 characters",
                },
                last_name: {
                    required: "Please, enter last name",
                    minlength: "Please, details must be at min 3 characters",
                    maxlength: "Please, name details be at max 10 characters",
                },
                email: {
                    required: "Please, enter email",
                },
                mobile: {
                    required: "Please, enter mobile",
                },
                age: {
                    required: "Please, enter age",
                },
                password: {
                    required: "Please, enter password",
                }
            }
        })
    </script>
@endsection
