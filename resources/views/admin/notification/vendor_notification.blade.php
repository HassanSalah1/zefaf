@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" id="general-form">


                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="title_ar">{{trans('admin.title_ar')}}</label>
                                    <input required type="text" id="title_ar" name="title_ar"
                                           class="form-control"
                                           placeholder="{{trans('admin.title_ar')}}">
                                </div> <!-- form-group -->
                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="title_en">{{trans('admin.title_en')}}</label>
                                    <input required type="text" id="title_en" name="title_en"
                                           class="form-control"
                                           placeholder="{{trans('admin.title_en')}}">
                                </div> <!-- form-group -->

                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="message_ar">{{trans('admin.message_ar')}}</label>
                                    <textarea required id="message_ar" name="message_ar"
                                              class="form-control"
                                              placeholder="{{trans('admin.message_ar')}}"></textarea>
                                </div> <!-- form-group -->

                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="message_en">{{trans('admin.message_en')}}</label>
                                    <textarea required id="message_en" name="message_en"
                                              class="form-control"
                                              placeholder="{{trans('admin.message_en')}}"></textarea>
                                </div> <!-- form-group -->

                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="country_id">Country</label>
                                    <select id="country_id" class="form-control" name="country_id">
                                        <option value="-1">none</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div> <!-- form-group -->

                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="city_id">City</label>
                                    <select id="city_id" class="form-control" name="city_id">
                                    </select>
                                </div> <!-- form-group -->
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="status">Main Category</label>
                                    <select id="main_category_id" class="form-control" name="main_category_id">
                                        <option value="-1">none</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div> <!-- form-group -->

                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="status">Sub Category</label>
                                    <select id="category_id" class="form-control" name="category_id">
                                    </select>
                                </div> <!-- form-group -->
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label class="control-label"
                                           for="vendor_id">{{trans('admin.vendors_title')}}</label>
                                    <select multiple id="vendor_id" class="form-control" name="vendor_id[]">
                                        @foreach($vendors as $vendor)
                                            <option
                                                value="{{$vendor->id}}">{{$vendor->name . ' - '. $vendor->phone}}</option>
                                        @endforeach
                                    </select>
                                </div> <!-- form-group -->

                                <div class="form-group col-sm-6">
                                    <label class="control-label"
                                           for="all_vendors">all vendors</label>
                                    <input type="checkbox" id="all_vendors" name="all_vendors"
                                    />
                                </div> <!-- form-group -->
                            </div>


                            <div class="form-group btn-left">
                                <button type="submit"
                                        class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                    {{trans('admin.save')}}
                                </button>
                            </div>


                        </form>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div>
        </div><!-- end col -->
    </div>

@stop

@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
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

            $('#user_id').select2();
            $('#vendor_id').select2();
            $('#category_id').select2();
            $('#main_category_id').select2();
            $('#country_id').select2();
            $('#city_id').select2();

            $('#general-form').on('submit', function (e) {
                e.preventDefault();
                var form = new FormData(this);
                $.ajax({
                    url: '/notification/send',
                    method: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    success: function (response) {
                        toastr['success'](response.message, response.title);
                        resetForm($('#general-form'));
                        $('#user_id').select2('val', []);
                        $('#vendor_id').select2('val', []);
                        $('#category_id').select2('val', null);
                        $('#main_category_id').select2('val', null);
                    },
                    error: function () {
                        toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                    }
                });
            });

            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                console.log(category);
                let form = new FormData();
                form.append('category_id', category);
                form.append('deleted', 1);
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
        });
    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
