{{-- <script>var hostUrl = "assets/";</script> --}}
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/fontawesome-iconpicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ URL::asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
<script src="{{ URL::asset('assets/js/toastr.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    var masterDataUrl = "{{ route('master.getmasterdata') }}";
    var masterparentcategory = "{{ route('mastermenu.getmainmenu') }}";
    var logout = "{{ route('logout') }}";
    var login = "{{ route('login') }}";
    var masterroles = "{{ route('get.masterroles') }}";
    var rolesByTypeUrl = "{{ route('roles.byType', ['roleTypeId' => ':roleTypeId']) }}";
    var statedate = "{{ route('location.state') }}";
    var citybystate = "{{ route('location.city', ['stateid' => ':stateId']) }}";
    var customertype = "{{ route('customer.type') }}";
    var delaertype = "{{ route('dealer.type') }}";
    var gallerytype = "{{ route('gallery.type') }}";
    var billingtype = "{{ route('billing.type') }}";
    var dristributortype = "{{ route('distributor.type') }}";
    var businesstype = "{{ route('business.type') }}";
    var banktype = "{{ route('bank.type') }}";
    var allsalesusers = "{{ route('salesuser.all') }}";
    var mainheads = "{{ route('mainheads.type') }}";
    var cluster = "{{ route('cluster.all') }}";
    var transproter = "{{ route('transproter.all') }}";
    var parentcategory = "{{ route('parentcategory.all') }}";
    var brand = "{{ route('brand.all') }}";
    var color = "{{ route('color.all') }}";
    var allsalesuser = "{{ route('sales.all') }}";
    var alldistributor = "{{ route('distributor.all') }}";
    var allordertype = "{{ route('order.type') }}";
    var paymnetmode = "{{ route('payment.mode') }}";
</script>
<script src="{{ URL::asset('assets/js/myjs.js') }}"></script>

<script>
    function startClock() {
        setInterval(updateClock, 1000);
    }

    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
        document.getElementById('clock').innerHTML = '<i class="fa fa-stopwatch"></i> ' + strTime;
    }

    $(document).ready(function() {
        startClock();
    });

    function requestLocation() {
            // Check if user response is already saved
            const locationPermission = localStorage.getItem('locationPermission');

            if (locationPermission === 'allowed') {
                // User has already allowed location
                getUserLocation();
                return;
            } 
            //else 
            // if (locationPermission === 'denied') {
            //     // User has already denied location
            //     //alert("You have previously denied access to your location.");
            //    //return;
            // }

            // Ask for location permission
            const confirmLocation = confirm("Do you want to allow access to your location?");

            if (confirmLocation) {
                // Save 'allowed' in localStorage and fetch location
                localStorage.setItem('locationPermission', 'allowed');
                getUserLocation();
            } else {
                // Save 'denied' in localStorage and show a message
                localStorage.setItem('locationPermission', 'denied');
                alert("You chose not to share your location.");
            }
        }

        function getUserLocation() {
            // Check if Geolocation is supported
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const { latitude, longitude } = position.coords;
                       // alert(`Latitude: ${latitude}, Longitude: ${longitude}`);
                    },
                    (error) => {
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                alert("You denied the location permission.");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                alert("Location information is unavailable.");
                                break;
                            case error.TIMEOUT:
                                alert("The request to get user location timed out.");
                                break;
                            default:
                                alert("An unknown error occurred.");
                        }
                    }
                );
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }

        // Trigger location request on page load
        window.onload = requestLocation;
</script>
{{-- <script> 
    var zoom = 1;
    $('.zoom').on('click', function() {
        zoom += 0.01;
        $('.target').css('width', '110%');
    });
    $('.zoom-init').on('click', function() {
        zoom = 1;
        $('.target').css('transform', 'scale(' + zoom + ')');
    });
    $('.zoom-out').on('click', function() {
        zoom -= 0.01;
        $('.target').css('transform', 'scale(' + zoom + ')');
    });
</script> --}}
