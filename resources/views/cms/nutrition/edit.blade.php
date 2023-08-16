@extends('cms.parent')

@section('title',__('cms.dashboard'))

@section('page_name',__('cms.edit'))
@section('redirect_page', route('nutritions.index'))
@section('main_page',__('cms.nutrition'))
@section('small_page_name',__('cms.edit'))

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('cms/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('cms.edit_nutrition')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">{{__('cms.name')}}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{$nutrition->name}}"
                                           placeholder="{{__('cms.name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('cms.description')}}</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                           value="{{$nutrition->description}}"
                                           placeholder="{{__('cms.description')}}">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performStore()"
                                        class="btn btn-primary">{{__('cms.update')}}</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{asset('cms/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        function performStore() {
            // alert('Perform Store Function');
            // console.log('Perform Store - Function');
            axios.put('/cms/admin/nutritions/{{$nutrition->id}}', {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
            })
                .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    window.location.href = '/cms/admin/nutritions';
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
