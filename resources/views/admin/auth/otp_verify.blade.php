<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="FoneUI">
    <meta name="keywords"
          content="FoneUI, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>HSN - Verify OTP</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/core/core.css')}}">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css')}}">
    <!-- End layout styles -->

    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.png')}}"/>
</head>
<body>
<div class="main-wrapper">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pe-md-0">
                                <div class="auth-side-wrapper">
                                    <img src="{{asset('admin/assets/black logo.JPG')}}">
                                </div>
                            </div>
                            <div class="col-md-8 ps-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-2">Helmets<span> Nepal</span></a>
                                    <h5 class="text-muted fw-normal mb-4">Verify OTP TO Login.</h5>
                                    @if ($errors->has('login_error'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('login_error') }}</strong>
                                        </span>
                                    @endif
                                    <form class="forms-sample" id="otp_verify" action="{{route('admin.otp-verified-login')}}" method="POST">
                                        @csrf
                                            <div class="mb-3">
                                                <label for="otp" class="form-label">OTP Code</label>
                                                <input type="number" id="two_factor_code" name="two_factor_code"
                                                       class="form-control @error('two_factor_code') is-invalid @enderror"
                                                       autocomplete="current-password">
                                                @if ($errors->has('two_factor_code'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('two_factor_code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        <div>
                                        <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">
                                            Verify
                                        </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- core:js -->
<script src="{{ asset('admin/assets/vendors/core/core.js')}}"></script>
<!-- endinject -->

<!-- inject:js -->
<script src="{{ asset('admin/assets/vendors/feather-icons/feather.min.js')}}"></script>
<script src="{{ asset('admin/assets/js/template.js')}}"></script>
<!-- endinject -->


<script src="{{ asset('admin/assets/js/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery-validation/additional-methods.min.js') }}"></script>
<script src="{{ asset('admin/assets/validation/otp.js') }}"></script>


</body>
</html>
