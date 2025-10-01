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

                    <li class="breadcrumb-item text-dark">Inventory List</li>

                </ul>
                <!--end::Title-->
            </div>

            <div class="d-flex align-items-center mr-20px">
                <a href="#" class="btn btn-sm btn-primary">Last Sync {{ date('d-m-Y h:i:s A', $mst_inventory->datetime) }}</i></a>
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>

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

                                        <th style="width:350px;" class="w-220px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="name" class="form-control" required="">
                                                <label class="floating-label px">Name</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-80px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Group" class="form-control" required="">
                                                <label class="floating-label px">Group</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Category" class="form-control" required="">
                                                <label class="floating-label px">Category</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>



                                      

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="PartNo" class="form-control" required="">
                                                <label class="floating-label px">PartNo</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <!-- <th class="w-190px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Alias" class="form-control" required="">
                                                <label class="floating-label px">Alias</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>


                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Op_Qty" class="form-control" required="">
                                                <label class="floating-label px">Op Qty</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Op_Rate" class="form-control" required="">
                                                <label class="floating-label px">Op Rate</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Op_Amount" class="form-control" required="">
                                                <label class="floating-label px">Op Amount</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th> -->

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Cl_Qty" class="form-control" required="">
                                                <label class="floating-label px">Cl Qty</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-70px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Units" class="form-control" required="">
                                                <label class="floating-label px">Units</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Cl_Rate" class="form-control" required="">
                                                <label class="floating-label px">Cl Rate</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-90px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="Cl_Amount" class="form-control" required="">
                                                <label class="floating-label px">Cl Amount</label>
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
                url: "{{ route('master.listdata') }}",
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

                            // <td class="w-70px rounded-start">`+ value.Alias +`</td>
                            //         <td class="w-90px rounded-start text-right">`+ value.Op_Qty +`</td>
                            //         <td class="w-90px rounded-start text-right">`+ value.Op_Rate +`</td>
                            //         <td class="w-90px rounded-start text-right">`+ value.Op_Amount +`</td>
                         
                            var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td style="width:350px;" class="w-220px rounded-start">`+ value.Name +`</td>
                                    <td class="w-80px rounded-start">`+ value.Group +`</td>
                                    <td class="w-90px rounded-start">`+ value.Category +`</td>
                                    <td class="w-90px rounded-start">`+ value.PartNo +`</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Qty +`</td>
                                    <td class="w-70px rounded-start">` + value.Units + `</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Rate +`</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Amount +`</td>
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
                fetchData(100, page); // Fetch data for the clicked page
            });
        }

        fetchData(100, 1);


    

        function searchData(searchParams){
            $.ajax({
                url: "{{ route('master.inventorysearch') }}",
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
                            // <td class="w-70px rounded-start">`+ value.Alias +`</td>
                            // <td class="w-90px rounded-start text-right">`+ value.Op_Qty +`</td>
                            //         <td class="w-90px rounded-start text-right">`+ value.Op_Rate +`</td>
                            //         <td class="w-90px rounded-start text-right">`+ value.Op_Amount +`</td>

                            var tr = ` <tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td style="width:350px;" class="w-220px rounded-start">`+ value.Name +`</td>
                                    <td class="w-80px rounded-start">`+ value.Group +`</td>
                                    <td class="w-90px rounded-start">`+ value.Category +`</td>
                                    <td class="w-90px rounded-start">`+ value.PartNo +`</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Qty +`</td>
                                       <td class="w-70px rounded-start">` + value.Units + `</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Rate +`</td>
                                    <td class="w-90px rounded-start text-right">`+ value.Cl_Amount +`</td>
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


        $('.form-control').on('keyup', function() {
            //  alert();
            var name = $('#name').val().trim();
            var Group = $('#Group').val().trim();
            var Category = $('#Category').val().trim();
            var Units = $('#Units').val().trim();
            var PartNo = $('#PartNo').val().trim();
            // var Alias = $('#Alias').val().trim();
            // var Op_Qty = $('#Op_Qty').val().trim();
            // var Op_Rate = $('#Op_Rate').val().trim();
            // var Op_Amount = $('#Op_Amount').val().trim();
            var Cl_Qty = $('#Cl_Qty').val().trim();
            var Cl_Rate = $('#Cl_Rate').val().trim();
            var Cl_Amount = $('#Cl_Amount').val().trim();

            var searchParams = {
                name: name,
                Group:Group,
                Category: Category,
                Units: Units,
                PartNo: PartNo,
                // Alias: Alias,
                // Op_Qty: Op_Qty,
                // Op_Rate: Op_Rate,
                // Op_Amount: Op_Amount,
                Cl_Qty: Cl_Qty,
                Cl_Rate: Cl_Rate,
                Cl_Amount: Cl_Amount,
                rowCount: 100,
                page: 1
            };
            searchData(searchParams);
        });
    </script>
@endsection
