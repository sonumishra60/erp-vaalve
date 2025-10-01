@extends('layouts.main')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack p-0 m-0">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1 ml-10">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">Add Master Menu</li>
                </ul>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Container-->
    </div>


    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title align-items-start flex-column"><span
                                class="card-label fw-bolder fs-3 mb-1">Information</span></h3>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#" id="">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-3">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="masterdata"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select Master Data <span class="text-danger" >*</span></label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3 d-none">
                                            <div class="float-select">
                                                <select class="form-select form-select-sm" id="mainmenudata"
                                                    data-control="select2" data-placeholder=" ">
                                                </select>
                                                <label class="new-labels"> Select Main Menu</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="mastermenuname" class="form-control"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">Name <span class="text-danger" >*</span> </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3 d-none">
                                            <div class="floating-label-group">
                                                <input type="text" id="url" class="form-control"
                                                    autocomplete="off" required="">
                                                <label class="floating-label px">URL</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3 d-none">
                                            <div class="floating-label-group">
                                                <input type="file" id="mastermenuimage" class="form-control"  required="">
                                                <label class="floating-label-img px">Menu Image </label>
                                            </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <a href="#" class="btn btn-sm btn-primary mastermenusubmit">
                                                Save </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                    <!--begin::Body-->
                </div>
            </div>

            <div class=" ">

       
            <div class="row mb-xl-8 tablediv d-none" >
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
                                            <input type="text" id="user_name" class="form-control" required="">
                                            <label class="floating-label px">MasterName</label>
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">
                                            <input type="text" id="user_name" class="form-control" required="">
                                            <label class="floating-label px">MenuName</label>
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
        </div>

        
        
        <!--end::Container-->
    </div>


@endsection


@section('js')
    <script>
        $(document).ready(function() {


         
            funmasterdata().done(function(masterdata) {
                var data = masterdata.data;
                var options = '<option value="" >Select Master Data</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterDataId + '" >' + value.fieldName +
                        '</option>';
                });

                $('#masterdata').empty().append(options);
            });

            funmastercategory().done(function(masterparentcategory) {
              //  console.log(masterparentcategory);
                var data = masterparentcategory.data;
                var options = '<option value="" >Select Master Menu</option>';
                $.each(data, function(key, value) {
                    options += '<option value="' + value.masterMenuId + '" >' + value.name +
                        '</option>';
                });

              $('#mainmenudata').empty().append(options);
            });

            $('.mastermenusubmit').on('click', function() {
                var checkvalidation = 0;
                var masterdata = $('#masterdata').val();
                var masterdata = $('#masterdata').val();
                var mainmenudata = $('#mainmenudata').val();
                var mastermenuname = $('#mastermenuname').val();
                var url = $('#url').val();
                var mastermenuimage = $('#mastermenuimage')[0].files[0];
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (masterdata == '') {
                    toastr.error('Select Master data');
                    checkvalidation++;
                }

                if (mastermenuname == '') {
                    toastr.error('Enter Menu Name');
                    checkvalidation++;
                }

                if(mainmenudata != ''){

                    if (mastermenuimage == undefined) {
                       toastr.error('Select File');
                       checkvalidation++;
                    }

                }
                

                if (checkvalidation == 0) {
                    
                    // create form here 
                    var formData = new FormData();
                    formData.append('masterdata',masterdata);
                    formData.append('mastermenuname',mastermenuname);
                    formData.append('mainmenudata',mainmenudata);
                    formData.append('url',url);
                    formData.append('mastermenuimage',mastermenuimage);
                    formData.append('_token',csrfToken);

                    //console.log(formData);
                   // return false;

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('mastermenu.indexformsubmit') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var resp = response.resp;
                            var msg = response.msg;

                            if (resp === 1) {
                                toastr.success(msg);
                            fetchData(100, 1, masterdata);
                            }else if(resp === 2){
                                toastr.error(msg)
                            }
                             else {
                                toastr.error(msg);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while submitting the form.');
                        }
                    });
                }
            });

            $(document).on('click', '.delete', function() {
                event.preventDefault();
                var id = $(this).data('id');
                var masterdata = $('#masterdata').val();
                var url = '{{ route('mastermenu.delete', ':id') }}';
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
                                fetchData(100, 1, masterdata);
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


            function fetchData(rowCount, page, masterdata) {

                $.ajax({
                    url: "{{ route('mastermenu.listdata') }}",
                    method: 'GET',
                    data: {
                        masterdata:masterdata,
                        rowCount: rowCount,
                        page: page
                    },
                    success: function(response) {
                        $('#tbody').empty()

                        $('.tablediv').removeClass('d-none');
                        var countdata = response.data.length;
                        if (countdata != 0) {
                            $.each(response.data, function(index, value) {

                                 var id = index + 1;
                                // var editurl = "{{ route('user.edit', ':id') }}";
                                // editurl = editurl.replace(':id', value.userAuthKey);
                                // var statecity = value.state + ' ' + value.city;

                                var tr = `<tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                        <td class="w-100px rounded-start">` + value.mastername + `</td>
                                        <td class="w-150px rounded-start">` + value.mastermenuname + `</td>
                                        
                                        <td class="w-100px rounded-start"> <div class="text-centern tblicon">
                                           
                                        <a  class="delete" data-id="` + value.masterMenuId + `">  <i class="fa fa-trash text-danger"></i>  </a>
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
                        var masterdata = $('#masterdata').val();
                        var page = $(this).data('page');
                        var rowCount = $('#rowCount').val();
                        fetchData(100, page, masterdata); // Fetch data for the clicked page
                    });
                }


                
              

                $('#masterdata').change(function() {
                    var masterdata = $(this).val();

                    fetchData(100, 1, masterdata);
                });




        });
    </script>
@endsection
