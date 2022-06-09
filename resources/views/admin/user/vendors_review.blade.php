@extends('admin.layers.partials.master')

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Main Category</label>
                        <select id="main_category_id" class="form-control" name="main_category_id">
                            <option value="-1">none</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Sub Category</label>
                        <select id="category_id" class="form-control" name="category_id">
                        </select>
                    </div> <!-- form-group -->


                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="country_id">Country</label>
                        <select id="country_id" class="form-control" name="country_id">
                            <option value="-1">none</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="city_id">City</label>
                        <select id="city_id" class="form-control" name="city_id">
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <button class="btn btn-warning btn-rounded" style="margin-top: 22px;" onclick="search()">
                            Search
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- end row--}}

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
            $('#category_id').select2();
            $('#main_category_id').select2();

            $('#country_id').select2();
            $('#city_id').select2();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                console.log(category);
                let form = new FormData();
                form.append('category_id', category);

                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . "/vendors/get/categories")}}',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'},
                    success: function (response) {
                        let categoryHtml = '<option value="-1">none</option>';
                        response.data.forEach((category) => {
                            categoryHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#category_id').html(categoryHtml);
                        $('#category_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            $('#country_id').on('change', (e) => {
                const country = $('#country_id').find('option:selected').val();
                let form = new FormData();
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
                        $('#city_id').html(cityHtml);
                        $('#city_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            searchVendors('{{ url( (($locale === 'ar') ? $locale : '') . "/vendors/review/data") }}', {
                'show': '{{trans('admin.show')}}',
                'first': '{{trans('admin.first')}}',
                'last': '{{trans('admin.last')}}',
                'filter': '{{trans('admin.filter')}}',
                'filter_type': '{{trans('admin.type_filter')}}'
            });
        });

        function searchVendors(url, lang) {
            let keys = [
                {
                    data: 'name',
                    name: 'name',
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    searchable: true
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false
                },
            ];
            loadDataTablesKeys(url , keys, '', lang);
        }

        function search() {
            let lang = {
                'show': '{{trans('admin.show')}}',
                'first': '{{trans('admin.first')}}',
                'last': '{{trans('admin.last')}}',
                'filter': '{{trans('admin.filter')}}',
                'filter_type': '{{trans('admin.type_filter')}}'
            };
            let keys = [
                {
                    data: 'name',
                    name: 'name',
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    searchable: true
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false
                },
            ];
            let category_id = $('#category_id').find('option:selected').val();
            let city_id = $('#city_id').find('option:selected').val();

            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            let query = '';

            if (category_id) {
                query += 'category_id=' + category_id + '&';
            }
            if (city_id) {
                query += 'city_id=' + city_id;
            }
            let url = '{{ url( (($locale === 'ar') ? $locale : '') . "/vendors/review/data") }}';
            loadDataTablesKeys(url + '?' + query, keys, '', lang);
        }

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
            ban(item, '{{url((($locale === 'ar') ? $locale : '') . '/vendor/change')}}', {
                error_message: '{{trans('admin.error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.approve_action')}}",
                ban_message: "{{trans('admin.approve_message')}}",
                inactivate: "{{trans('admin.approve_action')}}",
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
