@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <a type="button" href="{{url('/restaurant/show/add')}}"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_restaurant')}}
                </a>
            </div>
        </div>
    </div>
    {{-- end row--}}

    @include('admin.layers.partials.table')
@stop



@section('script')
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
        let defaultImage = '{{url('/dashboard/images/placeholder.jpg')}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/restaurants/data") }}',
                ['name' , 'restaurant_name', 'logo' , 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                    fancy: true
                });
        });

        function deleterestaurant(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/restaurant/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

        function banRestaurant(item){
            ban(item, '{{url('/restaurant/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title : "{{trans('admin.ban_title')}}",
                ban_message : "{{trans('admin.ban_message')}}",
                inactivate : "{{trans('admin.inactive_action')}}",
                cancel : "{{trans('admin.cancel')}}"
            });
        }

        function changeRestaurantStatus(item) {
            ban(item, '{{url('/restaurant/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.activate_title')}}",
                ban_message: "{{trans('admin.activate_message')}}",
                inactivate: "{{trans('admin.activate_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
