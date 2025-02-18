<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet">
        

    <title>{{ $title }}</title>
    <x-head-inc/>
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/template/front') }}/assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="{{ url('public/template/front') }}/assets/css/font-awesome.css">

    <link rel="stylesheet" href="{{ url('public/template/front') }}/assets/css/templatemo-klassy-cafe.css">

    <link rel="stylesheet" href="{{ url('public/template/front') }}/assets/css/owl-carousel.css">

    <link rel="stylesheet" href="{{ url('public/template/front') }}/assets/css/lightbox.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ route('welcome') }}" class="logo">
                            <img src="{{ url('public/images/'.config('settings.logo')) }}"
                                align="logo">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            @if(Route::currentRouteName() == 'welcome')
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#about">About</a></li>
                            <li class="scroll-to-section"><a href="#menu">Menu</a></li>
                            <li class="scroll-to-section"><a href="#reservation">Contact Us</a></li>
                            @endif
                            @if(!Auth::check())
                            <li><a href="{{ route('login') }}"><span class='text-primary'><i class='fa fa-external-link-square'></i> Login</span></a></li>
                            <li><a href="{{ route('register') }}"><span class='text-success'><i class='fa fa-flag'></i> Register</span></a></li>
                            @else
                            <li><a href="{{ route('dashboard') }}"><span class='text-success'><i class='fa fa-user'></i> Account</span></a></li>
                            <li><a href="{{ route('logout') }}"><span class='text-danger'><i class='fa fa-level-down'></i> Logout</span></a></li>
                            @endif
                            <li id='cart_div'>
                                <x-cart-div/>
                            </li>
                        </ul>
                        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>

                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    {{ $slot }}

  <!-- Modal -->
  <div class="modal fade" id="status_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <x-auth-session-status :status="session('status')"/>
          <x-auth-errors :errors="$errors"/>
        </div>

      </div>
    </div>
  </div>
 
    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="right-text-content">
                        <ul class="social-icons">
                            <li><a href="{{ config('settings.facebook') }}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{ config('settings.twitter') }}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{ config('settings.youtube') }}"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="{{ config('settings.instagram') }}"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="logo">
                       
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="left-text-content">
                        <p>© {{ date('Y', time()) }} Copyright {{ config('settings.name') }}

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <x-foot-inc/>

    <!-- Bootstrap -->
    <script src="{{ url('public/template/front') }}/assets/js/popper.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="{{ url('public/template/front') }}/assets/js/owl-carousel.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/accordions.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/datepicker.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/scrollreveal.min.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/waypoints.min.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/imgfix.min.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/slick.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/lightbox.js"></script>
    <script src="{{ url('public/template/front') }}/assets/js/isotope.js"></script>


    <!-- Global Init -->
    <script src="{{ url('public/template/front') }}/assets/js/custom.js"></script>
    <script>
        $(function() {
            var selectedClass = "";
            $("p").click(function() {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function() {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });
    </script>
    @if(session('status') != '')
     <script>
        $('#status_modal').modal('show');
      </script>
      @endif

    
</body>

</html>
