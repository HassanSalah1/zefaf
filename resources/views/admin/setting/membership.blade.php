@extends('admin.layers.partials.master')

@section('form_inputs')

    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label"
                   for="type">{{trans('admin.type')}}</label>
            <select required id="type" class="form-control" name="type">
                @foreach(\App\Entities\MembershipType::getKeys() as $type)
                    <option value="{{$type}}">{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button type="button" onclick="addNewFeature()"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_feature')}}
                </button>
            </div>
        </div>
    </div>

    <div id="features">

    </div>

    <br>

    <div class="row" id="price-div">
        <div class="form-group col-sm-12">
            <label class="control-label"
                   for="image">{{trans('admin.image')}}</label>
            <div class="media no-margin-top">
                <div class="media-left">
                    <a href="{{url('/dashboard/images/placeholder.jpg')}}" data-popup="lightbox">
                        <img id="preview" src="{{url('/dashboard/images/placeholder.jpg')}}"
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
                   for="price">{{trans('admin.price')}}</label>
            <input type="number" id="price" name="price"
                   class="form-control"
                   placeholder="{{trans('admin.price')}}">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="discount">{{trans('admin.discount')}}</label>
            <input type="number" id="discount" name="discount"
                   class="form-control"
                   placeholder="{{trans('admin.discount')}}">
        </div> <!-- form-group -->
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="duration">{{trans('admin.duration')}}</label>
            <input type="number" id="duration" name="duration"
                   class="form-control"
                   placeholder="{{trans('admin.duration')}}">
        </div> <!-- form-group -->
    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> {{trans('admin.add_membership')}}
                </button>
            </div>
        </div>
    </div>
    {{-- end row--}}

    @include('admin.layers.partials.table')
    @include('admin.layers.partials.modal')
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
        let defaultlogo = '{{url('/dashboard/logos/placeholder.jpg')}}';
        let features = 0;
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>


        $(function () {

            $('#type').select2();
            $('#duration-div').hide();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            previewImage($('#general-form input[name=image]'));

            $('#add_btn').on('click', function (e) {
                e.preventDefault();
                $('.modal-title').text('{{trans('admin.add_membership')}}');
                resetForm($('#general-form'));
                $('#type').select2('val', $('#type > option:first-child').val());
                $('#type').trigger('change');
                $('#features').html('');
                features = 0;
                add = true;
                edit = false;
            });

            onClose();

            $('#type').on('change', function (e) {
                let type = $(this).find('option:selected').val();
                if (type === '{{\App\Entities\MembershipType::FREE}}') {
                    $('#price-div').hide();
                    $('#duration-div').show();
                } else {
                    $('#price-div').show();
                    $('#duration-div').hide();
                }
            });

            loadDataTables('{{ url( (($locale === 'ar') ? $locale : '') ."/memberships/data") }}',
                ['image', 'features', 'price', 'discount', 'actions'], '',
                {
                    'show': '{{trans('admin.show')}}',
                    'first': '{{trans('admin.first')}}',
                    'last': '{{trans('admin.last')}}',
                    'filter': '{{trans('admin.filter')}}',
                    'filter_type': '{{trans('admin.type_filter')}}',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/membership/add')}}',
                    '{{url( (($locale === 'ar') ? $locale : '') . '/membership/edit')}}', {
                        error_message: '{{trans('admin.general_error_message')}}',
                        error_title: '{{trans('admin.error_title')}}',
                        loader: true,
                    });
            });
        });


        function addNewFeature(feature_ar = null, feature_en = null) {
            let html = '<div id="feature_' + features + '" class="row">' +
                '<div class="form-group col-md-4">' +
                '<input type="text" name="features_ar[]" class="form-control"' +
                'placeholder="{{trans('admin.features_ar')}} ' + (features + 1) + '" ' +
                ((feature_ar !== null) ? 'value="' + feature_ar + '"' : '') + ' />' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<input type="text" name="features_en[]" class="form-control"' +
                'placeholder="{{trans('admin.features_en')}} ' + (features + 1) + '" ' +
                ((feature_en !== null) ? 'value="' + feature_en + '"' : '') + ' />' +
                '</div>' +
                '<div class="form-group col-md-3">' +
                '<button type="button" onclick="deleteFeature(' + features + ')"' +
                'class="btn btn-danger btn-rounded waves-effect waves-light m-b-5">' +
                '<i class="fa fa-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>';
            $('#features').append(html);
            features++;
        }


        function deleteFeature(featureIndex) {
            $('#feature_' + featureIndex).remove();
            features--;
            // deletedSizes++;
        }

        function editMembership(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('{{trans('admin.edit_membership')}}');
            pub_id = id;
            $.ajax({
                url: '{{url( (($locale === 'ar') ? $locale : '') . '/membership/data')}}',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#type').select2('val', response.data.type);
                    $('#type').trigger('change');

                    $('#features').html('');
                    features = 0;
                    response.data.features_ar.forEach((feature, row) => {
                        addNewFeature(feature, response.data.features_en[row]);
                    });

                    $('#general-form input[name=discount]').val(response.data.discount);
                    $('#general-form input[name=price]').val(response.data.price);
                    $('#general-form input[name=duration]').val(response.data.duration);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('{{trans('admin.general_error_message')}}', '{{trans('admin.error_title')}}');
                }
            });

        }

        function blockMembership(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/membership/change')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.inactive_action')}}",
                ban_message: "{{trans('admin.inactive_message')}}",
                inactivate: "{{trans('admin.inactive_action')}}",
                cancel: "{{trans('admin.cancel')}}",
            });
        }

        function activeMembership(item) {
            ban(item, '{{url( (($locale === 'ar') ? $locale : '') . '/membership/change')}}', {
                error_message: '{{trans('admin.general_error_message')}}',
                error_title: '{{trans('admin.error_title')}}',
                ban_title: "{{trans('admin.active_action')}}",
                ban_message: "{{trans('admin.active_message')}}",
                inactivate: "{{trans('admin.active_action')}}",
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
