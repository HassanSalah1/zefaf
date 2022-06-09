@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <input type="hidden" name="id" value="{{$article->id}}">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="title_ar">{{trans('admin.title_arabic')}}</label>
                            <input required type="text" id="title_ar" name="title_ar"
                                   class="form-control" value="{{$article->title_ar}}"
                                   placeholder="{{trans('admin.title_arabic')}}">
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="title_en">{{trans('admin.title_english')}}</label>
                            <input required type="text" id="title_en" name="title_en"
                                   class="form-control" value="{{$article->title_en}}"
                                   placeholder="{{trans('admin.title_english')}}">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image">{{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if($article->image !== null)
                                       href="{{url($article->image)}}"
                                       @else
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @endif data-popup="lightbox">
                                        <img id="preview" @if($article->image !== null)
                                        src="{{url($article->image)}}"
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
                                   for="short_description_ar">{{trans('admin.short_description_arabic')}}</label>
                            <textarea required id="short_description_ar" name="short_description_ar"
                                      class="form-control "
                                      placeholder="{{trans('admin.short_description_arabic')}}">{{$article->short_description_ar}}</textarea>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="short_description_en">{{trans('admin.short_description_english')}}</label>
                            <textarea required id="short_description_en" name="short_description_en"
                                      class="form-control"
                                      placeholder="{{trans('admin.short_description_english')}}">{{$article->short_description_en}}</textarea>
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description_ar">
                                    {{trans('admin.description_ar')}}
                                </label>
                                <textarea class="form-control textarea" id="description_ar"
                                          name="description_ar">{{$article->description_ar}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description_en">
                                    {{trans('admin.description_en')}}
                                </label>
                                <textarea class="form-control textarea" id="description_en"
                                          name="description_en">{{$article->description_en}}</textarea>
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
    <script src="{{url('/dashboard/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script src="{{url('/dashboard/js/fancybox.min.js')}}"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            setInterval(function () {
                $('.mce-notification-inner').css('display', 'none');
                $('#mceu_90').css('display', 'none');
                $('#mceu_91').css('display', 'none');
                $('#mceu_92').css('display', 'none');
                $('#mceu_93').css('display', 'none');
                $('#mceu_94').css('display', 'none');
                $('#mceu_46').css('display', 'none');
                $('#mceu_45').css('display', 'none');
            }, 1000);

            if ($("textarea").length > 0) {
                tinymce.init({
                    selector: ".textarea",
                    theme: "modern",
                    height: 300,
                    relative_urls: false,
                    remove_script_host: false,
                    plugins: [
                        "advlist autolink link image imagetools lists charmap  print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor media"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ],
                    images_upload_handler: function (blobInfo, success, failure) {
                        var xhr, formData;
                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = false;
                        xhr.open('POST', '{{url( (($locale === 'ar') ? $locale : '') . '/upload/image')}}');
                        var token = '{{ csrf_token() }}';
                        xhr.setRequestHeader("X-CSRF-Token", token);
                        xhr.onload = function () {
                            var json;
                            if (xhr.status != 200) {
                                failure('HTTP Error: ' + xhr.status);
                                return;
                            }
                            json = JSON.parse(xhr.responseText);

                            if (!json || typeof json.location != 'string') {
                                failure('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                            success(json.location);
                        };
                        formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        xhr.send(formData);
                    },
                });
            }

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            previewImage($('#general-form input[name=image]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/article/edit')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('/articles')}}'
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
