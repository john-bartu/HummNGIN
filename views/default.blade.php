<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@section('article')

    <h1>Strona Główna</h1>


    <h2>Ostatnie strony</h2>
    <div class="page-list">
        @for($i=0; $i<2 ; $i++)
            <div class="page-box">
                <a href="<?=Kernel::generateUrl("page-show", ["id" => $pages[$i]->get('id')])?>">
                    <h2><i></i>{{$pages[$i]->get('name')}}</h2>
                    {!!$pages[$i]->get('document')!!}
                </a>
            </div>
        @endfor

    </div>

@endsection
