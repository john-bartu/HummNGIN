<?php
use HummNGIN\Core\Kernel;
?>
@section('navigation')
    <nav id="nav-menu">
        <a href="<?=Kernel::generateUrl("admin-home")?>">
            <div class="site-title">
                <img class="logo" src="/historia-favicon.png" alt="logo">
                <span class="title-text">HummNGIN</span>
            </div>
        </a>

        <a class="nav-item" href="<?=Kernel::generateUrl("admin-home")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Panel Administratora</p>
        </a>

        <p class="nav-item header">
            Manadżer:
        </p>

        <a class="nav-item" href="<?=Kernel::generateUrl("admin-page-list")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Lista Stron</p>
        </a>
        <a class="nav-item" href="<?=Kernel::generateUrl("admin-page-post")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Dodaj Stronę</p>
        </a>


    </nav>
@endsection