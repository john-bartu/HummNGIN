<?php if (!isset($error_object)) $error_object = new Error("Message not provided", -1); ?>

@extends('template')

@section('body')

    <div class="error-box">
        <h1 class="error-title">Error <?= $error_object->getCode() ?></h1>
        <p class="error-content"><?= $error_object->getMessage() ?></p>

    </div>

@endsection