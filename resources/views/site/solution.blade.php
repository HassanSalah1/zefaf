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
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Solutions</li>
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
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-6">
                                <div class="thumb-classic d-flex transation p-4 bg-light hover-bg-primary hover-text-white mb-30">
                                    <span class="float-left d-table">
                                        {{--<i class="flaticon-security flat-medium text-primary"></i>--}}
                                        <img src="{{$product->icon}}" style="width: 50px;" />
                                    </span>
                                    <div class="pl-3">
                                        <h4 class="mb-3">
                                            <a href="{{url('/solution/details/'.$product->id)}}">{{$product->title}}</a>
                                        </h4>
                                        <p>{{$product->short_description}}</p>
                                        <a class="btn-link" href="{{url('/solution/details/'.$product->id)}}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($products->hasPages())
                            <div class="col-md-auto mx-auto mt-4">
                                <nav aria-label="...">
                                    <ul class="pagination">
                                        <li class="page-item @if ($products->onFirstPage()) disabled @endif">
                                            @if ($products->onFirstPage())
                                                <span class="page-link">Previous</span>
                                            @else
                                                <a class="page-link" href="{{$products->previousPageUrl()}}">
                                                    Previous
                                                </a>
                                            @endif
                                        </li>
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            @if($products->currentPage() === $i)
                                                <li class="page-item active">
										    <span class="page-link">
										        {{$i}}
										    <span class="sr-only">(current)</span>
									        </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{$products->url($i)}}">
                                                        {{$i}}
                                                    </a>
                                                </li>
                                            @endif
                                        @endfor

                                        <li class="page-item @if (!$products->hasMorePages()) disabled @endif">
                                            @if (!$products->hasMorePages())
                                                <span class="page-link">Next</span>
                                            @else
                                                <a class="page-link" href="{{$products->nextPageUrl()}}">
                                                    Next
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
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