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
                   for="phone">{{trans('admin.phone')}}</label>
            <input required type="number" id="phone" name="phone"
                   class="form-control"
                   placeholder="{{trans('admin.phone')}}">
        </div> <!-- form-group -->

    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="phone">{{trans('admin.email')}}</label>
            <input required type="email" id="email" name="email"
                   class="form-control"
                   placeholder="{{trans('admin.email')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="password">{{trans('admin.password')}}</label>
            <input required type="password" id="password" name="password"
                   class="form-control"
                   placeholder="{{trans('admin.password')}}">
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="country_id">{{trans('admin.country_name')}}</label>
            <select id="country_id" class="form-control" name="country_id">
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="city_id">{{trans('admin.city_name')}}</label>
            <select id="city_id" class="form-control" name="city_id">
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div> <!-- form-group -->
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="scountry_id">Country</label>
                        <select id="scountry_id" class="form-control" name="scountry_id">
                            <option value="-1">none</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="scity_id">City</label>
                        <select id="scity_id" class="form-control" name="scity_id">
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <button class="btn btn-warning btn-rounded" style="margin-top: 22px;" onclick="search()">
                            Search
                        </button>

                        <button style="margin-top: 26px;" id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                                class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                            <i class="fa fa-plus-square"></i> {{trans('admin.add_user')}}
                        </button>
                    </div>

                </div>
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

            $('#country_id').select2();
            $('#city_id').select2();

            $('#scountry_id').select2();
            $('#scity_id').select2();

            addModal({
                title: '{{trans('admin.add_user')}}',
                select_selector: ['country_id', 'city_id']
            });
            onClose();

            $('#country_id').change((e) => {
                const form = new FormData();
                form.append('country_id', $('#country_id').find('option:selected').val());
                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . '/get/country/cities')}}',
                    method: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    success: function (response) {
                        createPspSelect(response.data);
                    },
                    error: function () {
                        createPspSelect([]);
                    }
                });

            });

            $('#scountry_id').change((e) => {
                const country = $('#country_id').find('option:selected').val();
                const form = new FormData();
                form.append('country_id', country);

                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . "/countries/get/cities")}}',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        let cityHtml = '<option value="-1">none</option>';
                        response.data.forEach((city) => {
                            cityHtml += '<option value="' + city.id + '">'
                                + city.name + '</option>';
                        });
                        $('#scity_id').html(cityHtml);
                        $('#scity_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            search();

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') .'/user/add')}}',
                    '', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });

        });

        function search() {
            let lang = {
                'show': '{{trans('admin.show')}}',
                'first': '{{trans('admin.first')}}',
                'last': '{{trans('admin.last')}}',
                'filter': '{{trans('admin.filter')}}',
                'filter_type': '{{trans('admin.type_filter')}}'
            };
            let keys = ['name', 'phone', 'email', 'status', 'actions'];
            let city_id = $('#scity_id').find('option:selected').val();

            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            let query = '';

            if (city_id) {
                query += 'city_id=' + city_id;
            }
            let url = '{{ url( (($locale === 'ar') ? $locale : '') . "/users/data") }}';
            loadDataTables(url + '?' + query, keys, '', lang);
        }

        function createPspSelect(psps) {
            $('#city_id').select2('val' , null);
            let html = '';
            psps.forEach((psp) => {
                html += '<option value="' + psp.id + '">' + psp.name + '</option>';
            });
            $('#city_id').html(html);
        }

        function activeUser(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/user/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.activate_title')}}",
                ban_message: "{{trans('admin.activate_message')}}",
                inactivate: "{{trans('admin.activate_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\UserStatus::ACTIVE}}"
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

        function blockUser(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/user/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.ban_title')}}",
                ban_message: "{{trans('admin.ban_message')}}",
                inactivate: "{{trans('admin.inactive_action')}}",
                cancel: "{{trans('admin.cancel')}}",
                status: "{{\App\Entities\UserStatus::BLOCKED}}",
            });
        }

        function isCalled(item) {
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/user/called')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.called_action')}}",
                ban_message: "{{trans('admin.called_message')}}",
                inactivate: "{{trans('admin.yes')}}",
                cancel: "{{trans('admin.cancel')}}",
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
