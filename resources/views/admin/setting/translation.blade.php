@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="form-group">
        <label class="control-label"
               for="value">{{trans('admin.value')}}</label>
        <input required type="text" id="value" name="value"
               class="form-control"
               placeholder="{{trans('admin.value')}}">
    </div> <!-- form-group -->
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <select required id="lang_locale" class="form-control" name="lang_locale">
                            @foreach($locales as $localeText)
                                <option value="{{$localeText}}">{{trans('admin.'.$localeText)}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->
                    <div class="form-group col-sm-4">
                        <select required id="file_name" class="form-control" name="file_name">
                            <option selected value="admin">{{trans('admin.dashboard')}}</option>
                            <option value="api">{{trans('admin.api_messages')}}</option>
                        </select>
                    </div> <!-- form-group -->
                    <div class="form-group">
                        <button id="search" type="button"
                                class="btn btn-warning btn-rounded w-md waves-effect waves-light m-b-5">
                            {{trans('admin.search')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layers.partials.table')

    @include('admin.layers.partials.modal')
@stop





@section('style')
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
@stop


@section('script')
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>
        var locale = '';
        var file_name = '';

        $(function () {

            $('#lang_locale').select2();
            $('#file_name').select2();

            $('#file_name').on('change', function (e) {
                e.preventDefault();
                $selected_file = $('#file_name option:selected').val();
                if ($selected_file == 'admin') {
                    $('#lang_locale').html('<option value="ar" selected>{{trans('admin.ar')}}</option>')
                } else if ($selected_file == 'api') {
                    $('#lang_locale').html('<option value="ar" selected>{{trans('admin.ar')}}</option>'
                        + '<option value="en">{{trans('admin.en')}}</option>')
                }
            });

            locale = $('#lang_locale').find('option:selected').val();
            file_name = $('#file_name').find('option:selected').val();
            generateTable(locale, file_name);

            $('#search').on('click', function (e) {
                e.preventDefault();
                locale = $('#lang_locale').find('option:selected').val();
                file_name = $('#file_name').find('option:selected').val();
                if ($.fn.DataTable.isDataTable('#datatable')) {
                    $('#datatable').DataTable().destroy();
                }
                generateTable(locale, file_name);
            });


            $('#general-form').submit(function (e) {
                e.preventDefault();
                var form = new FormData(this);
                form.append('lang_locale', locale);
                form.append('file_name', file_name);
                form.append('key', pub_id);
                if (edit) {
                    url = '{{url((($locale === 'en') ? $locale : '').'/translation/edit')}}';
                }
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        if (response.code === 1) {
                            $('.general_modal').modal('toggle');
                            var $toast = toastr['success'](response.message, response.title); // Wire up an
                            $('#datatable').DataTable().ajax.reload(null, false);
                            edit = false;
                        } else if (response.code === 2) {
                            var $toast = toastr['error'](response.message, response.title); // Wire up an
                        }
                    }
                });
            });
        });

        function generateTable(locale, file_name) {

            loadDataTables('{{ url((($locale === 'en') ? $locale : '')."/translations/data?lang_locale=") }}' + locale + '&file_name=' + file_name
                , ['key', 'value', 'actions'], '', {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}'
                });
        }

        function edit_translation(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('key', id);
            form.append('lang_locale', locale);
            form.append('file_name', file_name);
            $('.modal-title').text('{{trans('admin.translation_edit')}}');
            pub_id = id;
            $.ajax({
                url: '{{url((($locale === 'en') ? $locale : '').'/translation/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                success: function (response) {
                    if (response.code === 1) {
                        $('#general-form input[name=value]').val(response.data);
                        $('.general_modal').modal('toggle');
                        edit = true;
                    } else if (response.code === 2) {
                        var $toast = toastr['error'](response.message, response.title);
                    }
                },
                error: function () {
                    var $toast = toastr['error']('{{trans('admin.error_message')}}', '{{trans('admin.error_title')}}');
                }
            });
        }

        function resetForm($form) {
            $form.find('input,input:text,input:password, input:file, select, textarea').val('');
        }

    </script>

@stop

@section('plugin_styles')
    <link href="/../../../../admin/css/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
    <!-- DataTables -->
    <link href="/../../../../admin/css/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

@stop
