<x-front-template>
    <x-slot:title>Welcome</x-slot:title>

    <!-- ***** Main Banner Area Start ***** -->
    <div id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-content">
                        <div class="inner-content">
                            <h4>{{ config('settings.name') }}</h4>
                            <h6>{{ strtoupper(config('settings.slogan')) }}</h6>
                            <div class="main-white-button scroll-to-section">
                                <a href="#reservation">Make A Reservation</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="main-banner header-text">
                        <div class="Modern-Slider">
                            @if ($slide_list->count() > 0)
                                @foreach ($slide_list as $item)
                                    <!-- Item -->
                                    <div class="item">
                                        <div class="img-fill">
                                            <img src="{{ url('public/uploads/slides/' . $item->pix) }}" alt="">
                                        </div>
                                    </div>
                                    <!-- // Item -->
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <section class="section" id="about">
        <div class="container">
            

            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>About Us</h6>
                            <h2>{{ config('settings.home_about_title') }}</h2>
                        </div>
                        {!! config('settings.home_about') !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="right-content">
                        <div class="thumb">
                            <img src="{{ url('public/images/' . config('settings.home_about_pix')) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Reservation Us Area Starts ***** -->
    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>To make a reservation, kindly use the reservation form</h2>
                        </div>
                        <p>We are always available to attend to your needs</p>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="phone">
                                    <i class="fa fa-phone"></i>
                                    <h4>Phone Numbers</h4>
                                    <span><a
                                            href="tel:{{ config('settings.tell') }}">{{ config('settings.tell') }}</a></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                    <i class="fa fa-envelope"></i>
                                    <h4>Emails</h4>
                                    <span><a
                                            href="mailto:{{ config('settings.email') }}">{{ config('settings.email') }}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <form id="contact" action="{{ route('reservation_store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>Make a Reservation</h4>
                                    <x-auth-session-status :status="session('status')"/>
                                    <x-auth-errors :errors="$errors"/>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="name" type="text" id="name" placeholder="Your Name*"
                                            required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="email" type="email" id="email"
                                            placeholder="Your Email Address" required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <fieldset>
                                        <input name="tell" type="text" id="phone" placeholder="Phone Number*"
                                            required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <fieldset>
                                        <select value="number-guests" name="guest_num" id="number-guests" required>
                                            <option value="">Number Of Guests</option>
                                            <option name="1" id="1">1</option>
                                            <option name="2" id="2">2</option>
                                            <option name="3" id="3">3</option>
                                            <option name="4" id="4">4</option>
                                            <option name="5" id="5">5</option>
                                            <option name="6" id="6">6</option>
                                            <option name="7" id="7">7</option>
                                            <option name="8" id="8">8</option>
                                            <option name="9" id="9">9</option>
                                            <option name="10" id="10">10</option>
                                            <option name="11" id="11">11</option>
                                            <option name="12" id="12">12</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">

                                    <input name="date" id="date" type="date" class="form-control"
                                        placeholder="Date" required>

                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input name="time" id="time" type="time" class="form-control"
                                        placeholder="Time" required>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" rows="6" id="message" placeholder="Message"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="main-button-icon">Make A
                                            Reservation</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Reservation Area Ends ***** -->
    @if ($category_list->count() > 0)
        <!-- ***** Menu Area Starts ***** -->
        <section class="section" id="offers">
            <div class="container" id='menu'>
                <div class="row">
                    <div class="col-lg-4 offset-lg-4 text-center">
                        <div class="section-heading">
                            <h6>Our Menu</h6>
                            <h2>Browse our special menu</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row" id="tabs">
                            <div class="col-lg-12">
                                <div class="heading-tabs">
                                    <div class="row">
                                        <div class="col-lg-12 offset-lg-12">
                                            <ul>
                                                <li><a href='#tabs-0'><img
                                                    src="{{ url('public/template/front') }}/assets/images/tab-icon-03.png"
                                                    alt="">All</a></a></li>
                                                @foreach ($category_list as $item)
                                                    <li><a href='#tabs-{{ $item->id }}'><img
                                                                src="{{ url('public/template/front') }}/assets/images/tab-icon-03.png"
                                                                alt="">{{ $item->name }}</a></a></li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <section class='tabs-content'>
                                    <article id='tabs-0'>
                                        @if($product_list->count() > 0)
                                        <div class="row">
                                            @foreach($product_list as $item)
                                            <div class="col-sm-6 mb-3 border">
                                                <div class="tab-item">
                                                    <img src="{{ url('public/uploads/product/'.$item->pix) }}"
                                                        alt="">
                                                    <h4>{{ $item->name }}</h4>
                                                    <p>{{ substr(strip_tags($item->description), 0, 100) }}..
                                                    
                                                    </p>
                                                    <table align='right' cellpadding='5'>
                                                        <tr>
                                                        
                                                        <td><button class='btn btn-success' onclick="add_to_cart({{ $item->id }})">Add to cart</button></td>
                                                            <!--<td><button type='button' id='add_to_wishlist' class='btn btn-danger'><i class='bi bi-heart'></i></button></td>-->
                                                        </tr>
                                                    </table>
                                                    <div class="price">
                                                        <h6>{{ config('settings.currency').number_format($item->price, 2) }}</h6>
                                                    </div>
                                                </div>

                                            </div>
@endforeach
                                        </div>
                                        @endif
                                    </article>
                                    @foreach ($category_list as $item)
                                        <article id='tabs-{{ $item->id }}'>
                                            @if($item->product->count() > 0)
                                            <div class="row">
                                                @foreach($item->product as $pitem)
                                                <div class="col-sm-6 mb-3">
                                                    <div class="tab-item">
                                                        <img src="{{ url('public/uploads/product/'.$pitem->pix) }}"
                                                            alt="">
                                                        <h4>{{ $pitem->name }}</h4>
                                                        <p>{{ substr(strip_tags($pitem->description), 0, 100) }}..</p>
                                                        <table align='right' cellpadding='5'>
                                                            <tr>
                                                            
                                                            <td><button id='add_to_cart' class='btn btn-success' onclick="add_to_cart({{ $pitem->id }})">Add to cart</button></td>
                                                                <!--<td><button type='button' id='add_to_wishlist' class='btn btn-danger'><i class='bi bi-heart'></i></button></td>-->
                                                            </tr>
                                                        </table>
                                                        <div class="price">
                                                            <h6>{{ config('settings.currency').number_format($pitem->price, 2) }}</h6>
                                                        </div>
                                                    </div>

                                                </div>
@endforeach
                                            </div>
                                            @endif
                                        </article>
                                    @endforeach

                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ***** Chefs Area Ends ***** -->
    @endif
</x-front-template>
