@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="name">{{trans('admin.name_arabic')}}</label>
            <input required type="text" id="name_ar" name="name_ar"
                   class="form-control"
                   placeholder="{{trans('admin.name_arabic')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="name">{{trans('admin.name_english')}}</label>
            <input required type="text" id="name_en" name="name_en"
                   class="form-control"
                   placeholder="{{trans('admin.name_english')}}">
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label"
                   for="government_id">{{trans('admin.country_name')}}</label>
            <select required id="government_id" class="form-control" name="country_id">
                @foreach($governments as $government)
                    <option value="{{$government->id}}">{{$government->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_area')}}
                </button>
            </div>
        </div>
    </div>
    {{-- end row--}}

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

            $('#government_id').select2();

            addModal({
                title: '{{trans('admin.add_area')}}',
                select_selector: ['government_id']
            });
            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/areas/data") }}',
                ['name_ar', 'name_en' , 'country_name', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/area/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/area/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function editArea(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_area')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/area/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#general-form input[name=name_ar]').val(response.data.name_ar);
                    $('#general-form input[name=name_en]').val(response.data.name_en);
                    $('#government_id').select2('val' , response.data.country_id);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function deleteArea(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/area/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
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
