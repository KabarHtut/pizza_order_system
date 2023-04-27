@extends('admin.layouts.master')

@section('title', 'Products_list')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <form action="{{ route('admin#changeStatus') }}" method="get" class="col-5">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-database me-2"></i> {{ count($order) }}
                                </span>
                            </div>
                            <select name="orderStatus" class="custom-select" id="inputGroupSelect02">
                                <option value="all">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm ms-3 bg-dark text-white"><i
                                        class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $o)
                                    <tr class="tr-shadow" style="margin-bottom: 2px !important">
                                        <input type="hidden" class="orderId" value="{{ $o->id }}">
                                        <td>{{ $o->user_id }}</td>
                                        <td>{{ $o->user_name }}</td>
                                        <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin#listInfo',$o->order_code) }}" class="text-primary">{{ $o->order_code }}</a>
                                        </td>
                                        <td>{{ $o->total_price }} Kyats</td>
                                        <td>
                                            <select name="status" class="form-control statusChange">
                                                <option value="0" @if ($o->status == 0) selected @endif>
                                                    Pending
                                                </option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Accept
                                                </option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="mt-3">
                    {{ $order->links() }}
                </div> --}}

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
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://127.0.0.1:8000/order/ajax/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = ``;
            //             for ($i = 0; $i < response.length; $i++) {

            //                 $months = ['January', 'February', 'March', 'April', 'May', 'July',
            //                     'August', 'September', 'October', 'November', 'December'
            //                 ];
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $months[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
            //                     "-" + $dbDate.getFullYear();

            //                 if (response[i].status == 0) {
            //                     $statusMessage = `
            //                         <select name="status" class="form-control statusChange">
            //                             <option value="0" selected>Pending</option>
            //                             <option value="1">Accept</option>
            //                             <option value="2">Reject</option>
            //                         </select>
            //                         `;
            //                 } else if (response[i].status == 1) {
            //                     $statusMessage = `
            //                         <select name="status" class="form-control statusChange">
            //                             <option value="0">Pending</option>
            //                             <option value="1" selected>Accept</option>
            //                             <option value="2">Reject</option>
            //                         </select>
            //                         `;
            //                 } else if (response[i].status == 2) {
            //                     $statusMessage = `
            //                         <select name="status" class="form-control statusChange">
            //                             <option value="0">Pending</option>
            //                             <option value="1">Accept</option>
            //                             <option value="2" selected>Reject</option>
            //                         </select>
            //                         `;
            //                 }
            //                 $list += `
            //                     <input type="hidden" class="orderId" value="${response[$i].id}">
            //                     <tr class="tr-shadow" style="margin-bottom: 2px !important">
            //                         <td> ${response[$i].user_id} </td>
            //                         <td> ${response[$i].user_name} </td>
            //                         <td> ${$finalDate} </td>
            //                         <td> ${response[$i].order_code} </td>
            //                         <td> ${response[$i].total_price} Kyats</td>
            //                         <td> ${$statusMessage} </td>
            //                     </tr>
            //                     `;
            //             }
            //             $('#dataList').html($list);
            //         }

            //     })
            // })

            //status change
            $('.statusChange').change(function() {
                //  $parentNode = $(this).parents("tr");
                //  $price = Number($parentNode.find('#price').text().replace("kyats", ""));
                //  $qty = Number($parentNode.find('#qty').val());

                //  $total = $price * $qty;

                //  $parentNode.find('#total').html(`${total+" Kyats"}`);

                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId
                };

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json',


                })
            })
        })
    </script>
@endsection
