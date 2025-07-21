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
                <section
                    class="section register">
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
                                <div class="card-body login-bg">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-white pb-0 fs-4">Login</h5>
                                        <p class="small text-white">Enter your Login details</p>
                                    </div>

                                    <form class="row g-3" method="POST"
                                        action="{{ route('doLogin') }}">
                                        @csrf

                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="text" name="username" placeholder="Username" value="{{old('username')}}"
                                                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                                                    id="username" style="color: white;">
                                                @if($errors->has('username'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('username') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="input-group">
                                                <input type="password" name="password" placeholder="Password"
                                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                    id="password" style="color: white;">
                                                <span class="input-group-text"
                                                    style="cursor: pointer;background-color: #1f2024;border: none;color: #77777A;border-bottom: 2px solid #77777A;border-radius: 0px;"
                                                    onclick="ShowHidePassword()" id="passIcon">
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                                @if($errors->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="input-group pt-4">
                                               <a href="{{ route('forget.password.get') }}" class="forgot-password">Forgot Password?</a> 
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="login_detail_right">
                            <div>
                                <div class="login_abha_btn">
                                    <a class="btn" href="{{ route('abha.create') }}">Create Abha ID</a>
                                    <a class="btn" href="#">Download App</a>
                                </div>
                            </div>

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
    <script>
           function ShowHidePassword() {
                var currentType = $('#password').attr('type');
                if (currentType == 'password') {
                    $('#password').attr('type', 'text');
                    $('#passIcon').html('');
                    $('#passIcon').append('<i class="bi bi-eye"></i>');
                } else {
                    $('#password').attr('type', 'password');
                    $('#passIcon').html('');
                    $('#passIcon').append('<i class="bi bi-eye-slash"></i>');
                }
            }
    </script>

</body>

</html>
