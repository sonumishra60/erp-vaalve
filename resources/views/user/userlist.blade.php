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
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-dark">User List</li>

                </ul>
                <!--end::Title-->
            </div>

            <div class="d-flex align-items-center mr-20px">
                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary"> Add New</i></a>
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

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="emp_code" class="form-control" required="">
                                                <label class="floating-label px">EMP Code.</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>



                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="user_name" class="form-control" required="">
                                                <label class="floating-label px">Name</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-150px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="email_id" class="form-control" required="">
                                                <label class="floating-label px">Email Id.</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="phone_no" class="form-control" required="">
                                                <label class="floating-label px">Phone No.</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-190px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="address" class="form-control" required="">
                                                <label class="floating-label px">Address</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="state_city" class="form-control" required="">
                                                <label class="floating-label px">State, City</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="status" class="form-control" required="">
                                                <label class="floating-label px">Status</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="d-flex">
                                                Action
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
        $(document).on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            var url = '{{ route('user.delete', ':id') }}';
            url = url.replace(':id', id);
            swal({
                    title: "Are you sure?",
                    text: "To delete this record?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: {
                        cancel: "No",
                        confirm: "Yes",
                    },
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            beforeSend: function() {
                                $('.spinner-cls').show();
                            },
                            success: function(data) {
                                $('.spinner-cls').hide();
                                if (data == 0) {
                                    toastr.error('Your record has not been deleted!');
                                } else {
                                    toastr.success('Your record has been deleted!');
                                }

                                //location.reload();
                            },
                            error: function(xhr, status, error) {
                                $('.spinner-cls').hide();
                                toastr.error('Some error occurred please try again');
                            }
                        });
                    }
                });
        });

        function fetchData(rowCount, page) {

            $.ajax({
                url: "{{ route('user.listdata') }}",
                method: 'GET',
                data: {
                    rowCount: rowCount,
                    page: page
                },
                success: function(response) {
                    $('#tbody').empty()

                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(response.data, function(index, value) {

                            var id = index + 1;
                            var editurl = "{{ route('user.edit', ':id') }}";
                            editurl = editurl.replace(':id', value.userAuthKey);
                            var statecity = value.state + ' ' + value.city;

                            var tr = `<tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                      <td class="w-100px rounded-start">` + value.emp_code + `</td>
                                    <td class="w-100px rounded-start">` + value.name + `</td>
                                    <td class="w-150px rounded-start">` + value.emailAddress + `</td>
                                    <td class="w-100px">` + value.mobileNumber + `</td>
                                    <td class="w-190px rounded-start">` + value.address + `</td>
                                    <td class="w-100px rounded-start">` + statecity + `</td>
                                    <td class="w-100px rounded-start">` + value.status + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                        <a href="` + editurl + `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>
                                     <a  class="delete" data-id="` + value.userId + `">  <i class="fa fa-trash text-danger"></i>  </a>
                                    </div></td>
                                     
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

            //console.log('opo =>'+response);
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
                fetchData(10, page); // Fetch data for the clicked page
            });
        }
        fetchData(10, 1);

        function searchData(searchParams) {

            $.ajax({
                url: "{{ route('user.search') }}",
                method: 'GET',
                data: searchParams,
                success: function(response) {
                    $('#tbody').empty()

                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(response.data, function(index, value) {
                            console.log(value);
                            var id = index + 1;
                            var editurl = "{{ route('user.edit', ':id') }}";
                            editurl = editurl.replace(':id', value.userAuthKey);
                            var statecity = value.state + ' ' + value.city;

                            var tr = `<tr>
                                    <td class="w-50px rounded-start">` + id + `</td>
                                    <td class="w-100px rounded-start">` + value.emp_code + `</td>
                                    <td class="w-100px rounded-start">` + value.name + `</td>
                                    <td class="w-150px rounded-start">` + value.emailAddress + `</td>
                                    <td class="w-100px">` + value.mobileNumber + `</td>
                                    <td class="w-190px rounded-start">` + value.address + `</td>
                                    <td class="w-100px rounded-start">` + statecity + `</td>
                                    <td class="w-100px rounded-start">` + value.status + `</td>
                                    <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                        <a href="` + editurl + `" title="Edit" ><i class="fas fa-pencil-alt text-primary"></i> </a>
                                     <a  class="delete" data-id="` + value.userId + `">  <i class="fa fa-trash text-danger"></i>  </a>
                                    </div></td>
                                     
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
            var user_name = $('#user_name').val().trim();
            var email_id = $('#email_id').val().trim();
            var phone_no = $('#phone_no').val().trim();
            var address = $('#address').val().trim();
            var state_city = $('#state_city').val().trim();
            var emp_code = $('#emp_code').val().trim();
            var status  = $('#status').val().trim();

             var searchParams = {
                user_name: user_name,
                email_id: email_id,
                phone_no: phone_no,
                address: address,
                state_city: state_city,
                emp_code:emp_code,
                status:status,
                rowCount: 100,
                page: 1
            };
            searchData(searchParams);
        });
    </script>
@endsection
