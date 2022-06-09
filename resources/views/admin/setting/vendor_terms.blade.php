@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="{{\App\Entities\Key::VENDOR_TERMS_AR}}">
                                    {{trans('admin.' . \App\Entities\Key::VENDOR_TERMS_AR)}}
                                </label>
                                <textarea class="form-control" id="{{\App\Entities\Key::VENDOR_TERMS_AR}}"
                                          name="{{\App\Entities\Key::VENDOR_TERMS_AR}}">@if(isset($terms_ar) && $terms_ar) {{$terms_ar->value}} @endif</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="{{\App\Entities\Key::VENDOR_TERMS_EN}}">
                                    {{trans('admin.' . \App\Entities\Key::VENDOR_TERMS_EN)}}
                                </label>
                                <textarea class="form-control" id="{{\App\Entities\Key::VENDOR_TERMS_EN}}"
                                          name="{{\App\Entities\Key::VENDOR_TERMS_EN}}">@if(isset($terms_en) && $terms_en) {{$terms_en->value}} @endif</textarea>
                            </div>
                        </div>

                    </div>

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
                $('#mceu_46').css('display', 'none');
                $('#mceu_45').css('display', 'none');
            }, 1000);

            if ($("textarea").length > 0) {
                tinymce.init({
                    selector: "textarea",
                    theme: "modern",
                    height: 300,
                    relative_urls: false,
                    remove_script_host: false,
                    plugins: [
                        "advlist autolink link image imagetools lists charmap  print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
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

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/vendor/terms/save')}}',
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
