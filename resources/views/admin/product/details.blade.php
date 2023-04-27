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

                            <div class="ms-5">
                                <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                            </div>

                            <div class="card-title">
                                <h3 class="text-center title-2">Pizza Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <img src="{{ asset('storage/' . $pizza->image) }}">
                                </div>
                                <div class="col-5 offset-1">
                                    <div class="my-3 btn bg-danger text-white d-block w-50 fs-5 text-center"> {{ $pizza->name }}</div>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5 fa-money-bill-wave me-2"></i> {{ $pizza->price }} kyats</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5 fa-clock me-2"></i> {{ $pizza->waiting_time }} mins</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5 fa-eye me-2"></i> {{ $pizza->view_count }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clone me-2"></i> {{ $pizza->category_name }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5 fa-user-clock me-2"></i> {{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"><i class="fa-solid fs-4 fa-envelope-open-text me-2"></i> Details</div>
                                    <div class="">{{ $pizza->description }}</div>

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
