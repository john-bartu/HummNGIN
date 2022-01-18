<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@include('admin-navigation')

@section('article')

    <h1>Strony</h1>

    <div class="page-list">
        @foreach($pages as $document)
            <div class="page-box">
                <a href="<?=Kernel::generateUrl("admin-page-edit", ["id" => $document->get('id')])?>">
                    <div class="page-item">
                        <h2><i></i>{{$document->get('name')}}</h2>

                    </div>
                </a>
                <button class="button-default page-item" onclick="DeleteAdminAction('{{$url}}', {{$document->get('id')}})">
                    Delete
                </button>
            </div>
        @endforeach

    </div>

@endsection