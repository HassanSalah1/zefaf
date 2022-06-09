@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="panel border-primary no-border border-3-top">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h5>{{$userProfile->name}}</h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            @if($userProfile->image != null)
                                <img src="{{$userProfile->image}}"
                                     alt="{{$userProfile->name}}"
                                     class="img-responsive"/>
                            @else
                                <img src="{{url('/dashboard/images/placeholder.jpg')}}"
                                     alt="{{$userProfile->name}}"
                                     class="img-responsive"/>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel border-success no-border border-3-top">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h5>{{trans('admin.actions')}}</h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">

                        @if ($userProfile->status === \App\Entities\UserStatus::ACTIVE)
                            <a name="block" class="btn btn-danger " style="margin: 4px;"
                               href="#" onclick="blockUser(this);return false;" id="{{$userProfile->id}}">
                                {{trans('admin.block_action')}} <span class="btn-label btn-label-right"><i
                                        class="fa fa-lock"></i></span>
                            </a>
                        @endif
                        @if ($userProfile->status === \App\Entities\UserStatus::BLOCKED)
                            <a name="unblock" class="btn btn-success" style="margin: 4px;"
                               href="#" onclick="activeUser(this);return false;" id="{{$userProfile->id}}">
                                {{trans('admin.active_action')}} <span class="btn-label btn-label-right"><i
                                        class="fa fa-unlock-alt"></i></span>
                            </a>
                        @endif
{{--                        @if ($userProfile->status === \App\Entities\UserStatus::UNVERIFIED)--}}
{{--                            <a name="verify" class="btn btn-warning" href="#" style="margin: 4px;"--}}
{{--                               onclick="verifyAccount(this);return false;" id="{{$userProfile->id}}">--}}
{{--                                {{trans('admin.verify_action')}} <span class="btn-label btn-label-right"><i--}}
{{--                                        class="fa fa-certificate"></i></span>--}}
{{--                            </a>--}}
{{--                        @endif--}}


                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9">

            <ul class="nav nav-tabs nav-justified custom-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#profile2" aria-controls="profile2"
                       role="tab" data-toggle="tab" aria-expanded="true">
                        {{trans('admin.profile')}}
                    </a>
                </li>

                <li role="presentation">
                    <a href="#favourite" aria-controls="favourite"
                       role="tab" data-toggle="tab" aria-expanded="true">
                        Saved service providers
                    </a>
                </li>

            </ul>
            <div class="tab-content bg-white p-15">

                <div role="tabpanel" class="tab-pane active" id="profile2">
                    <!-- /.panel -->

                    <div class="panel border-primary no-border border-3-top">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h5>{{trans('admin.profile')}}</h5>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <td>
                                            {{trans('admin.name')}}
                                        </td>
                                        <td>
                                            {{$userProfile->name}}
                                        </td>
                                        <td>
                                            {{trans('admin.phone')}}
                                        </td>
                                        <td>
                                            {{$userProfile->phone}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            {{trans('admin.email')}}
                                        </td>
                                        <td>
                                            {{$userProfile->email}}
                                        </td>
                                        <td>
                                            {{trans('admin.status')}}
                                        </td>
                                        <td>
                                            @if ($userProfile->status === \App\Entities\UserStatus::ACTIVE)
                                                <span class="btn btn-success">{{trans('admin.active_status')}} </span>
{{--                                            @elseif ($userProfile->status === \App\Entities\UserStatus::UNVERIFIED) {--}}
{{--                                            <span class="btn btn-warning"> {{trans('admin.unverified_status')}} </span>--}}
                                            @elseif ($userProfile->status === \App\Entities\UserStatus::BLOCKED)
                                                <span class="btn btn-danger">{{ trans('admin.blocked_status') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>country name</td>
                                        <td>{{$userProfile->countryName}}</td>

                                        <td>city name</td>
                                        <td>{{$userProfile->cityName}}</td>
                                    </tr>

                                    <tr>
                                        <td>wedding date</td>
                                        <td>{{$userProfile->weddingDate}}</td>

                                        <td></td>
                                        <td></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>

                <div role="tabpanel" class="tab-pane" id="favourite">
                    <!-- /.panel -->

                    <div class="panel border-primary no-border border-3-top">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Saved service providers
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="favourite_datatble">
                                            <thead>
                                            <tr>
                                                <th>{{trans('admin.name')}}</th>
                                                <th>{{trans('admin.category_name')}}</th>
                                                <th>{{trans('admin.location')}}</th>
                                                <th>{{trans('admin.membership')}}</th>
                                                <th>{{trans('admin.price_range')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>

            </div>
        </div>
    </div>

    @include('admin.layers.partials.modal')
    @include('admin.layers.partials.credit_modal')
@stop


@section('script')
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script src="{{url('/dashboard/js/fancybox.min.js')}}"></script>
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {
            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            // load Favourites
            loadDataTablesWithId('{{ url( (($locale === 'ar') ? $locale : '') ."/user/favourites/data/".$userProfile->id) }}',
                ['name', 'category_name', 'location', 'membership', 'price_range'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                    'id': 'favourite_datatble'
                });

        });


        function activeUser(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/user/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.activate_title')}}",
                ban_message: "{{trans('admin.activate_message')}}",
                inactivate: "{{trans('admin.activate_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\UserStatus::ACTIVE}}",
                load_page: '{{url('/user/details/'.$userProfile->id)}}'
            });
        }

        function verifyAccount(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/user/verify')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.verify_action')}}",
                ban_message: "{{trans('admin.verify_message')}}",
                inactivate: "{{trans('admin.verify_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                load_page: '{{url('/user/details/'.$userProfile->id)}}'
            });
        }

        function blockUser(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/user/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.ban_title')}}",
                ban_message: "{{trans('admin.ban_message')}}",
                inactivate: "{{trans('admin.inactive_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\UserStatus::BLOCKED}}",
                load_page: '{{url('/user/details/'.$userProfile->id)}}'
            });
        }

    </script>

@stop

@section('style')
    <style>
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .img-responsive, .thumbnail > img, .thumbnail a > img, .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .custom-tabs li {
            padding: 8px;
        }

        .nav-tabs a {
            padding: 10px;
        }
    </style>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
    <link href="{{url('/dashboard/css/components.css')}}" rel="stylesheet"/>
    <link href="{{url('/dashboard/css/pages.css')}}" rel="stylesheet"/>
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #favourite_datatble, #product_datatble , #nurse_datatble {
            width: 100% !important;
        }
    </style>
@stop
