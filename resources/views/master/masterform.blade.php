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
                    <li class="breadcrumb-item text-dark">Add Master Data</li>

                </ul>
                <!--end::Title-->


            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            {{-- <div class="d-flex align-items-center mr-20px">
                <div class="toptx"> Indicates required fields (<span class="text-danger">*</span>)</div>
            </div> --}}
            <!--end::Actions-->
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
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Information</span>

                        </h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="basic-form">
                                <form method="POST" action="#" id="">
                                    <div class="mb-1 row">
                                        <div class="col-sm-3 mb-3">
                                            <div class="floating-label-group">
                                                <input type="text" id="masterdataname" class="form-control" required="">
                                                <label class="floating-label px">Master Data</label>
                                                </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                                <div class="floating-label-group">
                                                    <input type="text" id="levelname" class="form-control" required="">
                                                    <label class="floating-label px">Level Name</label>
                                                </div>
                                        </div>

                                        <div class="col-sm-3 mb-3">
                                            <a href="#" class="btn btn-sm btn-primary pull-right masterdatasubmit">
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
        </div>
        <!--end::Container-->
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('.masterdatasubmit').on('click', function() {
                var masterdataname = $('#masterdataname').val();
                var levelname = $('#levelname').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                if (masterdataname == '') {
                    toastr.error('Enter Masterdata');
                }

                if (levelname == '') {
                    toastr.error('Enter Masterdata');
                }


                 if(masterdataname != '' && levelname != '') {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('master.indexformsubmit') }}", // Replace with your server endpoint
                            data: {
                                masterdataname:masterdataname,
                                levelname:levelname,
                                _token:csrfToken
                            },
                            success: function(response) {
                                // console.log(response.msg); 
                                var resp = response.resp;
                                var msg = response.msg;

                                if(resp === 1){
                                    toastr.success(msg);
                                    location.reload();
                                }else{
                                    toastr.error(msg);
                                }

                            }
                        });

                }


            });
        });
    </script>
@endsection
