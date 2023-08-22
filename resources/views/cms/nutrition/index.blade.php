@extends('cms.parent')

@section('title', __('cms.nutrition'))

@section('page_name', __('cms.index'))
@section('redirect_page', route('nutritions.index'))
@section('main_page', __('cms.nutrition'))
@section('small_page_name', __('cms.index'))

@section('styles')

@endsection

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('cms.nutrition') }}</h3>
                            <a href="{{ route('nutritions.create') }}"
                                class="btn btn-info float-right">{{ __('cms.create_nutrition') }}</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>description</th>
                                        {{--                                    <th>Sub Category</th> --}}
                                        <th>Created At</th>
                                        <th>Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nutritions as $nutrition)
                                        <tr>
                                            <td>{{ $nutrition->id }}</td>
                                            <td>{{ $nutrition->name }}</td>
                                            <td>
                                                @if ($nutrition->description != null)
                                                    {{ $nutrition->description }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($nutrition->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('nutritions.edit', [$nutrition->id]) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    {{--                                                <a href="#" onclick="confirmDelete('{{$nutrition->id}}',this)" --}}
                                                    {{--                                                   class="btn btn-danger"> --}}
                                                    {{--                                                    <i class="fas fa-trash"></i> --}}
                                                    {{--                                                </a> --}}
                                                    <form action="{{ route('nutritions.destroy', $nutrition->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-md btn-danger show-alert-delete-box"
                                                            data-toggle="tooltip" title='Delete'><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">

                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('scripts')
    @include('cms.alertScript')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, element) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id, element)
                }
            })
        }

        function performDelete(id, element) {
            axios.delete('/cms/admin/nutritions/{{ $nutrition->id }}')
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();
                })
                .catch(function(error) {
                    //4xx, 5xx
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
