<?php
?>
@extends('template-box')

@include('navigation')

@section('article')

    <h1>{{$page->get('name')}}</h1>
    {!! $page->get('document') !!}

@endsection