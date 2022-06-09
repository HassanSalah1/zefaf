@extends("general.email.template")

@section('subject')
    {{trans('admin.forget_password_subject')}}
@stop
@section('title')
    <h1> <span style="color:#C39A6B;text-align: center">{{trans('admin.forget_password_subject')}}</span></h1>
    <h4> {{str_replace('{username}' , $data['user']->name , trans('admin.hello_user'))}}</h4>

@stop


@section('message')
    {!! str_replace(
    [
        '{code}',
    ] ,
     [
         $data['code']
     ] ,
      trans('admin.forget_password_message')) !!}
@stop
