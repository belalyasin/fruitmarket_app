@extends('cms.parent')

@section('title', __('cms.products'))

@section('page_name', __('cms.index'))
@section('redirect_page', route('products.index'))
@section('main_page', __('cms.products'))
@section('small_page_name', __('cms.index'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/rateYo/jquery.rateyo.min.css') }}">
@endsection

@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('cms.products') }}</h3>
                            <a href="{{ route('products.create') }}"
                                class="btn btn-info float-right">{{ __('cms.create_product') }}</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        {{--                                    <th style="width: 40px">Gender</th> --}}
                                        <th>Sub Category</th>
                                        {{--                                    <th>Description</th> --}}
                                        <th>Rate</th>
                                        <th>Created At</th>
                                        <th>Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><img src="{{ asset('images/' . $product->image) }}" alt="product image"
                                                    width="40px" height="40px"></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            {{--                                    <td><span --}}
                                            {{--                                            class="badge @if ($products->gender == 'M') bg-success @else bg-warning @endif">{{$products->gender_type}}</span> --}}
                                            {{--                                    </td> --}}
                                            <td>{{ $product->category ? $product->category->title : 'not found' }}</td>
                                            {{--                                    <td> --}}
                                            {{--                                        <a class="btn btn-app bg-info" --}}
                                            {{--                                            href="{{route('user.edit-permissions',$product->id)}}"> --}}
                                            {{--                                            <span class="badge bg-purple">{{$product->permissions_count}}</span> --}}
                                            {{--                                            <i class="fas fa-users"></i> {{__('cms.permissions')}} --}}
                                            {{--                                        </a> --}}
                                            {{--                                    </td> --}}
                                            <td>
                                                <div id="rateYo_{{ $product->id }}"></div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($product->created_at)->format('Y-m-d') }}</td>
                                            {{--                                    <td>{{$product->updated_at}}</td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    {{--                                                <a href="/cms/admin/products/{{$product->id)}}" --}}
                                                    {{--                                                   class="btn btn-danger"> --}}
                                                    {{--                                                    <i class="fas fa-trash"></i> --}}
                                                    {{--                                                </a> --}}
                                                    <form action="{{ route('products.destroy', $product->id) }}"
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
    <script src="{{ asset('cms/plugins/rateYo/rateyo.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @foreach ($products as $product)
                $("#rateYo_{{ $product->id }}").rateYo({
                    rating: {{ $product->rate }}, // Use the actual rate value
                    starWidth: "25px", // Adjust as needed
                    readOnly: true, // Disable interactivity
                });
            @endforeach
        });
    </script>

    {{--    in the first way its done --}}
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
            axios.delete('/cms/admin/products/' + id)
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
