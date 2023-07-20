@extends('cms.parent')

@section('title', __('cms.dashboard'))

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
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
                            <h3 class="card-title">{{ __('cms.create_product') }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="create-form" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{ __('cms.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="{{ __('cms.name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">{{ __('cms.price') }}</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        placeholder="{{ __('cms.price') }}">
                                </div>
                                <div class="col-sm-12">
                                    {{-- <span class="irs irs--flat js-irs-2">
                                        <span class="irs"><span class="irs-line"tabindex="0"></span>
                                            <span class="irs-min" style="visibility: hidden;">0</span>
                                            <span class="irs-max" style="visibility: visible;">5</span>
                                            <span class="irs-from" style="visibility: hidden;">0</span>
                                            <span class="irs-to" style="visibility: hidden;">0</span>
                                            <span class="irs-single" style="left: -1.60581%;">0</span>
                                        </span> --}}
                                    {{-- <span class="irs-grid"></span>
                                        <span class="irs-bar irs-bar--single" style="left: 0px; width: 1.35227%;"></span>
                                        <span class="irs-shadow shadow-single" style="display: none;"></span>
                                        <span class="irs-handle single" style="left: 0%;">
                                            <i></i>
                                            <i></i>
                                            <i></i>
                                        </span>
                                    </span> --}}
                                    <label for="range_5">{{ __('cms.rate') }}</label>
                                    <input id="range_5" type="text" name="range_5" value="0"
                                        class="irs-hidden-input" tabindex="-1" readonly="" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('cms.description') }}</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                        placeholder="{{ __('cms.description') }}">
                                </div>
                                <div class="form-group">
                                    <label for="customFile">{{__('cms.image')}}</label>

                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="image" name="image">
                                      <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                  </div>

                                <div class="form-group">
                                    <label for="category_id">{{ __('cms.subcategory') }}</label>
                                    <select class="form-control subCategories" style="width: 100%;" id="category_id" name="category_id">
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}">{{ $subCategory->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" data-select2-id="30">
                                    <label>{{__('cms.nutrients')}}</label>
                                    <div class="select2-purple" data-select2-id="29">
                                        <select id="nutrients-select" class="select2 select2-hidden-accessible"
                                            multiple="multiple" name="nutrients[]" data-placeholder="Select a Nutrients"
                                            data-dropdown-css-class="select2-blue" style="width: 100%;" data-select2-id="15"
                                            tabindex="-1" aria-hidden="true">
                                            @foreach ($nutrients as $nutrient)
                                                <option value="{{ $nutrient->id }}">{{ $nutrient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="performStore()"
                                    class="btn btn-primary">{{ __('cms.save') }}</button>
                                    {{-- <input type="submit" value="{{ __('cms.save') }}" class="btn btn-primary"> --}}
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
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script src="{{ asset('cms/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script>
        $(function() {

            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            // $('.select2').select2();
            $('.subCategories').select2({
                theme: 'bootstrap4'
            });
            $('.nutrients').select2({
                theme: 'bootstrap4'
            });
            $('.js-example-basic-multiple').select2({
                theme: 'bootstrap4'
            });
            bsCustomFileInput.init();
            $('.slider').bootstrapSlider();

            $('#range_5').ionRangeSlider({
                min: 0,
                max: 5,
                type: 'single',
                step: 1,
                prettify: false,
                hasGrid: true
            })
            // $(document).ready(function() {
            //     $('.js-example-basic-multiple').select2();
            // });
        });

        function performStore() {
            // alert('Perform Store Function');
            // console.log('Perform Store - Function');
            // var selectedNutrients = $('#nutrients-select').val();
            console.log(document.getElementById('image').files[0]);
            var form = document.getElementById('create-form');
            var formData = new FormData(form);
            // var selectedNutrients = $('#nutrients-select').val();
            // formData.set('nutrients', selectedNutrients);
            console.log(formData);
            // axios.post('/cms/admin/products/store', formData)
            axios.post('/cms/admin/products', formData)
            // axios.post('/cms/admin/product/store', {
            //         name: document.getElementById('name').value,
            //         price: document.getElementById('price').value,
            //         range_5: document.getElementById('range_5').value,
            //         description: document.getElementById('description').value,
            //         image: document.getElementById('image').files[0],
            //         sub__category_id: document.getElementById('sub__category_id').value,
            //         nutrients: selectedNutrients,
            //     })
                .then(function(response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('create-form').reset();
                    window.location.href = '/cms/admin/products'
                })
                .catch(function(error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }
    </script>
@endsection
