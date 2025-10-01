<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login | Vaalve</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Vaalve" />
    <link rel="stylesheet" href="{{ URL::asset('login/css/style.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.png') }}" />
    <link href="{{ URL::asset('assets/css/toastr.css') }}" rel="stylesheet" />
</head>

<body>
    <!-- Start Preloader -->
    <div id="preload-block">
        <div class="square-block"></div>
    </div>
    <!-- Preloader End -->

    <div class="container-fluid">
        <div class="row">
            <div class="authfy-container col-xs-12 col-sm-10 col-md-7 col-lg-7">
                <div class="col-sm-6 authfy-panel-left">
                    <div class="top-img"><img src="{{ URL::asset('login/images/banb.png') }}" height="330"></div>
                </div>
                <div class="col-sm-6 authfy-panel-right">
                    <!-- authfy-login start -->
                    <div class="authfy-login">
                        <!-- panel-login start -->
                        <div class="authfy-panel panel-login text-center active">
                            <div class="brand-logo">
                                <img src="{{ URL::asset('login/images/logo-small.png') }}" width="250"
                                    alt="brand-logo">
                            </div>
                            <div class="authfy-heading">
                                <h3 class="auth-title">Login to your account</h3>

                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <form name="loginForm" class="loginForm" action="#" method="POST">
                                        <div class="form-group wrap-input">
                                            <input type="email" class="form-control email" name="username"
                                                placeholder="Enter Phone Number" id="loginusername" autocomplete="off">
                                            <span class="focus-input"></span>
                                        </div>
                                        <div class="form-group wrap-input">
                                            <div class="pwdMask">
                                                <input type="password" class="form-control password" name="password"
                                                    placeholder="Password" id="loginpassword" autocomplete="off">
                                                <span class="focus-input"></span>
                                                <span class="fa fa-eye-slash pwd-toggle"></span>
                                            </div>
                                        </div>
                                        <!-- start remember-row -->
                                        <div class="row remember-row">
                                            <div class="col-xs-6 col-sm-6">
                                                <label class="checkbox text-left">
                                                    <input type="checkbox" value="remember-me">
                                                    <span class="label-text">Remember me</span>
                                                </label>
                                            </div>
                                            {{-- <div class="col-xs-6 col-sm-6">
                                                <p class="forgotPwd">
                                                    <a class="lnk-toggler" data-panel=".panel-forgot"
                                                        href="#">Forgot
                                                        password?</a>
                                                </p>
                                            </div> --}}
                                        </div> <!-- ./remember-row -->
                                        <div class="form-group">
                                            <a href="#" class="btn btn-lg btn-info btn-block loginbutton"
                                                type="submit">SUBMIT</a>
                                        </div>



                                    </form>
                                </div>
                            </div>
                        </div> <!-- ./panel-login -->

                        <div class="authfy-panel panel-forgot">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <div class="authfy-heading">
                                        <h3 class="auth-title">Recover your password</h3>
                                        <p>Fill in your e-mail address below and we will send you an email with further
                                            instructions.</p>
                                    </div>
                                    <form name="forgetForm" class="forgetForm" action="#" method="POST">
                                        <div class="form-group wrap-input">
                                            <input type="email" class="form-control" name="username"
                                                placeholder="Email address">
                                            <span class="focus-input"></span>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Recover your
                                                password</button>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- ./row -->
    </div> <!-- ./container -->

    <script src="{{ URL::asset('login/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('login/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('login/js/custom.js') }}"></script>
    <script src="{{ URL::asset('assets/js/toastr.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.loginbutton', function() {

                var loginusername = $('#loginusername').val();
                var loginpassword = $('#loginpassword').val();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

               // console.log('username =>'+loginusername +'password => '+loginpassword);
                //return false;

                if (loginusername == '') {
                    toastr.error('Enter Phone Number');
                }

                if (loginpassword == '') {
                    toastr.error('Enter Password');
                }

                if (loginusername != '' && loginpassword != '') {

                    var formData = new FormData();
                    formData.append('username',loginusername);
                    formData.append('password',loginpassword);
                    formData.append('_token',csrfToken);

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('login.indexformsubmit') }}",
                        data:formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            var resp = response.resp;
                            var msg = response.msg;
                            if (resp === 1) {
                                toastr.success(msg);
                                //console.log('edfewfew');
                                window.location.href = "{{ route('customer.distributorlist') }}";
                            } else if(resp === 2 || resp === 3){
                                toastr.error(msg);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred while submitting the form.');
                        }
                    });


                }


            });

        });
    </script>

</body>


</html>
