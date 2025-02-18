<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('public/images/favicon.png') }}" type="image/x-icon">
    <!-- Custom styles -->
    <x-head-inc />
    <link rel="stylesheet" href="{{ url('public/template/back') }}/css/style.min.css">

</head>

<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">
        <!-- ! Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-start">
                <div class="sidebar-head">
                    <div style='padding: 5px; background-color: #FFF'>
                        <a href="{{ route('dashboard') }}" class="logo-wrapper" title="Home">
                            <span class="sr-only">Home</span>

                            <img src='{{ url('public/images/' . config('settings.logo')) }}' class='img-fluid'>

                        </a>
                    </div>
                    <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                        <span class="sr-only">Toggle menu</span>
                        <span class="icon menu-toggle" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="sidebar-body">
                    @if (Auth::user()->user_role_id == 2)
                        <div class='d-grid gap-2'>
                            <a href='{{ route('welcome') }}' class='btn btn-primary'>Continue to site</a>
                        </div>
                    @endif
                    <ul class="sidebar-body-menu">
                        <li>
                            <a href="{{ route('dashboard') }}"><span class="icon bi bi-airplane-engines-fill"
                                    aria-hidden="true"></span>Dashboard</a>
                        </li>
                        @if (Auth::user()->user_role_id == 1)
                            <li>
                                <a class="show-cat-btn" href="##">
                                    <span class="icon bi bi-apple" aria-hidden="true"></span>Product
                                    <span class="category__btn transparent-btn" title="Open list">
                                        <span class="sr-only">Open list</span>
                                        <span class="icon arrow-down" aria-hidden="true"></span>
                                    </span>
                                </a>
                                <ul class="cat-sub-menu">
                                    <li>
                                        <a href="{{ route('category') }}">Category</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('product') }}">Product List</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Auth::user()->user_role_id == 2)
                            <li>
                                <a href="{{ route('address') }}"><span class="icon bi bi-award-fill"
                                        aria-hidden="true"></span>Address</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('orders') }}"><span class="icon bi bi-bag-fill"
                                    aria-hidden="true"></span>Orders</a>
                        </li>
                        @if(Auth::user()->user_role_id == 1)
                        <li>
                            <a href="{{ route('pos') }}"><span class="icon bi bi-basket2"
                                    aria-hidden="true"></span>POS</a>
                        </li>
                        <li>
                            <a href="{{ route('user') }}"><span class="icon bi bi-people-fill"
                                    aria-hidden="true"></span>Users</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('reservation') }}"><span class="icon bi bi-bookmark-check-fill"
                                    aria-hidden="true"></span>Reservations</a>
                        </li>
                        @if(Auth::user()->user_role_id == 2)
                        <li>
                            <a class="show-cat-btn" href="##">
                                <span class="icon bi bi-gitlab" aria-hidden="true"></span>Account
                                <span class="category__btn transparent-btn" title="Open list">
                                    <span class="sr-only">Open list</span>
                                    <span class="icon arrow-down" aria-hidden="true"></span>
                                </span>
                            </a>
                            <ul class="cat-sub-menu">
                                <li>
                                    <a href="{{ route('profile.edit') }}">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                    @if (Auth::user()->user_role_id == 1)
                        <span class="system-menu__title">Configs</span>
                        <ul class="sidebar-body-menu">
                            <li>
                                <a href="{{ route('setting_create') }}"><span class="icon bi bi-wrench-adjustable" aria-hidden="true"></span>General Settings</a>
                                <a href="{{ route('setting_icon_create') }}"><span class="icon bi bi-boxes" aria-hidden="true"></span>Logo/Favicon</a>
                                <a href="{{ route('slide') }}"><span class="icon bi bi-display" aria-hidden="true"></span>Slides</a>
                                <a href="{{ route('payment_gateway') }}"><span class="icon bi bi-cash-coin" aria-hidden="true"></span>Payment Gateway</a>
                                <a href="{{ route('smtp_create') }}"><span class="icon bi bi-envelope" aria-hidden="true"></span>SMTP</a>
                                <a href="{{ route('setting_social_create') }}"><span class="icon bi bi-chat-heart" aria-hidden="true"></span>Social Media</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
            <div class="sidebar-footer">
                <a href="##" class="sidebar-user">
                    <span class="sidebar-user-img">
                        <picture>
                            <img src="{{ url('public/images/avatar.png') }}" alt="User">
                        </picture>
                    </span>
                    <div class="sidebar-user-info">
                        <span class="sidebar-user__title">{{ substr(Auth::user()->name, 0, 9) }}.</span>
                        <span class="sidebar-user__subtitle">{{ Auth::user()->user_role->name }}</span>
                    </div>
                </a>
            </div>
        </aside>
        <div class="main-wrapper">
            <!-- ! Main nav -->
            <nav class="main-nav--bg">
                <div class="container main-nav">
                    <div class="main-nav-start">

                    </div>
                    <div class="main-nav-end">
                        <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                            <span class="sr-only">Toggle menu</span>
                            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
                        </button>

                        <div class="nav-user-wrapper">

                            <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                                <span class="sr-only">My profile</span>
                                <span class="nav-user-img">
                                    <picture>
                                        <img src="{{ url('public/images/avatar.png') }}" alt="User">
                                    </picture>
                                </span>
                            </button>
                            <ul class="users-item-dropdown nav-user-dropdown dropdown">
                                <li><a href="{{ route('profile.edit') }}">
                                        <i data-feather="user" aria-hidden="true"></i>
                                        <span>Profile</span>
                                    </a></li>

                                <li><a class="danger" href="{{ route('logout') }}">
                                        <i data-feather="log-out" aria-hidden="true"></i>
                                        <span>Log out</span>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- ! Main -->
            <main class="main users chart-page" id="skip-target">
                <div class="container">
                    <h2 class="main-title">{{ $title }}</h2>
                    <x-auth-session-status :status="session('status')" />
                    <x-auth-errors :errors="$errors" />
                    {{ $slot }}
                </div>
            </main>
            <!-- ! Footer -->
            <footer class="footer">
                <div class="container footer--flex">
                    <div class="footer-start">
                        <p>{{ date('Y', time()) }} © {{ config('settings.name') }}</p>
                    </div>

                </div>
            </footer>
        </div>
    </div>
    <x-foot-inc />
    <!-- Chart library -->
    <script src="{{ url('public/template/back') }}/plugins/chart.min.js"></script>
    <!-- Icons library -->
    <script src="{{ url('public/template/back') }}/plugins/feather.min.js"></script>
    <!-- Custom scripts -->
    <script src="{{ url('public/template/back') }}/js/script.js"></script>

</body>

</html>
