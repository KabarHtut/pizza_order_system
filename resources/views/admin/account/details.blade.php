@extends('admin.layouts.master')

@section('title', 'Category_list')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7 mb-2">
                @if (session('updateSuccess'))
                <div class="">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                         {{ session('updateSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    @if (Auth::user()->image != null)
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" >
                                        @else
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('image/default_user.jpg') }}"
                                                class="img-thumbnail shadow-sm" />
                                            @else
                                                <img src="{{ asset('image/female_default.webp') }}"
                                                class="img-thumbnail shadow-sm">
                                            @endif
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3"><i class="fa-solid fa-user-tie me-2"></i>{{ Auth::user()->name }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-envelope me-2"></i>{{ Auth::user()->email }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-phone me-2"></i>{{ Auth::user()->phone }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-mars-and-venus me-2"></i>{{ Auth::user()->gender }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-address-card me-2"></i>{{ Auth::user()->address }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-user-clock me-2"></i>{{ Auth::user()->created_at->format('j-F-Y') }}</h4>
                                </div>

                                <div class="row">
                                    <div class="col-4 offset-2 mt-3">
                                        <a href="{{ route('admin#edit') }}">
                                            <button class="btn bg-dark text-white">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit Profile
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
