<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Habsha</title>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <style>
        #layoutSidenav #layoutSidenav_content {
            margin-left: 0;
        }

        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding-left: 0px;
        }

        #layoutSidenav #layoutSidenav_nav {
            transform: translateX(225px)
        }

        @media (min-width: 992px) {
            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_content {
                margin-right: 225px;
                margin-left: 0;
            }

            .sb-sidenav-toggled #layoutSidenav #layoutSidenav_nav {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="d-flex">
    <main class="d-flex flex-fill">
        <div class="container d-flex flex-fill justify-content-center align-items-center">
            <div class="row w-100 justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">تسجيل الدخول</div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">
                                        رقم الهاتف</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="number"
                                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">كلمة السر</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            سجل دخولك
                                        </button>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('script')
</body>

</html>
