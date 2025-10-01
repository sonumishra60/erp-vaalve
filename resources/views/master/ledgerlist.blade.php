@extends('layouts.main')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack p-0 m-0">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1 ml-10">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                </li>

                <li class="breadcrumb-item text-dark">Ledger List</li>

            </ul>
            <!--end::Title-->
        </div>

        <div class="d-flex align-items-center mr-20px">
            <a href="#" class="btn btn-sm btn-primary">Last Sync {{ date('d-m-Y h:i:s A', $mst_ledger->datetime)}}</i></a>
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <div class="row mb-xl-8">
            <div class="card">
                <div class="card-body py-3">

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table border table-striped">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder bg-light">
                                    <th class="w-50px rounded-start" style="color: #5e6278;">
                                        S.No.
                                    </th>

                                    <th class="w-220px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="ledger_name" class="form-control" required="">
                                            <label class="floating-label px"> Ledger Name</label>
                                            <i class="fa fa-search"></i>
                                            <!-- Ledger Name -->
                                        </div>
                                    </th>

                                    <th class="w-80px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="ledger_group" class="form-control" required="">
                                            <label class="floating-label px">Ledger Group</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>

                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="address" class="form-control" required="">
                                            <label class="floating-label px">Address</label>
                                            <i class="fa fa-search"></i>


                                        </div>
                                    </th>



                                    <th class="w-70px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="State" class="form-control" required="">
                                            <label class="floating-label px">State</label>
                                            <i class="fa fa-search"></i>


                                        </div>
                                    </th>

                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="Country" class="form-control" required="">
                                            <label class="floating-label px">Country</label>
                                            <i class="fa fa-search"></i>


                                        </div>
                                    </th>

                                    <th class="w-190px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="Pincode" class="form-control" required="">
                                            <label class="floating-label px">Pincode</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>


                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="PAN" class="form-control" required="">
                                            <label class="floating-label px">PAN</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>

                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="GSTIN" class="form-control" required="">
                                            <label class="floating-label px">GSTIN</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>

                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="opening_balance" class="form-control" required="">
                                            <label class="floating-label px">Opening Balance</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>

                                    <th class="w-90px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="closing_balance" class="form-control" required="">
                                            <label class="floating-label px"> Closing Balance</label>
                                            <i class="fa fa-search"></i>

                                        </div>
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="tbody">
                            </tbody>

                        </table>
                        <!--end::Table-->
                    </div>

                    <div class="pagen" id="pagination">
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
        </div>


    </div>
    <!--end::Container-->
</div>
@endsection

@section('js')
<script>
    function fetchData(rowCount, page) {

        $.ajax({
            url: "{{ route('master.ledgerlistdata') }}",
            method: 'GET',
            data: {
                rowCount: rowCount,
                page: page
            },
            success: function(response) {
                $('#tbody').empty();
                var countdata = response.data.length;
                if (countdata != 0) {
                    var startIndex = (page - 1) * rowCount;
                    $.each(response.data, function(index, value) {
                        var id = startIndex + index + 1;

                        var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-220px rounded-start">` + value.Ledger_Name + `</td>
                                    <td class="w-80px rounded-start">` + value.Ledger_Group + `</td>
                                    <td class="w-90px rounded-start">` + value.Address + `</td>
                                    <td class="w-70px rounded-start">` + value.State + `</td>
                                    <td class="w-90px rounded-start">` + value.Country + `</td>
                                    <td class="w-70px rounded-start">` + value.Pincode + `</td>
                                    <td class="w-90px rounded-start">` + value.PAN + `</td>
                                    <td class="w-90px rounded-start">` + value.GSTIN + `</td>
                                    <td class="w-90px rounded-start text-right">` + value.Opening_Balance + `</td>
                                    <td class="w-90px rounded-start text-right">` + value.Closing_Balance + `</td>
                                </tr>`;
                        $('#tbody').append(tr);
                    });

                } else {
                    var tr = `<tr>
                                    <td class="text-center" colspan="8"> No Record Found</td>
                                 </tr>`;

                    $('#tbody').append(tr);
                }


                updatePagination(response);
            },
            error: function(xhr, status, error) {
                console.error('error => ' + error);
            }
        });
    }

    function updatePagination(response) {

        //  console.log('updatePagination => '+response.last_page);

        var totalPages = response.last_page;
        var paginationHtml = '';
        for (var i = 1; i <= totalPages; i++) {
            paginationHtml += '<li class="page-item' + (response.current_page === i ? ' active' : '') +
                '"><a class="page-link" href="/admins/forms?page=' + i + '" data-page="' + i + '">' + i +
                '</a></li>';
        }

        $('#pagination').html(paginationHtml);
        // Event listener for pagination links
        $('#pagination a').on('click', function(event) {
            event.preventDefault();
            var page = $(this).data('page');
            var rowCount = $('#rowCount').val();
            fetchData(200, page); // Fetch data for the clicked page
        });
    }

    fetchData(200, 1);

    function searchData(searchParams) {
        $.ajax({
            url: "{{ route('master.ledgersearch') }}",
            method: 'GET',
            data: searchParams,
            success: function(response) {

                console.log(response);
                var data = response.data;
                $('#tbody').empty();
                var countdata = response.data.length;
                if (countdata != 0) {
                    var startIndex = (searchParams.page - 1) * searchParams.rowCount;
                    $.each(response.data, function(index, value) {
                        var id = startIndex + index + 1;

                        var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-220px rounded-start">` + value.Ledger_Name + `</td>
                                    <td class="w-80px rounded-start">` + value.Ledger_Group + `</td>
                                    <td class="w-90px rounded-start">` + value.Address + `</td>
                                    <td class="w-70px rounded-start">` + value.State + `</td>
                                    <td class="w-90px rounded-start">` + value.Country + `</td>
                                    <td class="w-70px rounded-start">` + value.Pincode + `</td>
                                    <td class="w-90px rounded-start">` + value.PAN + `</td>
                                    <td class="w-90px rounded-start">` + value.GSTIN + `</td>
                                    <td class="w-90px rounded-start text-right">` + value.Opening_Balance + `</td>
                                    <td class="w-90px rounded-start text-right">` + value.Closing_Balance + `</td>
                                </tr>`;
                        $('#tbody').append(tr);
                    });

                } else {
                    var tr = `<tr>
                                    <td class="text-center" colspan="11"> No Record Found</td>
                                 </tr>`;

                    $('#tbody').append(tr);
                }


                updatePagination(response);

            },
            error: function(xhr, status, error) {
                console.error('error => ' + error);
            }
        });


    }


    $('.form-control').on('keyup', function() {
        //  alert();
        var ledger_group = $('#ledger_group').val().trim();
        var ledger_name = $('#ledger_name').val().trim();
        var address = $('#address').val().trim();
        var State = $('#State').val().trim();
        var Country = $('#Country').val().trim();
        var Pincode = $('#Pincode').val().trim();
        var PAN = $('#PAN').val().trim();
        var GSTIN = $('#GSTIN').val().trim();
        var opening_balance = $('#opening_balance').val().trim();
        var closing_balance = $('#closing_balance').val().trim();

        var searchParams = {
            ledger_name: ledger_name,
            ledger_group: ledger_group,
            address: address,
            State: State,
            Country: Country,
            Pincode: Pincode,
            PAN: PAN,
            GSTIN:GSTIN,
            opening_balance:opening_balance,
            closing_balance:closing_balance,
            rowCount: 100,
            page: 1
        };
        searchData(searchParams);
    });
</script>
@endsection