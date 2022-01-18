<?php
?>
@extends('template-box')

@include('admin-navigation')

@section('article')

    <div class="page-admin-edit">
        <form class="form-admin" id="form-admin" action="{{$api_url}}" method="{{$method}}">


            @foreach($form as $name => $formEntry)

                <div class="form-field">

                    <?php $value = $formEntry['value'] ?? ""; ?>
                    @if($name != "id")
                        <label>{{$name}}

                            @if($formEntry['type'] == HummNGIN\Util\Forms\Form::FieldNumber)
                                <input name="{{$name}}" type="number" class="form-input" value="{{$value}}">

                            @elseif($formEntry['type'] == HummNGIN\Util\Forms\Form::FieldText)

                                <input name="{{$name}}" type="text" class="form-input" value="{{$value}}">

                            @elseif($formEntry['type'] == HummNGIN\Util\Forms\Form::FieldTextArea)

                                <textarea rows="12" name="{{$name}}" class="form-input">{{$value}}</textarea>

                            @else

                                Unsupported Field {{$name}} with type {{$formEntry['type']}}

                            @endif

                        </label>
                    @else
                        <label>{{$name}}: {{$value}}
                            <input name="{{$name}}" type="number" class="form-input" value="{{$value}}" readonly
                                   hidden>
                        </label>
                    @endif
                </div>

            @endforeach

            <div class="form-field">
                <button class="form-input" type="submit">Potwierdz</button>
            </div>
        </form>


    </div>
@endsection