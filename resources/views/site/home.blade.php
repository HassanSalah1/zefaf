@extends('site.master')

@section('content')
    <header class="nav-on-banner header-transparent fixed-bg-secondary">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-4">
                        <div class="float-left">
                            <ul class="d-flex text-white">
                                @include('site.top')
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-8">
                        <div class="float-right">
                            <ul class="d-flex text-white">
                                @if ($email)
                                    <li>
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:{{$email->value}}" target="_blanck">{{$email->value}}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-nav">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light nav-white nav-primary-hover py-3">
                            <a class="navbar-brand" href="{{url('/')}}"><img class="nav-logo"
                                                                           src="{{url('assets/images/logo/logo-white.png')}}"
                                                                           alt="Image not found"></a>
                            <button class="navbar-toggler bg-light" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation"><span
                                        class="navbar-toggler-icon"></span></button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                @include('site.navbar')
                                <div class="float-right navbar-nav nav-element sm-mx-none">
                                    <div class="navbar-nav search-pop ml-3 position-relative">
                                        <span class="flaticon-search"><i class="fas fa-search text-white"></i></span>
                                        <div class="search-form shadow-sm bg-white">
                                            <form action="#" method="post" class="position-relative">
                                                <input class="form-control" type="search" placeholder="Search"
                                                       aria-label="Search">
                                                <button class="btn-search my-2 y-center my-sm-0" type="submit"><i
                                                            class="fas fa-search"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="full-row p-0 overflow-hidden">
        <div id="slider" style="width:1200px; height:800px; margin:0 auto;margin-bottom: 0px;">

        @foreach($slider_images as $slider_image)
            <!-- Slide 1-->
                <div class="ls-slide"
                     data-ls="bgsize:cover; bgposition:50% 50%; duration:10000; transition2d:3; timeshift:-500; deeplink:home; kenburnszoom:in; kenburnsrotate:0; kenburnsscale:1.2; parallaxevent:scroll; parallaxdurationmove:500;">
                    <img width="1920" height="1280" src="{{url($slider_image->image)}}" class="ls-bg" alt=""/>
                    <div style="width:100%; height:100%; background:rgba(11, 15, 41, 0.49); top:50%; left:50%;"
                         class="ls-l"
                         data-ls="easingin:easeOutQuint; durationout:400; parallaxlevel:0; position:fixed;"></div>
                    <div style="width:440px; height:440px; background:transparent; border: 5px solid; border-color: rgba(255, 255, 255, 0.1); top:50%; left:50%;"
                         class="ls-l"
                         data-ls="delayin:1500; durationout:400; easingin:easeOutExpo; scalexin:0.8; parallaxlevel:0;"></div>
                    <p style="font-weight:400; text-align:center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); width:700px; font-size:60px; line-height:80px; color:#ffffff; top:280px; left:50%; white-space:normal;"
                       class="ls-l font-highlight"
                       data-ls="offsetyin:40; delayin:250; easingin:easeOutQuint; filterin:blur(10px); offsetyout:-200; durationout:400; parallax:true; parallaxlevel:3;">{{$slider_image->title}}</p>
                    {{--<p style="font-weight:500; text-align:center; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); width:700px; font-size:24px; line-height:50px; color:#ffffff; top:230px; left:50%; white-space:normal;" class="ls-l text-primary" data-ls="offsetyin:40; easingin:easeOutQuint; offsetyout:-200; durationout:400; parallax:true; parallaxlevel:4;">Be an inspiration</p>--}}
                    {{--<p style="font-weight:400; text-align:center; width:720px; font-size:20px; line-height:30px; color:#ffffff; top:460px; left:50%; white-space:normal;" class="ls-l" data-ls="offsetyin:40; delayin:700; easingin:easeOutQuint; offsetyout:-250; durationout:400; parallax:true; parallaxlevel:2;">Digital business is changing the way organizations use and think about technology, moving technology from a supporting player to a leading player in innovation, revenue and market growth.</p>--}}
                </div>
            @endforeach

        </div>
    </div>
    <div class="full-row">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <img class="mb-4 sm-mx-none" src="assets/images/elconnova.png" alt="image not found!">
                </div>
                <div class="col-lg-6 offset-lg-2">
                    <span class="tagline text-primary pb-2 d-table w-xs-100">About Our Company</span>
                    <h2 class="down-line mb-4">Company Intro
                    </h2>
                    @if ($company_info)
                        <p>
                            {{$company_info->value}}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="full-row bg-secondary p-0 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-dark text-light p-35" style="margin-top: -50px">
                        <h2 class="down-line mb-4 text-white">Our Solutions</h2>
                        @if ($solutions_description)
                            <p>
                                {{$solutions_description->value}}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 py-8">
                    <div class="row">
                        @foreach($solutions as $solution)
                            <div class="col-md-6">
                                <div class="thumb-classic d-flex transation p-4 bg-light hover-bg-primary hover-text-white mb-30">
                                <span class="float-left d-table">
                                    {{--<i class="flaticon-security flat-medium text-primary"></i>--}}
                                    <img src="{{url($solution->icon)}}" style="width: 50px;" />
                                </span>
                                    <div class="pl-3">
                                        <h4 class="mb-3"><a href="{{url('/solution/details/'.$solution->id)}}">{{$solution->title}}</a></h4>
                                        <p>{{$solution->short_description}}</p>
                                        <a class="btn-link" href="{{url('/solution/details/'.$solution->id)}}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="text-primary pb-1 d-table m-auto tagline">Let's Know</span>
                    <h2 class="down-line w-50 mx-auto text-center w-sm-100 mb-4">Why Choose Us</h2>
                    <span class="d-table w-75 w-sm-100 font-medium mx-auto text-center mb-4 font-italic">
                    @if ($choose_description)
                            {{$choose_description->value}}
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="full-row bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fact-counter mt-5">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                @if ($happy_clients)
                                    <div class="mb-30 count-border-style count wow fadeIn" data-wow-duration="300ms">
                                        <span class="count-num text-primary h2" data-speed="3000"
                                              data-stop="{{$happy_clients->value}}">0</span>
                                        <div class="h4 position-absolute text-white bg-dark y-center">Happy<br>Clients
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($qualified_employee)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-30 count-border-style count wow fadeIn" data-wow-duration="300ms">
                                        <span class="count-num text-primary h2" data-speed="3000"
                                              data-stop="{{$qualified_employee->value}}">0</span>
                                        <div class="h4 position-absolute text-white bg-dark y-center">Qualified<br>Employee
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($deal_assigned)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-30 count-border-style count wow fadeIn" data-wow-duration="300ms">
                                        <span class="count-num text-primary h2" data-speed="3000"
                                              data-stop="{{$deal_assigned->value}}">0</span>
                                        <div class="h4 position-absolute text-white bg-dark y-center">Deal<br>Assigned
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($experience_years)
                                <div class="col-lg-3 col-sm-6">
                                    <div class="mb-30 count-border-style count wow fadeIn" data-wow-duration="300ms">
                                        <span class="count-num text-primary h2" data-speed="3000"
                                              data-stop="{{$experience_years->value}}">0</span>
                                        <div class="h4 position-absolute text-white bg-dark y-center">Years of<br>Experience
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="text-primary pb-1 d-table m-auto tagline">Our Experience</span>
                    <h2 class="down-line w-50 mx-auto text-center w-sm-100 mb-4">Team Leaders</h2>
                    <span class="d-table w-75 w-sm-100 font-medium mx-auto text-center mb-5 font-italic">
                    @if ($members_description)
                            {{$members_description->value}}
                        @endif
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="4block-carusel owl-carousel nav-disable">
                        @foreach($members as $member)
                            <div class="item">
                                <div class="team-thumb-default overlay-primary hover-text-PushUpBottom">
                                    <img src="{{url($member->image)}}" alt="corporate template">
                                    <div class="position-absolute xy-center p-4 w-100">
                                        <h6 class="overflow-hidden text-center">
                                            <a class="text-white first-push-up transation" href="#">
                                                {{$member->name}}
                                            </a>
                                        </h6>
                                        <div class="text-white text-center overflow-hidden">
                                        <span class="second-push-up transation">
                                            ( {{$member->position}} )
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="text-center p-4">
                                    <a class="text-secondary hover-text-primary transation" href="#">
                                        {{$member->name}}
                                    </a>
                                </h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#slider').layerSlider({
                sliderVersion: '6.0.0',
                type: 'fullsize',
                pauseOnHover: 'disabled',
                responsiveUnder: 0,
                layersContainer: 1200,
                maxRatio: 1,
                parallaxScrollReverse: true,
                hideUnder: 0,
                hideOver: 100000,
                skin: 'numbers',
                showBarTimer: false,
                showCircleTimer: false,
                thumbnailNavigation: 'disabled',
                allowRestartOnResize: true,
                skinsPath: 'assets/skins/',
            });
        });
    </script>
@stop