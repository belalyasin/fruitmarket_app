@extends('cms.parent')

@section('title',__('cms.dashboard'))

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
                            <h3 class="card-title">{{__('cms.edit_sub_category')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">{{__('cms.title')}}</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{$subCategory->title}}"
                                           placeholder="{{__('cms.title')}}">
                                </div>
                                <div class="form-group">
                                    <label for="discount">{{__('cms.discount')}}</label>
                                    <input type="number" class="form-control" id="discount" name="discount"
                                           value="{{$subCategory->discount}}"
                                           placeholder="{{__('cms.discount')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('cms.description')}}</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                           value="{{$subCategory->description}}"
                                           placeholder="{{__('cms.description')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('cms.category')}}</label>
                                    <select class="form-control cities" style="width: 100%;" id="parent_id">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}"
                                                    @if($subCategory->parent_id == $category->id) selected @endif>{{$category->title}}</option>
                                        @endforeach
                                    </select>
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
            axios.put('/cms/admin/subCategories/{{$subCategory->id}}', {
                title: document.getElementById('title').value,
                discount: document.getElementById('discount').value,
                description: document.getElementById('description').value,
                parent_id: document.getElementById('parent_id').value,
            })
                .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    window.location.href = '/cms/admin/subCategories';
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
