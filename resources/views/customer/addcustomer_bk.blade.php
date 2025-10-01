@extends('layouts.main')

@section('css')
    <style>
        /* -----------multi select--------- */

        .multi-select-container {
            display: inline-block;
            position: relative;
            width: 100%;
        }



        .multi-select-menu {
            position: absolute;
            left: 0;
            top: 0.8em;
            z-index: 1;
            float: left;
            min-width: 100%;
            background: #fff;
            margin: 1em 0;
            border: 1px solid #e4e6ef;
            display: none;

        }

        .multi-select-menuitem {
            display: block;
            font-size: 11px;
            padding: 0.2em 1em 0.0em 30px;
            white-space: nowrap;
            line-height: 23px;
        }

        .multi-select-legend {
            font-size: 0.875em;
            font-weight: bold;
            padding-left: 10px;
        }

        .multi-select-legend+.multi-select-menuitem {
            padding-top: 0.25rem;
        }

        .multi-select-menuitem+.multi-select-menuitem {
            padding-top: 0;
        }

        .multi-select-presets {
            border-bottom: 1px solid #ddd;
        }

        .multi-select-menuitem input {
            position: absolute;
            margin-top: 0.25em;
            margin-left: -20px;
        }

        .multi-select-button {
            display: inline-block;
            font-size: 11px;
            padding: 0.4em 0.6em;
            max-width: 100%;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: -0.5em;
            background-color: #fff;
            border: 1px solid #e4e6ef;
            border-radius: 5px;
            cursor: default;
            color: #5e6278;

        }

        .multi-select-button:after {
            content: "";
            display: inline-block;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0.4em 0.4em 0 0.4em;
            border-color: #999 transparent transparent transparent;
            margin-left: 0.4em;
            vertical-align: 0.1em;
        }

        .multi-select-container--open .multi-select-menu {
            display: block;
        }

        .multi-select-container--open .multi-select-button:after {
            border-width: 0 0.4em 0.4em 0.4em;
            border-color: transparent transparent #999 transparent;
        }

        .multi-select-container--positioned .multi-select-menu {
            /* Avoid border/padding on menu messing with JavaScript width calculation */
            box-sizing: border-box;
        }

        .multi-select-container--positioned .multi-select-menu label {
            /* Allow labels to line wrap when menu is artificially narrowed */
            white-space: normal;
        }


        /* -------end multi select----------- */
    </style>
@endsection

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
                        <a href="home.html" class="text-muted text-hover-primary">Home</a>
                    </li>


                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-dark">Distributon Network-Add New</li>

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
                            <div class="accordion accordion-primary" id="accordion-1">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg collapsed" id="headingOne"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne"
                                        aria-expanded="false" role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Distributon Network
                                            Type</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#accordion-1" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" id="form1">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    id="customer_type" data-control="select2"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Select
                                                                    Customer Type <span class="text-danger">*</span>
                                                                </label>
                                                            </div>



                                                        </div>
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm" id="dealer_type"
                                                                    data-control="select2" data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Select
                                                                    Dealer Type <span class="text-danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" data-placeholder=" ">
                                                                    <option></option>
                                                                    <option value="1">Option 1</option>
                                                                    <option value="2">Option 2</option>
                                                                </select>
                                                                <label class="new-labels"> Select
                                                                    Primary Network Type</label>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm" id="gallery_type"
                                                                    data-control="select2" data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Select
                                                                    Galleries <span class="text-danger">*</span> </label>
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


                            <!-- ------------Acordion 2---------- -->
                            <div class="accordion accordion-primary" id="accordion-2">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg collapsed" id="headingTwo"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo"
                                        aria-expanded="false" role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Ownership Section</span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingOne"
                                        data-bs-parent="#accordion-2" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" id="form2">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-4 mb-4">

                                                            <div class="floating-label-group">
                                                                <input type="text" id="customer_name"
                                                                    class="form-control" autocomplete="off" autofocus
                                                                    required />
                                                                <label class="floating-label px">Company Name <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-4 mb-4">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="email_id" class="form-control"
                                                                    autocomplete="off" autofocus required />
                                                                <label class="floating-label ">Email Id <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 mb-4">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="phone_no"
                                                                    class="form-control text-uppercases"
                                                                    autocomplete="off" maxlength="10" autofocus
                                                                    required />
                                                                <label class="floating-label">Mobile No. <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4 mb-4">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="gst"
                                                                    class="form-control text-uppercases"
                                                                    autocomplete="off" autofocus required />
                                                                <label class="floating-label">GST No.<span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">


                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="mainheads"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Main Heads <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="cluster_type"
                                                                    data-placeholder=" ">

                                                                </select>
                                                                <label class="new-labels">Cluster <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm" id="tansproter"
                                                                    data-control="select2" data-placeholder=" ">

                                                                </select>
                                                                <label class="new-labels">
                                                                    Transporter <span class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 ">
                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="nature_of_business"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Nature of
                                                                    Ownership <span class="text-danger">*</span> </label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-4 mb-1">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="nature_name"
                                                                    class="form-control" autocomplete="off" autofocus
                                                                    required />
                                                                <label class="floating-label ">Owner Name <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-4 mb-1">
                                                            <div class="floating-label-group">
                                                                <input type="text" id="nature_mobile_no"
                                                                    maxlength="10"
                                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                    class="form-control" autocomplete="off" autofocus
                                                                    required />
                                                                <label class="floating-label">
                                                                    Whatsapp Mobile
                                                                    No <span class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    id="distributor_status" data-control="select2"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels">
                                                                    Status <span class="text-danger">*</span> </label>
                                                            </div>
                                                        </div>


                                                    </div>



                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ------------End Acordion 2---------- -->

                            <!-- ------------Acordion 4---------- -->
                            <div class="accordion accordion-primary" id="accordion-4">
                                <div class="accordion-item accordion-bg">
                                    <div class="accordion-header rounded-lg collapsed" id="headingFour"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-controls="collapseFour" aria-expanded="false" role="button">
                                        <span class="accordion-header-icon"></span>
                                        <span class="accordion-header-text fs-14">Address
                                            Information <span class="text-danger">*</span> </span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                        data-bs-parent="#accordion-4" style="">
                                        <div class="accordion-body-text mt-4">

                                            <div class="basic-form">
                                                <form method="POST" id="form4">
                                                    <div class="mb-1 row">
                                                        <div class="col-sm-4 mb-1">


                                                            {{-- <div class="floating-label-group">
                                                                <input type="text" id="street" class="form-control"
                                                                    style="height: 55px;" required="">
                                                                <label class="floating-label px">Street <span
                                                                        class="text-danger">*</span> </label>
                                                            </div> --}}
                                                            <div class="form-floating">
                                                                <textarea class="form-control"  id="street"></textarea>
                                                                <label for="floatingTextarea" class="floatingTextarea">Street</label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="select_state"
                                                                    data-placeholder=" ">
                                                                </select>
                                                                <label class="new-labels"> Select
                                                                    State <span class="text-danger">*</span> </label>
                                                            </div>

                                                            <div class="col-sm- mb-4">
                                                                <div class="floating-label-group">
                                                                    <input type="text" id="select_district" class="form-control" autocomplete="off" required="" >
                                                                    <label class="floating-label px">Select
                                                                        District <span class="text-danger">*</span> </label>
                                                                </div>
                                                            </div>

                                                            <div class="floating-label-group mt-1">
                                                                <input type="text" id="pin_code" class="form-control"
                                                                    maxlength="6"
                                                                    onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                    autocomplete="off" autofocus required />
                                                                <label class="floating-label px">Enter Pin Code <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-4 mb-1">

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="select_city"
                                                                    data-placeholder=" ">

                                                                </select>
                                                                <label class="new-labels"> Select City <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>

                                                            <div class="float-select">
                                                                <select class="form-select form-select-sm"
                                                                    data-control="select2" id="select_zone"
                                                                    data-placeholder=" ">

                                                                </select>
                                                                <label class="new-labels"> Select Zone <span
                                                                        class="text-danger">*</span> </label>
                                                            </div>

                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 4---------- -->

                        <!-- ------------Acordion 6---------- -->

                        <div class="accordion accordion-primary" id="accordion-6">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading6"
                                    data-bs-toggle="collapse" data-bs-target="#collapse6" aria-controls="collapseFive"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">Last Three Year
                                        Turnover</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse6" class="collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordion-6" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form5">
                                                <div class="ml-0 row">
                                                    <b> Vaalve (Turnover) </b>
                                                </div>
                                                <div class="mb-1 row">
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="one_year_vaalve"
                                                                class="form-control" maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label">Year 1 <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="two_year_vaalve"
                                                                class="form-control " maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Year
                                                                2 <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="three_year_vaalve"
                                                                class="form-control " maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Year
                                                                3 <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-0 row">
                                                    <b> Company (Turnover) </b>
                                                </div>
                                                <div class="mb-1 row">
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="one_year_company"
                                                                class="form-control" maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label">Year 1 <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="two_year_company"
                                                                class="form-control " maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Year
                                                                2 <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="three_year_company"
                                                                class="form-control " maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Year
                                                                3 <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 6---------- -->

                        <!-- ------------Acordion 7---------- -->

                        <div class="accordion accordion-primary" id="accordion-7">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading7"
                                    data-bs-toggle="collapse" data-bs-target="#collapse7" aria-controls="collapse7"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">Add Contact Person</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse7" class="collapse" aria-labelledby="heading7"
                                    data-bs-parent="#accordion-7" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form6">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-2 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" name="contact_person_name[]"
                                                                class="form-control" autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label">Name <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>

                                                    <div class="col-sm-2 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" name="contact_person_degination[]"
                                                                class="form-control" autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label">Designation <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" name="contact_person_email[]"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label px">Email <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-3 mb-1">



                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" class="form-control"
                                                                name="contact_mobile[]" maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Mobile <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-2 mb-1">
                                                        <div class="btn-add  addcontactper"><img
                                                                src="{{ URL::asset('assets/media/pls.png') }}"
                                                                height="25"></div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 7---------- -->

                        <!-- ------------Acordion 8---------- -->

                        <div class="accordion accordion-primary" id="accordion-8">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading8"
                                    data-bs-toggle="collapse" data-bs-target="#collapse8" aria-controls="collapse8"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">Bank Details</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse8" class="collapse" aria-labelledby="heading8"
                                    data-bs-parent="#accordion-8" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form7">
                                                <div class="mb-1 row">

                                                    <div class="col-sm-4">
                                                        <div class="float-select">
                                                            <select class="form-select form-select-sm"
                                                                data-control="select2" id="bank_name"
                                                                data-placeholder=" ">
                                                            </select>
                                                            <label class="new-labels"> Select
                                                                Bank <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 ">
                                                        <div class="float-select">
                                                            <select class="form-select form-select-sm" id="bank_type">
                                                                <option value="Saving"> Saving </option>
                                                                <option value="Current"> Current </option>
                                                            </select>
                                                            <label class="new-labels"> Bank Type <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 ">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="account_number"
                                                            maxlength="17"
                                                                class="form-control" autocomplete="off"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autofocus required />
                                                            <label class="floating-label px">Enter
                                                                Account Number <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>

                                                </div>

                                                <div class="mb-4 row">
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="account_holder_name"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label px">Enter
                                                                Account Holder Name <span class="text-danger">*</span>
                                                            </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="ifsc_code"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Enter IFSC
                                                                Code <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="ltd_llp"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label">LTD/LLP <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="mb-1 row">

                                                    <div class="col-sm-4">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="security_amount" maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label w-100px">Security
                                                                Amount <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 ">
                                                        <div class="float-select">
                                                            <select class="form-select form-select-sm" id="blank_cheq">
                                                                <option value="1">
                                                                    Yes</option>
                                                                <option value="0">
                                                                    NO</option>
                                                            </select>
                                                            <label class="new-labels">Blank Cheque <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 ">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="credit_limit" class="form-control"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label w-100px">Credit
                                                                Limit <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>

                                                </div>

                                                <div class="mb-4 row">
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="credit_period"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label w-100px">Credit
                                                                Period <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="bank_check_recieved_date"
                                                                class="form-control bank_check_recieved_date"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Cheque
                                                                Recieved Date <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="cheque_number"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label w-100px">Cheque
                                                                Number <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="mb-1 row">
                                                    <div class="col-sm-4 mb-1">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" id="amount" class="form-control "
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label w-100px">Amount <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-6 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="security_check_detail"
                                                                class="form-control" style="height: 55px;"
                                                                required="">
                                                            <label class="floating-label px">Security
                                                                Cheque Detail <span class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-1 row">
                                                    <div class="col-sm-3 mb-1 d-flex mt-2">
                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                                            <!--begin::Image preview wrapper-->
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <!--end::Image preview wrapper-->

                                                            <!--begin::Edit button-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="chquebook_image" name="avatar"
                                                                    accept=".png, .jpg, .jpeg, .pdf," />
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
                                                        </div>
                                                        <div class="check"
                                                            style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                            Cheque Book</div>
                                                        <!--end::Image input-->


                                                    </div>

                                                    <div class="col-sm-3 mb-1 d-flex mt-2">


                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }}">
                                                            <!--begin::Image preview wrapper-->
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <!--end::Image preview wrapper-->

                                                            <!--begin::Edit button-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="cheque_image" name="avatar"
                                                                    accept=".png, .jpg, .jpeg, .pdf," multiple />
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

                                                        </div>
                                                        <div class="check"
                                                            style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                            Cheque Image</div>
                                                        <!--end::Image input-->

                                                    </div>

                                                    <div class="col-sm-3 mb-1 d-flex mt-2">

                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }}">
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="agreement_image" name="avatar"
                                                                    accept=".png, .jpg, .jpeg, .pdf," multiple />
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


                                                        </div>
                                                        <div class="check"
                                                            style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                            Agreement Image</div>
                                                        <!--end::Image input-->
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ------------End Acordion 8---------- -->

                        <!-- ------------Acordion 9---------- -->

                        <div class="accordion accordion-primary" id="accordion-9">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading9"
                                    data-bs-toggle="collapse" data-bs-target="#collapse9" aria-controls="collapse9"
                                    aria-expanded="false" role="button">
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
                                                    {{-- <div class="col-sm-4 mb-1">


                                                        <div class="float-select">
                                                            <select class="form-select form-select-sm"
                                                                data-control="select2" data-placeholder=" ">
                                                                <option></option>
                                                                <option value="1">Option 1</option>
                                                                <option value="2">Option 2</option>
                                                            </select>
                                                            <label class="new-labels"> Select Doc
                                                                Type</label>
                                                        </div>


                                                    </div> --}}

                                                    <div class="col-sm-4 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="adahar_number" class="form-control"
                                                            maxlength="16"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Enter Doc
                                                                Number <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>

                                                    <div class="col-sm-2 mb-1 d-flex">


                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }}">
                                                            <!--begin::Image preview wrapper-->
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <!--end::Image preview wrapper-->

                                                            <!--begin::Edit button-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="adahar_front_image"
                                                                    name="avatar" accept=".png, .jpg, .jpeg, .pdf," />
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
                                                        </div>
                                                        <div class="check"
                                                            style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                            Aadhaar Front <span class="text-danger">*</span> </div>
                                                        <!--end::Image input-->


                                                    </div>

                                                    <div class="col-sm-2 mb-1 d-flex">


                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }}">
                                                            <!--begin::Image preview wrapper-->
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <!--end::Image preview wrapper-->

                                                            <!--begin::Edit button-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="adahar_back_image"
                                                                    name="avatar" accept=".png, .jpg, .jpeg, .pdf," />
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
                                                        </div>
                                                        <div class="check"
                                                            style="line-height: 60px; padding-left: 5px; font-size: 11px;">
                                                            Aadhaar Back <span class="text-danger">*</span> </div>
                                                        <!--end::Image input-->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 9---------- -->

                        <!-- ------------Acordion 10---------- -->

                        <div class="accordion accordion-primary" id="accordion-10">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading9"
                                    data-bs-toggle="collapse" data-bs-target="#collapse10" aria-controls="collapse10"
                                    aria-expanded="false" role="button">
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
                                                            maxlength="10"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Enter Pan
                                                                No. <span class="text-danger">*</span> </label>
                                                        </div>



                                                    </div>



                                                    <div class="col-sm-2 mb-1 d-flex">


                                                        <!--begin::Image input-->
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }}">
                                                            <!--begin::Image preview wrapper-->
                                                            <div class="image-input-wrapper w-60px h-60px">
                                                            </div>
                                                            <!--end::Image preview wrapper-->

                                                            <!--begin::Edit button-->
                                                            <label
                                                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-plus fs-7"></i>

                                                                <!--begin::Inputs-->
                                                                <input type="file" id="pan_card_image" name="avatar"
                                                                    accept=".png, .jpg, .jpeg, .pdf," />
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

                        <!-- ------------End Acordion 10---------- -->

                        <!-- ------------Acordion 11---------- -->

                        <div class="accordion accordion-primary" id="accordion-11">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading11"
                                    data-bs-toggle="collapse" data-bs-target="#collapse11" aria-controls="collapse11"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">Sanitary Discount</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse11" class="collapse" aria-labelledby="heading11"
                                    data-bs-parent="#accordion-11" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form9">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="sanitary_ex_fc_disc" maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">EX FC Discount</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="sanitary_retailer_disc"
                                                                maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Retailer Disc</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="sanitary_distributor_disc"
                                                                maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Distributor </label>
                                                        </div>



                                                    </div>

                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="sanitary_cash_disc" maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">CASH DISC </label>
                                                        </div>



                                                    </div>



                                                </div>





                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 11---------- -->


                        <!-- ------------Acordion 13---------- -->

                        <div class="accordion accordion-primary" id="accordion-13">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading9"
                                    data-bs-toggle="collapse" data-bs-target="#collapse13" aria-controls="collapse13"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">FAUCET Discount</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse13" class="collapse" aria-labelledby="heading13"
                                    data-bs-parent="#accordion-13" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form9">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="faucet_ex_fc_disc" maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">EX FC Discount</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3 mb-1">
                                                        <div class="floating-label-group">
                                                            <input type="text" id="faucet_retailer_disc"
                                                                maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Retailer Disc</label>
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="faucet_distributor_disc"
                                                                maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">Distributor </label>
                                                        </div>



                                                    </div>

                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" id="faucet_cash_disc" maxlength="2"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="floating-label px">CASH DISC </label>
                                                        </div>
                                                    </div>

                                                </div>



                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ------------End Acordion 13---------- -->


                        <!-- ------------Acordion 1---------- -->
                        <div class="accordion accordion-primary" id="accordion-12">
                            <div class="accordion-item accordion-bg">
                                <div class="accordion-header rounded-lg collapsed" id="heading12"
                                    data-bs-toggle="collapse" data-bs-target="#collapse12" aria-controls="collapse12"
                                    aria-expanded="false" role="button">
                                    <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text fs-14">Assign User</span>
                                    <span class="accordion-header-indicator"></span>
                                </div>
                                <div id="collapse12" class="collapse" aria-labelledby="heading12"
                                    data-bs-parent="#accordion-12" style="">
                                    <div class="accordion-body-text mt-4">

                                        <div class="basic-form">
                                            <form method="POST" id="form10">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-4 mb-1">


                                                        <div class="float-select">
                                                            <select class="form-select form-select-sm" id="assign_user"
                                                                data-control="select2" data-placeholder=" ">

                                                            </select>
                                                            <label class="new-labels"> Assign
                                                                User <span class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-4 mb-1">
                                                        <div class="float-select">
                                                            <input type="text" id="state_head"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="new-labels">State Heads <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4 mb-1">
                                                        <div class="float-select">
                                                            <input type="text" id="zonal_heads"
                                                                class="form-control text-uppercase" autocomplete="off"
                                                                autofocus required />
                                                            <label class="new-labels">Zonal Heads <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="mb-1 row">
                                                    <div class="col-sm-6 mb-1">
                                                        {{-- <div class="floating-label-group">
                                                            <input type="text" id="ṛemarks" class="form-control"
                                                                style="height: 55px;" required=""
                                                                fdprocessedid="nwio6a" autocomplete="off">
                                                                <textarea class="form-control"  id="ṛemarks"></textarea>
                                                            <label class="floating-label px">Remarks</label>
                                                        </div> --}}

                                                        <div class="form-floating">
                                                            <textarea class="form-control"  id="ṛemarks"></textarea>
                                                                    <label for="floatingTextarea" class="floatingTextarea">Remarks</label>
                                                        </div>

                                                    </div>
                                                </div>




                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------End Acordion 11---------- -->

                    </div>



                    <div class="mb-4 mt-3 row">

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary subtn saveForm  pull-right"
                                style="margin-left: 10px;">
                                <div class="spinner-border d-none distriloader" role="status">
                                </div>
                                Submit
                            </button>
                            <button type="submit" class="btn btn-primary subtn accordianbutton pull-right">Close
                                All</button>
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
@endsection
 
@section('js')
    <script>
        funcustomertype().done(function(mastercustomertype) {
            var data = mastercustomertype.data;
            var options = '<option value="" >Select Customer Type</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#customer_type').empty().append(options);
        });


        fundealertype().done(function(masterdealer) {
            var data = masterdealer.data;
            var options = '<option value="" >Select Dealer Type</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#dealer_type').empty().append(options);
        });


        fungalleriestype().done(function(mastergallery) {
            var data = mastergallery.data;
            var options = '<option value="" >Select Gallery Type</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#gallery_type').empty().append(options);
        });


        funbillingstatus().done(function(masterbilling) {
            var data = masterbilling.data;
            var options = '<option value="" >Select billing Type</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#billing_type').empty().append(options);
        });

        funbdistributorstatus().done(function(masterdistributor) {
            var data = masterdistributor.data;
            var options = '<option value="" >Select Distributor Type</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#distributor_status').empty().append(options);
        });

        funbusinesstype().done(function(masterdistributor) {
            var data = masterdistributor.data;
            var options = '<option value="" >Select Nature Business</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#nature_of_business').empty().append(options);
        });

        funbanktype().done(function(masterdistributor) {
            var data = masterdistributor.data;
            var options = '<option value="" >Select Nature Business</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name + '</option>';
            });
            $('#bank_name').empty().append(options);
        });

        funallsalesusers().done(function(mastersalesusers) {
            var data = mastersalesusers.data;
            var options = '<option value="" >Select sales user</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.userId + '" >' + value.name + '</option>';
            });
            $('#assign_user').empty().append(options);
        });

        funlocation().done(function(response) {
            var data = response.data;
            var options = '<option value="" >Select State</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.cityId + '" >' + value.cityName +
                    '</option>';
            });

            $('#select_state').empty().append(options);
        });


        funmainhead().done(function(response) {
            var data = response.data;
            var options = '<option value="" >Select State</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name +
                    '</option>';
            });

            $('#mainheads').empty().append(options);
        });

        funcluster().done(function(response) {
            var data = response.data;
            var options = '<option value="" >Select Cluster</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name +
                    '</option>';
            });

            $('#cluster_type').empty().append(options);
        });

        funtransproter().done(function(response) {
            var data = response.data;
            var options = '<option value="" >Select Transproter</option>';
            $.each(data, function(key, value) {
                options += '<option value="' + value.masterMenuId + '" >' + value.name +
                    '</option>';
            });

            $('#tansproter').empty().append(options);
        });

        $(document).ready(function() {
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


            $('#select_state').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#select_city').empty().append(options);
                    });
                } else {
                    $('#select_city').empty().append('<option value="">Select Role</option>');
                }
            });

            $('#select_city').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#select_district').empty().append(options);
                    });
                } else {
                    $('#select_district').empty().append('<option value="">Select Role</option>');
                }
            });

            $('#select_district').change(function() {
                var statname_id = $(this).val();
                if (statname_id) {
                    funcitybysate(statname_id).done(function(roles) {
                        var data = roles.data;
                        var options = '<option value="">Select City Name</option>';
                        $.each(data, function(key, value) {
                            options += '<option value="' + value.cityId + '">' + value
                                .cityName + '</option>';
                        });
                        $('#select_zone').empty().append(options);
                    });
                } else {
                    $('#select_zone').empty().append('<option value="">Select Role</option>');
                }
            });


            $('.addcontactper').on('click', function() {

                var div = `<div class="mb-1 row">
                                                    <div class="col-sm-2 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" name="contact_person_name[]"
                                                                class="form-control" autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label">Name <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2 mb-1">

                                                        <div class="floating-label-group">
                                                            <input type="text" name="contact_person_degination[]"
                                                                class="form-control" autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label">Designation <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-3 mb-1">

                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" name="contact_person_email[]"
                                                                class="form-control " autocomplete="off" autofocus
                                                                required />
                                                            <label class="floating-label px">Email <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-3 mb-1">



                                                        <div class="floating-label-group mt-1">
                                                            <input type="text" class="form-control"
                                                                name="contact_mobile[]" maxlength="10"
                                                                onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57"
                                                                autocomplete="off" autofocus required />
                                                            <label class="floating-label px">Mobile <span
                                                                    class="text-danger">*</span> </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-2 mb-1">
                                                        <div class="btn-add removediv"><img
                                                                src="{{ URL::asset('assets/media/remove.png') }}"
                                                                height="25"></div>
                                                    </div>

                                                </div>`;

                $('#form6').append(div);

            });

            $(document).on('click', '.removediv', function(e) {
                e.preventDefault(); // Prevent the default behavior of the anchor tag
                $(this).closest('.row').remove(); // Remove the closest parent with class "row"
            });

            $('.saveForm').on('click', function() {
                var checkvalidation = 0;
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var customer_type = $('#customer_type').val();
                var dealer_type = $('#dealer_type').val();
                var gallery_type = $('#gallery_type').val();
                var customer_name = $('#customer_name').val();
                var email_id = $('#email_id').val();
                var phone_no = $('#phone_no').val();
                var gst = $('#gst').val();
                var mainheads = $('#mainheads').val();
                var blank_cheq = $('#blank_cheq').val();
                var state_head = $('#state_head').val();
                var bank_type = $('#bank_type').val();
                var zonal_heads = $('#zonal_heads').val();
                var ṛemarks = $('#ṛemarks').val();
                var cluster_type = $('#cluster_type').val();
                var distributor_status = $('#distributor_status').val();
                var nature_of_business = $('#nature_of_business').val();
                var nature_name = $('#nature_name').val();
                var tansproter = $('#tansproter').val();
                var nature_mobile_no = $('#nature_mobile_no').val();
                var street = $('#street').val();
                var select_state = $('#select_state').val();
                var select_city = $('#select_city').val();
                var select_district = $('#select_district').val();
                var select_zone = $('#select_zone').val();
                var pin_code = $('#pin_code').val();
                var one_year_company = $('#one_year_company').val();
                var two_year_company = $('#two_year_company').val();
                var three_year_company = $('#three_year_company').val();
                var one_year_vaalve = $('#one_year_vaalve').val();
                var two_year_vaalve = $('#two_year_vaalve').val();
                var three_year_vaalve = $('#three_year_vaalve').val();
                var contact_person_name = $('input[name="contact_person_name[]"]').map(function() {
                    return $(this).val();
                }).get();
                var contact_person_degination = $('input[name="contact_person_degination[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();
                var contact_person_email = $('input[name="contact_person_email[]"]').map(function() {
                    return $(this).val();
                }).get();
                var contact_mobile = $('input[name="contact_mobile[]"]').map(function() {
                    return $(this).val();
                }).get();


                var sanitary_ex_fc_disc = $('#sanitary_ex_fc_disc').val();
                var sanitary_retailer_disc = $('#sanitary_retailer_disc').val();
                var sanitary_distributor_disc = $('#sanitary_distributor_disc').val();
                var sanitary_cash_disc = $('#sanitary_cash_disc').val();

                var faucet_ex_fc_disc = $('#faucet_ex_fc_disc').val();
                var faucet_retailer_disc = $('#faucet_retailer_disc').val();
                var faucet_distributor_disc = $('#faucet_distributor_disc').val();
                var faucet_cash_disc = $('#faucet_cash_disc').val();

                var bank_name = $('#bank_name').val();
                var account_number = $('#account_number').val();
                var ifsc_code = $('#ifsc_code').val();
                var ltd_llp = $('#ltd_llp').val();
                var account_holder_name = $('#account_holder_name').val();
                var security_amount = $('#security_amount').val();
                var credit_limit = $('#credit_limit').val();
                var credit_period = $('#credit_period').val();
                var bank_check_recieved_date = $('#bank_check_recieved_date').val();
                var cheque_number = $('#cheque_number').val();
                var amount = $('#amount').val();
                var security_check_detail = $('#security_check_detail').val();
                var chquebook_image = $('#chquebook_image')[0].files[0];
                var cheque_image = $('#cheque_image')[0].files;
                var agreement_image = $('#agreement_image')[0].files;
                var adahar_number = $('#adahar_number').val();
                var adahar_front_image = $('#adahar_front_image')[0].files[0];
                var adahar_back_image = $('#adahar_back_image')[0].files[0];
                var pan_number = $('#pan_number').val();
                var pan_card_image = $('#pan_card_image')[0].files[0];
                var assign_user = $('#assign_user').val();


                //Validate fields
                if (customer_type == '') {
                    $('#customer_type').css('border-color', 'red');
                    toastr.error('Select Customer Type');
                    checkvalidation++;
                } else {
                    $('#customer_type').css('border-color', '');
                }

                if (dealer_type == '') {
                    $('#dealer_type').css('border-color', 'red');
                    toastr.error('Select Dealer Type');
                    checkvalidation++;
                } else {
                    $('#dealer_type').css('border-color', '');
                }


                if (gallery_type == '') {
                    $('#gallery_type').css('border-color', 'red');
                    toastr.error('Select Gallery Type');
                    checkvalidation++;
                } else {
                    $('#gallery_type').css('border-color', '');
                }


                if (blank_cheq == '') {
                    $('#blank_cheq').css('border-color', 'red');
                    toastr.error('Select Blank Cheq');
                    checkvalidation++;
                } else {
                    $('#blank_cheq').css('border-color', '');
                }


                if (account_holder_name == '') {
                    $('#account_holder_name').css('border-color', 'red');
                    toastr.error('Enter Account Holder Name');
                    checkvalidation++;
                } else {
                    $('#account_holder_name').css('border-color', '');
                }


                if (zonal_heads == '') {
                    $('#zonal_heads').css('border-color', 'red');
                    toastr.error('Select zonal heads');
                    checkvalidation++;
                } else {
                    $('#zonal_heads').css('border-color', '');
                }


                if (state_head == '') {
                    $('#state_head').css('border-color', 'red');
                    toastr.error('Select State Heads');
                    checkvalidation++;
                } else {
                    $('#state_head').css('border-color', '');
                }

                // if (ṛemarks == '') {
                //     $('#ṛemarks').css('border-color', 'red');
                //     toastr.error('Select State Heads');
                //     checkvalidation++;
                // } else {
                //     $('#ṛemarks').css('border-color', '');
                // }

                if (customer_name == '') {
                    $('#customer_name').css('border-color', 'red');
                    toastr.error('Enter Company Name');
                    checkvalidation++;
                } else {
                    $('#customer_name').css('border-color', '');
                }


                if (email_id == '') {
                    $('#email_id').css('border-color', 'red');
                    toastr.error('Enter Email Id.');
                    checkvalidation++;
                } else if (!validateEmail(email_id)) {
                    $('#email_id').css('border-color', 'red');
                    toastr.error('Enter a valid email id');
                    checkvalidation++;
                } else {
                    $('#email_id').css('border-color', '');
                }


                if (phone_no == '') {
                    $('#phone_no').css('border-color', 'red');
                    toastr.error('Enter Cust Code');
                    checkvalidation++;
                } else {
                    $('#phone_no').css('border-color', '');
                }


                if (gst == '') {
                    $('#gst').css('border-color', 'red');
                    toastr.error('Enter GST No.');
                    checkvalidation++;
                } else if (!validateGST(gst)) {
                    $('#gst').css('border-color', 'red');
                    toastr.error('Enter a valid GST number');
                    checkvalidation++;
                } else {
                    $('#gst').css('border-color', '');
                }

                if (mainheads == '') {
                    $('#mainheads').css('border-color', 'red');
                    toastr.error('Select Billing status');
                    checkvalidation++;
                } else {
                    $('#mainheads').css('border-color', '');
                }

                if (tansproter == '') {
                    $('#tansproter').css('border-color', 'red');
                    toastr.error('Select transproter');
                    checkvalidation++;
                } else {
                    $('#tansproter').css('border-color', '');
                }

                if (cluster_type == '') {
                    $('#cluster_type').css('border-color', 'red');
                    toastr.error('Select cluster status');
                    checkvalidation++;
                } else {
                    $('#cluster_type').css('border-color', '');
                }

                if (distributor_status == '') {
                    $('#distributor_status').css('border-color', 'red');
                    toastr.error('Select Status');
                    checkvalidation++;
                } else {
                    $('#distributor_status').css('border-color', '');
                }

                if (nature_of_business == '') {
                    $('#nature_of_business').css('border-color', 'red');
                    toastr.error('Select Nature Of Business');
                    checkvalidation++;
                } else {
                    $('#nature_of_business').css('border-color', '');
                }

                if (nature_name == '') {
                    $('#nature_name').css('border-color', 'red');
                    toastr.error('Enter Nature Name');
                    checkvalidation++;
                } else {
                    $('#nature_name').css('border-color', '');
                }

                if (nature_mobile_no == '') {
                    $('#nature_mobile_no').css('border-color', 'red');
                    toastr.error('Enter Mobile No.');
                    checkvalidation++;
                } else if (!validatePhone(nature_mobile_no)) {
                    $('#nature_mobile_no').css('border-color', 'red');
                    toastr.error('Enter Valid Mobile No.');
                    checkvalidation++;

                } else {
                    $('#nature_mobile_no').css('border-color', '');
                }

                if (street == '') {
                    $('#street').css('border-color', 'red');
                    toastr.error('Enter Street Address');
                    checkvalidation++;
                } else {
                    $('#street').css('border-color', '');
                }

                if (select_state == '') {
                    $('#select_state').css('border-color', 'red');
                    toastr.error('Select State');
                    checkvalidation++;
                } else {
                    $('#select_state').css('border-color', '');
                }

                if (select_city == '') {
                    $('#select_city').css('border-color', 'red');
                    toastr.error('Select City');
                    checkvalidation++;
                } else {
                    $('#select_city').css('border-color', '');
                }

                // if (select_district == '') {
                //     $('#select_district').css('border-color', 'red');
                //     toastr.error('Select District');
                //     checkvalidation++;
                // } else {
                //     $('#select_district').css('border-color', '');
                // }
                // if (select_zone == '') {
                //     $('#select_zone').css('border-color', 'red');
                //     toastr.error('Select Zone');
                //     checkvalidation++;
                // } else {
                //     $('#select_zone').css('border-color', '');
                // }
                if (pin_code == '') {
                    $('#pin_code').css('border-color', 'red');
                    toastr.error('Enter Pin Code.');
                    checkvalidation++;
                } else {
                    $('#pin_code').css('border-color', '');
                }
                if (one_year_company == '') {
                    $('#one_year_company').css('border-color', 'red');
                    toastr.error('Enter Turnover One');
                    checkvalidation++;
                } else {
                    $('#one_year_company').css('border-color', '');
                }
                if (two_year_company == '') {
                    $('#two_year_company').css('border-color', 'red');
                    toastr.error('Enter Turnover Two');
                    checkvalidation++;
                } else {
                    $('#two_year_company').css('border-color', '');
                }
                if (three_year_company == '') {
                    $('#three_year_company').css('border-color', 'red');
                    toastr.error('Enter Turnover Three');
                    checkvalidation++;
                } else {
                    $('#three_year_company').css('border-color', '');
                }

                if (one_year_vaalve == '') {
                    $('#one_year_vaalve').css('border-color', 'red');
                    toastr.error('Enter Turnover One');
                    checkvalidation++;
                } else {
                    $('#one_year_vaalve').css('border-color', '');
                }
                if (two_year_vaalve == '') {
                    $('#two_year_vaalve').css('border-color', 'red');
                    toastr.error('Enter Turnover Two');
                    checkvalidation++;
                } else {
                    $('#two_year_vaalve').css('border-color', '');
                }
                if (three_year_vaalve == '') {
                    $('#three_year_vaalve').css('border-color', 'red');
                    toastr.error('Enter Turnover Three');
                    checkvalidation++;
                } else {
                    $('#three_year_vaalve').css('border-color', '');
                }


                if (contact_person_name.length === 0 || contact_person_name.some(name => name === '')) {
                    $('input[name="contact_person_name[]"]').css('border-color', 'red');
                    toastr.error('Enter Contact Person Name');
                    checkvalidation++;
                } else {
                    $('input[name="contact_person_name[]"]').css('border-color', '');
                }

                if (contact_person_degination.length === 0 || contact_person_degination.some(deg => deg ===
                        '')) {
                    $('input[name="contact_person_degination[]"]').css('border-color', 'red');
                    toastr.error('Enter Contact Person Designation');
                    checkvalidation++;
                } else {
                    $('input[name="contact_person_degination[]"]').css('border-color', '');
                }

                if (contact_person_email.length === 0 || contact_person_email.some(email => email === '')) {
                    $('input[name="contact_person_email[]"]').css('border-color', 'red');
                    toastr.error('Enter Contact Person Email');
                    checkvalidation++;
                }


                if (contact_mobile.length === 0 || contact_mobile.some(mobile => mobile === '')) {
                    $('input[name="contact_mobile[]"]').css('border-color', 'red');
                    toastr.error('Enter Contact Mobile');
                    checkvalidation++;
                }

                if (bank_name == '') {
                    $('#bank_name').css('border-color', 'red');
                    toastr.error('Select Bank Name');
                    checkvalidation++;
                } else {
                    $('#bank_name').css('border-color', '');
                }


                if (bank_type == '') {
                    $('#bank_type').css('border-color', 'red');
                    toastr.error('Select Bank Type');
                    checkvalidation++;
                } else {
                    $('#bank_type').css('border-color', '');
                }


                if (account_number == '') {
                    $('#account_number').css('border-color', 'red');
                    toastr.error('Enter Account Number');
                    checkvalidation++;
                } else {
                    $('#account_number').css('border-color', '');
                }

                if (ifsc_code == '') {
                    $('#ifsc_code').css('border-color', 'red');
                    toastr.error('Enter IFSC Code');
                    checkvalidation++;
                } else {
                    $('#ifsc_code').css('border-color', '');
                }

                // Validate ltd_llp
                if (ltd_llp == '') {
                    $('#ltd_llp').css('border-color', 'red');
                    toastr.error('Enter LTD/LLP');
                    checkvalidation++;
                } else {
                    $('#ltd_llp').css('border-color', '');
                }

                // Validate security_amount
                if (security_amount == '') {
                    $('#security_amount').css('border-color', 'red');
                    toastr.error('Enter Security Amount');
                    checkvalidation++;
                } else {
                    $('#security_amount').css('border-color', '');
                }

                // Validate credit_limit
                if (credit_limit == '') {
                    $('#credit_limit').css('border-color', 'red');
                    toastr.error('Enter Credit Limit');
                    checkvalidation++;
                } else {
                    $('#credit_limit').css('border-color', '');
                }

                // Validate credit_period
                if (credit_period == '') {
                    $('#credit_period').css('border-color', 'red');
                    toastr.error('Enter Credit Period');
                    checkvalidation++;
                } else {
                    $('#credit_period').css('border-color', '');
                }

                // Validate bank_check_recieved_date
                if (bank_check_recieved_date == '') {
                    $('#credit_period').css('border-color', 'red');
                    toastr.error('Enter Bank Check Received Date');
                    checkvalidation++;
                } else {
                    $('#credit_period').css('border-color', '');
                }

                // Validate cheque_number
                if (cheque_number == '') {
                    $('#cheque_number').css('border-color', 'red');
                    toastr.error('Enter Cheque Number');
                    checkvalidation++;
                } else {
                    $('#cheque_number').css('border-color', '');
                }

                // Validate amount
                if (amount == '') {
                    $('#amount').css('border-color', 'red');
                    toastr.error('Enter Amount');
                    checkvalidation++;
                } else {
                    $('#amount').css('border-color', '');
                }

                // Validate security_check_detail
                if (security_check_detail == '') {
                    $('#security_check_detail').css('border-color', 'red');
                    toastr.error('Enter Security Check Detail');
                    checkvalidation++;
                } else {
                    $('#security_check_detail').css('border-color', '');
                }

                // Validate chquebook_image
                if (!chquebook_image) {
                    toastr.error('Upload Chequebook Image');
                    checkvalidation++;
                }

                // Validate cheque_image
                if (!cheque_image) {
                    toastr.error('Upload Cheque Image');
                    checkvalidation++;
                }

                // Validate adahar_number
                if (adahar_number == '') {
                    $('#adahar_number').css('border-color', 'red');
                    toastr.error('Enter Aadhar Number');
                    checkvalidation++;
                } else {
                    $('#adahar_number').css('border-color', '');
                }

                // Validate adahar_front_image
                if (!adahar_front_image) {
                    toastr.error('Upload Aadhar Front Image');
                    checkvalidation++;
                }

                // Validate adahar_back_image
                if (!adahar_back_image) {
                    toastr.error('Upload Aadhar Back Image');
                    checkvalidation++;
                }

                // Validate pan_number
                if (pan_number == '') {
                    $('#pan_number').css('border-color', 'red');
                    toastr.error('Enter PAN Number');
                    checkvalidation++;
                } else if (!validatePAN(pan_number)) {
                    $('#pan_number').css('border-color', 'red');
                    toastr.error('Enter Valid PAN Number');
                    checkvalidation++;
                } else {
                    $('#pan_number').css('border-color', '');
                }

                // Validate pan_card_image
                if (!pan_card_image) {
                    toastr.error('Upload PAN Card Image');
                    checkvalidation++;
                }

                // Validate assign_user
                if (assign_user == '') {
                    $('#assign_user').css('border-color', 'red');
                    toastr.error('Select Assigned User');
                    checkvalidation++;
                }

                // Repeat the validation for other fields...

                if (checkvalidation > 0) {
                    return false;
                }

                $(this).prop('disabled', true);
                // Create FormData object
                var formData = new FormData();
                formData.append('customer_type', customer_type);
                formData.append('dealer_type', dealer_type);
                formData.append('gallery_type', gallery_type);
                formData.append('customer_name', customer_name);
                formData.append('email_id', email_id);
                formData.append('phone_no', phone_no);
                formData.append('gst', gst);
                formData.append('mainheads', mainheads);
                formData.append('cluster_type', cluster_type);
                formData.append('distributor_status', distributor_status);
                formData.append('nature_of_business', nature_of_business);
                formData.append('nature_name', nature_name);
                formData.append('nature_mobile_no', nature_mobile_no);
                formData.append('street', street);
                formData.append('blank_cheq', blank_cheq);
                formData.append('account_holder_name', account_holder_name);
                //formData.append('account_type', account_type);
                formData.append('state_head', state_head);
                formData.append('ṛemarks', ṛemarks);
                formData.append('zonal_heads', zonal_heads);
                formData.append('select_state', select_state);
                formData.append('select_city', select_city);
                formData.append('select_district', select_district);
                formData.append('select_zone', select_zone);
                formData.append('pin_code', pin_code);
                formData.append('one_year_company', one_year_company);
                formData.append('two_year_company', two_year_company);
                formData.append('three_year_company', three_year_company);
                formData.append('one_year_vaalve', one_year_vaalve);
                formData.append('two_year_vaalve', two_year_vaalve);
                formData.append('three_year_vaalve', three_year_vaalve);

                formData.append('sanitary_ex_fc_disc', sanitary_ex_fc_disc);
                formData.append('sanitary_retailer_disc', sanitary_retailer_disc);
                formData.append('sanitary_distributor_disc', sanitary_distributor_disc);
                formData.append('sanitary_cash_disc', sanitary_cash_disc);
                formData.append('faucet_ex_fc_disc', faucet_ex_fc_disc);
                formData.append('faucet_retailer_disc', faucet_retailer_disc);
                formData.append('faucet_distributor_disc', faucet_distributor_disc);
                formData.append('faucet_cash_disc', faucet_cash_disc);


                contact_person_name.forEach((name, index) => formData.append(
                    `contact_person_name[${index}]`, name));
                contact_person_degination.forEach((deg, index) => formData.append(
                    `contact_person_degination[${index}]`, deg));
                contact_person_email.forEach((email, index) => formData.append(
                    `contact_person_email[${index}]`, email));
                contact_mobile.forEach((mobile, index) => formData.append(`contact_mobile[${index}]`,
                    mobile));

                formData.append('bank_name', bank_name);
                formData.append('bank_type', bank_type);
                formData.append('account_number', account_number);
                formData.append('ifsc_code', ifsc_code);
                formData.append('ltd_llp', ltd_llp);
                formData.append('security_amount', security_amount);
                formData.append('credit_limit', credit_limit);
                formData.append('credit_period', credit_period);
                formData.append('bank_check_recieved_date', bank_check_recieved_date);
                formData.append('cheque_number', cheque_number);
                formData.append('amount', amount);
                formData.append('security_check_detail', security_check_detail);
                formData.append('chquebook_image', chquebook_image);
                //console.log('cheque_image_length => '+cheque_image.length);

                for (var i = 0; i < cheque_image.length; i++) {
                    formData.append('cheque_images[]', cheque_image[i]);
                }

                for (var p = 0; p < agreement_image.length; p++) {
                    formData.append('agreement_image[]', agreement_image[p]);
                }

                formData.append('adahar_number', adahar_number);
                formData.append('adahar_front_image', adahar_front_image);
                formData.append('adahar_back_image', adahar_back_image);
                formData.append('pan_number', pan_number);
                formData.append('pan_card_image', pan_card_image);
                formData.append('assign_user', assign_user);
                formData.append('tansproter', tansproter);
                formData.append('_token', csrfToken);

                // console.log(formData);
                // return false;

                $('.distriloader').removeClass('d-none');

                // Submit form data via AJAX
                $.ajax({
                    url: "{{ route('customer.formsubmit') }}", // Replace with your server endpoint
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.distriloader').addClass('d-none');
                        var resp = response.resp;
                        var msg = response.msg;

                        var redirecturl = "{{ route('customer.list') }}";
                        if (resp == 1) {
                            toastr.success('Data insert successfully!');
                        } else if (resp == 2) {
                            toastr.error('Data not insert successfully!');
                        } else {

                            alert(response);
                        }

                        window.location.replace(redirecturl);

                    },
                    error: function(xhr, status, error) {
                        toastr.error('Form submission failed.');
                    }
                });
            });

            // Helper functions for validation
            function validateEmail(email) {
                var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function validateGST(gst) {
                var re = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                return re.test(gst);
            }

            function validatePhone(phone) {
                var re = /^[0-9]{10}$/;
                return re.test(phone);
            }


        });
    </script>
@endsection
