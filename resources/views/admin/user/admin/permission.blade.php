@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label"
                       for="weight">{{trans('admin.group_name')}}</label>
                <input required type="text" id="group_name" name="group_name"
                       class="form-control"
                       placeholder="{{trans('admin.group_name')}}">
            </div> <!-- form-group -->
        </div>
    </div>

    <div class="row">
        @foreach(\App\Entities\PermissionKey::getKeys() as $permissionKey)
            <div class="col-md-3">
                <input name="permissions[]" type="checkbox" id="{{$permissionKey}}"
                       value="{{$permissionKey}}"> {{trans('admin.'.$permissionKey.'_permission')}}
            </div>
        @endforeach
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.group_add')}}
                </button>
            </div>
        </div>
    </div>
    {{-- end row--}}

    @include('admin.layers.partials.table')
    @include('admin.layers.partials.modal')
@stop



@section('script')
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

            $('#add_btn').on('click', function (e) {
                e.preventDefault();
                $('input[type=text]').val('');
                $('input[type=checkbox]').prop('checked', false);
                $('.modal-title').text('{{trans('admin.group_add')}}');
                add = true;
                edit = false;
            });

            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/permissions/data") }}',
                ['group_name', 'permissions', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/permission/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/permission/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });

        function editPermission(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_permission')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/permission/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#group_name').val(response.data.group_name);
                    // $('#permissions').select2('val', response.data.permissions);
                    response.data.permissions.forEach(function (permission) {
                        $('#' + permission).prop('checked', true);
                        console.log(permission)
                    })
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function deletePermission(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/permission/delete')}}', {
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
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
