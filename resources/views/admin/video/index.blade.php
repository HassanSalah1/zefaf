@extends('admin.layers.partials.master')

@section('form_inputs')
    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="title_ar">{{trans('admin.title_arabic')}}</label>
            <input required type="text" id="title_ar" name="title_ar"
                   class="form-control"
                   placeholder="{{trans('admin.title_arabic')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="title_en">{{trans('admin.title_english')}}</label>
            <input required type="text" id="title_en" name="title_en"
                   class="form-control"
                   placeholder="{{trans('admin.title_english')}}">
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="short_description_ar">{{trans('admin.short_description_arabic')}}</label>
            <textarea required id="short_description_ar" name="short_description_ar"
                      class="form-control"
                      placeholder="{{trans('admin.short_description_arabic')}}"></textarea>
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="short_description_en">{{trans('admin.short_description_english')}}</label>
            <textarea required id="short_description_en" name="short_description_en"
                   class="form-control"
                      placeholder="{{trans('admin.short_description_english')}}"></textarea>
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="video">{{trans('admin.video')}}</label>
            <div class="media no-margin-top">
                <div class="media-left">
                </div>

                <div class="media-body">
                    <div class="uploader bg-danger" id="uniform-img">
                        <input type="file" class="file-styled form-data ui-wizard-content" id="video"
                               name="video" accept="video/*">
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
                   for="photo">{{trans('admin.photo')}}</label>
            <div class="media no-margin-top">
                <div class="media-left">
                </div>

                <div class="media-body">
                    <div class="uploader bg-danger" id="uniform-img">
                        <input type="file" class="file-styled form-data ui-wizard-content" id="photo"
                               name="photo" accept="image/*">
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
@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_video')}}
                </button>
            </div>
        </div>
    </div>
    {{-- end row--}}

    @include('admin.layers.partials.table')
    @include('admin.layers.partials.modal')
@stop



@section('script')
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <!-- Datatables-->
    <script src="{{url('/dashboard/js/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('/dashboard/js/sweet-alert.min.js')}}"></script>
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

            addModal({
                title: '{{trans('admin.add_video')}}',
            });
            onClose();

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/videos/data") }}',
                ['title_ar', 'title_en', 'video', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/video/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/video/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function editVideo(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_video')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/video/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#general-form input[name=title_ar]').val(response.data.title_ar);
                    $('#general-form input[name=title_en]').val(response.data.title_en);
                    $('#general-form textarea[name=short_description_ar]').val(response.data.short_description_ar);
                    $('#general-form textarea[name=short_description_en]').val(response.data.short_description_en);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function deleteVideo(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/video/delete')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.delete_action')}}",
                ban_message: "{{trans('admin.delete_message')}}",
                inactivate: "{{trans('admin.delete_action')}}",
                cancel: "{{trans('admin.cancel')}}"
            });
        }

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/sweet-alert.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
