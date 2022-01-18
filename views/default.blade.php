<?php
use HummNGIN\Core\Kernel;
?>
@extends('template-box')

@section('article')

    <h1>Home Page</h1>
    <p>
        Curabitur eu dictum lorem. Morbi aliquet, nulla aliquam consectetur hendrerit, urna felis auctor dolor, a
        lacinia nunc erat id augue. Ut aliquam quam vel tellus dictum venenatis. Praesent eget velit tincidunt arcu
        volutpat commodo et et leo. Praesent in euismod arcu. Ut in venenatis diam. Morbi maximus lectus non nunc
        placerat dapibus. Nullam faucibus tempus ipsum, in pretium metus placerat ac. Donec leo sapien, viverra ac leo
        vitae, volutpat consequat ex. Phasellus lobortis vehicula massa vel cursus. Cras pulvinar dui et elit varius, et
        pulvinar elit eleifend. Curabitur dignissim semper lacus. Nam vel mi metus. Cras aliquet urna purus, non rutrum
        sapien mollis quis.
    </p>

    <h2>Last pages</h2>
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
