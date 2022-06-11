@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">
                    <input type="hidden" name="user_id" value="{{$vendor->id}}">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="status">Main Category</label>
                            <select id="main_category_id" class="form-control" name="main_category_id">
                                <option value="-1">none</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$vendor->vendor->category->category->id === $category->id  ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="status">Sub Category</label>
                            <select required id="category_id" class="form-control" name="category_id">
                            </select>
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name">Name</label>
                            <input required type="text" id="name" value="{{$vendor->name}}" class="form-control" name="name"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="email">Email</label>
                            <input required type="email" id="email" class="form-control" value="{{$vendor->email}}" name="email"/>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="phone">Phone</label>
                            <input required type="number" id="phone" class="form-control" value="{{$vendor->phone}}" name="phone"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password"/>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label class="control-label"
                                   for="biography">biography</label>
                            <textarea required id="biography" class="form-control" name="biography">{{$vendor->vendor->biography}}</textarea>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-3">
                            <label class="control-label"
                                   for="price_from">price from</label>
                            <input required type="number" id="price_from" value="{{$vendor->vendor->from_price}}" class="form-control" name="price_from"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-3">
                            <label class="control-label"
                                   for="price_to">price to</label>
                            <input required type="number" id="price_to" value="{{$vendor->vendor->to_price}}" class="form-control" name="price_to"/>
                        </div> <!-- form-group -->

                        {{--  image upload --}}

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image">{{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
{{--                                    {{$vendor->vendor_images->id}}--}}
                                    <a href="{{url($vendor->vendor_images->first()->image)}}" data-popup="lightbox">
                                        <img id="preview" src="{{url($vendor->vendor_images->first()->image)}}"
                                             class="img-rounded img-preview"
                                             style="width: 58px; height: 58px; border-radius: 2px;"
                                             alt="">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div class="uploader bg-danger" id="uniform-img">
                                        <input type="file" class="file-styled form-data ui-wizard-content" id="image"
                                               name="image" accept="image/*">
                                        <span class="filename"
                                              style="user-select: none;">{{trans('admin.no_file_selected')}}</span>
                                        <span class="action" style="user-select: none;">
                                            <i class="fa fa-plus-square fa-3x icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="country_id">Country</label>
                            <select id="country_id" class="form-control" name="country_id">
                                <option value="-1">none</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{ $vendor->city->country->id === $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="city_id">City</label>
                            <select required id="city_id" class="form-control" name="city_id">
                            </select>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="membership_id">Membership</label>
                            <select id="membership_id" class="form-control" name="membership_id">
                                @foreach($memberships as $membership)
                                    <option value="{{$membership->id}}" {{ $vendor->vendor->membership_id === $membership->id ? 'selected' : '' }}>{{$membership->type}}</option>
                                @endforeach
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6" id="duration_div">
                            <label class="control-label"
                                   for="duration">Duration</label>
                            <select id="duration" class="form-control" name="duration">
                                <option value="30" {{$vendor->vendor->membership_duration === 30 ? 'selected' : ''}}>1 Month</option>
                                <option value="60" {{$vendor->vendor->membership_duration === 60 ? 'selected' : ''}}>2 Month</option>
                                <option value="90" {{$vendor->vendor->membership_duration === 90 ? 'selected' : ''}}>3 Month</option>
                                <option value="120" {{$vendor->vendor->membership_duration === 120 ? 'selected' : ''}}>4 Month</option>
                                <option value="150" {{$vendor->vendor->membership_duration === 150 ? 'selected' : ''}}>5 Month</option>
                                <option value="180" {{$vendor->vendor->membership_duration === 180 ? 'selected' : ''}}>6 Month</option>
                                <option value="210" {{$vendor->vendor->membership_duration === 210 ? 'selected' : ''}}>7 Month</option>
                                <option value="240" {{$vendor->vendor->membership_duration === 240 ? 'selected' : ''}}>8 Month</option>
                                <option value="270" {{$vendor->vendor->membership_duration === 270 ? 'selected' : ''}}>9 Month</option>
                                <option value="300" {{$vendor->vendor->membership_duration === 300 ? 'selected' : ''}}>10 Month</option>
                                <option value="330" {{$vendor->vendor->membership_duration === 330 ? 'selected' : ''}}>11 Month</option>
                                <option value="360" {{$vendor->vendor->membership_duration === 360 ? 'selected' : ''}}>12 Month</option>
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6" id="duration2_div" style="display: none;">
                            <label class="control-label"
                                   for="free_duration">Duration</label>
                            <input class="form-control" type="number" min="1"
                                   name="free_duration" id="free_duration"/>
                        </div> <!-- form-group -->

                    </div>

                    <br>

                    <div class="row">

                        <div class="form-group col-md-4 offset-4">
                            <button type="submit"
                                    class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                {{trans('admin.save')}}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@stop



@section('script')
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
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
        let meals = [];
        let cart = [];

        $(function () {
            $('#main_category_id').select2();
            $('#category_id').select2();
            $('#country_id').select2();
            $('#city_id').select2();

            $('#membership_id').select2();
            $('#duration').select2();

            $('#membership_id').on('change', (e) => {
                console.log($('#membership_id').find('option:selected').val())
                if ($('#membership_id').find('option:selected').val() == 4) {
                    $('#duration_div').hide();
                    $('#duration2_div').show();
                }else{
                    $('#duration_div').show();
                    $('#duration2_div').hide();
                }
            });


            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            previewImage($('#general-form input[name=image]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/vendor/edit/'.$vendor->id)}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('vendors')}}'
                    });
            });
            let sub_category = {{$vendor->vendor->category->id}};
            let index = 0;
            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                index++;
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
                        console.log(sub_category)
                        response.data.forEach((category) => {
                            categoryHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#category_id').html(categoryHtml);
                        if (index === 1){
                            $('#category_id').val(sub_category)
                        }
                        $('#category_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });
            $('#main_category_id').trigger('change')
            let city_old = {{$vendor->city_id}};
            let city_index = 0;
            $('#country_id').on('change', (e) => {
                city_index++;
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
                        response.data.forEach((category) => {
                            cityHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#city_id').html(cityHtml);
                        if(city_index===1){
                            $('#city_id').val(city_old)
                        }
                        $('#city_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });
            $('#country_id').trigger('change')
        });
    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
