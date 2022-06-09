@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="name">{{trans('admin.name')}}</label>
            <input required type="text" id="name" name="name"
                   class="form-control"
                   placeholder="{{trans('admin.name')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="email">{{trans('admin.email')}}</label>
            <input required type="email" id="email" name="email"
                   class="form-control"
                   placeholder="{{trans('admin.email')}}">
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="password">{{trans('admin.password')}}</label>
            <input type="password" id="password" name="password"
                   class="form-control"
                   placeholder="{{trans('admin.password')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="permission_group_id">{{trans('admin.group_name')}}</label>
            <select required id="permission_group_id" class="form-control" name="permission_group_id">
                @foreach($permissions as $permission)
                    <option value="{{$permission->id}}">{{$permission->group_name}}</option>
                @endforeach
            </select>
        </div> <!-- form-group -->
    </div>

    <div class="row">

    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_employee')}}
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

            $('#permission_group_id').select2();

            addModal({
                title: '{{trans('admin.add_employee')}}',
                select_selector: ['permission_group_id']
            });
            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/employees/data") }}',
                ['name', 'email', 'group_name', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/employee/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/employee/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function editEmployee(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_employee')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/employee/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#general-form input[name=name]').val(response.data.name);
                    $('#general-form input[name=email]').val(response.data.email);
                    $('#permission_group_id').select2('val', response.data.permission_group_id);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function deleteEmployee(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/employee/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

        function banEmployee(item) {
            ban(item, '{{url('/employee/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.ban_title')}}",
                ban_message: "{{trans('admin.ban_message')}}",
                inactivate: "{{trans('admin.inactive_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: '{{\App\Entities\UserStatus::BLOCKED}}'
            });
        }

        function changeEmployeeStatus(item) {
            ban(item, '{{url('/employee/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.activate_title')}}",
                ban_message: "{{trans('admin.activate_message')}}",
                inactivate: "{{trans('admin.activate_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: '{{\App\Entities\UserStatus::ACTIVE}}'
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
