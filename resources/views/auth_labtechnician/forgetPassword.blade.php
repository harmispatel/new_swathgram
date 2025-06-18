<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eaccuster</title>

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/toastr/css/toastr.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/font-awesome/css/all.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/datatable/css/datatable.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('public/assets/css/custom_css.css') }}" rel="stylesheet">
</head>

<body>
    <main>
        <div class="bg_login">
            <div class="">
                <section class="section register">
                    <div class="login_detail_main">
                        <div class="login_detail_left">
                            <div class="card mb-3">
                                @if(session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="card-body login-bg">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-white pb-0 fs-4">Reset Password</h5>
                                        <p class="small text-white">Enter your details</p>
                                    </div>

                                    <form action="{{ route('forget.password.post') }}" method="POST">
                                        @csrf

                                         <div class="col-12 mb-3">
                                            <div class="input-group">
                                                <input type="text" name="email" placeholder="Email"
                                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                    id="email" style="color: white;">
                                                @if($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Send Password Reset Link</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="login_detail_right">
                            <div class="login-title">
                                <h2><span>Welcome to</span> eaccuster portal</h2>
                                <p> Login to access your account </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <script src="{{ asset('public/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
    </script>
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/sweetalert/js/sweet-alert.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/datatable/js/datatables.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/toastr/js/toastr.min.js') }}"></script>
    <!-- <script type="text/javascript">
        // Toastr Message
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            timeOut: 4000
        }

        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script> -->

</body>

</html>
