@extends('admin.layers.partials.master')

@section('content')
    @include('admin.layers.partials.table')
@stop





@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script src="{{url('/dashboard/js/fancybox.min.js')}}"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            $('#status').select2();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });


            let keys = ['user_name' , 'user_phone' , 'category' , 'sub_category', 'new', 'actions'];

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') . "/requests/data") }}', keys, '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}'
                });
        });

        function activeVendor(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/vendor/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.activate_title')}}",
                ban_message: "{{trans('admin.activate_message')}}",
                inactivate: "{{trans('admin.activate_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\UserStatus::ACTIVE}}"
            });
        }

        function approveVendor(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/request/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.approve_action')}}",
                ban_message: "approve this edit request",
                inactivate: "{{trans('admin.approve_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\EditRequestStatus::APPROVED}}"
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
            });
        }

        function blockVendor(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/request/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "refuse",
                ban_message: "refuse this edit request",
                inactivate: "refuse",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\EditRequestStatus::REFUSED}}",
            });
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">

    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
