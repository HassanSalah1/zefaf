<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Favicon -->
    <link rel="icon" href="{{url('/landing/assets/img/icon.png')}}">
    <!-- Bootstrap CSS -->
    <link href="{{url('/landing/assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Slick Slider -->
    <link href="{{url('/landing/assets/css/slick.css')}}" rel="stylesheet">
    <link href="{{url('/landing/assets/css/slick-theme.css')}}" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="{{url('/landing/assets/css/aos.css')}}" rel="stylesheet">
    <!-- Lity CSS -->
    <link href="{{url('/landing/assets/css/lity.min.css')}}" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{url('/landing/assets/css/fontawesome-all.min.css')}}">
    <!-- linearicons CSS -->
    <link rel="stylesheet" href="{{url('/landing/assets/css/linearicons.css')}}">

    <!-- Our Min CSS -->
    <link href="{{url('/landing/assets/css/main.css')}}" rel="stylesheet">

    <!-- Themes * You can select your color from color-1 , color-2 , color-3 , color-4 , ..etc * -->
{{--    <link href="{{url('/landing/assets/css/color-6.css')}}" rel="stylesheet">--}}
    <link href="{{url('/landing/assets/css/color-21.css')}}" rel="stylesheet">
{{--    #--}}
    <!-- <link href="assets/css/color-1.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-2.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-3.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-4.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-5.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-6.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-7.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-8.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-9.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-10.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-11.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-12.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-13.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-14.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-15.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-16.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-17.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-18.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-19.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/color-20.css" rel="stylesheet"> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body data-spy="scroll" data-target="#main_menu" data-offset="70">
<!-- Start Preloader -->
<div class="preloader">
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
</div>
<!-- End Preloader -->

<!-- Start Header -->
<header class="foxapp-header">
    <nav class="navbar navbar-expand-lg navbar-light" id="foxapp_menu">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{url('/landing/assets/img/fox-logo.png')}}" style="width: 97px;" class="img-fluid" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu"
                    aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_menu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link anchor active" href="#slide">Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#main_features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#screenshots">Screenshots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link anchor" href="#git_in_touch">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- End Header -->

<!-- Start Header -->
<section id="slide" class="slide background-withcolor">
    <div class="content-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <p class="mb-0">With us you will</p>
                    <h2>succeed</h2>
                    <p>Proactively syndicate open-source e-markets after low-risk high-yield synergy. Professionally
                        simplify visionary technology.
                    </p>
{{--                    <a href="#" class="btn btn-primary btn-white shadow btn-theme"><span>Read More</span></a>--}}
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <img src="{{url('/landing/assets/screenshots/1.png')}}" class="img-fluid d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Header -->



<!-- Start Main Features -->
<section id="main_features" class="main-features padding-100">
    <div class="container">
        <div class="row">
            <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                <h3>Main
                    <span>Features</span>
                </h3>
                <div class="space-25"></div>
                <p></p>
                <div class="space-25"></div>
            </div>
        </div>
        <div class="row align-items-center">
{{--            <div class="col-lg-3 text-lg-right left-side">--}}
{{--                <div class="one-feature" data-aos="fade-right" data-aos-delay="1000">--}}
{{--                    --}}{{--                    <h5></h5>--}}
{{--                    <p>Scan the QR code to download the application.</p>--}}
{{--                </div>--}}
{{--                <div class="one-feature" data-aos="fade-right" data-aos-delay="1400">--}}
{{--                    --}}{{--                    <h5>Lorem ipsum</h5>--}}
{{--                    --}}{{--                    <span class="lnr lnr-gift"></span>--}}
{{--                    <p>There are 2 QR codes one for iOS and one for Android, use the one for your device.</p>--}}
{{--                </div>--}}
{{--                <div class="one-feature" data-aos="fade-right" data-aos-delay="1800">--}}
{{--                    --}}{{--                    <h5>Lorem ipsum</h5>--}}
{{--                    --}}{{--                    <span class="lnr lnr-database"></span>--}}
{{--                    <p>You will go to disclaimer message, accept to proceed.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-lg-6 left-side">
                <div class="features-circle">
{{--                    <div class="circle-svg" data-aos="zoom-in" data-aos-delay="400">--}}
{{--                        <svg version="1.1" id="features_circle" xmlns="http://www.w3.org/2000/svg"--}}
{{--                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="543px"--}}
{{--                             height="542.953px" viewBox="0 0 543 542.953" enable-background="new 0 0 543 542.953"--}}
{{--                             xml:space="preserve">--}}
{{--                                <g>--}}
{{--                                    <circle fill="none" stroke="#" stroke-width="3" stroke-miterlimit="10"--}}
{{--                                            stroke-dasharray="11.9474,11.9474" cx="271.5" cy="271.516" r="270" />--}}
{{--                                    <animateTransform attributeName="transform" type="rotate" from="0" to="360"--}}
{{--                                                      dur="50s" repeatCount="indefinite"></animateTransform>--}}
{{--                                </g>--}}
{{--                            </svg>--}}
{{--                    </div>--}}
                    <img data-aos="fade-up" data-aos-delay="200" src="{{url('/landing/assets/screenshots/home.png')}}" class="img-fluid"
                         alt="">
                </div>
            </div>
            <div class="col-lg-6 right-side">
                <p style="text-align: left">
                    1- Scan the QR code to download the application. <br>
                    2- There are 2 QR codes one for iOS and one for Android, use the one for your device.<br>
                    3- You will go to disclaimer message, accept to proceed.<br>
                    4- The consent message will appear, accept to proceed.<br>
                    5- Sign up by entering your name, address and mobile no.<br>
                    6- Verification code will be requested, it is “0000”.<br>
                    7- Choose PSP<br>
                    8- Read the instructions on how to use the application and<br>
                    9- Our call center will contact you for activation and enrollment.<br>
                    10- When you want to request LDL test, click on lab test, choose the test, date and time for lab visit.<br>
                    11- The call center will contact you for confirmation<br>
                    12-	For product delivery click on the icon, choose time and date.<br>
                    13-	The call center will contact you for confirmation<br>
                    14-	For nurse visit, click on the icon and choose time and date.<br>
                    15-	For a new pack of Repatha, select “New cycle” to be able to digitally request the services again.<br>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End Main Features -->


<!-- Start Screenshots -->
<section id="screenshots" class="screenshots padding-100 background-fullwidth background-fixed"
         style="background-image: url(assets/img/gray-bg.jpg);">
    <div class="container-fluid">
        <div class="row">
            <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                <h3><span> Screenshots</span>
                </h3>
                <div class="space-25"></div>
                <p></p>
                <div class="space-50"></div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12">
                <div class="screenshots-slider" data-aos="fade-up">


                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/1.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>

                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/2.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>

                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/3.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/4.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/5.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/6.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/7.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/8.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/9.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                    <div class="item text-center">
                        <img src="{{url('/landing/assets/screenshots/10.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Screenshots -->



<!-- Start Download App -->
<section id="download_app" class="download-app padding-100 pb-0 background-fullwidth background-fixed"
         style="background-image: url(/landing/assets/img/gray-bg.jpg);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12 offset-3" data-aos="fade-right">
                <h2>Download our free App</h2>
                <p></p>
                <a href="#" class="btn btn-primary shadow btn-colord btn-theme" tabindex="0">
                    <i class="fab fa-apple"></i>
                    <span>Git it on
                            <br>APP STORE</span>
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.amgen.amgen360care" class="btn btn-primary shadow  btn-colord btn-theme" tabindex="0">
                    <i class="fab fa-google-play"></i>
                    <span>Git it on
                            <br>GOOGLE PLAY</span>
                </a>
            </div>
            <div class="col-lg-6 col-12" data-aos="fade-left" data-aos-delay="400">
{{--                <img src="assets/img/mobile-6.png" class="img-fluid d-block mx-auto" alt="">--}}
            </div>
        </div>
    </div>
</section>
<!-- End Download App -->

<!-- Start  Git in touch -->
<section id="git_in_touch" class="git-in-touch padding-100">
    <div class="container">
        <div class="row">
            <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                <h3>Git
                    <span> in </span>touch
                </h3>
                <div class="space-25"></div>
                <p></p>
                <div class="space-50"></div>
            </div>
        </div>
        <form data-aos="fade-up">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Your Name">
                        <span class="focus-border"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Enter Your Email">
                        <span class="focus-border"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Your Subject">
                        <span class="focus-border"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <textarea class="form-control" rows="4" placeholder="Enter Your Message"></textarea>
                        <span class="focus-border"></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="space-25"></div>
                    <button type="submit" class="btn btn-primary shadow btn-colord btn-theme"><span>Send
                                Message</span></button>
                </div>
            </div>
        </form>
        <div class="space-50"></div>
        <div class="row contact-info">
            <div class="col-md-4 col-12 text-center">
                <div class="info-box" data-aos="fade-right" data-aos-delay="400">
                    <span class="lnr lnr-map-marker"></span>
                    <h5>28 Green Tower, Street Name New York City, USA</h5>
                </div>
            </div>
            <div class="col-md-4 col-12 text-center">
                <div class="info-box" data-aos="fade-up" data-aos-delay="800">
                    <span class="lnr lnr-phone"></span>
                    <h5>{{$support->value}}</h5>
                </div>
            </div>
            <div class="col-md-4 col-12 text-center">
                <div class="info-box" data-aos="fade-left" data-aos-delay="1200">
                    <span class="lnr lnr-envelope"></span>
                    <a href="mailto:info@yourcompany.com">info@yourcompany.com</a>
                    <a href="mailto:sales@yourcompany.com">sales@yourcompany.com</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End  Git in touch  -->


<!-- Start  Footer -->
<footer class="padding-100 pb-0">
    <div class="space-50"></div>
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="widget">
                        <img src="{{url('/landing/assets/img/fox-logo.png')}}" style="width: 97px;" class="img-fluid" alt="">
                        <p>Sed pottitor lects nibh. Viamus magna justo, lacinia eget consectetur sed, convallis
                            at
                            tellus.
                            Curabitur aliquet quam id dui posuere blandit. Lorem ipsum dolor sit amet,
                            consectetur
                            adipiscing
                            elit.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="widget">
                        <h6>Quick Links</h6>
                        <ul>
                            <li>
                                <a href="#">Home</a>
                            </li>
                            <li>
                                <a href="#">About Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="widget">
                        <h6>Social Media</h6>
                        <ul>
                            <li>
                                <a href="#">Facbook</a>
                            </li>
                            <li>
                                <a href="#">Instagram</a>
                            </li>
                            <li>
                                <a href="#">LinkedIn</a>
                            </li>
                            <li>
                                <a href="#">Twitter</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="widget">
                        <h6>Quick Contact</h6>
                        <ul>
                            <li>
                                <span>Phone : </span>{{$support->value}}
                            </li>
                            @if (isset($support_email) && $support_email)
                            <li>
                                <span>Email : </span>
                                <a href="mailto:{{$support_email->value}}"></a>{{$support_email->value}}
                            </li>
                            @endif
                            <li>
                                <span>Address : </span>8 Green Tower, Street Name New York City, USA</li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space-50"></div>
    <div class="copyright">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <p>All rights reserved © IMN, {{date('Y')}}</p>
                </div>
                <div class="offset-md-4 col-md-4">
                    <ul class="nav justify-content-end">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End  Footer  -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{url('/landing/assets/js/jquery-3.3.1.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Bootstrap JS -->
<script src="{{url('/landing/assets/js/popper.min.js')}}"></script>
<script src="{{url('/landing/assets/js/bootstrap.min.js')}}"></script>
<!-- svg -->
<script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
<!-- Slick Slider JS -->
<script src="{{url('/landing/assets/js/slick.min.js')}}"></script>
<!-- Counterup JS -->
<script src="{{url('/landing/assets/js/waypoints.min.js')}}"></script>
<script src="{{url('/landing/assets/js/jquery.counterup.js')}}"></script>
<!-- AOS JS -->
<script src="{{url('/landing/assets/js/aos.js')}}"></script>
<!-- lity JS -->
<script src="{{url('/landing/assets/js/lity.min.js')}}"></script>
<!-- Our Main JS -->
<script src="{{url('/landing/assets/js/main.js')}}"></script>

</body>

</html>
