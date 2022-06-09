@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <input type="hidden" name="id" value="{{$restaurant->id}}">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">{{trans('admin.name')}}</label>
                                <input type="text" class="form-control" id="name"
                                       value="{{$restaurant->name}}"
                                       name="name"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">{{trans('admin.email')}}</label>
                                <input type="email" class="form-control" id="email"
                                       value="{{$restaurant->email}}"
                                       name="email"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">{{trans('admin.password')}}</label>
                                <input type="password" class="form-control" id="password" name="password"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">{{trans('admin.phone')}}</label>
                                <input type="tel" class="form-control" value="{{$restaurant->phone}}"
                                       id="phone" name="phone"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title">{{trans('admin.restaurant_name')}}</label>
                                <input type="text" class="form-control" id="title"
                                       value="{{$restaurant->restaurant->name}}"
                                       name="restaurant_name"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"
                                       for="image">{{trans('admin.logo')}}</label>
                                <div class="media no-margin-top">
                                    <div class="media-left">
                                        <a href="{{$restaurant->restaurant->logo}}" data-popup="lightbox">
                                            <img id="preview" src="{{$restaurant->restaurant->logo}}"
                                                 class="img-rounded img-preview"
                                                 style="width: 58px; height: 58px; border-radius: 2px;"
                                                 alt="">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <div class="uploader bg-danger" id="uniform-img">
                                            <input type="file" class="file-styled form-data ui-wizard-content"
                                                   id="logo"
                                                   name="logo" accept="image/*">
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

        $(function () {

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            previewImage($('#general-form input[name=logo]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/restaurant/edit')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('restaurants')}}'
                    });
            });
        });

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
