@extends('admin.layers.partials.master')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <div class="row">
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name_ar">{{trans('admin.name_arabic')}}</label>
                            <input required type="text" id="name_ar" name="name_ar"
                                   class="form-control" value="{{$category->name_ar}}"
                                   placeholder="{{trans('admin.name_arabic')}}">
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name_en">{{trans('admin.name_english')}}</label>
                            <input required type="text" id="name_en" name="name_en"
                                   class="form-control" value="{{$category->name_en}}"
                                   placeholder="{{trans('admin.name_english')}}">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image">{{trans('admin.image')}}</label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a @if($category->image === null)
                                       href="{{url('/dashboard/images/placeholder.jpg')}}"
                                       @else
                                       href="{{url($category->image)}}"
                                       @endif
                                       data-popup="lightbox">
                                        <img id="preview"
                                             @if($category->image === null)
                                             src="{{url('/dashboard/images/placeholder.jpg')}}"
                                             @else
                                             src="{{url($category->image)}}"
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

                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="category_id">{{trans('admin.main_category')}}</label>
                            <select id="category_id" class="form-control"
                                    data-placeholder="{{trans('admin.main_category')}}" name="category_id">
                                <option value="">none</option>
                                @foreach($categories as $categoryObj)
                                    <option @if($category->category_id === $categoryObj->id) selected @endif
                                    value="{{$categoryObj->id}}">{{$categoryObj->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row" id="question_type_div" @if ($category->category_id === null)
                        style="display: none;"
                    @endif>
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="question_type">Question</label>
                            <select id="question_type" class="form-control" name="question_type">
                                @foreach(\App\Entities\CategoryQuestionType::getKeys() as $questionType)
                                    <option @if($category->question_type === $questionType) selected @endif
                                    value="{{$questionType}}">{{trans('admin.'. $questionType)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <button type="button" onclick="addNewTip()"
                                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                                    <i class="fa fa-plus-square"></i> {{trans('admin.add_tip')}}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="tips">
                        @foreach($tips as $key => $tip)
                            <div id="tip_{{$key}}" class="row">
                                <div class="form-group col-md-4">
                                    <input type="text" name="tips_en[]" class="form-control"
                                           @if(isset($tip['en'])) value="{{$tip['en']}}" @endif
                                           placeholder="{{trans('admin.tip')}} en {{$key}}"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="tips_ar[]" class="form-control"
                                           @if(isset($tip['ar'])) value="{{$tip['ar']}}" @endif
                                           placeholder="{{trans('admin.tip')}} ar {{$key}}"/>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" onclick="deleteTip('{{$key}}')"
                                            class="btn btn-danger btn-rounded waves-effect waves-light m-b-5">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
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
        let tips = parseInt('{{count($tips)}}');
        $(function () {

            $('#category_id').select2();
            $('#question_type').select2();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            $('#category_id').on('change' , () => {
                let category = $(this).find('option:selected').val();
                if(category){
                    $('#question_type_div').show();
                }else{
                    $('#question_type_div').hide();
                }
            });

            previewImage($('#general-form input[name=image]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/category/edit')}}',
                    {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                        load_page: '{{url('/categories')}}'
                    });
            });
        });

        function addNewTip() {
            let html = '<div id="tip_' + tips + '" class="row">' +
                '<div class="form-group col-md-4">' +
                '<input type="text" name="tips_en[]" class="form-control"' +
                'placeholder="{{trans('admin.tip')}} en ' + (tips + 1) + '" />' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<input type="text" name="tips_ar[]" class="form-control"' +
                'placeholder="{{trans('admin.tip')}} ar ' + (tips + 1) + '" />' +
                '</div>' +
                '<div class="form-group col-md-3">' +
                '<button type="button" onclick="deleteTip(' + tips + ')"' +
                'class="btn btn-danger btn-rounded waves-effect waves-light m-b-5">' +
                '<i class="fa fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>';
            $('#tips').append(html);
            tips++;
        }

        function deleteTip(tipIndex) {
            $('#tip_' + tipIndex).remove();
            tips--;
            // deletedSizes++;
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/select2.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/select2-bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
