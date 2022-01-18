<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@include('admin-navigation')

@section('article')

    <h1>Strony</h1>

    @foreach($pages as $document)
        <a href="<?=Kernel::generateUrl("admin-page-edit", ["id" => $document->get('id')])?>">
            <div class="knowledge-box">
                <h2><i></i>{{$document->get('name')}}</h2>
            </div>
        </a>
    @endforeach


@endsection