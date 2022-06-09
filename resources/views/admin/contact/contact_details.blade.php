@extends('admin.layers.partials.master')


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>{{trans('admin.name')}}</th>
                            <td>
                                {{$contact->name}}
                            </td>
                        </tr>

                        <tr>
                            <th>{{trans('admin.email')}}</th>
                            <td>
                                {{$contact->email}}
                            </td>
                        </tr>

                        <tr>
                            <th>{{trans('admin.title')}}</th>
                            <td>{{$contact->subject}}</td>
                        </tr>

                        <tr>
                            <th>{{trans('admin.message')}}</th>
                            <td>{{$contact->message}}</td>
                        </tr>

                        <tr>
                            <th>{{trans('admin.message_delivery_date')}}</th>
                            <td>{{$contact->receive_date}}</td>
                        </tr>

                        @if($contact->seen === 0)
                            <tr>
                                <td>
                                    <button id="add_btn" type="button"
                                            class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                                        <i class="fa fa-reply"></i> {{trans('admin.send_message')}}
                                    </button>
                                </td>
                                <td></td>
                            </tr>
                            <tr>

                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <div id="form" style="display: none" class="col-md-12">
            <form id="replay-form">
                <div class="row">
                    <div class="form-group col-md-12">
                      <textarea name="message" class="form-control"
                                placeholder="{{trans('admin.message')}}"></textarea>
                    </div> <!-- form-group -->
                </div>
                <input type="hidden" name="id" value="{{$contact->id}}"/>
                <button type="submit"
                        class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-5 btn-left">
                    {{trans('admin.send')}}
                </button>
            </form>
        </div>
    </div>

@stop

@if($contact->seen === 0)
@section('script')
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.loader.js')}}"></script>
    <script>
        var edit = false;
        var add = true;
        var pub_id;
        var csrf_token = '{{csrf_token()}}';
    </script>
    <script src="{{url('/dashboard/js/general/utils.js')}}"></script>
    <script>

        $(function () {


            var toggle = false;

            $('#add_btn').on('click', function (e) {
                e.preventDefault();
                if (!toggle) {
                    $('#form').css('display', 'block');
                    toggle = true;
                } else {
                    $('#form').css('display', 'none');
                    toggle = false;
                }
            });

            $('#replay-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '{{url( (($locale === 'ar') ? $locale : '') . '/contact/replay')}}', {
                    error_message: '{{trans('admin.error_message')}}',
                    error_title: '{{trans('admin.error_title')}}',
                    loader: true,
                    load_page: '{{url('/contact/details/'.$contact->id)}}'
                });
            });


        });

    </script>

@stop

@section('style')
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/jquery.loader.css')}}" rel="stylesheet"/>
@stop
@endif
