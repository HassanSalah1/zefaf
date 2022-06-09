@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image">{{trans('admin.'.\App\Entities\Key::VIDEO)}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                </div>
                                <div class="media-body">
                                    <div class="uploader bg-danger" id="uniform-img">
                                        <input type="file" class="file-styled form-data ui-wizard-content"
                                               id="{{\App\Entities\Key::VIDEO}}" accept="video/*"
                                               name="{{\App\Entities\Key::VIDEO}}"/>
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
                        @if ($video)
                            <div class="col-md-12">
                                <video width="50%" controls>
                                    <source src="{{$video->value}}" type="video/mp4">
                                </video>
                            </div>
                        @endif
                    </div>

                    <hr>



                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="logo">Layality {{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if(isset($loyality_image) && $loyality_image)
                                       href="{{$loyality_image->value}}"
                                       @else
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @endif data-popup="lightbox">
                                        <img id="preview" @if(isset($loyality_image) && $loyality_image)
                                        src="{{$loyality_image->value}}"
                                             @else
                                             src="{{url('/dashboard/images/placeholder.jpg')}}"
                                             @endif
                                             class="img-rounded img-preview"
                                             style="width: 58px; height: 58px; border-radius: 2px;"
                                             alt="">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div class="uploader bg-danger" id="uniform-img">
                                        <input type="file" class="file-styled form-data ui-wizard-content" id="{{\App\Entities\Key::LOYALITY_IMAGE}}"
                                               name="{{\App\Entities\Key::LOYALITY_IMAGE}}" accept="image/*">
                                        <span class="filename"
                                              style="user-select: none;">{{trans('admin.no_file_selected')}}</span>
                                        <span class="action" style="user-select: none;">
                                            <i class="fa fa-plus-square fa-3x icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="logo">list of services {{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if(isset($service_image) && $service_image)
                                       href="{{$service_image->value}}"
                                       @else
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @endif data-popup="lightbox">
                                        <img id="preview" @if(isset($service_image) && $service_image)
                                        src="{{$service_image->value}}"
                                             @else
                                             src="{{url('/dashboard/images/placeholder.jpg')}}"
                                             @endif
                                             class="img-rounded img-preview"
                                             style="width: 58px; height: 58px; border-radius: 2px;"
                                             alt="">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div class="uploader bg-danger" id="uniform-img">
                                        <input type="file" class="file-styled form-data ui-wizard-content" id="{{\App\Entities\Key::LOYALITY_IMAGE}}"
                                               name="{{\App\Entities\Key::Service_IMAGE}}" accept="image/*">
                                        <span class="filename"
                                              style="user-select: none;">{{trans('admin.no_file_selected')}}</span>
                                        <span class="action" style="user-select: none;">
                                            <i class="fa fa-plus-square fa-3x icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="{{\App\Entities\Key::SUPPORT}}">{{trans('admin.'.\App\Entities\Key::SUPPORT)}}</label>
                            <input required type="number" id="{{\App\Entities\Key::SUPPORT}}"
                                   name="{{\App\Entities\Key::SUPPORT}}" class="form-control"
                                   @if(isset($support) && $support) value="{{$support->value}}" @endif
                                   placeholder="{{trans('admin.'.\App\Entities\Key::SUPPORT)}}">
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

            previewImage($('#general-form input[name=video]'));

            previewImage($('#general-form input[name=loyality_image]'));
            previewImage($('#general-form input[name=service_image]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/setting/save')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
