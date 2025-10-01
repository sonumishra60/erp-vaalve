@extends('layouts.main')

@section('content')
<!--begin::Toolbar-->
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
                <li class="breadcrumb-item text-dark">Attendance Sheet</li>
            </ul>
            <!--end::Title-->
        </div>
        <div class="d-flex align-items-center mr-20px">
            <div class="toptx"> Indicates required fields (<span class="text-danger">*</span>)</div>
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row mb-5 mb-xl-8">
            <div class="card">
                <div class="card-header ">
                    {{-- <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Basic Information</span>
                        </h3> --}}

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="row align-items-center">
                                    <div
                                        class="col-md-4 checkInbutton {{ $userattendance?->jobStartDate ? 'd-none' : '' }}">
                                        <a href="#" class="btn btn-primary checkInbutton" data-toggle="modal"
                                            data-target="#myModal">Check In</a>
                                    </div>



                                    <div
                                        class="col-md-4 checkoutbutton   
                                    @if ($userattendance?->jobStartDate != '' && $userattendance?->jobExistDate == '') @elseif ($userattendance?->jobStartDate != '' && $userattendance?->jobExistDate != '') 
                                        d-none
                                    @else 
                                        d-none @endif">

                                        <a href="#" class="btn btn-primary checkOutbutton @if (isset($dsrattendance) && $dsrattendance->checkOutDate == '') mydisabled @endif"
                                            data-toggle="modal" data-target="#myModal2">Check
                                            Out</a>
                                    </div>

                                    <div
                                        class="col-md-4 checkinshow {{ $userattendance?->jobStartDate ? '' : 'd-none' }}">
                                        <span> Check In </span> : <p class="timecheckIn">
                                            {{ date('d-M-Y H:i:s', $userattendance?->jobStartDate) }}
                                        </p>
                                    </div>

                                    <div
                                        class="col-md-4 checkoutshow {{ $userattendance?->jobExistDate ? '' : 'd-none' }}">
                                        <span> Check Out</span> : <p class="timecheckOut">
                                            {{ date('d-M-Y H:i:s', $userattendance?->jobExistDate) }}
                                        </p>
                                    </div>

                                </div>
                            </div>



                        </div>

                    </div>

                </div>
                <div class="card-body py-3">
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
                                        <div class="floating-label-group">Date</div>
                                    </th>

                                    <th class="w-150px rounded-start">
                                        <div class="floating-label-group">Check In</div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Check Out</div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">Duration </div>
                                    </th>

                                    <th class="w-100px rounded-start">
                                        <div class="floating-label-group">KM</div>
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
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Check In</h5>
                <button type="button" class="close btn btn-primary checkinclose" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form1">
                    <div class="mb-1 row">

                        <div class="col-sm-3 mb-1">
                            <div class="floating-label-group mb-3">
                                <input type="text" id="meter_reading" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required=""
                                    autocomplete="off">
                                <label class="floating-label px">Meter reading <span class="text-danger">*</span></label>
                            </div>
                        </div>


                        <div class="col-sm-3 mb-1 d-flex">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty" data-kt-image-input="true"
                                style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-60px h-60px">
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Change avatar">
                                    <i class="bi bi-plus fs-7"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="meter_reading_upload" name="avatar"
                                        accept=".png, .jpg, .jpeg, .pdf," />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>


                                <!--end::Remove button-->
                            </div>
                            <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">Meter reading Upload <span class="text-danger">*</span></div>
                            <!--end::Image input-->

                        </div>

                    </div>
                    <button type="button" class="btn btn-primary checkinsavebutton">Save</button>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Check Out</h5>
                <button type="button" class="close btn btn-primary checkoutclose" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form2">
                    <div class="mb-1 row">

                        <div class="col-sm-2 mb-1">
                            <div class="floating-label-group mb-3 ">
                                <input type="text" id="checkout_meter_reading" class="form-control " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required=""
                                    autocomplete="off">
                                <label class="floating-label px">Meter reading <span class="text-danger">*</span></label>
                            </div>
                        </div>


                        <div class="col-sm-3 mb-1 d-flex">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty" data-kt-image-input="true"
                                style="background-image: url({{ URL::asset('assets/media/svg/files/blank-image.svg') }})">
                                <!--begin::Image preview wrapper-->
                                <div class="image-input-wrapper w-60px h-60px">
                                </div>
                                <!--end::Image preview wrapper-->

                                <!--begin::Edit button-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Change avatar">
                                    <i class="bi bi-plus fs-7"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" id="chekout_meter_reading_upload" name="avatar"
                                        accept=".png, .jpg, .jpeg, .pdf," />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Edit button-->

                                <!--begin::Cancel button-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel button-->

                                <!--begin::Remove button-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    data-bs-dismiss="click" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>


                                <!--end::Remove button-->
                            </div>
                            <div class="check" style="line-height: 60px; padding-left: 5px; font-size: 11px;">Meter reading Upload <span class="text-danger">*</span></div>
                            <!--end::Image input-->

                        </div>


                    </div>
                    <button type="button" class="btn btn-primary checkoutbutton2 @if (isset($dsrattendance) && $dsrattendance->checkOutDate == '') mydisabled @endif @if (isset($dsrattendance2) && $dsrattendance2->checkOutDate == '') mydisabled @endif">Save</button>

                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#myModal').on('hidden.bs.modal', function() {
            // Clear all input fields inside the form

        });

        $('#myModal2').on('hidden.bs.modal', function() {
            // Clear all input fields inside the form
            $(this).find('form')[0].reset();
            $(this).find('select').val('').trigger('change');
            $(this).find('.image-input-wrapper').css('background-image', 'none');
            $(this).find('input[type="file"]').val('');
            $(this).find('input[type="text"]').val('');
        });

        function compressImage(file, maxSizeKB, quality = 0.7) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();

                // Read the file as a Data URL
                reader.readAsDataURL(file);

                reader.onload = function(event) {
                    const img = new Image();
                    img.src = event.target.result;

                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // Calculate scale factor to fit within the target size
                        const scaleFactor = Math.sqrt(maxSizeKB * 1024 / file.size);
                        canvas.width = img.width * scaleFactor;
                        canvas.height = img.height * scaleFactor;

                        // Draw the resized image onto the canvas
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                        // Compress the image as JPEG
                        const compressedDataUrl = canvas.toDataURL('image/jpeg', quality);

                        // Convert to a Blob
                        fetch(compressedDataUrl)
                            .then(res => res.blob())
                            .then(blob => resolve(blob))
                            .catch(err => reject(err));
                    };

                    img.onerror = function() {
                        reject(new Error('Failed to load image for compression.'));
                    };
                };

                reader.onerror = function() {
                    reject(new Error('Failed to read file.'));
                };
            });
        }

        $(document).on('click', '.checkinsavebutton', function(e) {
            e.preventDefault();
            var $checkInButton = $('.checkinsavebutton');

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                            // Success callback
                            var checkvalidation = 0;
                            var meter_reading = $('#meter_reading').val();
                            var meter_reading_upload = $('#meter_reading_upload')[0].files[0];

                            try {
                                const compressedImage1 = meter_reading_upload ? await compressImage(meter_reading_upload, 30) : null;

                                const latitude = position.coords.latitude;
                                const longitude = position.coords.longitude;

                                // Validation checks

                                if (meter_reading == '') {
                                    $('#meter_reading').css('border-color', 'red');
                                    $('#meter_reading').css('border', '1px solid red');
                                    toastr.error('Enter meter Reading');
                                    checkvalidation++;
                                }

                                // if (meter_reading_upload == undefined) {
                                //     $('input[name="meter_reading_upload"]').css('border-color', 'red');
                                //     toastr.error('Upload Meter reading');
                                //     checkvalidation++;
                                // }




                                if (checkvalidation > 0) {
                                    return false;
                                }

                                $checkInButton.prop('disabled', true);

                                // Create FormData object for file upload

                                var formData = new FormData();
                                formData.append('latitude', latitude);
                                formData.append('longitude', longitude);
                                formData.append('meter_reading', meter_reading);
                                if (compressedImage1) {
                                    formData.append('meter_reading_upload', compressedImage1, meter_reading_upload.name);
                                }


                                $.ajax({
                                    url: '{{ route('attendance.submit') }}',
                                    type: 'POST',
                                    data: formData,
                                    processData: false, // Prevents jQuery from converting data into query string
                                    contentType: false, // Prevents setting default content type to application/x-www-form-urlencoded
                                    beforeSend: function() {
                                        $checkInButton.text('Saving...');
                                    },
                                    success: function(response) {
                                        // alert(response);
                                        $checkInButton.text('Save');
                                        $checkInButton.prop('disabled', false);
                                        let data = typeof response === 'string' ? JSON.parse(
                                            response) : response;
                                        if (data.status === 200) {
                                            toastr.success('Check In Insert Successfully');

                                            location.reload();
                                            fetchData(100, 1);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        $checkInButton.text('Check In');
                                        $(this).prop('disabled', false);
                                        console.error('Error sending location:', error);
                                    }
                                });
                            } catch (error) {
                                console.error('Image compression failed:', error);
                            }
                        },
                        (error) => {
                            // Error callback
                            if (error.code === error.PERMISSION_DENIED) {
                                toastr.error(
                                    "Location access denied. Please enable location services and try again."
                                );
                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                toastr.error(
                                    "Location information is unavailable. Please try again later.");
                            } else if (error.code === error.TIMEOUT) {
                                toastr.error("Location request timed out. Please try again.");
                            } else {
                                toastr.error("An unknown error occurred while fetching location.");
                            }
                            console.error("Error getting location:", error.message);
                        }, {
                            enableHighAccuracy: true, // Use GPS if available
                            timeout: 5000, // Timeout after 5 seconds
                            maximumAge: 0 // No cached location
                        }
                );
            } else {
                toastr.error("Geolocation is not supported by this browser.");
            }
        });

        // $(document).on('click', '.checkoutbutton', function() {

        //     var $checkoutbutton = $('.checkoutbutton');

        //     if ("geolocation" in navigator) {
        //         navigator.geolocation.getCurrentPosition(
        //             (position) => {
        //                 var checkvalidation = 0;
        //                 var checkout_meter_reading = $('#checkout_meter_reading').val();
        //                 var chekout_meter_reading_upload = $('#chekout_meter_reading_upload')[0].files[0];
        //                 const latitude = position.coords.latitude;
        //                 const longitude = position.coords.longitude;

        //                 if (checkout_meter_reading == '') {
        //                     $('#checkout_meter_reading').css('border-color', 'red');
        //                     $('#checkout_meter_reading').css('border', '1px solid red');
        //                     toastr.error('Enter meter Reading');
        //                     checkvalidation++;
        //                 }

        //                 if (chekout_meter_reading_upload == undefined) {
        //                     $('input[name="chekout_meter_reading_upload"]').css('border-color', 'red');
        //                     toastr.error('Upload Meter reading');
        //                     checkvalidation++;
        //                 }




        //                 if (checkvalidation > 0) {
        //                     return false;
        //                 }

        //                 $checkoutbutton.prop('disabled', true);

        //                 var formData = new FormData();
        //                 formData.append('latitude', latitude);
        //                 formData.append('longitude', longitude);
        //                 formData.append('checkout_meter_reading', checkout_meter_reading);
        //                 formData.append('chekout_meter_reading_upload', chekout_meter_reading_upload);


        //                 $.ajax({
        //                     url: '{{ route('dsr.checkoutsubmit') }}',
        //                     type: 'POST',
        //                     data: formData,
        //                     processData: false, // Important: Prevents jQuery from converting data into query string
        //                     contentType: false, // Important: Prevents setting default content type to application/x-www-form-urlencoded
        //                     beforeSend: function() {
        //                         $checkoutbutton.text('Saving...');
        //                     },
        //                     success: function(response) {
        //                         $checkoutbutton.text('Save');
        //                         $checkoutbutton.prop('disabled', false);

        //                         let data = typeof response === 'string' ? JSON.parse(
        //                             response) : response;

        //                         if (data.status === 200) {
        //                             toastr.success('Checkout Insert Successfully');
        //                             $('.checkoutclose').trigger('click');
        //                             $('.checkInbutton').removeClass('d-none');
        //                             $('.checkOutbutton').addClass('d-none');


        //                             fetchData(100, 1);
        //                         }
        //                     },
        //                     error: function(xhr, status, error) {
        //                         $checkoutbutton.text('Check Out');
        //                         $(this).prop('disabled', false);
        //                         console.error('Error sending location:', error);
        //                     }
        //                 });




        //             },
        //             (error) => {
        //                 // Error callbacks
        //                 if (error.code === error.PERMISSION_DENIED) {
        //                     toastr.error(
        //                         "Location access denied. Please enable location services and try again."
        //                     );
        //                 } else if (error.code === error.POSITION_UNAVAILABLE) {
        //                     toastr.error(
        //                         "Location information is unavailable. Please try again later.");
        //                 } else if (error.code === error.TIMEOUT) {
        //                     toastr.error("Location request timed out. Please try again.");
        //                 } else {
        //                     toastr.error("An unknown error occurred while fetching location.");
        //                 }
        //                 console.error("Error getting location:", error.message);
        //             }, {
        //                 enableHighAccuracy: true, // Use GPS if available
        //                 timeout: 5000, // Timeout after 5 seconds
        //                 maximumAge: 0 // No cached location
        //             }
        //         );
        //     } else {
        //         toastr.error("Geolocation is not supported by this browser.");
        //     }

        // });

        $('.checkoutbutton2').on('click', function(event) {
            if ($(this).hasClass('mydisabled')) {
                event.preventDefault();
                toastr.error('Please first DSR checkout.');
                console.log('Button is disabled');
                return false;
            }

            swal({
                title: "Are you sure?",
                text: "you want to proceed with checkout?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: {
                    cancel: "No",
                    confirm: "Yes",
                },
            }).then((willProceed) => {
                if (willProceed) {
                    swal({
                        title: "Are you sure?",
                        text: "This action cannot be undone. Do you really want to proceed?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: {
                            cancel: "No",
                            confirm: "Yes",
                        },
                    }).then((finalConfirm) => {
                        if (finalConfirm) {
                            if ("geolocation" in navigator) {
                                navigator.geolocation.getCurrentPosition(
                                    async (position) => {
                                            try {



                                                var checkvalidation = 0;

                                                let $checkoutbutton = $('.checkoutbutton2'); // Fixed selector
                                                $checkoutbutton.text('Checking Out...');

                                                var checkout_meter_reading = $('#checkout_meter_reading').val();
                                                var chekout_meter_reading_upload = $('#chekout_meter_reading_upload')[0].files[0];
                                                const compressedImage1 = chekout_meter_reading_upload ? await compressImage(chekout_meter_reading_upload, 30) : null;
                                               
                                              
                                                const latitude = position.coords.latitude;
                                                const longitude = position.coords.longitude;

                                                if (checkout_meter_reading === '') {
                                                    $('#checkout_meter_reading').css({
                                                        border: '1px solid red',
                                                    });
                                                    toastr.error('Enter meter reading.');
                                                    checkvalidation++;
                                                }

                                                // if (!chekout_meter_reading_upload) {
                                                //     $('input[name="chekout_meter_reading_upload"]').css({
                                                //         border: '1px solid red',
                                                //     });
                                                //     toastr.error('Upload meter reading.');
                                                //     checkvalidation++;
                                                // }

                                                if (checkvalidation > 0) {
                                                    $checkoutbutton.text('Checkout');
                                                    return false;
                                                }

                                                var formData = new FormData();
                                                formData.append('latitude', latitude);
                                                formData.append('longitude', longitude);
                                                formData.append('checkout_meter_reading', checkout_meter_reading);
                                                //formData.append('chekout_meter_reading_upload', chekout_meter_reading_upload);
                                                if (compressedImage1) {
                                                    formData.append('chekout_meter_reading_upload', compressedImage1, chekout_meter_reading_upload.name);
                                                }

                                                $.ajax({
                                                    url: '{{ route('attendance.chekout') }}',
                                                    type: 'POST',
                                                    data: formData,
                                                    processData: false, // Prevent jQuery from processing the data
                                                    contentType: false, // Prevent jQuery from setting the Content-Type header
                                                    beforeSend: function() {
                                                        $checkoutbutton.text('Processing...');
                                                    },
                                                    success: function(response) {
                                                        let data = typeof response === 'string' ? JSON.parse(response) : response;

                                                        if (data.status === 200) {
                                                            $('.checkoutbutton2').addClass('d-none');
                                                            $('.checkoutshow').removeClass('d-none');
                                                            $('.timecheckOut').text(data.data);
                                                            toastr.success('Checkout successful.');
                                                            location.reload();
                                                            fetchData(100, 1); // Update UI
                                                        }
                                                    },
                                                    error: function(xhr, status, error) {
                                                        toastr.error('Error sending location. Please try again.');
                                                        console.error('Error:', error, 'Response:', xhr.responseText);
                                                    },
                                                    complete: function() {
                                                        $checkoutbutton.text('Checkout');
                                                    },
                                                });

                                            } catch (error) {
                                                console.error('Image compression failed:', error);
                                            }
                                        },
                                        (error) => {
                                            if (error.code === error.PERMISSION_DENIED) {
                                                toastr.error('Location access denied. Enable location services and try again.');
                                            } else if (error.code === error.POSITION_UNAVAILABLE) {
                                                toastr.error('Location information unavailable. Please try again later.');
                                            } else if (error.code === error.TIMEOUT) {
                                                toastr.error('Location request timed out. Please try again.');
                                            } else {
                                                toastr.error('An unknown error occurred while fetching location.');
                                            }
                                        }, {
                                            enableHighAccuracy: true,
                                            timeout: 5000,
                                            maximumAge: 0,
                                        }
                                );
                            } else {
                                alert('Geolocation is not supported by this browser.');
                            }
                        }
                    });
                }
            });
        });



        function fetchData(rowCount, page) {
            var dayDetailUrlPattern = `{{ url('attendance/day/detail') }}/{id}`
            $.ajax({
                url: "{{ route('attendance.listdata') }}",
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
                        $.each(data, function(index, value) {

                            var id = index + 1;
                            var empIdOnJobsId = value.empIdOnJobsId;
                            var url = dayDetailUrlPattern.replace('{id}', empIdOnJobsId);
                            var tr = ` <tr>
                            <td class="w-50px rounded-start">` + id + `</td>
                            <td class="w-100px rounded-start">` + value.date + `</td>
                            <td class="w-100px rounded-start">` + value.jobStartDate + `</td>
                            <td class="w-100px rounded-start">` + value.jobExistDate + `</td>
                            <td class="w-100px rounded-start">` + value.duration + `</td>
                            <td class="w-100px rounded-start"> <a href="` + url + `">` + value.distance + ` </a></td>
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

        fetchData(100, 1);


    });
</script>

<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
@endsection