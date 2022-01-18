<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@include('admin-navigation')

@section('article')

    <h1>Pages</h1>
    <div class="page-list">
        @foreach($pages as $document)
            <div class="page-box">
                <h2><i></i>{{$document->get('name')}}</h2>

                <a class="button-default"
                   href="<?=Kernel::generateUrl("admin-page-edit", ["id" => $document->get('id')])?>">
                    Edit
                </a>
                <button class="button-default" onclick="DeleteAdminAction('{{$url}}', {{$document->get('id')}})">
                    Delete
                </button>
            </div>
        @endforeach

    </div>

@endsection