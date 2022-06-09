@extends('admin.layers.partials.master')



@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <input type="hidden" name="id" value="{{$pharmacy->id}}">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name">{{trans('admin.name_arabic')}}</label>
                            <input required type="text" id="name_ar" name="name_ar"
                                   class="form-control" value="{{$pharmacy->name_ar}}"
                                   placeholder="{{trans('admin.name_arabic')}}">
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name">{{trans('admin.name_english')}}</label>
                            <input required type="text" id="name_en" name="name_en"
                                   class="form-control" value="{{$pharmacy->name_en}}"
                                   placeholder="{{trans('admin.name_english')}}">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="government_id">{{trans('admin.government_name')}}</label>
                            <select required id="government_id" class="form-control" name="government_id">
                                @foreach($governments as $government)
                                    <option value="{{$government->id}}">{{$government->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="city_id">{{trans('admin.area_name')}}</label>
                            <select required id="city_id" class="form-control" name="city_id">
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="logo">{{trans('admin.logo')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if($pharmacy->logo !== null)
                                       href="{{url($pharmacy->logo)}}"
                                       @else
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @endif data-popup="lightbox">
                                        <img id="preview" @if($pharmacy->logo !== null)
                                        src="{{url($pharmacy->logo)}}"
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
                                        <input type="file" class="file-styled form-data ui-wizard-content" id="logo"
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

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image">{{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if($pharmacy->image !== null)
                                       href="{{url($pharmacy->image)}}"
                                       @else
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @endif data-popup="lightbox">
                                        <img id="preview" @if($pharmacy->image !== null)
                                        src="{{url($pharmacy->image)}}"
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

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="phone">{{trans('admin.phone')}}</label>
                            <input required type="number" id="phone" name="phone"
                                   class="form-control" value="{{$pharmacy->phone}}"
                                   placeholder="{{trans('admin.phone')}}">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="latitude">{{trans('admin.latitude')}}</label>
                                <input type="text" class="form-control" id="latitude"
                                       value="{{$pharmacy->lat}}" name="latitude" readonly/>
                            </div> <!-- form-group -->
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="latitude">{{trans('admin.longitude')}}</label>
                                <input type="text" class="form-control" id="longitude"
                                       value="{{$pharmacy->long}}" name="longitude" readonly/>
                            </div> <!-- form-group -->
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="map" style="height:700px"></div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="short_description_ar">{{trans('admin.short_description_arabic')}}</label>
                            <textarea required id="short_description_ar" name="short_description_ar"
                                      class="form-control "
                                      placeholder="{{trans('admin.short_description_arabic')}}">{{$pharmacy->short_description_ar}}</textarea>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="short_description_en">{{trans('admin.short_description_english')}}</label>
                            <textarea required id="short_description_en" name="short_description_en"
                                      class="form-control"
                                      placeholder="{{trans('admin.short_description_english')}}">{{$pharmacy->short_description_en}}</textarea>
                        </div> <!-- form-group -->
                    </div>


                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description_ar">
                                    {{trans('admin.description_ar')}}
                                </label>
                                <textarea class="form-control textarea" id="description_ar"
                                          name="description_ar">{{$pharmacy->description_ar}}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description_en">
                                    {{trans('admin.description_en')}}
                                </label>
                                <textarea class="form-control textarea" id="description_en"
                                          name="description_en">{{$pharmacy->description_en}}</textarea>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Day</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- 1 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Saturday"/></td>
                                    <td>Saturday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 2 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Sunday"/></td>
                                    <td>Sunday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 3 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Monday"/></td>
                                    <td>Monday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 4 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Tuesday"/></td>
                                    <td>Tuesday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 5 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Wednesday"/></td>
                                    <td>Wednesday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 6 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Thursday"/></td>
                                    <td>Thursday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                {{-- 7 --}}
                                <tr>
                                    <td><input type="checkbox" name="workDays[]" value="Friday"/></td>
                                    <td>Friday</td>
                                    <td><input type="time" name="fromTimes[]" placeholder="from"/></td>
                                    <td><input type="time" name="toTimes[]" placeholder="to"/></td>
                                </tr>
                                </tbody>
                            </table>
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
    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyDhoc3Xe0kB2rp77fI1lLLm6MH3I4UDdQw"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
        let defaultlogo = '{{url('/dashboard/logos/placeholder.jpg')}}';
    </script>
    <script>
            @if($pharmacy->lat !== null)
        var editLatLng = new google.maps.LatLng(parseFloat('{{$pharmacy->lat}}'), parseFloat('{{$pharmacy->long}}'));
        @endif
    </script>
    <script src="{{url('/dashboard/js/map.js')}}"></script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {

            $('#government_id').select2();
            $('#city_id').select2();

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

            previewImage($('#general-form input[name=logo]'));
            previewImage($('#general-form input[name=image]'));


            $('#government_id').on('change', function (e) {
                let government_id = $(this).find('option:selected').val();
                let form = new FormData();
                form.append('government_id', government_id);
                $.ajax({
                    url: '{{url( (($locale === 'ar') ? $locale : '') . '/get/areas')}}',
                    method: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    success: function (response) {
                        console.log(response);
                        let html = '';
                        response.areas.forEach((area) => {
                            html += '<option value="' + area.id + '">' + area.name + '</option>';
                        });
                        $('#city_id').html(html);
                        $('#city_id').select2();
                    },
                    error: function () {
                        $('#city_id').html('');
                        $('#city_id').select2();
                    }
                });
            });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/pharmacy/edit')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('/pharmacies')}}'
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
