<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Patron - Security Service Company Template">
    <meta name="author" content="root">
    <title>Elcon Nova</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{url('assets/images/logo/logo-white.png')}}">
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
</head>
<body>

@if($support_phone)
    <a href="tel:{{$support_phone->value}}" class="float">
        <i class="fas fa-phone-alt my-float"></i> Call US
    </a>
    <a href="https://wa.me/{{$support_phone->value}}/?text=" class="float">
        <i class="fas fa-phone-alt my-float"></i> WhatsApp
    </a>
@endif

<div class="preloader">
    <div class="text-center text-primary xy-center position-relative">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
<div id="page_wrapper">
    <div class="row">
        @yield('content')
        @include('site.footer')
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
<script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
<script>
    $(function () {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-left",
            "preventDuplicates": false,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",

            "hideMethod": "fadeOut"
        };
        $('#subscribe-form').submit(function (e) {
            e.preventDefault();
            const form = new FormData(this);
            $.ajax({
                url: '{{url('/subscribe')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                success: function (response) {
                    $('#subscribe-form').find('input:text,input, textarea').val('');
                    toastr['success']('you are subscribed', 'success message');
                },
                error: function (response) {
                    toastr['error']('error happens, try again later', 'error message');
                }
            });
        });
    });
</script>
@yield('script')
</body>
</html>
