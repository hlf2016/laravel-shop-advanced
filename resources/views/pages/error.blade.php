@extends('layouts.app')

@section('title', '错误')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body text-center">
            <h1>{{ $msg }}</h1>
            <a class="btn btn-primary" href="{{ route('root') }}" style="margin-top: 50px;">返回首页</a>
        </div>
    </div>
@endsection
