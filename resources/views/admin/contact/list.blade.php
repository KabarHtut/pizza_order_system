@extends('admin.layouts.master')

@section('title', 'Contact_list')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">

                        <h3> Total - {{ $contact->total() }} </h3>
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($contact as $c)

                                    <tr class="tr-shadow" style="margin-bottom: 2px !important">
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->email }}</td>
                                        <td>{{ $c->message }}</td>
                                        <td>{{ $c->created_at->format('j-F-Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-5">
                           {{ $contact->links() }}
                        </div>

                    </div>

                    <!-- END DATA TABLE -->
                </div>


            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
