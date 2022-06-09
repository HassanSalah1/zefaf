@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="address">{{trans('admin.address')}}</label>
            <input required type="text" id="address" name="address"
                   class="form-control"
                   placeholder="{{trans('admin.address')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="city_id">{{trans('admin.city_name')}}</label>
            <select required id="city_id" class="form-control" name="city_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div> <!-- form-group -->
    </div>

    @if ($user && $user->isDashboardAuth())
        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label"
                       for="restaurant_id">{{trans('admin.restaurant_name')}}</label>
                <select required id="restaurant_id" class="form-control" name="restaurant_id">
                    @foreach($restaurants as $restaurant)
                        <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                    @endforeach
                </select>
            </div> <!-- form-group -->
        </div>
    @endif
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_branch')}}
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
    <script src="{{url('/dashboard/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            $('#city_id').select2();

            $('#restaurant_id').select2();
            addModal({
                title: '{{trans('admin.add_branch')}}',
                select_selector: ['city_id' ,'restaurant_id']
            });
            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/branches/data") }}',
                ['restaurant_name', 'city_name', 'address', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/branch/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/branch/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function editBranch(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_branch')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/branch/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#general-form input[name=address]').val(response.data.address);
                    $('#city_id').select2('val', response.data.city_id);
                    $('#restaurant_id').select2('val', response.data.restaurant_id);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function deleteBranch(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/branch/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

        function banBranch(item) {
            ban(item, '{{url('/branch/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.ban_title')}}",
                ban_message: "{{trans('admin.ban_message')}}",
                inactivate: "{{trans('admin.inactive_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

        function changeBranchStatus(item) {
            ban(item, '{{url('/branch/change')}}', {
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
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
    <link href="{{url('/dashboard/css/bootstrap-timepicker.min.css')}}" rel="stylesheet"/>
@stop
