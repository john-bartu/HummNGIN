<?php
use HummNGIN\Core\Kernel;
?>
@section('navigation')
    <nav id="nav-menu">

        <a href="<?=Kernel::generateUrl("home-page")?>">
            <div class="site-title">
                <img class="logo" src="/logo.png" alt="logo">

                <span class="title-text">HummNGIN</span>

            </div>
        </a>

        <a class="nav-item" href="<?=Kernel::generateUrl("home-page")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Home</p>
        </a>

        <a class="nav-item" href="<?=Kernel::generateUrl("page-index")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Pages</p>
        </a>

    </nav>
@endsection