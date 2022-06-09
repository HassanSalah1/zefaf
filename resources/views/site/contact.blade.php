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
                        <h1 class="page-titile">Contact</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent px-0">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
                <div class="col-lg-8 col-md-12">
                    <div class="bg-gray p-5 mb-4">
                        <h2 class="mb-4 down-line">Get In Touch</h2>
                        <span class="d-table mb-4 font-medium font-italic"></span>
                        <form id="contact-form" class="contact_message" method="post" novalidate="novalidate">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <input class="form-control" id="name" name="name" required
                                           placeholder="Name" type="text">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <input class="form-control" id="email" name="email" required
                                           placeholder="Email Address" type="email">
                                </div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <input class="form-control" id="subject" name="subject" required
                                           placeholder="Subject" type="text">
                                </div>
                                <div class="form-group col-md-12 col-sm-12">
                                    <textarea class="form-control" id="message" rows="5" required
                                              name="message" placeholder="Message"></textarea>
                                </div>
                                <div class="form-group col-md-12 col-sm-6">
                                    <input class="btn btn-primary" id="send" value="Send Message" type="submit">
                                </div>
                                <div class="col-md-12">
                                    <div class="error-handel">
                                        <div id="success">Your email sent Successfully, Thank you.</div>
                                        <div id="error"> Error occurred while sending email. Please try again later.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="contact-detail p-5 text-white bg-dark">
                        <h3 class="down-line mb-4 text-white">Get In Touch</h3>
                        <span class="d-table mb-4 font-medium font-italic"></span>
                        <div class="mb-4">
                            <span class="text-primary">Phone Number</span>
                            @if ($phone)
                                <p>{{$phone->value}}</p>
                            @endif
                            @if ($phone2)
                                <p>{{$phone2->value}}</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <span class="text-primary">E-Mail</span>
                            @if ($email)
                                <p>{{$email->value}}</p>
                            @endif
                            @if ($email2)
                                <p>{{$email2->value}}</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <span class="text-primary">Address</span>
                            @if ($address)
                                <p>{{$address->value}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-row p-0">
        <div class="container-fluid">
            <div class="row">
                <div id="map"></div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhoc3Xe0kB2rp77fI1lLLm6MH3I4UDdQw"></script>
    <script>
        @if($latitude)
        google.maps.event.addDomListener(window, 'load', init);
        function init() {
            'use strict';
            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(parseFloat('{{$latitude->value}}'), parseFloat('{{$longitude->value}}')), // New York
                styles:
                    [
                        {
                            "featureType": "administrative",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": "-100"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative.province",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 65
                                },
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": "50"
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": "-100"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "lightness": "30"
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "lightness": "40"
                                }
                            ]
                        },
                        {
                            "featureType": "transit",
                            "elementType": "all",
                            "stylers": [
                                {
                                    "saturation": -100
                                },
                                {
                                    "visibility": "simplified"
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [
                                {
                                    "hue": "#ffff00"
                                },
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -97
                                }
                            ]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels",
                            "stylers": [
                                {
                                    "lightness": -25
                                },
                                {
                                    "saturation": -100
                                }
                            ]
                        }
                    ]
            };
            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(parseFloat('{{$latitude->value}}'), parseFloat('{{$longitude->value}}')),
                map: map,
                title: '{{$address->value}}'
            });
        }
        @endif

        $(function () {
            $('#contact-form').submit(function (e) {
                e.preventDefault();
                const form = new FormData(this);
                $.ajax({
                    url: '{{url('/contact/add')}}',
                    method: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        $('#error').css('display', 'none');
                        $('#success').css('display', 'block');
                        $('#contact-form').find('input:text,input, textarea').val('');
                        $('#contact-form').find('input:submit').val('Send Message');
                    },
                    error: function (response) {
                        $('#error').css('display', 'block');
                    }
                });
            });
        })
    </script>
@stop