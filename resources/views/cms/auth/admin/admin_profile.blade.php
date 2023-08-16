@extends('cms.parent')
@section('title',__('cms.dashboard'))

@section('page_name', __('cms.profile'))
@section('redirect_page', route('dashboard'))
@section('main_page', __('cms.home'))
@section('small_page_name', __('cms.admin_profile'))
@section('main-content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 m-auto">
                    <div class="card card-secondary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{asset('images/'.auth()->user()->profile_image)}}" alt="Admin profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                            {{--                            <p class="text-muted text-center">Software Engineer</p>--}}

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">

                                    <b>Name</b> <a class="float-right">{{ auth()->user()->name }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                                </li>

                            </ul>

{{--                            <a href="#" class="btn btn-primary btn-block"><b>Edit</b></a>--}}
                            {{--                            <a href="{{ route('user.edit_admin_profile', auth()->user()->id) }}"--}}
                            {{--                               class="btn btn-primary btn-block"><b>Edit</b></a>--}}
                        </div>
                        <!-- /.card-body -->
{{--                        <div class="card-footer p-3 bg-secondary border-bottom-5">--}}
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="{{ route('edit_admin_profile', auth()->user()->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <!-- Profile Image -->
@endsection
