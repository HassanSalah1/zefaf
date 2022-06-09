@extends("general/email/template")

@section('subject')
    {{trans('email.account_verification_subject')}}
@stop
@section('title')
    <h1> <span style="color:#00cccc;text-align: center">{{trans('email.account_verification_subject')}}</span></h1>
    <h41> {{str_replace('{username}' , $data['user']->username , trans('email.hello_user'))}}</h41>

@stop


@section('message')
    {!! str_replace(
    [
        '{code}',
        '{expire}'
    ] ,
     [
        '<b style="color:#00cccc;">'.$data['verificationCode']->code.'</b>',
        $data['verificationCode']->expire
     ] ,
      trans('email.account_verification_message')) !!}
@stop