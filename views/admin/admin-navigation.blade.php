<?php
use HummNGIN\Core\Kernel;
?>
@section('navigation')
    <nav id="nav-menu">
        <a href="<?=Kernel::generateUrl("home-page")?>">
            <div class="site-title">
                <img class="logo" src="/historia-favicon.png" alt="logo">
                <span class="title-text">HummNGIN</span>
            </div>
        </a>

        <a class="nav-item" href="<?=Kernel::generateUrl("admin-home")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Dashboard</p>
        </a>

        <p class="nav-item header">
            Manage:
        </p>

        <a class="nav-item" href="<?=Kernel::generateUrl("admin-page-list")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Pages</p>
        </a>
        <a class="nav-item" href="<?=Kernel::generateUrl("admin-page-post")?>">
            <span class="nav-item-fold">&nbsp;</span>
            <p class="nav-text">Add Page</p>
        </a>


    </nav>
@endsection