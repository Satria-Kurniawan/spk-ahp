<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">

    <title>SPK Gateball AHP</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('template') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--

TemplateMo 570 Chain App Dev

https://templatemo.com/tm-570-chain-app-dev

-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/animated.css">
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/owl.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        {{-- <a href="index.html" class="logo">
                            <img src="{{ asset('template') }}/assets/images/logo.png" alt="Chain App Dev">
                        </a> --}}
                        <h5 class="logo font-weight-bold">SPK GATEBALL</h5>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#fitur">Fitur</a></li>
                            <li class="scroll-to-section"><a href="#about">About</a></li>
                            <li class="scroll-to-section"><a href="#galery">Galery</a></li>
                            {{-- <li class="scroll-to-section"><a href="#pricing">Pricing</a></li> --}}
                            <li class="scroll-to-section"><a href="#newsletter">Contact</a></li>
                            <li>
                                @auth
                                    <div class="gradient-button">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </div>
                                @else
                                    <div class="gradient-button"><a href="{{ route('login') }}">
                                            <i class="fa fa-sign-in-alt"></i> Login</a>
                                    </div>
                                @endauth
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

    <div id="modal" class="popupContainer" style="display:none;">
        <div class="popupHeader">
            <span class="header_title">Login</span>
            <span class="modal_close"><i class="fa fa-times"></i></span>
        </div>

        <section class="popupBody">
            <!-- Social Login -->
            <div class="social_login">
                <div class="">
                    <a href="#" class="social_box fb">
                        <span class="icon"><i class="fab fa-facebook"></i></span>
                        <span class="icon_title">Connect with Facebook</span>

                    </a>

                    <a href="#" class="social_box google">
                        <span class="icon"><i class="fab fa-google-plus"></i></span>
                        <span class="icon_title">Connect with Google</span>
                    </a>
                </div>

                <div class="centeredText">
                    <span>Or use your Email address</span>
                </div>

                <div class="action_btns">
                    <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
                    <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
                </div>
            </div>

            <!-- Username & Password Login form -->
            <div class="user_login">
                <form>
                    <label>Email / Username</label>
                    <input type="text" />
                    <br />

                    <label>Password</label>
                    <input type="password" />
                    <br />

                    <div class="checkbox">
                        <input id="remember" type="checkbox" />
                        <label for="remember">Remember me on this computer</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i
                                    class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><a href="#" class="btn btn_red">Login</a></div>
                    </div>
                </form>

                <a href="#" class="forgot_password">Forgot password?</a>
            </div>

            <!-- Register Form -->
            <div class="user_register">
                <form>
                    <label>Full Name</label>
                    <input type="text" />
                    <br />

                    <label>Email Address</label>
                    <input type="email" />
                    <br />

                    <label>Password</label>
                    <input type="password" />
                    <br />

                    <div class="checkbox">
                        <input id="send_updates" type="checkbox" />
                        <label for="send_updates">Send me occasional email updates</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i
                                    class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><a href="#" class="btn btn_red">Register</a></div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="1s">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2>SPK Metode Analitycal Hierarchy Process</h2>
                                        <p class="text-white">Solusi cerdas untuk memilih atlet terbaik berdasarkan
                                            metode Analytic
                                            Hierarchy Process (AHP). Optimalkan kinerja tim Anda dengan keputusan yang
                                            lebih tepat dan efisien, berkat analisis yang mendalam dan akurat dari
                                            kriteria yang relevan. Bergabunglah dengan kami dalam menggali potensi
                                            terbaik atlet gateball untuk meraih prestasi gemilang!</p>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="white-button first-button scroll-to-section">
                                            <a href="#fitur">Explore <i class="fab fa-apple"></i></a>
                                        </div>
                                        <div class="white-button scroll-to-section">
                                            <a href="#contact">Login <i class="fab fa-google-play"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="{{ asset('template') }}/assets/images/slider-dec.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fitur" class="services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading  wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
                        <h4>Fitur Website</h4>
                        <img src="assets/images/heading-line-dec.png" alt="">
                        <p>Menyediakan antarmuka intuitif untuk menginput data atlet gateball dan hasilkan rangking
                            prioritas atlet terbaik berdasarkan metode AHP secara cepat dan akurat.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="service-item first-service">
                        <div class="icon"></div>
                        <h4>Analisis Kinerja Atlet Profesional</h4>
                        <p>Dengan metode AHP, kami membantu tim pelatih dan manajemen dalam mengevaluasi kekuatan dan
                            kelemahan setiap atlet</p>
                        <div class="text-button">
                            <a href="#">Read More <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item third-service">
                        <div class="icon"></div>
                        <h4>Identifikasi Potensi Atlet Muda</h4>
                        <p>Melalui analisis AHP, kami membantu dalam menemukan calon-calon atlet potensial yang memiliki
                            kualitas dan kemampuan untuk menjadi bintang masa depan.</p>
                        <div class="text-button">
                            <a href="#">Read More <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item fourth-service">
                        <div class="icon"></div>
                        <h4>Evaluasi Kriteria Seleksi Atlet</h4>
                        <p> Dengan menggunakan metode AHP, kami membantu menyusun prioritas dan bobot setiap kriteria,
                            sehingga tim dapat memilih atlet dengan pendekatan yang lebih sistematis dan adil.</p>
                        <div class="text-button">
                            <a href="#">Read More <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="section-heading">
                        <h4>About</h4>
                        <img src="{{ asset('template') }}/assets/images/heading-line-dec.png" alt="">
                        <p>Sebuah platform inovatif yang didedikasikan untuk membantu tim gateball dan asosiasi olahraga
                            dalam
                            membuat keputusan yang lebih tepat dan efisien dalam memilih atlet terbaik. Dengan antarmuka
                            yang mudah digunakan, Anda dapat memasukkan data atlet dan melihat hasil perangkingan
                            prioritas atlet dengan cepat, berdasarkan analisis mendalam dari berbagai kriteria yang
                            relevan. </p>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="gradient-button">
                                <a href="#galery">Galery</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-image">
                        <img src="{{ asset('template') }}/assets/images/about-right-dec.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="galery" class="the-clients">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading">
                        <h4>Galery</h4>
                        <img src="{{ asset('template') }}/assets/images/heading-line-dec.png" alt="">
                        <p>Memperlihatkan momen-momen penting dan prestasi luar biasa mereka dalam perjalanan menuju
                            kesuksesan olahraga.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="naccs">
                        <div class="grid">
                            <div class="row">
                                <div class="col-lg-7 align-self-center">
                                    <div class="">
                                        <div>
                                            <div class="thumb">
                                                <div class="row">
                                                    {{-- <div class="col-lg-4 col-sm-4 col-12">
                                                        <h4>David Martino Co</h4>
                                                        <span class="date">30 November 2021</span>
                                                    </div> --}}
                                                    <div class="col-lg-4 col-sm-4 d-none d-sm-block mb-5">
                                                        <span class="category">Informasi</span>
                                                    </div>
                                                    {{-- <div class="col-lg-4 col-sm-4 col-12">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="rating">4.8</span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 mb-5">
                                                <div class="service-item first-service">
                                                    <div class="p-3 text-black">
                                                        <h5 class="mb-3">Informasi 1</h5>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Reprehenderit, quo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-5">
                                                <div class="service-item first-service">
                                                    <div class="p-3 text-black">
                                                        <h5 class="mb-3">Informasi 2</h5>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Reprehenderit, quo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-5">
                                                <div class="service-item first-service">
                                                    <div class="p-3 text-black">
                                                        <h5 class="mb-3">Informasi 3</h5>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Reprehenderit, quo.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-5">
                                                <div class="service-item first-service">
                                                    <div class="p-3 text-black">
                                                        <h5 class="mb-3">Informasi 4</h5>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Reprehenderit, quo.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div>
                                            <div class="thumb">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <h4>Jake Harris Nyo</h4>
                                                        <span class="date">29 November 2021</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 d-none d-sm-block">
                                                        <span class="category">Digital Business</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="rating">4.5</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="thumb">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <h4>May Catherina</h4>
                                                        <span class="date">27 November 2021</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 d-none d-sm-block">
                                                        <span class="category">Business &amp; Economics</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="rating">4.7</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="thumb">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <h4>Random User</h4>
                                                        <span class="date">24 November 2021</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 d-none d-sm-block">
                                                        <span class="category">New App Ecosystem</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="rating">3.9</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="last-thumb">
                                            <div class="thumb">
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <h4>Mark Amber Do</h4>
                                                        <span class="date">21 November 2021</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 d-none d-sm-block">
                                                        <span class="category">Web Development</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-12">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <span class="rating">4.3</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <ul class="nacc">
                                        <li class="active">
                                            <div>
                                                <div class="thumb">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="client-content">
                                                                <iframe class="w-100" height="260"
                                                                    src="https://www.youtube.com/embed/WZU18aaXH9o"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen></iframe>
                                                                {{-- <img src="assets/images/quote.png" alt="">
                                                                <p>“Lorem ipsum dolor sit amet, consectetur adpiscing
                                                                    elit, sed do eismod tempor idunte ut labore et
                                                                    dolore magna aliqua darwin kengan
                                                                    lorem ipsum dolor sit amet, consectetur picing elit
                                                                    massive big blasta.”</p> --}}
                                                            </div>
                                                            {{-- <div class="down-content">
                                                                <img src="{{ asset('template') }}/assets/images/client-image.jpg"
                                                                    alt="">
                                                                <div class="right-content">
                                                                    <h4>David Martino</h4>
                                                                    <span>CEO of David Company</span>
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        {{-- <li>
                                            <div>
                                                <div class="thumb">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="client-content">
                                                                <img src="assets/images/quote.png" alt="">
                                                                <p>“CTO, Lorem ipsum dolor sit amet, consectetur
                                                                    adpiscing elit, sed do eismod tempor idunte ut
                                                                    labore et dolore magna aliqua darwin kengan
                                                                    lorem ipsum dolor sit amet, consectetur picing elit
                                                                    massive big blasta.”</p>
                                                            </div>
                                                            <div class="down-content">
                                                                <img src="assets/images/client-image.jpg"
                                                                    alt="">
                                                                <div class="right-content">
                                                                    <h4>Jake H. Nyo</h4>
                                                                    <span>CTO of Digital Company</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <div class="thumb">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="client-content">
                                                                <img src="assets/images/quote.png" alt="">
                                                                <p>“May, Lorem ipsum dolor sit amet, consectetur
                                                                    adpiscing elit, sed do eismod tempor idunte ut
                                                                    labore et dolore magna aliqua darwin kengan
                                                                    lorem ipsum dolor sit amet, consectetur picing elit
                                                                    massive big blasta.”</p>
                                                            </div>
                                                            <div class="down-content">
                                                                <img src="{{ asset('template') }}/assets/images/client-image.jpg"
                                                                    alt="">
                                                                <div class="right-content">
                                                                    <h4>May C.</h4>
                                                                    <span>Founder of Catherina Co.</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <div class="thumb">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="client-content">
                                                                <img src="{{ asset('template') }}/assets/images/quote.png"
                                                                    alt="">
                                                                <p>“Lorem ipsum dolor sit amet, consectetur adpiscing
                                                                    elit, sed do eismod tempor idunte ut labore et
                                                                    dolore magna aliqua darwin kengan
                                                                    lorem ipsum dolor sit amet, consectetur picing elit
                                                                    massive big blasta.”</p>
                                                            </div>
                                                            <div class="down-content">
                                                                <img src="assets/images/client-image.jpg"
                                                                    alt="">
                                                                <div class="right-content">
                                                                    <h4>Random Staff</h4>
                                                                    <span>Manager, Digital Company</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <div class="thumb">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="client-content">
                                                                <img src="assets/images/quote.png" alt="">
                                                                <p>“Mark, Lorem ipsum dolor sit amet, consectetur
                                                                    adpiscing elit, sed do eismod tempor idunte ut
                                                                    labore et dolore magna aliqua darwin kengan
                                                                    lorem ipsum dolor sit amet, consectetur picing elit
                                                                    massive big blasta.”</p>
                                                            </div>
                                                            <div class="down-content">
                                                                <img src="{{ asset('template') }}/assets/images/client-image.jpg"
                                                                    alt="">
                                                                <div class="right-content">
                                                                    <h4>Mark Am</h4>
                                                                    <span>CTO, Amber Do Company</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="pricing" class="pricing-tables">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading">
                        <h4>We Have The Best Pre-Order <em>Prices</em> You Can Get</h4>
                        <img src="{{ asset('template') }}/assets/images/heading-line-dec.png" alt="">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eismod tempor incididunt ut
                            labore et dolore magna.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pricing-item-regular">
                        <span class="price">$12</span>
                        <h4>Standard Plan App</h4>
                        <div class="icon">
                            <img src="assets/images/pricing-table-01.png" alt="">
                        </div>
                        <ul>
                            <li>Lorem Ipsum Dolores</li>
                            <li>20 TB of Storage</li>
                            <li class="non-function">Life-time Support</li>
                            <li class="non-function">Premium Add-Ons</li>
                            <li class="non-function">Fastest Network</li>
                            <li class="non-function">More Options</li>
                        </ul>
                        <div class="border-button">
                            <a href="#">Purchase This Plan Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pricing-item-pro">
                        <span class="price">$25</span>
                        <h4>Business Plan App</h4>
                        <div class="icon">
                            <img src="{{ asset('template') }}/assets/images/pricing-table-01.png" alt="">
                        </div>
                        <ul>
                            <li>Lorem Ipsum Dolores</li>
                            <li>50 TB of Storage</li>
                            <li>Life-time Support</li>
                            <li>Premium Add-Ons</li>
                            <li class="non-function">Fastest Network</li>
                            <li class="non-function">More Options</li>
                        </ul>
                        <div class="border-button">
                            <a href="#">Purchase This Plan Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pricing-item-regular">
                        <span class="price">$66</span>
                        <h4>Premium Plan App</h4>
                        <div class="icon">
                            <img src="{{ asset('template') }}/assets/images/pricing-table-01.png" alt="">
                        </div>
                        <ul>
                            <li>Lorem Ipsum Dolores</li>
                            <li>120 TB of Storage</li>
                            <li>Life-time Support</li>
                            <li>Premium Add-Ons</li>
                            <li>Fastest Network</li>
                            <li>More Options</li>
                        </ul>
                        <div class="border-button">
                            <a href="#">Purchase This Plan Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <footer id="newsletter">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-heading">
                        <h4>Contact Us</h4>
                    </div>
                </div>
                {{-- <div class="col-lg-6 offset-lg-3">
                    <form id="search" action="#" method="GET">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <fieldset>
                                    <input type="address" name="address" class="email"
                                        placeholder="Email Address..." autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <fieldset>
                                    <button type="submit" class="main-button">Subscribe Now <i
                                            class="fa fa-angle-right"></i></button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-3">
                    <div class="footer-widget">
                        <h4>Hubungi Kami</h4>
                        <ul>
                            <li><a target="_blank" href="https://wa.me/62812345678">Kontak 1</a></li>
                            <li><a target="_blank" href="https://wa.me/62812345678">Kontak 2</a></li>
                        </ul>
                        <ul>
                            <li><a target="_blank" href="https://wa.me/62812345678">Kontak 3</a></li>
                            <li><a target="_blank" href="https://wa.me/62812345678">Kontak 4</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-widget">
                        <h4>About Us</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#fitur">Fitur</a></li>
                        </ul>
                        <ul>
                            <li><a href="#about">About</a></li>
                            <li><a href="#galery">Galery</a></li>
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    <div class="footer-widget">
                        <h4>About Our Company</h4>
                        <div class="logo">
                            <img src="{{ asset('template') }}/assets/images/white-logo.png" alt="">
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore.</p>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <div class="copyright-text">
                        <p>Copyright © 2022 Chain App Dev Company. All Rights Reserved.
                            <br>Design: <a href="https://templatemo.com/" target="_blank"
                                title="css templates">TemplateMo</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Scripts -->
    <script src="{{ asset('template') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('template') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template') }}/assets/js/owl-carousel.js"></script>
    <script src="{{ asset('template') }}/assets/js/animation.js"></script>
    <script src="{{ asset('template') }}/assets/js/imagesloaded.js"></script>
    <script src="{{ asset('template') }}/assets/js/popup.js"></script>
    <script src="{{ asset('template') }}/assets/js/custom.js"></script>
</body>

</html>
