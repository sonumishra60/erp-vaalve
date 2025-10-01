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
                    <li class="breadcrumb-item text-dark">Edit Sales User</li>

                </ul>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center mr-20px">
                <div class="toptx"> Indicates required fields (<span class="text-danger">*</span>)</div>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row mb-5 mb-xl-8">
                <div class="card">
                    <div class="card-body py-3">
                        <div class="row">
                            <!-- ------------Acordion 1---------- -->
                            <div class="accordion accordion-primary" id="accordion-one">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg collapsed" id="headingOne"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne"
                                        aria-expanded="false" role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Basic Information</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#accordion-one" style="">
                                        <div class="accordion-body-text mt-4">
                                            <input type="hidden" id="currentuserid" value="{{ $userlist->userId }}">
                                            <div class="basic-form">
                                                <form method="POST" action="" id="">
                                                    <div class="mb-3 row">

                                                        <div class="col-sm-2 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="empcode" class="form-control"
                                                                    onkeypress="return isNumberKey(event)" value="{{ $userlist->emp_code }}"
                                                                    autocomplete="off" required readonly>
                                                                <label class="floating-label-new">Emp Code <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="name" class="form-control"
                                                                    value="{{ $userlist->name }}" autocomplete="off"
                                                                    required>
                                                                <label class="floating-label px">Name <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="mobile_no" class="form-control"
                                                                    maxlength="10" value="{{ $userlist->mobileNumber }}"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    autocomplete="off" required>
                                                                <label class="floating-label px">Mobile No. <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 mb-new">

                                                            <div class="floating-label-group">
                                                                <input type="text" id="alternate_mobile_no"
                                                                    class="form-control" maxlength="10"
                                                                    value="{{ $userlist->alertnetNumber }}"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    autocomplete="off" required>
                                                                <label class="floating-label px">Alternate Mobile
                                                                    No. <span class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="email_id" class="form-control"
                                                                    value="{{ $userlist->emailAddress }}"
                                                                    autocomplete="new-email" required>
                                                                <label class="floating-label px">Email ID <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">

                                                        <div class="col-sm-3 mb-new d-none">
                                                            {{-- <div class="float-select " style="height: 30px;">
                                                                <select class="form-select form-select-sm" id="role_type"
                                                                    data-control="select2" data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels">Role Type <span
                                                                        class="text-danger">*</span> </label>
                                                            </div> --}}
                                                            <input type="hidden" id="role_type" value="3">
                                                        </div>

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="float-select " style="height: 30px;">
                                                                <select class="form-select form-select-sm  "
                                                                    data-control="select2" id="role"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Role <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="dob"
                                                                    value="{{ date('d-M-Y', $userlist->dob) }}"
                                                                    class="form-control bank_check_recieved_date"
                                                                    autocomplete="off" required>
                                                                <label class="floating-label px"> DOB <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        @php
                                                            $doa = '';
                                                            if($userlist->doa != 0){
                                                              $doa = date('d-M-Y', $userlist->doa);
                                                            }

                                                        @endphp
                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="doa"
                                                                    value="{{ $doa }}"
                                                                    class="form-control bank_check_recieved_date"
                                                                    autocomplete="off" required>
                                                                <label class="floating-label px"> DOA  </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="education"
                                                                    value="{{ $userlist->education }}"
                                                                    class="form-control" autocomplete="off" required>
                                                                <label class="floating-label px"> Education <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row mb-3">


                                                        <div class="col-sm-3 mb-new">


                                                            {{-- <div class="float-select " style="height: 30px;">
                                                                <select class="form-select form-select-sm  "
                                                                    data-control="select2" id="role"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Role <span
                                                                        class="text-danger">*</span> </label>
                                                            </div> --}}

                                                            <div class="float-select " style="height: 30px;">
                                                                {{-- <input type="text" id="reporting_head"
                                                                    class="form-control" autocomplete="off" required> --}}
                                                                <select class="form-select form-select-sm"
                                                                    id="reporting_head" data-control="select2"
                                                                    data-placeholder="">

                                                                </select>
                                                                <label class="new-labels"> Reporting Head <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>


                                                        </div>


                                                        <div class="col-sm-3 mb-new ">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="job_experence"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $userlist->job_experience }}" required>
                                                                <label class="floating-label px"> Job experience <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new ">
                                                            <div class="floating-label-group">
                                                                <input type="password" id="password"
                                                                    class="form-control" autocomplete="new-password"
                                                                    required>
                                                                <label class="floating-label px"> Password </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new  d-flex">
                                                            <!--begin::Image input-->
                                                            <div class="image-input image-input-empty"
                                                                data-kt-image-input="true"
                                                                style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                                                <!--begin::Image preview wrapper-->
                                                                <div class="image-input-wrapper w-60px h-60px"></div>
                                                                <!--end::Image preview wrapper-->

                                                                <!--begin::Edit button-->
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="Change avatar">
                                                                    <i class="bi bi-plus fs-7"></i>
                                                                    <!--begin::Inputs-->
                                                                    <input type="file" name="avatar" accept="image/*"
                                                                        id="profile_image" />
                                                                    <input type="hidden" name="avatar_remove" />
                                                                    <!--end::Inputs-->
                                                                </label>
                                                                <!--end::Edit button-->

                                                                <!--begin::Cancel button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="cancel"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="Cancel avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Cancel button-->

                                                                <!--begin::Remove button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="remove"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="Remove avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Remove button-->

                                                                @if ($userlist->profileImage)
                                                                    <div class="d-flex">
                                                                        <img src="{{ URL::asset('profile_image') . '/' . $userlist->profileImage }}"
                                                                            class="productimg">
                                                                    </div>
                                                                @endif

                                                                <input type="hidden" id="profile_img_old"
                                                                    value="{{ $userlist->profileImage }}">
                                                            </div>
                                                            <div class="check"
                                                                style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                                Profile Img </div>
                                                            <!--end::Image input-->
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-4 mb-new">
                                                            {{-- <div class="floating-label-group">
                                                                <input type="text" id="address" class="form-control"
                                                                    style="height: 55px;"
                                                                    value="{{ $userlist->address }}" autocomplete="off"
                                                                    required>
                                                                <label class="floating-label px">Address <span
                                                                        class="text-danger">*</span> </label>
                                                            </div> --}}

                                                            <div class="form-floating">
                                                                <textarea class="form-control" id="address"> {{ $userlist->address }} </textarea>
                                                                <label for="floatingTextarea"
                                                                    class="floatingTextarea">Address <span
                                                                    class="text-danger">*</span> </label>
                                                            </div>

                                                        </div>


                                                        <div class="col-sm-3 mb-new ">
                                                            <div class="float-select" style="height: 30px;">
                                                                <select class="form-select form-select-sm" id="statename"
                                                                    data-control="select2" data-placeholder="">
                                                                </select>
                                                                <label class="new-labels">State <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-3 mb-new ">
                                                            <div class="float-select" style="height: 30px;">
                                                                <select class="form-select form-select-sm" id="city_id"
                                                                    data-control="select2" data-placeholder="">

                                                                </select>
                                                                <label class="new-labels">City <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ------------End Acordion 1---------- -->

                            <!-- ------------Acordion 8---------- -->

                            <div class="accordion accordion-primary" id="accordion-2">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg collapsed" id="heading2"
                                        data-bs-toggle="collapse" data-bs-target="#collapse2" aria-controls="collapse2"
                                        aria-expanded="false" role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Bank Details</span>
                                        <span class="accordion-header-indicator"></span>

                                    </div>
                                    <div id="collapse2" class="collapse" aria-labelledby="heading2"
                                        data-bs-parent="#accordion-2" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" action="#" id="">
                                                    <div class="mb-1 row">

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    id="select_bank" data-control="select2"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Select Bank</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="account_no"
                                                                    value="{{ @$trans_salesBankInfo->accountNo }}"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    maxlength="17" class="form-control"
                                                                    autocomplete="off" autofocus required />
                                                                <label class="floating-label px">Enter Account
                                                                    Number</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group mt-1">
                                                                <input type="text" id="account_holder_name"
                                                                    value="{{ @$trans_salesBankInfo->accountHolder }}"
                                                                    class="form-control " autocomplete="off" autofocus
                                                                    required />
                                                                <label class="floating-label px">Enter Account Holder
                                                                    Name</label>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-3 mb-new">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="ifsc_code"
                                                                    value="{{ @$trans_salesBankInfo->ifscCode }}"
                                                                    class="form-control text-uppercase" autocomplete="off"
                                                                    autofocus required />
                                                                <label class="floating-label px">Enter IFSC Code</label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ------------End Acordion 8---------- -->


                            <div class="accordion accordion-primary" id="accordion-9">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg" id="heading9" data-bs-toggle="collapse"
                                        data-bs-target="#collapse9" aria-controls="collapse9" aria-expanded="true"
                                        role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Aadhaar Information</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapse9" class="collapse" aria-labelledby="heading9"
                                        data-bs-parent="#accordion-9" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" id="form8">
                                                    <div class="mb-1 row">


                                                        <div class="col-sm-4 mb-new mb-1">

                                                            <div class="floating-label-group">
                                                                <input type="text" id="adahar_number"
                                                                    class="form-control" maxlength="16"
                                                                    value="{{ $userlist->aadhar_number }}"
                                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                    autocomplete="off" autofocus="" required=""
                                                                    fdprocessedid="oflyqs3">
                                                                <label class="floating-label px">Enter Doc
                                                                    Number <span class="text-danger">*</span> </label>
                                                            </div>


                                                        </div>

                                                        <div class="col-sm-2  mb-new mb-1 d-flex">


                                                            <!--begin::Image input-->
                                                            <div class="image-input image-input-empty"
                                                                data-kt-image-input="true"
                                                                style="background-image: url(http://127.0.0.1:8000/assets/media/svg/files/blank-image.svg">
                                                                <!--begin::Image preview wrapper-->
                                                                <div class="image-input-wrapper w-60px h-60px">
                                                                </div>
                                                                <!--end::Image preview wrapper-->

                                                                <!--begin::Edit button-->
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Change avatar">
                                                                    <i class="bi bi-plus fs-7"></i>

                                                                    <!--begin::Inputs-->
                                                                    <input type="file" id="adahar_front_image"
                                                                        name="avatar" accept=".png, .jpg, .jpeg, .pdf,">
                                                                    <input type="hidden" name="avatar_remove">
                                                                    <!--end::Inputs-->
                                                                </label>
                                                                <!--end::Edit button-->

                                                                <!--begin::Cancel button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="cancel"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Cancel avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Cancel button-->

                                                                <!--begin::Remove button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="remove"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Remove avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Remove button-->

                                                                @if ($userlist->aadhar_imageFront)
                                                                    <div class="d-flex">
                                                                        <img src="{{ URL::asset('document') . '/' . $userlist->aadhar_imageFront }}"
                                                                            class="productimg">
                                                                    </div>
                                                                @endif
                                                                <input type="hidden" id="aadhar_imageFront_old"
                                                                    value="{{ $userlist->aadhar_imageFront }}">
                                                            </div>
                                                            <div class="check"
                                                                style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                                Aadhaar Front </div>
                                                            <!--end::Image input-->
                                                        </div>

                                                        <div class="col-sm-2 mb-1 d-flex">


                                                            <!--begin::Image input-->
                                                            <div class="image-input image-input-empty"
                                                                data-kt-image-input="true"
                                                                style="background-image: url(http://127.0.0.1:8000/assets/media/svg/files/blank-image.svg">
                                                                <!--begin::Image preview wrapper-->
                                                                <div class="image-input-wrapper w-60px h-60px">
                                                                </div>
                                                                <!--end::Image preview wrapper-->

                                                                <!--begin::Edit button-->
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Change avatar">
                                                                    <i class="bi bi-plus fs-7"></i>

                                                                    <!--begin::Inputs-->
                                                                    <input type="file" id="adahar_back_image"
                                                                        name="avatar" accept=".png, .jpg, .jpeg, .pdf,">
                                                                    <input type="hidden" name="avatar_remove">
                                                                    <!--end::Inputs-->
                                                                </label>
                                                                <!--end::Edit button-->

                                                                <!--begin::Cancel button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="cancel"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Cancel avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Cancel button-->

                                                                <!--begin::Remove button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="remove"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Remove avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Remove button-->

                                                                @if ($userlist->aadharBackImage)
                                                                    <div class="d-flex">
                                                                        <img src="{{ URL::asset('document') . '/' . $userlist->aadharBackImage }}"
                                                                            class="productimg">
                                                                    </div>
                                                                @endif
                                                                <input type="hidden" id="aadharBackImage_old"
                                                                    value="{{ $userlist->aadharBackImage }}">

                                                            </div>
                                                            <div class="check"
                                                                style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                                Aadhaar Back </div>
                                                            <!--end::Image input-->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion accordion-primary" id="accordion-10">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg" id="heading9" data-bs-toggle="collapse"
                                        data-bs-target="#collapse10" aria-controls="collapse10" aria-expanded="true"
                                        role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Pan Information</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapse10" class="collapse" aria-labelledby="heading10"
                                        data-bs-parent="#accordion-10" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" id="form9">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="floating-label-group">
                                                                <input type="text" id="pan_number"
                                                                    value="{{ $userlist->pan_number }}"
                                                                    class="form-control text-uppercase" autocomplete="off"
                                                                    autofocus="" required="" fdprocessedid="qmy3tb">
                                                                <label class="floating-label px">Enter Pan
                                                                    No. <span class="text-danger">*</span> </label>
                                                            </div>



                                                        </div>



                                                        <div class="col-sm-2 mb-1 d-flex">


                                                            <!--begin::Image input-->
                                                            <div class="image-input image-input-empty"
                                                                data-kt-image-input="true"
                                                                style="background-image: url(http://127.0.0.1:8000/assets/media/svg/files/blank-image.svg">
                                                                <!--begin::Image preview wrapper-->
                                                                <div class="image-input-wrapper w-60px h-60px">
                                                                </div>
                                                                <!--end::Image preview wrapper-->

                                                                <!--begin::Edit button-->
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Change avatar">
                                                                    <i class="bi bi-plus fs-7"></i>

                                                                    <!--begin::Inputs-->
                                                                    <input type="file" id="pan_card_image"
                                                                        name="avatar" accept=".png, .jpg, .jpeg, .pdf,">
                                                                    <input type="hidden" name="avatar_remove">
                                                                    <!--end::Inputs-->
                                                                </label>
                                                                <!--end::Edit button-->

                                                                <!--begin::Cancel button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="cancel"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Cancel avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Cancel button-->

                                                                <!--begin::Remove button-->
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="remove"
                                                                    data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                    title="" data-bs-original-title="Remove avatar">
                                                                    <i class="bi bi-x fs-2"></i>
                                                                </span>
                                                                <!--end::Remove button-->

                                                                @if ($userlist->pancardImage)
                                                                    <div class="d-flex">
                                                                        <img src="{{ URL::asset('document') . '/' . $userlist->pancardImage }}"
                                                                            class="productimg">
                                                                    </div>
                                                                @endif

                                                                <input type="hidden" id="pancardImage_old"
                                                                    value="{{ $userlist->pancardImage }}">
                                                            </div>
                                                            <!--end::Image input-->


                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="mb-4 mt-3 row">

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary subtn saveuserForm  pull-right"
                                    style="margin-left: 10px;">
                                    <div class="spinner-border d-none distriloader" role="status">
                                    </div> Submit
                                </button>
                                {{-- <button type="submit" class="btn btn-primary subtn savedelegationForm pull-right">Show
                                    All</button> --}}
                                <!-- <button type="button" class="btn btn-primary subtn savedelegationForm">Submit</button> -->
                            </div>
                        </div>
                    </div>
                    <!--begin::Body-->
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
        funroles(3).done(function(roles) {

            var rolesid = '{{ $userlist->roleId_fk }}';
            var data = roles.data;
            var options = '<option value="">Select Role</option>';
            $.each(data, function(key, value) {

                var selected = (rolesid == value.masterMenuId) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '" ' + selected + '>' + value
                    .name + '</option>';
            });
            $('#role').empty().append(options);
        });


        fungetallsalesuser().done(function(sales) {

            var userId = '{{ $userlist->reporting_head }}';
            var data = sales.data;
            var options = '<option value="" >Select Role Type</option>';
            $.each(data, function(key, value) {

                var selected = (userId == value.userId) ? 'selected' : '';

                options += '<option value="' + value.userId + '" ' + selected + ' >' + value.name +
                    '</option>';
            });

            $('#reporting_head').empty().append(options);

        })



        funlocation().done(function(response) {

            var state = '{{ $userlist->state }}';
            var data = response.data;
            var options = '<option value="" >Select State</option>';
            $.each(data, function(key, value) {

                selected = (state == value.cityId) ? 'selected' : '';

                if (selected) {
                    getcitys(value.cityId);
                }

                options += '<option value="' + value.cityId + '" ' + selected + ' >' + value.cityName +
                    '</option>';
            });

            $('#statename').empty().append(options);
        });



        function getcitys(stateId) {

            funcitybysate(stateId).done(function(roles) {

                var city = '{{ $userlist->city }}';
                var data = roles.data;
                var options = '<option value="">Select City</option>';
                $.each(data, function(key, value) {

                    var selected = (city == value.cityId) ? 'selected' : '';
                    options += '<option value="' + value.cityId + '" ' + selected + '>' + value
                        .cityName + '</option>';
                });
                $('#city_id').empty().append(options);
            });

        }

        funbanktype().done(function(masterdistributor) {
            var data = masterdistributor.data;
            var bankId_fk = '{{ @$trans_salesBankInfo->bankId_fk }}';
            var options = '<option value="" >Select Bank</option>';
            $.each(data, function(key, value) {
                selected = (bankId_fk == value.masterMenuId) ? 'selected' : '';
                options += '<option value="' + value.masterMenuId + '" ' + selected + ' >' + value.name +
                    '</option>';
            });
            $('#select_bank').empty().append(options);
        });


        $(document).ready(function() {

            $('.pwd-toggle').on('click', function() {
                var $pwdInput = $(this).siblings('#password');
                var type = $pwdInput.attr('type') === 'password' ? 'text' : 'password';
                $pwdInput.attr('type', type);
                $(this).toggleClass('fa-eye fa-eye-slash');
            });

            $('.accordion .collapse').collapse({
                toggle: false
            });
            $('.accordianbutton').on('click', function() {
                var $button = $(this);
                var isAllOpen = $button.text().trim() === 'Close All';

                $('.accordion .collapse').each(function() {
                    $(this).collapse(isAllOpen ? 'hide' : 'show');
                });

                $button.text(isAllOpen ? 'Show All' : 'Close All');
            });


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


            $('#role_type').change(function() {
                var roleTypeId = $(this).val();
                if (roleTypeId) {
                    funroles(roleTypeId).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select Role</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.masterMenuId + '">' + value
                                .name + '</option>';
                        });
                        $('#role').empty().append(options);
                    });
                } else {
                    $('#role').empty().append('<option value="">Select Role</option>');
                }
            });

            $('#statename').change(function() {
                var stateId = $(this).val();
                if (stateId) {
                    funcitybysate(stateId).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#city_id').empty().append(options);
                    });
                } else {
                    $('#city_id').empty().append('<option value="">Select City</option>');
                }

            });

            $('.saveuserForm').on('click', function() {

                var checkvalidation = 0;
                var name = $('#name').val();
                var mobile_no = $('#mobile_no').val();
                var alternate_mobile_no = $('#alternate_mobile_no').val();
                var email_id = $('#email_id').val();
                var role_type = $('#role_type').val();
                var role = $('#role').val();
                var statename = $('#statename').val();
                var city_id = $('#city_id').val();
                var password = $('#password').val();
                var profileimage = $('#profile_image')[0].files[0];
                var address = $('#address').val();
                var dob = $('#dob').val();
                var doa = $('#doa').val();
                var education = $('#education').val();
                var reporting_head = $('#reporting_head').val();
                var job_experence = $('#job_experence').val();
                var select_bank = $('#select_bank').val();
                var account_no = $('#account_no').val();
                var account_holder_name = $('#account_holder_name').val();
                var ifsc_code = $('#ifsc_code').val();
                var adahar_number = $('#adahar_number').val();
                var adahar_front_image = $('#adahar_front_image')[0].files[0];
                var adahar_back_image = $('#adahar_back_image')[0].files[0];
                var pan_number = $('#pan_number').val();
                var pan_card_image = $('#pan_card_image')[0].files[0];
                var profile_img_old = $('#profile_img_old').val();
                var currentuserid = $('#currentuserid').val();
                var pancardImage_old = $('#pancardImage_old').val();
                var aadharBackImage_old = $('#aadharBackImage_old').val();
                var aadhar_imageFront_old = $('#aadhar_imageFront_old').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (name == "") {
                    $('#name').css('border-color', 'red');
                    toastr.error('Enter Name');
                    checkvalidation++;
                } else {
                    $('#name').css('border-color', '');
                }

                if (mobile_no == "") {
                    $('#mobile_no').css('border-color', 'red');
                    toastr.error('Enter Mobile No.');
                    checkvalidation++;
                } else if (!validatePhone(mobile_no)) {
                    $('#mobile_no').css('border-color', 'red');
                    toastr.error('Enter Valid Mobile No.');
                    checkvalidation++;

                } else {
                    $('#mobile_no').css('border-color', '');
                }

                if (alternate_mobile_no == "") {
                    $('#alternate_mobile_no').css('border-color', 'red');
                    toastr.error('Enter alternate Mobile No.');
                    checkvalidation++;
                } else if (!validatePhone(alternate_mobile_no)) {
                    $('#alternate_mobile_no').css('border-color', 'red');
                    toastr.error('Enter Valid Mobile No.');
                    checkvalidation++;

                } else {
                    $('#alternate_mobile_no').css('border-color', '');
                }

                if (email_id == "") {
                    $('#email_id').css('border-color', 'red');
                    toastr.error('Enter Email Id.');
                    checkvalidation++;
                } else if (!validateEmail(email_id)) {
                    $('#email_id').css('border-color', 'red');
                    toastr.error('Enter a valid email id');
                    checkvalidation++;
                } else {
                    $('#alternate_mobile_no').css('border-color', '');
                }

                if (role_type == "") {
                    $('#role_type').css('border-color', 'red');
                    toastr.error('Select Role Type.');
                    checkvalidation++;
                } else {
                    $('#role_type').css('border-color', '');
                }

                if (role == "") {
                    $('#role').css('border-color', 'red');
                    toastr.error('Select Role.');
                    checkvalidation++;
                } else {
                    $('#role').css('border-color', '');
                }
                if (statename == "") {
                    $('#statename').css('border-color', 'red');
                    toastr.error('Select State Name');
                    checkvalidation++;
                } else {
                    $('#statename').css('border-color', '');
                }

                if (city_id == "") {
                    $('#city_id').css('border-color', 'red');
                    toastr.error('Select State Name');
                    checkvalidation++;
                } else {
                    $('#city_id').css('border-color', '');
                }

                // if (password == "") {
                //     $('#password').css('border-color', 'red');
                //     toastr.error('Enter Password');
                //     checkvalidation++;
                // } else {
                //     $('#password').css('border-color', '');
                // }

                // if (profileimage == undefined) {
                //     $('#profileimage').css('border-color', 'red');
                //     toastr.error('Select Profile Image');
                //     checkvalidation++;
                // } else {
                //     $('#profileimage').css('border-color', '');
                // }

                if (address == "") {
                    $('#address').css('border-color', 'red');
                    toastr.error('Enter Address');
                    checkvalidation++;
                } else {
                    $('#address').css('border-color', '');
                }


                if (dob == "") {
                    $('#dob').css('border-color', 'red');
                    toastr.error('Enter dob');
                    checkvalidation++;
                } else {
                    $('#dob').css('border-color', '');
                }


                // if (doa == "") {
                //     $('#doa').css('border-color', 'red');
                //     toastr.error('Enter doa');
                //     checkvalidation++;
                // } else {
                //     $('#doa').css('border-color', '');
                // }

                if (education == "") {
                    $('#education').css('border-color', 'red');
                    toastr.error('Enter education');
                    checkvalidation++;
                } else {
                    $('#education').css('border-color', '');
                }

                if (reporting_head == "") {
                    $('#reporting_head').css('border-color', 'red');
                    toastr.error('Enter reporting head');
                    checkvalidation++;
                } else {
                    $('#reporting_head').css('border-color', '');
                }


                if (job_experence == "") {
                    $('#job_experence').css('border-color', 'red');
                    toastr.error('Enter job_experence');
                    checkvalidation++;
                } else {
                    $('#job_experence').css('border-color', '');
                }

                if (select_bank == "") {
                    $('#select_bank').css('border-color', 'red');
                    toastr.error('Enter select bank');
                    checkvalidation++;
                } else {
                    $('#select_bank').css('border-color', '');
                }

                if (account_no == "") {
                    $('#account_no').css('border-color', 'red');
                    toastr.error('Enter account_no');
                    checkvalidation++;
                } else {
                    $('#account_no').css('border-color', '');
                }

                if (account_holder_name == "") {
                    $('#account_holder_name').css('border-color', 'red');
                    toastr.error('Enter account holder name');
                    checkvalidation++;
                } else {
                    $('#account_holder_name').css('border-color', '');
                }

                if (ifsc_code == "") {
                    $('#ifsc_code').css('border-color', 'red');
                    toastr.error('Enter ifsc code');
                    checkvalidation++;
                } else {
                    $('#ifsc_code').css('border-color', '');
                }

                if (adahar_number == "") {
                    $('#adahar_number').css('border-color', 'red');
                    toastr.error('Enter adahar_number');
                    checkvalidation++;
                } else {
                    $('#adahar_number').css('border-color', '');
                }


                // if (!adahar_front_image) {
                //     toastr.error('Upload Aadhar Front Image');
                //     checkvalidation++;
                // }

                // if (!adahar_back_image) {
                //     toastr.error('Upload Aadhar Back Image');
                //     checkvalidation++;
                // }

                if (pan_number == "") {
                    $('#pan_number').css('border-color', 'red');
                    toastr.error('Enter pan number');
                    checkvalidation++;
                } else if (!validatePAN(pan_number)) {
                    $('#pan_number').css('border-color', 'red');
                    toastr.error('Enter Valid PAN Number');
                    checkvalidation++;
                } else {
                    $('#pan_number').css('border-color', '');
                }


                // if (!pan_card_image) {
                //     toastr.error('Upload Aadhar Back Image');
                //     checkvalidation++;
                // }

                if (checkvalidation == 0) {

                    $('.distriloader').removeClass('d-none');
                    $(this).prop('disabled', true);
                    var formData = new FormData();
                    formData.append('name', name);
                    formData.append('mobile_no', mobile_no);
                    formData.append('alternate_mobile_no', alternate_mobile_no);
                    formData.append('email_id', email_id);
                    formData.append('role_type', role_type);
                    formData.append('role', role);
                    formData.append('statename', statename);
                    formData.append('city_id', city_id);
                    formData.append('password', password);
                    formData.append('profileimage', profileimage);
                    formData.append('address', address);
                    formData.append('dob', dob);
                    formData.append('doa', doa);
                    formData.append('education', education);
                    formData.append('reporting_head', reporting_head);
                    formData.append('job_experence', job_experence);
                    formData.append('select_bank', select_bank);
                    formData.append('account_no', account_no);
                    formData.append('account_holder_name', account_holder_name);
                    formData.append('ifsc_code', ifsc_code);
                    formData.append('adahar_number', adahar_number);
                    formData.append('adahar_front_image', adahar_front_image);
                    formData.append('adahar_back_image', adahar_back_image);
                    formData.append('pan_number', pan_number);
                    formData.append('pan_card_image', pan_card_image);
                    formData.append('profile_img_old', profile_img_old);
                    formData.append('currentuserid', currentuserid);
                    formData.append('pancardImage_old', pancardImage_old);
                    formData.append('aadharBackImage_old', aadharBackImage_old);
                    formData.append('aadhar_imageFront_old', aadhar_imageFront_old);
                    formData.append('_token', csrfToken);


                    $.ajax({
                        type: 'POST',
                        url: "{{ route('user.editsubmit') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.distriloader').addClass('d-none');
                            var redirecturl = "{{ route('user.list') }}";
                            toastr.success('Data update Successfully!');
                            //location.reload();
                            window.location.replace(redirecturl);

                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while submitting the form.');
                        }
                    });

                }

            });


            // Helper functions for validation
            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // function validateGST(gst) {
            //     var re = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            //     return re.test(gst);
            // }

            function validatePhone(phone) {
                var re = /^[0-9]{10}$/;
                return re.test(phone);
            }



        })
    </script>
@endsection
