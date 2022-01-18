<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@section('article')

    <h1>Strony</h1>

    <div class="page-list">
        @foreach($pages as $document)
            <a href="<?=Kernel::generateUrl("page-show", ["id" => $document->get('id')])?>">
                    <div class="page-item">
                        <h2><i></i>{{$document->get('name')}}</h2>
                    </div>
            </a>
        @endforeach

    </div>

@endsection