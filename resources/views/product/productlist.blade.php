@extends('layouts.main')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack p-0 m-0">
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1 ml-10">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-dark">Product List</li>

                </ul>
            </div>

            @if(session('userinfo')->role_type == 2 )
            <div class="d-flex align-items-center mr-20px">
                <a href="{{ route('product.add') }}" class="btn btn-sm btn-primary modal-show">Add New</a>
            </div>
            @endif
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">

            <div class="row mb-xl-8">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="table-responsive">
                            <table class="table border table-striped">
                                <thead>
                                    <tr class="fw-bolder bg-light">
                                        <th class="w-50px rounded-start" style="color: #5e6278;">
                                            S.No.
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px"> Code</label>
                                                <i class="fa fa-search"></i>
                                            </div>

                                        </th>
                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="brand" class="form-control" required="">
                                                <label class="floating-label px">Brand</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="category" class="form-control" required="">
                                                <label class="floating-label px">Category</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="series" class="form-control" required="">
                                                <label class="floating-label px">Series</label>
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </th>

                                        <th class="w-160px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="product_name" class="form-control" required="">
                                                <label class="floating-label px">Product Name</label>
                                                <i class="fa fa-search"></i>
                                            </div>

                                        </th>

                                        <th class="w-100px rounded-start">
                                            <div class="floating-label-group">
                                                <input type="text" id="color" class="form-control" required="">
                                                <label class="floating-label px">Color</label>
                                                <i class="fa fa-search"></i>
                                            </div>

                                        </th>

                                        <th class="w-60px rounded-start">
                                            {{-- <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px">Piece</label>
                                                <i class="fa fa-search"></i>
                                            </div> --}}
                                            Piece
                                        </th>

                                        <th class="w-60px rounded-start">
                                            {{-- <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px">MRP</label>
                                                <i class="fa fa-search"></i>
                                            </div> --}}
                                            MRP
                                        </th>

                                        <th class="w-60px rounded-start">
                                            {{-- <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px">MRP</label>
                                                <i class="fa fa-search"></i>
                                            </div> --}}
                                            DOP
                                        </th>

                                        <th class="w-60px rounded-start">
                                            {{-- <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px">MRP</label>
                                                <i class="fa fa-search"></i>
                                            </div> --}}
                                            MOP
                                        </th>
                                        <th class="w-60px rounded-start">
                                            {{-- <div class="floating-label-group">
                                                <input type="text" id="cust_code" class="form-control" required="">
                                                <label class="floating-label px"></label>
                                                <i class="fa fa-search"></i>
                                            </div> --}}
                                            Box Packing
                                        </th>
                                        <th class="w-60px rounded-start">
                                            Box MRP
                                        </th>

                                        <th class="w-60px rounded-start">
                                            Image
                                        </th>
                                        @if(session('userinfo')->role_type == 2 )
                                        <th class="w-100px rounded-start">
                                            Action
                                        </th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody id="tbody">


                                </tbody>
                            </table>
                        </div>

                        <div class="pagen" id="pagination">
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!--end::Container-->
    </div>

    <div id="overlay" class="overlay" style="display: none;">
        <div id="overlayContent" class="overlay-content">
            <span class="close">&times;</span>
            <img id="zoomedImg" src="" alt="Zoomed Image">
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.productimg', function() {
                //alert();
                var imgSrc = $(this).attr('src');
                $('#zoomedImg').attr('src', imgSrc);
                $('#overlay').fadeIn();
            });

            // Close modal when close button or overlay background is clicked
            $('.overlay, .close').click(function() {
                $('#overlay').fadeOut();
            });

            $(document).on('click', '.delete', function() {
                event.preventDefault();
                var id = $(this).data('id');
                var url = "{{ route('product.delete', ':id') }}";
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
                            fetchData(100, 1)
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
                    url: "{{ route('product.listdata') }}",
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

                            var startIndex = (page - 1) * rowCount;

                            $.each(data.data, function(index, value) {

                                var id = startIndex + index + 1;
                                var statecity = value.state + ' ' + value.city;
                                var accessAuthKey = value.productAuthKey;
                                var url = "{{ route('product.edit', [':id', ':type']) }}"
                                                .replace(':id', accessAuthKey)
                                                .replace(':type', 'product'); // Replace 'typeValue' with your actual type variable


                                    if(value.productImage != null){
                                        var imgae = `<img src="{{ URL::asset('images/') }}/` + value.productImage + `" alt="` +
                                                            value.productImage + `"  class="w20px productimg" >`;
                                    }else{
                                        var imgae = 'NA';
                                    }

                                var tr = ` <tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                        <td class="w-100px text-end">` + value.productCode + `</td>
                                        <td class="w-100px rounded-start">` + value.brandId_fk + `</td>
                                        <td class="w-100px rounded-start">` + value.categoryId_fk + `</td>
                                        <td class="w-100px rounded-start">` + value.series + `</td>
                                        <td class="w-160px rounded-start">` + value.productName + `</td>
                                        <td class="w-100px rounded-start">` + value.productColorId_fk + `</td>
                                        <td class="w-60px text-end">` + value.piece + `</td>
                                        <td class="w-60px text-end">` + value.mrp + `</td>
                                            <td class="w-60px text-end">` + value.dop_netprice + `</td>
                                          <td class="w-60px text-end">` + value.mop_netprice + `</td>
                                        <td class="w-60px text-end">` + value.boxPack + `</td>
                                        <td class="w-60px text-end">` + value.boxMRP + `</td>
                                        <td class="w-60px rounded-start"> `+ imgae +`
                                        </td>
                                           @if(session('userinfo')->role_type == 2 )
                                        <td class="w-100px rounded-start">
                                            <div class="text-centern tblicon">

                                                <a href="` + url + `" title="Edit"><i class="fas fa-pencil-alt text-primary"></i> </a>
                                                  
                                               

                                                 <a class="delete" data-id="` + value.productId + `">  <i class="fa fa-trash text-danger"></i>  </a>
                                           </div>
                                        </td>

                                        @endif

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
                    fetchData(100, page); // Fetch data for the clicked page
                });
            }

            fetchData(100, 1);

            function searchData(searchParams) {

                $.ajax({
                    url: "{{ route('product.search') }}", // Replace with your backend route
                    method: 'GET',
                    data: searchParams,
                    success: function(response) {
                        var data = response.data;

                        $('#tbody').empty()
                        var countdata = response.data.length;
                        console.log(countdata);
                        if (countdata != 0) {

                            var startIndex = (searchParams.page - 1) * searchParams.rowCount;

                            $.each(data.data, function(index, value) {

                                var id = startIndex + index + 1;
                                var statecity = value.state + ' ' + value.city;
                                var accessAuthKey = value.productAuthKey;
                                var url = "{{ route('product.edit', [':id', ':type']) }}"
                                                .replace(':id', accessAuthKey)
                                                .replace(':type', 'product'); 

                                    if(value.productImage != null){
                                        var imgae = `<img src="{{ URL::asset('images/') }}/` + value.productImage + `" alt="` +
                                                            value.productImage + `"  class="w20px productimg" >`;
                                    }else{
                                        var imgae = 'NA';
                                    }

                                var tr = ` <tr>
                                        <td class="w-50px rounded-start">` + id + `</td>
                                        <td class="w-100px text-end">` + value.productCode + `</td>
                                        <td class="w-100px rounded-start">` + value.brandId_fk + `</td>
                                        <td class="w-100px rounded-start">` + value.categoryId_fk + `</td>
                                        <td class="w-100px rounded-start">` + value.series + `</td>
                                        <td class="w-160px rounded-start">` + value.productName + `</td>
                                        <td class="w-100px rounded-start">` + value.productColorId_fk + `</td>
                                        <td class="w-60px text-end">` + value.piece + `</td>
                                        <td class="w-60px text-end">` + value.mrp + `</td>
                                         <td class="w-60px text-end">` + value.dop_netprice + `</td>
                                          <td class="w-60px text-end">` + value.mop_netprice + `</td>
                                        <td class="w-60px text-end">` + value.boxPack + `</td>
                                        <td class="w-60px text-end">` + value.boxMRP + `</td>
                                        <td class="w-60px rounded-start"> `+ imgae +`
                                        </td>
                                         @if(session('userinfo')->role_type == 2 )
                                        <td class="w-100px rounded-start">
                                            <div class="text-centern tblicon">

                                                <a href="` + url + `" title="Edit"><i class="fas fa-pencil-alt text-primary"></i> </a>
                                                  
                                               

                                                 <a class="delete" data-id="` + value.productId + `">  <i class="fa fa-trash text-danger"></i>  </a>
                                    </div>
                                        </td>
                                        @endif

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
                        console.error('Error fetching data:', error);
                    }
                });
            }

            $('.form-control').on('keyup', function() {
                var catCode = $('#cust_code').val().trim();
                var brand = $('#brand').val().trim();
                var category = $('#category').val().trim();
                var series = $('#series').val().trim();
                var productName = $('#product_name').val().trim();
                var color = $('#color').val().trim();

                var searchParams = {
                    cat_code: catCode,
                    brand: brand,
                    category: category,
                    series: series,
                    product_name: productName,
                    color: color,
                    rowCount: 100,
                    page: 1
                };

                //console.log(searchParams);

                searchData(searchParams);
            });

        });
    </script>
@endsection
