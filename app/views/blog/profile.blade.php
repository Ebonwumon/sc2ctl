@extends('layout')

@section('title')
{{ $blog->title }}
@stop

@section('content')
@include('blog/post')
@stop
