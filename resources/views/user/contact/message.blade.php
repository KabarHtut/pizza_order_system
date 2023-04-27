@extends('user.layouts.master')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-4 offset-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact</h3>
                            </div>
                            @if (session('sentSuccess'))
                                <div class="col-12">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check"></i> {{ session('sentSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <form action="{{ route('user#sent') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="name" type="text" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Enter Name....">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Email</label>
                                    <input id="cc-pament" name="email" type="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Enter Email....">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="control-label mb-1">Message</label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="" cols="30"
                                        rows="10" placeholder="Enter Message....">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button id="sentBtn" type="submit" class="btn btn-lg btn-dark text-white btn-block">
                                    <span id="payment-button-amount">Sent</span>
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
