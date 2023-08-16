@extends('cms.parent')

@section('title',__('cms.dashboard'))

@section('page_name', __('cms.edit'))
@section('redirect_page', route('admin.admin_profile'))
@section('main_page', __('cms.profile'))
@section('small_page_name', __('cms.edit'))

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('cms/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('main-content')
    <!-- Main content -->
    <section class="content">

        <form id="edit" method="post" action="{{route('admin.update',['admin' => auth()->user()->id])}}"
              enctype="multipart/form-data" class="w-75 m-auto">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Editing</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control"
                                       value="{{ auth()->user()->name }}  " name="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control"
                                       value="{{ auth()->user()->email }}" name="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="profile_image">Upload Image</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{route('admin.admin_profile')}}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Save Changes"
                           class="btn btn-warning float-right">
                    {{--                    <button type="button" onclick="performStore()"--}}
                    {{--                            class="btn btn-primary">{{__('cms.update')}}</button>--}}
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script src="{{asset('cms/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        function performStore() {
            // alert('Perform Store Function');
            // console.log('Perform Store - Function');
            var form = document.getElementById('edit');
            var formData = new FormData(form);
            axios.put('/cms/admin/update/{{auth()->user()->id}}', formData
                //     {
                //     name: document.getElementById('name').value,
                //     email: document.getElementById('email').value,
                //     profile_image: document.getElementById('profile_image').files[0],
                // }
            )
                .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    window.location.href = '/cms/admin/profile';
                })
                .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
