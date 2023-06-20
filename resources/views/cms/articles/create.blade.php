@extends('cms.index')

@section('title','Dashboard')

@section('styles')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .custom-error-class {
            color: #FF0000; /* red */
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
                        <h1>Create Article</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Create Article</li>
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
                                <h3 class="card-title">Update Article</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="create_article_form" role="form" method="post"
                                      action="{{route('admin.articles.store')}}" enctype="multipart/form-data">
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
                                        <div class="col-sm-6">
                                            <!-- select -->
                                            <div class="form-group">
                                                <label>Select Category</label>
                                                <select class="form-control" name="category_id">
                                                    <option value="-1">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}"
                                                                @if(old('category_id')) @if(old('category_id') == $category->id) selected @endif @endif>{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- select -->
                                            <div class="form-group">
                                                <label>Select Auhor</label>
                                                <select class="form-control" name="author_id">
                                                    <option value="-1">Select Author</option>
                                                    @foreach($authors as $author)
                                                        <option
                                                            value="{{$author->id}}"
                                                            @if(old('author_id')) @if(old('author_id') == $author->id) selected @endif @endif>{{$author->first_name.' '.$author->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Article Title</label>
                                                <input name="article_title" value='{{old('article_title')}}'
                                                       type="text" class="form-control"
                                                       placeholder="Enter title...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Short Description</label>
                                                <textarea name="article_short_description" class="form-control" rows="3"
                                                          placeholder="Enter short description...">{{old('article_short_description')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <!-- textarea -->
                                            <div class="form-group">
                                                <label>Full Description</label>
                                                <textarea name="article_full_description" class="form-control" rows="3"
                                                          placeholder="Enter full description...">{{old('article_full_description')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <div class="form-group">
                                                <label for="customFile">Article Image</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                           @if(old('article_image')) value="{{old('article_image')}}" @endif
                                                           name="article_image">
                                                    <label class="custom-file-label" for="customFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input name="article_visibility_status" type="checkbox"
                                                   @if(old('article_visibility_status') == "on")
                                                   checked
                                                   @endif
                                                   class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1">
                                                Visibility Status
                                            </label>
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
        $.validator.addMethod("valueNotEquals", function (value, element, arg) {
            return arg != value;
        }, "Value must not equal arg.");
        $('#create_article_form').validate({
            errorClass: "custom-error-class",
            // validClass: "custom-valid-class",
            rules: {
                category_id: {
                    valueNotEquals: "-1"
                },
                author_id: {
                    valueNotEquals: "-1"
                },
                article_title: {
                    required: true,
                    minlength: 10,
                    maxlength: 50,
                },
                article_short_description: {
                    required: true,
                    minlength: 20,
                    maxlength: 150,
                },
                article_full_description: {
                    required: true,
                    minlength: 40,
                }
            },
            messages: {
                category_id: {
                    valueNotEquals: "Please, select category",
                },
                author_id: {
                    valueNotEquals: "Please, select author",
                },
                article_title: {
                    required: "Please, enter article title",
                    minlength: "Please, title must be at least 20",
                    maxlength: "Please, title must be at least 50",
                },
                article_short_description: {
                    required: "Please, enter short desc. title",
                    minlength: "Please, title must be at least 20",
                    maxlength: "Please, title must be at least 150",
                },
                article_full_description: {
                    required: "Please, enter full desc. title",
                    minlength: "Please, title must be at least 40",
                }
            }
        })
    </script>
@endsection
