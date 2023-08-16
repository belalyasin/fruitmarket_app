@extends('cms.parent')

@section('title',__('cms.category'))

@section('page_name',__('cms.index'))
@section('redirect_page', route('categories.index'))
@section('main_page',__('cms.category'))
@section('small_page_name',__('cms.index'))

@section('styles')

@endsection

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('cms.category')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Title</th>
                                    <th>description</th>
                                    {{--                                    <th>Sub Category</th>--}}
                                    <th>Created At</th>
                                    <th>Settings</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($categories as $category)
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->title}}</td>
                                        <td>@if($category->description!=null)
                                                {{ $category->description }}
                                            @else
                                                -
                                            @endif</td>
                                        <td>{{\Carbon\Carbon::parse($category->created_at)->format('Y-m-d')}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{route('categories.edit',[$category->id])}}"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{--                                                <a href="#" onclick="confirmDelete('{{$category->id}}',this)"--}}
                                                {{--                                                   class="btn btn-danger">--}}
                                                {{--                                                    <i class="fas fa-trash"></i>--}}
                                                {{--                                                </a>--}}
                                                <form action="{{ route('categories.destroy',$category->id) }}"
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
                                    @if ($category->subCategories->isNotEmpty())
                                        <tr class="expandable-body d-none">
                                            <td colspan="5">
                                                {{--                                                <p>{{$subCategory ? $subCategory->title :"not found"}}</p>--}}
                                                @foreach($category->subCategories as $subCategory)
                                                    <div
                                                        class="col-12 d-flex align-items-stretch flex-column">
                                                        <div class="card bg-light d-flex flex-fill">
                                                            <div class="card-header text-muted border-bottom-0">
                                                                Sub Category Title
                                                            </div>
                                                            <div class="card-body pt-0">
                                                                <div class="row">
                                                                    <div class="col-7">
                                                                        <h2 class="lead">
                                                                            <b>{{$subCategory ? $subCategory->title :"not found"}}</b>
                                                                        </h2>
                                                                        <p class="text-muted text-sm"><b>Discount
                                                                                : </b> {{$subCategory->discount}}
                                                                        </p>
                                                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                            <li class="small"><span class="fa-li"><i
                                                                                        class="fas fa-lg fa-audio-description"></i></span>
                                                                                Description
                                                                            </li>
                                                                            <li class="small"><span class="fa-li"><i
                                                                                        class="fas fa-lg fa-arrow-alt-circle-right"></i></span>
                                                                                {{$subCategory->description}}
                                                                            </li>
                                                                        </ul>
                                                                        <p class="text-muted text-sm"><b>Create At
                                                                                : </b> {{\Carbon\Carbon::parse($category->created_at)->format('Y-m-d')}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <div
                                                                    class="d-flex justify-content-end align-items-end">
                                                                    <a href="{{route('categories.edit',[$subCategory->id])}}"
                                                                       class="btn btn-sm bg-teal mr-2">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('categories.destroy',$subCategory->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                                class="btn btn-sm btn-danger"
                                                                                data-toggle="tooltip"
                                                                                title='Delete'><i
                                                                                class="fas fa-trash"></i></button>
                                                                    </form>
                                                                    {{--                                                                    <a href="#" class="btn btn-sm btn-danger">--}}
                                                                    {{--                                                                        <i class="fas fa-trash"></i>--}}
                                                                    {{--                                                                    </a>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="expandable-body d-none">
                                            <td colspan="5">
                                                <div
                                                    class="col-12 d-flex align-items-stretch flex-column">
                                                    <div class="card bg-light d-flex flex-fill">
                                                        <div class="card-header text-muted border-bottom-0">
                                                            No Sub Category for this Category
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

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
        // $(function () {
        //     $('#expandable-table-header-row').ExpandableTable('toggleRow')
        // })

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
            axios.delete('/cms/admin/categories/' + id)
                .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();
                })
                .catch(function (error) {
                    //4xx, 5xx
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
