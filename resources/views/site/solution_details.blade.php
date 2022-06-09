@extends('site.master')

@section('content')
    <header class="nav-on-banner header-transparent fixed-bg-white border-bottom">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-4">
                        <div class="float-left">
                            <ul class="d-flex text-general">
                                @include('site.top')
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-8">
                        <div class="float-right">
                            <ul class="d-flex text-general">
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
                        <nav class="navbar navbar-expand-lg navbar-light nav-secondary nav-primary-hover py-3">
                            <a class="navbar-brand" href="{{url('/')}}"><img class="nav-logo"
                                                                             src="{{url('assets/images/elconnova.png')}}"
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
    <div class="page-banner bg-light"
         style="background-image: url(../assets/images/pattern/concrete-wall.png); background-repeat: repeat">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="py-5">
                        <h1 class="page-titile">Solutions</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent px-0">
                                <li class="breadcrumb-item">
                                    <a href="{{url('/')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{url('/site/solutions')}}">Solutions</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Solution Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <img src="{{url($solution->image)}}" class="w-100" alt="image not found!">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <h2 class="down-line mb-3">{{$solution->title}}</h2>
                            {!! $solution->description !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <h2 class="down-line mb-3">Service Advantage</h2>
                            {!! $solution->service_description !!}
                        </div>
                    </div>
                    <div class="row">
                        @foreach($solution->features as $feature)
                        <div class="col-lg-4 col-md-4">
                            <div class="text-center">
                                {{--<span class="flaticon-pay d-table flat-medium block-100 text-white bg-primary rounded-circle p-5 mx-auto"></span>--}}
                                <img class="rounded-circle" src="{{url($feature->icon)}}"
                                     alt="{{$feature->title}}" style="width: 50px;">
                                <h3 class="py-4">{{$feature->title}}</h3>
                                <p>{{$feature->short_description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-5">
                            @foreach($solution->questions as $question)
                            <div class="accorden-block mb-1">
                                <div class="accorden-title px-4 py-3 bg-light active">
                                    {{$question->question}}
                                </div>
                                <div class="accorden-content px-4" style="display: block">
                                    <p>
                                        {{$question->answer}}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
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