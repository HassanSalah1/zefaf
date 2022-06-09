@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="form-group col-sm-12">
            <label class="control-label"
                   for="nurse_id">{{trans('admin.nurse_name')}}</label>
            <select required id="nurse_id" class="form-control" name="nurse_id">
                @foreach($nurses as $nurse)
                    <option value="{{$nurse->id}}">{{$nurse->name}}</option>
                @endforeach
            </select>
        </div> <!-- form-group -->
    </div>
@stop

@section('content')
    @include('admin.layers.partials.table')
    @include('admin.layers.partials.modal')
@stop



@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
        let defaultlogo = '{{url('/dashboard/logos/placeholder.jpg')}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            $('#nurse_id').select2();
            addModal({
                title: '{{trans('admin.assign_nurse')}}',
                select_selector: ['nurse_id']
            });
            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/journey/nurse/data") }}',
                ['userName' ,'phone','address' , 'requested_date' , 'from' , 'to', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/journey/nurse/assign')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/journey/nurse/assign')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function editNurse(item) {
            var id = $(item).attr('id');
            $('.modal-title').text('{{trans('admin.assign_nurse')}}');
            pub_id = id;
            $('.general_modal').modal('toggle');
            edit = true;
            add = false;
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
