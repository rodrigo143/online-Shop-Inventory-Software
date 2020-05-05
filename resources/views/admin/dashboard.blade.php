@extends('layouts.app')

@push('css')
    <link href="{{asset('libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/>
 @endpush
@section('content')

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-primary">
                            <i class="dripicons-wallet font-24 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1">
                                <span id="revenue" data-plugin="counterup">0 Tk</span>
                            </h3>
                            <p class="text-muted mb-1 text-truncate">Total Revenue</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-success">
                            <i class="dripicons-basket font-24 avatar-title text-success"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1">
                                <span id="all" data-plugin="counterup">0</span>
                            </h3>
                            <p class="text-muted mb-1 text-truncate">Orders</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-info">
                            <i class="dripicons-store font-24 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1">
                                <span id="store" data-plugin="counterup">0</span>
                            </h3>
                            <p class="text-muted mb-1 text-truncate">Stores</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded bg-soft-warning">
                            <i class="dripicons-user-group font-24 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1">
                                <span id="user" data-plugin="counterup">0</span>
                            </h3>
                            <p class="text-muted mb-1 text-truncate">Users</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Processing')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="processing" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Processing</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Payment Pending')}}">

                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="pendingPayment" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Payment Pending</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/On Hold')}}">

                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="onHold" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">On Hold</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Canceled')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="canceled" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Canceled</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Completed')}}">

                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="completed" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Completed</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Pending Invoiced')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="pendingInvoiced" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Pending Invoiced</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Invoiced')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="invoiced" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Invoiced</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Stock Out')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="stockOut" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Stock Out</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Delivered')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="delivered" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Delivered</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Customer Confirm')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="customerConfirm" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Customer Confirm</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Paid')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="paid" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Paid</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Return')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="return" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Return</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-2">
            <a href="{{ url('admin/order/status/Lost')}}">
                <div class="widget-rounded-circle card-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-left">
                                <h3 class="text-dark mt-1">
                                    <span id="lost" data-plugin="counterup">0</span>
                                </h3>
                                <p class="text-muted mb-1 text-truncate">Lost</p>
                            </div>
                        </div>
                    </div> <!-- end row-->
                </div> <!-- end widget-rounded-circle-->
            </a>
        </div> <!-- end col-->

    </div>

@endsection

@push('js')
    <script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#datepicker").flatpickr({mode:"range"})

            function loadcountOrders() {
                // Dashboard Detais
                $.ajax({
                    type: "get",
                    url: "{{url('admin/dashboard/getData')}}/?date="+$('#datepicker').val(),
                    contentType: "application/json",
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] === "success") {
                            $('#revenue').text(data["revenue"]+' TK');
                            $('#allOrders').text(data["allOrders"]);
                            $('#store').text(data["store"]);
                            $('#user').text(data["user"]);
                            $('#customerConfirm').text(data["customerConfirm"]);
                            $('#paid').text(data["paid"]);
                            $('#return').text(data["return"]);
                            $('#lost').text(data["lost"]);
                            $('#pendingInvoiced').text(data["pendingInvoiced"]);
                            $('#invoiced').text(data["invoiced"]);
                            $('#stockOut').text(data["stockOut"]);
                            $('#all').text(data["all"]);
                            $('#processing').text(data["processing"]);
                            $('#pendingPayment').text(data["pendingPayment"]);
                            $('#onHold').text(data["onHold"]);
                            $('#canceled').text(data["canceled"]);
                            $('#completed').text(data["completed"]);

                            // console.log(data)
                        } else {
                            if (data["status"] == "failed") {
                                // Swal.fire(data["message"]);
                            } else {
                                // Swal.fire("Something wrong ! Please try again.");
                            }
                        }
                    }
                });

            }
            loadcountOrders();

            $(document).on('change', '#datepicker', function(){
                loadcountOrders();
            });
        });
    </script>
@endpush

