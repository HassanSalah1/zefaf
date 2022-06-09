<!DOCTYPE html>
<html @if($locale === 'ar') dir="rtl" @else dir="ltr" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Amgen 350 Care CMS">
    <meta name="author" content="Amgen 350 Care">

    <link rel="shortcut icon" href="{{url('/dashboard/images/users/logo@2x.png')}}">

    <title>{{$title}}</title>

    <link href="{{url('/dashboard/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/icons.css')}}" rel="stylesheet" type="text/css"/>
    @if($locale === 'en')
        <link href="{{url('/dashboard/css/rtl/style.css')}}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{url('/dashboard/css/ltr/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('/dashboard/css/custom/styles_ar.css')}}" rel="stylesheet" type="text/css"/>
    @endif

    <style>
        .logo {
            color: #A7B622 !important;
        }

        .wrapper-page {
            width: 40%;
        }

        .checkbox-custom {
            float: right;
        }

        #showPassword {
            position: relative;
            top: -37px;
        }

    </style>

    <script src="{{url('/dashboard/js/modernizr.min.js')}}"></script>

</head>
<body>
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a class="logo"><span>{{$title}}</span></a>
    </div>
    <!-- start card-box-->
    <div class="m-t-40 card-box">
        <div class="text-center">
            <img src="{{url('/dashboard/images/users/logo@2x.png')}}" style="width: 100px;">
            <h4 class="text-uppercase font-bold m-b-0">
                {{$title}}
            </h4>
        </div>
        <div class="p-20">

            <form class="form-horizontal m-t-20" id="loginForm">
                @csrf
                <div class="form-group">
                    <div class="col-xs-12">
                        <span id="generalError" class="text-danger"></span>
                        <input class="form-control" name="password" type="password" required=""
                               placeholder="{{trans('admin.password')}}">
                        <span id="error" class="text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <span id="generalError" class="text-danger"></span>
                        <input class="form-control" name="repassword" type="password" required=""
                               placeholder="{{trans('admin.repassword')}}">
                        <span id="error" class="text-danger"></span>
                    </div>
                </div>
                <span id="success" class="text-success"></span>
                <span id="authError" class="text-danger"></span>
                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">
                            {{trans('admin.send')}}
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- end card-box-->
</div>
<!-- jQuery  -->
<script src="{{url('/dashboard/js/jquery.min.js')}}"></script>
<script src="{{url('/dashboard/js/popper.min.js')}}"></script>
<script src="{{url('/dashboard/js/bootstrap.min.js')}}"></script>
<script src="{{url('/dashboard/js/detect.js')}}"></script>
<script src="{{url('/dashboard/js/fastclick.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.blockUI.js')}}"></script>
<script src="{{url('/dashboard/js/waves.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.nicescroll.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.slimscroll.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.scrollTo.min.js')}}"></script>
<!-- App js -->
<script src="{{url('/dashboard/js/jquery.core.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.app.js')}}"></script>

<script>
    $(function () {
        //login
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            const password = $('#loginForm input[name=password]').val();
            const repassword = $('#loginForm input[name=repassword]').val();
            if(repassword !== password){
                return;
            }
            let form = new FormData(this);
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') ."/reset-password")}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                success: function (response) {
                    $('#authError').hide();
                    $('#success').show();
                    $('#loginForm input[type=email]').val('');
                    $('#success').text(response.message);
                    setTimeout(function () {
                        $('#success').hide();
                    } , 2000);
                },
                error: function (response) {
                    $('#success').hide();
                    if (response.status == 403) {
                        $('#authError').text(response.responseJSON.error);
                    } else {
                        $('#authError').text('{{trans('admin.general_error_message')}}');
                    }
                }
            });//ajax request
        });//login function

        $('#showPassword').on('click', function () {
            const password = $('#loginForm input[type=password]');
            const text = $('#loginForm input[type=text]');
            const iTag = $('#showPassword').find('i');
            console.log(password.attr('type'))
            if (password.attr('type') === 'password') {
                password.attr('type', 'text');
                iTag.removeClass('fa-eye');
                iTag.addClass('fa-eye-slash');
            } else if (text.attr('type') === 'text') {
                text.attr('type', 'password');
                iTag.removeClass('fa-eye-slash');
                iTag.addClass('fa-eye');
            }
        });

    });//ready function
</script>

</body>
</html>
