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
                        <a href="/" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-dark">Category List</li>

                </ul>
                <!--end::Title-->
            </div>

            <div class="d-flex align-items-center mr-20px">
                <a class="btn btn-sm btn-primary modal-show">Add New</a>
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
                                            Category Name
                                        </th>

                                        <th class="w-150px rounded-start">
                                            Child
                                        </th>

                                        <th class="w-100px rounded-start">
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody id="tbody">


                                </tbody>
                                <!--end::Table body-->
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

    {{-- modal start here --}}

    <div class="modal fade bd-example-modal-lg" tabindex="-1" style="display: none;" aria-hidden="true" id="masterModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" style="color: #fff;">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: #fff;">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class=" ">
                                <form class="profile-form">
                                    <div class=" ">
                                        <div class="row mt-5">
                                            <div class="col-sm-12 mb-10px">
                                                <input type="hidden" name="parentId" id="parentId">
                                            </div>

                                            <div class="col-sm-12 mb-10px modalfilerow">
                                                <label class="form-label"> Category Name</label>
                                                <input type="text" name="categoryname" id="categoryname"
                                                    class="form-control" placeholder="Enter Category Name"
                                                    autocomplete="off">
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary addnewcategory">
                        <div class="spinner-border categoryloader d-none" style="width:10px;height:10px;" role="status">
                        </div>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- modal end here --}}
@endsection

@section('js')
    <script>
        $(document).on("click", ".modal-show", function() {
            $(".bd-example-modal-lg").modal("show");
            $('#parentId').val('');
        });
        $('#masterModal').on('shown.bs.modal', function() {
            $(this).find('input[type="text"]').val('');

        });

        $(document).on("click", ".modal-show-child", function() {
            var parentId = $(this).data('id');
            $('#parentId').val(parentId);
            $(".bd-example-modal-lg").modal("show");
        });


        $(document).on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('category.delete', ':id') }}";
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

                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                $('.spinner-cls').hide();
                                toastr.error('Some error occurred please try again');
                            }
                        });
                    }
                });
        });

        $('.addnewcategory').on('click', function() {

            var categoryname = $('#categoryname').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var masterdata = 15;
            var parentId = $('#parentId').val();

            if (categoryname == '') {
                toastr.error('Enter Category Name');
            }

            $.ajax({
                url: "{{ route('mastermenu.indexformsubmit') }}",
                method: 'POST',
                data: {
                    mastermenuname: categoryname,
                    masterdata: masterdata,
                    mainmenudata: parentId,
                    _token: csrfToken
                },
                beforeSend: function() {
                    $('.categoryloader').removeClass('d-none');
                    $(this).prop('disabled', true);
                },
                success: function(response) {

                    if (response.resp == 1) {
                        toastr.success(response.msg)
                        $('.categoryloader').addClass('d-none');
                        $('#masterModal').modal('hide');
                        fetchData(10, 1)
                    } else {
                        $('.categoryloader').addClass('d-none');
                        toastr.error(response.msg)
                        $('#masterModal').modal('hide');
                    }
                }
            });
        });


        $(document).on('click', '.edit', function() {
            var $row = $(this).closest('tr');
            //var $editableTds = $row.find('td:not(:last-child)');
            var $editableTds = $row.find('td');
            var $saveButton = $row.find('.save');
            $row.find('td').removeClass('modal-show');

            $editableTds.each(function(index) {
                var $td = $(this);
                var text = $td.text().trim();
                var $input;
                switch (index) {
                    case 0:
                        break;
                    case 1:
                        $input = $(
                            '<input  type="text" name="categoryname"  class="form-control" autocomplete="off">'
                        ).val(text);
                        break;

                }

                if ($input) {
                    $td.html($input);
                }
            });

            $(this).addClass('d-none');
            $saveButton.removeClass('d-none');
        });


        $(document).on('click', '.save', function() {
            var $saveButton = $(this);
            var $row = $(this).closest('tr');
            var $editableTds = $row.find('td');
            var id = $(this).data('id');
            var data = {};
            var hasBlankFields = false;

            $editableTds.each(function(index) {
                var $td = $(this);
                var $input = $td.find('input, select');
                var name = $input.attr('name');
                var value = $input.val();

                if (name) {
                    if (!value) {
                        hasBlankFields = true;
                        return false; // Exit each loop if a blank field is found
                    }
                    data[name] = value;
                }
            });

            if (hasBlankFields) {
                toastr.error('All fields must be filled out.');
                return; // Exit function if there are blank fields
            }

            data['category_id'] = id;

            $.ajax({
                url: "{{ route('category.editsubmit') }}",
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response == 1) {
                        toastr.success('Category updated successfully');
                        location.reload();
                    } else {
                        toastr.error('Category was not updated successfully');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred. Please try again.');
                }
            });
        });


        function fetchData(rowCount, page) {

            $.ajax({
                url: "{{ route('category.listdata') }}",
                method: 'GET',
                data: {
                    rowCount: rowCount,
                    page: page
                },
                success: function(response) {
                    var data = response.data;

                    $('#tbody').empty()
                    var countdata = response.data.length;
                    if (countdata != 0) {
                        $.each(data.data, function(index, value) {

                            var id = index + 1;
                            var statecity = value.state + ' ' + value.city;
                            var accessAuthKey = value.accessAuthKey;
                            var url = '{{ route("category.childlist", ":id") }}'.replace(':id', accessAuthKey);
                          
                            var tr = ` <tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                        <td class="w-100px rounded-start">` + value.name + `</td>
                                        <td class="w-150px rounded-start">
                                            <button class="btn btn-success modal-show-child" data-id="` + value
                                .masterMenuId + `" >Add</button>
                                            <a href="`+ url +`"><button class="btn btn-primary" >View</button> </a>
                                        </td>
                                        <td class="w-100px rounded-start">
                                            <div class="text-centern tblicon">
                                                <a class="edit"  title="Edit"><i class="fas fa-pencil-alt text-primary"></i> </a>
                                                  
                                                <a class="save d-none" data-id="` + value.masterMenuId + `"
                                                    title="save"><i class="fas fa-save text-danger"></i></a>

                                                 <a class="delete" data-id="18">  <i class="fa fa-trash text-danger"></i>  </a>
                                    </div>
                                        </td>

                                    </tr>`;
                            $('#tbody').append(tr);
                        });

                    } else {
                        var tr = `<tr>
                                    <td class="text-center" colspan="8"> No Record Found</td>
                                 </tr>`;

                        $('#tbody').append(tr);
                    }


                    updatePagination(response.data);
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
                var page = $(this).data('page');
                var rowCount = $('#rowCount').val();
                fetchData(10, page); // Fetch data for the clicked page
            });
        }

        fetchData(10, 1);
    </script>
@endsection
