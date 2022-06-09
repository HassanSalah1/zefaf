@extends('admin.layers.partials.master')


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="setting-form">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="name">{{trans('admin.admin_username')}}</label>
                            <input required type="text" id="name" name="name"
                                   class="form-control"
                                   value="@if(isset($user->name)){{$user->name}}@endif"
                                   placeholder="{{trans('admin.admin_username')}}">
                        </div> <!-- form-group -->

                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="email">{{trans('admin.email')}}</label>
                            <input required type="email" id="email" name="email"
                                   class="form-control"
                                   value="@if(isset($user->email)){{$user->email}}@endif"
                                   placeholder="{{trans('admin.email')}}">
                        </div> <!-- form-group -->
                    </div>

                    <hr/>
                    <div class="row">
                        <h4>{{trans('admin.change_admin_password')}}</h4>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="old_password">{{trans('admin.old_password')}}</label>
                            <input type="password" id="old_password" name="old_password"
                                   class="form-control"
                                   placeholder="{{trans('admin.old_password')}}">
                        </div> <!-- form-group -->
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="new_password">{{trans('admin.new_password')}}</label>
                            <input type="password" id="new_password" name="password"
                                   class="form-control"
                                   placeholder="{{trans('admin.new_password')}}">
                        </div> <!-- form-group -->

                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="confirm_password">{{trans('admin.confirm_password')}}</label>
                            <input type="password" id="confirm_password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="{{trans('admin.confirm_password')}}">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="form-group btn-left">
                            <button type="submit"
                                    class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                {{trans('admin.save')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- end col -->
    </div>
    <!-- end row -->
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

            $('#setting-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') .'/profile/update/save')}}', {
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
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet" type="text/css" />
@stop
