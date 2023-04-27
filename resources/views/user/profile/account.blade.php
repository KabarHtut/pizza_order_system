@extends('user.layouts.master')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Profile</h3>
                            </div>
                            <hr>
                            @if (session('updateSuccess'))
                                <div class="col-3 offset-8">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check"></i>{{ session('updateSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('user#update', Auth::user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-2">
                                        @if (Auth::user()->image != null)
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}"  class="img-thumbnail shadow-sm">
                                        @else
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('image/default_user.jpg') }}"
                                                    class="img-thumbnail shadow-sm" />
                                            @else
                                                <img src="{{ asset('image/female_default.webp') }}"
                                                    class="img-thumbnail shadow-sm">
                                            @endif
                                        @endif

                                        <div class="mt-3">
                                            <input type="file" name="image" id=""
                                                class="form-control @error('image') is-invalid @enderror">
                                            @error('image')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn bg-dark text-white col-12">
                                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i>Update
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text"
                                                value="{{ old('name', Auth::user()->name) }}"
                                                class="form-control @error('name') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter User Name....">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="email"
                                                value="{{ old('email', Auth::user()->email) }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter User Email....">
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number"
                                                value="{{ old('phone', Auth::user()->phone) }}"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false"
                                                placeholder="Enter User Phone....">
                                            @error('phone')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Gender</label>
                                            <select name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="">Choose gender...</option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" cols="30"
                                                rows="10" placeholder="Enter User Address">{{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role" type="text"
                                                value="{{ old('role', Auth::user()->role) }}" class="form-control"
                                                aria-required="true" aria-invalid="false" disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
