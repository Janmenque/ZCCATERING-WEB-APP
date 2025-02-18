<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ url('public/template/log') }}/css/style.css">
<x-head-inc/>
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <a href='{{ route('welcome') }}'><h2 class="heading-section"><img src='{{ url('public/images/' . config('settings.logo')) }}'
                            class='img-fluid'></h2></a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img"
                            style="background-image: url({{ url('public/images/'.config('settings.log_back')) }});">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">{{ $title }}</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="{{ config('settings.facebook') }}"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="{{ config('settings.twitter') }}"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                    </p>
                                </div>
                            </div>
                            <x-auth-session-status :status="session('status')"/>
                            <x-auth-errors :errors="$errors"/>
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ url('public/template/log') }}/js/jquery.min.js"></script>
    <script src="{{ url('public/template/log') }}/js/popper.js"></script>
    <script src="{{ url('public/template/log') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('public/template/log') }}/js/main.js"></script>
    <x-foot-inc/>
</body>

</html>
