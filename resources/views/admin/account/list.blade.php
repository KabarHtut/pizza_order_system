@extends('admin.layouts.master')

@section('title', 'Category_list')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    @if (session('deleteSuccess'))
                        <div class="col-3 offset-9">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-sharp fa-solid fa-xmark"></i>{{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>

                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="GET">
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search...."
                                        value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="row my-2">
                            <div class="col-1 offset-11 bg-white shadow-sm p-2 my-1 text-center">
                                <h3><i class="fa-solid fa-database"></i> {{ $admin->total() }} </h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                    <tr class="tr-shadow mb-3">

                                        <td class="col-2">
                                            @if ($a->image != null)
                                                <img src="{{ asset('storage/' . $a->image) }}">
                                            @else
                                                @if ($a->gender == 'male')
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        class="img-thumbnail shadow-sm" />
                                                @else
                                                    <img src="{{ asset('image/female_default.webp') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @endif
                                            @endif
                                        </td>
                                        <input type="hidden" id="adminId" value="{{ $a->id }}">
                                        <td>{{ $a->name }}</td>
                                        <td>{{ $a->email }}</td>
                                        <td>{{ $a->phone }}</td>
                                        <td>{{ $a->gender }}</td>
                                        <td>{{ $a->address }}</td>
                                        <td>
                                            @if (Auth::user()->id == $a->id)

                                            @else
                                            <select class="form-control statusChange">
                                                <option value="user" @if ($a->role == 'user') selected @endif >User</option>
                                                <option value="admin" @if ($a->role == 'admin') selected @endif>Admin</option>
                                            </select>
                                            @endif
                                        </td>
                                        <td>
                                             @if (Auth::user()->id == $a->id)

                                            @else
                                                <a href="{{ route('admin#delete',$a->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $admin->links() }}
                        </div>

                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            //status change
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $adminId = $parentNode.find('#adminId').val();

                $data = {
                    'adminId': $adminId,
                    'role': $currentStatus,
                  };

                 $.ajax({
                    type: 'get',
                    url: '/admin/change',
                    data: $data,
                    dataType: 'json'
                  })

                //  location.reload();
            })
        })
    </script>
@endsection
