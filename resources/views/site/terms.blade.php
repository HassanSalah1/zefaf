<html>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="root">
    <title></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('/dashboard/images/users/logo@2x.png')}}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nova+Square&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,500i,700&display=swap" rel="stylesheet">

    <!--  CSS Style -->
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/fontawesome-all-5.9.0.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/webfonts/flaticon/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/layerslider.css')}}">
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    @yield('style')
    <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/ctg/security-2.css')}}">
    <style>
        html, body, #page_wrapper, .fixed-bg-white {
            /*background: transparent radial-gradient(closest-side at 50% 50%, #FFFFFF 0%, #75afd7 100%) 0% 0% no-repeat padding-box !important;*/
        }

        .border-bottom{
            border-bottom: unset;
        }
    </style>
</head>
<body>
<div class="preloader">
    <div class="text-center text-primary xy-center position-relative">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div id="page_wrapper">
        <header>
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-light nav-secondary nav-primary-hover py-3">
                        <a class="navbar-brand" href="{{url('/')}}">
                            <img class="nav-logo" src="{{url('/dashboard/images/users/logo@2x.png')}}"
                                 alt="Image not found">
                        </a>
                    </nav>
                </div>
            </div>
        </header>
        <div class="full-row">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12" style="">
                        @if ($terms)
                            <p>
                                {!! $terms->value !!}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Javascripts -->
<script src="{{url('assets/js/jquery.min.js')}}"></script>
<script src="{{url('assets/js/greensock.js')}}"></script>
<script src="{{url('assets/js/layerslider.transitions.js')}}"></script>
<script src="{{url('assets/js/layerslider.kreaturamedia.jquery.js')}}"></script>
<script src="{{url('assets/js/popper.min.js')}}"></script>
<script src="{{url('assets/js/bootstrap.min.js')}}"></script>
<script src="{{url('assets/js/fontawesome-all-5.9.0.min.js')}}"></script>
<script src="{{url('assets/js/jquery.fancybox.min.js')}}"></script>
<script src="{{url('assets/js/owl.js')}}"></script>
<script src="{{url('assets/js/wow.js')}}"></script>
<script src="{{url('assets/js/paraxify.js')}}"></script>
<script src="{{url('assets/js/custom.js')}}"></script>
</body>
</html>
