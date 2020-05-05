@extends('layouts.app')

@push('css')
    <link href="{{asset('libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <?php
     $status = ucfirst($status);
    ?>
    <div class="row">
            <div class="col-md-6 col-xl-2">
                <a href="{{ url('admin/order')}}">
                    <div class="widget-rounded-circle card-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="float-left">
                                    <h3 class="text-dark mt-1">
                                        <span id="all" data-plugin="counterup">0</span>
                                    </h3>
                                    <p class="text-muted mb-1 text-truncate">All Orders</p>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end widget-rounded-circle-->
                </a>
            </div> <!-- end col-->

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
                                    <span id="canceled" data-plugin="counterup">
                                    <?php
                                        echo DB::table('orders')->where('status','like','Canceled')->count();
                                        ?>
                                    </span>
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
    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <h4 class="page-title mt-0 d-inline">Total <span class="total">0</span> Orders </h4>
                        </div>
                        <div class="col-md-8">
                            <div class="text-md-right">
                                <button type="button"
                                        class="btn btn-warning btn-sync btn-xs waves-effect waves-light ml-2 float-right"><i
                                        class="fas fa-sync fa-spin mr-1"></i> Sync Order
                                </button>
                                <div class="btn-group dropdown ml-2 float-right">
                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn bg-info btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-thumbtack mr-1"></i> Change Status</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item btn-change-status" data-status="Processing" href="#"><i class="fe-tag mr-2 font-18 text-muted vertical-middle"></i>Processing</a>
                                        <a class="dropdown-item btn-change-status" data-status="On Hold" href="#"><i class="far fa-stop-circle mr-2 font-18 text-muted vertical-middle"></i>On Hold</a>
                                        <a class="dropdown-item btn-change-status"  data-status="Payment Pending" href="#"><i class="fe-tag mr-2 font-18 text-muted vertical-middle"></i>Payment Pending</a>
                                        <a class="dropdown-item btn-change-status" data-status="Canceled" href="#"><i class="fe-trash-2 mr-2 font-18 text-muted vertical-middle"></i>Canceled</a>
                                        <a class="dropdown-item btn-change-status" data-status="Completed" href="#"><i class="fe-check-circle mr-2 font-18 text-muted vertical-middle"></i>Completed</a>
                                    </div>
                                </div>

                                <div class="btn-group dropdown ml-2 float-right">
                                    <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn bg-success btn-xs" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-check mr-1"></i> Assign User</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php
                                        use App\User;
                                        $users = DB::table('users')->where([
                                            ['status', 'like', 'Active'],
                                            ['role_id', '=', '2']
                                        ])->inRandomOrder()->get();
                                        ?>
                                        @foreach($users as $user)
                                                <a class="dropdown-item btn-assign-user" data-id="{{$user->id}}" href="#">{{$user->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="button"
                                        class="btn btn-danger btn-all-delete btn-xs waves-effect waves-light ml-2 float-right"><i
                                        class="fas fa-trash mr-1"></i> Delete All
                                </button>
                                <a  href="{{url('admin/order/create')}}"
                                        class="btn btn-primary btn-add btn-xs waves-effect waves-light float-right"><i
                                        class="fas fa-plus mr-1"></i> Add New Order
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <table class="table table-centered table-striped" id="orderTable"
                               style="width: 100%;" data-status="<?php echo isset($status) == '' ? "all" : $status; ?>">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Invoice ID</th>
                                    <th>Name</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <th>Courier</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th class="hidden-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <div class="modal fade bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Edit Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" class="btn btn-primary">Save</button>
                    @csrf
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('libs/select2/select2.min.js')}}"></script>

    <script !src="">

        $(document).ready(function () {
            var table = $("#orderTable").DataTable({
                ajax: "{{url('admin/order/show')}}?status=" + $('#orderTable').attr('data-status'),
                ordering: false,
                pageLength: 50,
                rowId: "invoiceID",
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    }
                ],
                columns: [
                    {data: "id"},
                    {
                        data: null,
                        render: function (data) {
                            if(data.web_ID){
                                return data.invoiceID+'<br>' +data.web_ID;
                            }else{
                                return data.invoiceID;
                            }
                        }
                    },
                    {
                        data: null,
                        width: "15%",
                        render: function (data) {
                            return '<i class="fas fa-user mr-2 text-grey-dark"></i>'+data.customerName +'<br> <i class="fas fa-phone  mr-2 text-grey-dark"></i>'+data.customerPhone+'<br><i class="fas fa-map-marker mr-2 text-grey-dark"></i>' + data.customerAddress;
                        }
                    },
                    {
                        data: "products",
                        width: "15%"
                    },
                    {data: "subTotal"},
                    {data: "courierName"},
                    {data: "orderDate"},
                    {
                        data: null,
                        width: "10%",
                        render: function (data) {
                            return data.status+' <br>'+ data.notification ;
                        },
                    },
                    {data: "name"},
                    {
                        data: null,
                        render: function (data) {
                            return "<a href='javascript:void(0);' data-id='" + data.id + "' class='action-icon btn-edit mr-2'> <i class='fas fa-edit'></i></a>" +
                                "<a href='javascript:void(0);' data-id='" + data.id + "' class='action-icon btn-delete'> <i class='fas fa-trash-alt'></i></a>";
                        }
                    }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'>",
                        next: "<i class='fas fa-chevron-right'>"
                    }
                },
                initComplete: function () {
                    this.api().columns().every(function () {
                        var title = this.header();
                        title = $(title).html().replace(/[\W]/g, '-');
                        if (title === 'Order-Date' || title === 'Courier') {
                            var column = this;
                            var select = $('<select id="' + title + '" multiple class="select2 form-control " width="100%" ></select>')
                                .appendTo($(column.header()).empty()).on('change', function () {
                                    var data = $.map($(this).select2('data'), function (value, key) {
                                        return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                    });
                                    if (data.length === 0) {
                                        data = [""];
                                    }
                                    var val = data.join('|');
                                    column.search(val ? val : '', true, false).draw();
                                });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>');
                            });
                            $("#" + title).select2({
                                multiple: true,
                                closeOnSelect: false,
                                placeholder: title
                            });
                            $('.select2').val(null).trigger('change');
                        }
                    });
                },
                initComplete: function(settings, json) {
                    loadcountOrders();
                    $(".dataTables_paginate > .pagination").addClass("pagination-sm")
                },
                footerCallback: function ( ) {
                    var api = this.api();
                    var numRows = api.rows().count();
                    $('.total').empty().append(numRows);

                    var intVal = function (i) {
                        return typeof i === "string" ? i.replace(/[\$,]/g, "") * 1 : typeof i === "number" ? i : 0;
                    };
                    pageTotal = api.column(4, { page: "current" }).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(pageTotal + " Tk");
                }
            });
            function loadcountOrders(){
                $.ajax({
                type: "get",
                url: "{{url('admin/order/countOrders')}}",
                contentType: "application/json",
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data["status"] == "success") {

                        $('#delivered').text(data["delivered"]);
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
                            Swal.fire(data["message"]);
                        } else {
                            Swal.fire("Something wrong ! Please try again.");
                        }
                    }
                }
            });
            }
            // loadcountOrders();
            var token = $("input[name='_token']").val();

            $(document).on('click', '.btn-all-delete', function (e) {
                e.preventDefault();
                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.value) {
                        jQuery.ajax({
                            type: "get",
                            url: "{{url('admin/order/deleteAll')}}",
                            contentType: "application/json",
                            data: {
                                action: "deleteOrder",
                                ids: ids
                            },
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data["status"] == "success") {
                                    Swal.fire(data["message"]);
                                    table.ajax.reload();
                                } else {
                                    if (data["status"] == "failed") {
                                        Swal.fire(data["message"]);
                                    } else {
                                        Swal.fire("Something wrong ! Please try again.");
                                    }
                                }
                            }
                        });
                    }
                });

            });

            $(document).on('click', '.btn-assign-user', function (e) {
                e.preventDefault();

                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                var user_id = $(this).attr('data-id');

                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/assign')}}",
                    contentType: "application/json",
                    data: {
                        action: "assign",
                        ids: ids,
                        user_id: user_id
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] == "success") {
                            Swal.fire(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data["status"] == "failed") {
                                Swal.fire(data["message"]);
                            } else {
                                Swal.fire("Something wrong ! Please try again.");
                            }
                        }
                    }
                });

            });

            $(document).on('click', '.btn-sync', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Auto sync start!',
                    html: 'It will close after all order sync.',
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
                jQuery.ajax({
                    type: "get",
                    url: "{{url('admin/order/orderSync')}}",
                    contentType: 'application/json',
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            Swal.fire({
                                title: data['message'],
                                html: data['orders'] +
                                    ' Orders Sync.'

                            }).then(function() {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: data['message'],
                                html: data['orders'] +
                                    ' Orders Sync.'

                            });
                        }
                    }
                });



            });

            $(document).on('click', '.btn-change-status', function (e) {
                e.preventDefault();
                var rows_selected = table.column(0).checkboxes.selected();
                var ids = [];
                $.each(rows_selected, function (index, rowId) {
                    ids[index] = rowId;
                });
                var status = $(this).attr('data-status');
                 $.ajax({
                    type: "get",
                    url: "{{url('admin/order/changeStatusByCheckbox')}}",
                    data: {
                        'status': status,
                        'ids': ids,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            toastr.success(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data['status'] == 'failed') {
                                toastr.error(data["message"]);
                            } else {
                                toastr.error('Something wrong ! Please try again.');
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.btn-status', function (e) {
                e.preventDefault();
                var status = $(this).attr('data-status');
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "get",
                    url: "{{url('admin/order/status')}}",
                    data: {
                        'status': status,
                        'id': id,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data['status'] == 'success') {
                            toastr.success(data["message"]);
                            table.ajax.reload();
                        } else {
                            if (data['status'] == 'failed') {
                                toastr.error(data["message"]);
                            } else {
                                toastr.error('Something wrong ! Please try again.');
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    type: "get",
                    url: "{{url('admin/order')}}/"+id+"/edit",
                    data: {
                        '_token': token
                    },
                    success: function (response) {

                        $('.modal .modal-body').empty().append(response);
                        $('.modal').modal('toggle');
                        $('.modal-footer').hide();

                        $(".datepicker").flatpickr();

                        $("#productID").select2({
                            placeholder: "Select a Product",
                            templateResult: function (state) {
                                if (!state.id) {
                                    return state.text;
                                }
                                var $state = $(
                                    '<span><img width="60px" src="' +
                                    state.image +
                                    '" class="img-flag" /> ' +
                                    state.text +
                                    "</span>"
                                );
                                return $state;
                            },
                            ajax: {
                                url: '{{url('admin/order/product')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data.data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                            $("#productTable tbody").append(
                                "<tr>" +
                                '<td  style="display: none"><input type="text" class="productID" style="width:80px;" value="' + e.params.data.id + '"></td>' +
                                '<td><span class="productCode">' + e.params.data.productCode + '</span></td>' +
                                '<td><span class="productName">' + e.params.data.text + '</span></td>' +
                                '<td><input type="number" class="productQuantity form-control" style="width:80px;" value="1"></td>' +
                                '<td><span class="productPrice">' + e.params.data.productPrice + '</span></td>' +
                                '<td><button class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                                "</tr>"
                            );
                            calculation();
                        });

                        $("#storeID").select2({
                            placeholder: "Select a Store",
                            ajax: {
                                url: '{{url('admin/order/stores')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });


                        $("#courierID").select2({
                            placeholder: "Select a Courier",
                            ajax: {
                                url: '{{url('admin/order/courier')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                              $("#zoneID").empty();
                              for (var i = 0; i < couriers.length; i++) {
                                if (couriers[i]['courierName'] == e.params.data.text) {
                                     if (couriers[i]['hasCity'] == 'on') {
                                        jQuery(".hasCity").show();
                                    } else {
                                        jQuery(".hasCity").hide();
                                    }
                                    if (couriers[i]["hasZone"] == 'on') {
                                        jQuery(".hasZone").show();
                                    } else {
                                        jQuery(".hasZone").hide();
                                        $("#zoneID").empty();
                                    }
                                }

                                if (e.params.data.text == 'Pathao') {
                                    $("#cityID").empty().append('<option value="8">Dhaka</option>');
                                } else {
                                    $("#cityID").empty();
                                }
                            }

                        });

                        if ($("#courierID").text()) {
                            var courier = $("#courierID").text().trim();
                             for (var i = 0; i < couriers.length; i++) {
                                if (couriers[i]['courierName'] == courier) {
                                     if (couriers[i]['hasCity'] == 'on') {
                                        jQuery(".hasCity").show();
                                    } else {
                                        jQuery(".hasCity").hide();
                                    }

                                    if (couriers[i]["hasZone"] == 'on') {
                                        jQuery(".hasZone").show();
                                    } else {
                                        jQuery(".hasZone").hide();
                                        $("#zoneID").empty();
                                    }
                                }
                            }
                        }

                        $("#cityID").select2({
                            placeholder: "Select a City",
                            ajax: {
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        courierID: $("#courierID").val()
                                    };
                                    return query;
                                },
                                url: '{{url('admin/order/city')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });

                        $("#zoneID").select2({
                            placeholder: "Select a Zone",
                            ajax: {
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        courierID: $("#courierID").val(),
                                        cityID: $("#cityID").val()
                                    };
                                    return query;
                                },
                                url: '{{url('admin/order/zone')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });


                        var orderNoteTable = $("#orderNoteTable").DataTable({
                            ajax: "{{url('admin/order/getNotes')}}?id=" + $('#orderNoteTable').attr('data-id'),
                            ordering: false,
                            lengthChange: false,
                            bFilter:false,
                            search:false,
                            info:false,
                            columns: [
                                {data: "date"},
                                {data: "notificaton"},
                                {data: "name"}
                            ],
                        });

                        var oldOrderTable = $("#oldOrderTable").DataTable({
                            ajax: "{{url('admin/order/oldOrders')}}?id=" + $('#oldOrderTable').attr('data-id'),
                            ordering: false,
                            lengthChange: false,
                            bFilter:false,
                            search:false,
                            info:false,
                            columns: [
                                {data: "invoiceID"},
                                {
                                        data: null,
                                        width: "15%",
                                        render: function (data) {
                                            return '<i class="fas fa-user mr-2 text-grey-dark"></i>'+data.customerName +'<br> <i class="fas fa-phone  mr-2 text-grey-dark"></i>'+data.customerPhone+'<br><i class="fas fa-map-marker mr-2 text-grey-dark"></i>' + data.customerAddress;
                                        }
                                },
                                {data: "products"},
                                {data: "subTotal"},
                                {data: "status"}
                            ]
                        });

                        $(document).on("click", "#updateNote", function () {
                            let note = $('#note');
                            let id = $('#btn-update').val()
                            if(note.val() == ''){
                                note.css('border','1px solid red');
                                return;
                            }else if( id == ''){
                                toastr.success('Something Wrong , Try again ! ');
                                return;
                            }else{
                                $.ajax({
                                    type: "get",
                                    url: "{{url('admin/order/updateNotes')}}",
                                    data: {
                                        'note': note.val(),
                                        'id': id,
                                        '_token': token
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        if (data['status'] == 'success') {
                                            toastr.success(data["message"]);
                                            orderNoteTable.ajax.reload();
                                        } else {
                                            if (data['status'] == 'failed') {
                                                toastr.error(data["message"]);
                                            } else {
                                                toastr.error('Something wrong ! Please try again.');
                                            }
                                        }
                                    }
                                });
                            }


                        });


                        if ($("#paymentTypeID").text()) {
                            var paymentType = $("#paymentTypeID").val();
                            if (paymentType == "") {
                                $(".paymentID").hide();
                                $(".paymentAgentNumber").hide();
                                $(".paymentAmount").hide();
                            } else {
                                $(".paymentID").show();
                                $(".paymentAgentNumber").show();
                                $(".paymentAmount").show();
                            }
                        }

                        $("#paymentTypeID").select2({
                            placeholder: "Select a payment Type",
                            allowClear: true,
                            ajax: {
                                data: function (params) {
                                    return {
                                        q: params.term
                                    };
                                },
                                url: '{{url('admin/order/paymenttype')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        }).trigger("change").on("select2:select", function (e) {
                            if (e.params.data.text == "") {
                                $(".paymentID").hide();
                                $(".paymentAgentNumber").hide();
                                $(".paymentAmount").hide();
                            } else {
                                $(".paymentID").show();
                                $(".paymentAgentNumber").show();
                                $(".paymentAmount").show();
                            }
                        }).on("select2:unselect", function (e) {
                            $(".paymentID").hide();
                            $(".paymentAgentNumber").hide();
                            $(".paymentAmount").hide();
                            calculation();
                        });

                        $("#paymentID").select2({
                            placeholder: "Select a payment Number",
                            allowClear: true,
                            ajax: {
                                data: function (params) {
                                    return {
                                        q: params.term,
                                        paymentTypeID: $("#paymentTypeID").val(),
                                    };
                                },
                                url: '{{url('admin/order/paymentnumber')}}',
                                processResults: function (data) {
                                    var data = $.parseJSON(data);
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });

                        $(document).on("change", ".productQuantity", function () {
                             calculation();
                        });
                        $(document).on("input", "#paymentAmount", function () {
                            calculation();
                        });
                        $(document).on("input", "#deliveryCharge", function () {
                            calculation();
                        });
                        $(document).on("input", "#discountCharge", function () {
                            calculation();
                        });

                        calculation();

                        function calculation() {
                            var subtotal = 0;
                            var deliveryCharge = +$("#deliveryCharge").val();
                            var discountCharge = +$("#discountCharge").val();
                            var paymentAmount = +$("#paymentAmount").val();
                            $("#productTable tbody tr").each(function (index) {
                                subtotal = subtotal + +$(this).find(".productPrice").text() * +$(this).find(".productQuantity").val();
                            });
                            $("#subtotal").text(subtotal);
                            $("#total").text(subtotal + deliveryCharge - paymentAmount - discountCharge);
                        }

                        $(document).on("click", ".delete-btn", function () {
                            $(this).closest("tr").remove();
                            calculation();
                        });


                    }
                });
            });


            $(document).on("click", "#btn-update", function () {
                var id =  $(this).val();
                var invoiceID = $("#invoiceID");
                var customerName = $("#customerName");
                var customerPhone = $("#customerPhone");
                var customerAddress = $("#customerAddress");
                var storeID = $("#storeID");
                var total = +$("#total").text();
                var deliveryCharge = +$("#deliveryCharge").val();
                var discountCharge = +$("#discountCharge").val();
                var paymentTypeID = $("#paymentTypeID").val();
                var paymentID = $("#paymentID").val();
                var paymentAmount = +$("#paymentAmount").val();
                var paymentAgentNumber = $("#paymentAgentNumber").val();
                var orderDate = $("#orderDate");
                var courierID = $("#courierID");
                var cityID = +$("#cityID").val();
                var zoneID = +$("#zoneID").val();
                var memo = +$("#memo").val();
                var product = [];
                var productCount = 0 ;
                $("#productTable tbody tr").each(function (index, value) {
                    var currentRow = $(this);
                    var obj = {};
                    obj.productID = currentRow.find(".productID").val();
                    obj.productCode = currentRow.find(".productCode").text();
                    obj.productName = currentRow.find(".productName").text();
                    obj.productQuantity = currentRow.find(".productQuantity").val();
                    obj.productPrice = currentRow.find(".productPrice").text();
                    product.push(obj);
                    productCount++;
                });

                if(storeID.val() == ''){
                    toastr.error('Store Should Not Be Empty');
                    storeID.closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                storeID.closest('.form-group').find('.select2-selection').css('border','1px solid #ced4da');

                if(invoiceID.val() == ''){
                    toastr.error('Invoice ID Should Not Be Empty');
                    invoiceID.css('border','1px solid red');
                    return;
                }
                invoiceID.css('border','1px solid #ced4da');

                if(customerName.val() == ''){
                    toastr.error('Customer Name Should Not Be Empty');
                    customerName.css('border','1px solid red');
                    return;
                }
                customerName.css('border','1px solid #ced4da');

                if(customerPhone.val() == ''){
                    toastr.error('Customer Phone Should Not Be Empty');
                    customerPhone.css('border','1px solid red');
                    return;
                }
                customerPhone.css('border','1px solid #ced4da');

                if(customerAddress.val() == ''){
                    toastr.error('Customer Address Should Not Be Empty');
                    customerAddress.css('border','1px solid red');
                    return;
                }
                customerAddress.css('border','1px solid #ced4da');

                if(orderDate.val() == ''){
                    toastr.error('Order Date Should Not Be Empty');
                    orderDate.css('border','1px solid red');
                    return;
                }
                orderDate.css('border','1px solid #ced4da');

                if(courierID.val() == ''){
                    toastr.error('Courier Should Not Be Empty');
                    courierID.closest('.form-group').find('.select2-selection').css('border','1px solid red');
                    return;
                }
                courierID.css('border','1px solid #ced4da');

                if(productCount == 0){
                    toastr.error('Product Should Not Be Empty');
                    return;
                }

                var data = {};
                data["invoiceID"] = invoiceID.val();
                data["storeID"] = storeID.val();
                data["customerName"] = customerName.val();
                data["customerPhone"] = customerPhone.val();
                data["customerAddress"] = customerAddress.val();
                data["total"] = total;
                data["deliveryCharge"] = deliveryCharge;
                data["discountCharge"] = discountCharge;
                data["paymentTypeID"] = paymentTypeID;
                data["paymentID"] = paymentID;
                data["paymentAmount"] = paymentAmount;
                data["paymentAgentNumber"] = paymentAgentNumber;
                data["orderDate"] = orderDate.val();
                data["courierID"] = +courierID.val();
                data["cityID"] = cityID;
                data["zoneID"] = zoneID;
                data["userID"] = $('#user_id').val();
                data["products"] = product;
                data["memo"] = memo;
                $.ajax({
                    type: "PUT",
                    url: "{{url('admin/order')}}/" + id,
                    data: {
                        'data': data,
                        '_token': token
                    },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data["status"] === "success") {
                            toastr.success(data["message"])
                        } else {
                            toastr.error(data["message"])
                        }
                        table.ajax.reload();
                        $('.modal').modal('toggle');

                    }
                });


            });

            $(document).on("click", ".btn-delete", function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                Swal.fire({
                    title:"Are you sure?",
                    text:"You won't be able to revert this!",
                    type:"warning",
                    showCancelButton:!0,
                    confirmButtonColor:"#3085d6"
                    ,cancelButtonColor:"#d33"
                    ,confirmButtonText:"Yes, delete it!"
                }).then(function(t){
                    if(t.value){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            type: "DELETE",
                            url: "{{url('admin/order/')}}/" + id,
                            data: {
                                '_token': token
                            },
                            contentType: "application/json",
                            success: function (response) {
                                var data = JSON.parse(response);
                                if (data['status'] === 'success') {
                                    toastr.success(data["message"]);
                                    table.ajax.reload();
                                } else {
                                    if (data['status'] === 'failed') {
                                        toastr.error(data["message"]);
                                    } else {
                                        toastr.error('Something wrong ! Please try again.');
                                    }
                                }
                            }
                        });
                    }
                })

            });

        });
    </script>
@endpush
