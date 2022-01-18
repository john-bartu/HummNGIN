<?php
/** @noinspection PhpUnusedAliasInspection */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $tittle ?? "HummNGIN" ?></title>

    <meta name="description"
          content="New website engine">
    <meta name="keywords"
          content="Humming, Webiste, Engine, Jan, Bartula">
    <meta name="author" content="Jan Bartula">

    <link rel="preload" href="/stylesheets/main.css" as="style">
    <link rel="preload" href="/js/main.js" as="script">

    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <link rel="stylesheet" href="/stylesheets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/js/main.js" defer></script>
</head>
<body>

@yield('navigation')

<div class="page">
    <header>
        <div id="nav-hamburger" class="nav-hamburger">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>

        <div class="sep"></div>

        @if (\HummNGIN\Core\Auth::check())
            <div class="nav-menu user-menu last-menu" onclick="activateNavMenu(this)">
                <div class="menu-item">
                    <i class="nav-symbol fas fa-user"></i>
                    {{\HummNGIN\Core\Auth::getName()}}
                </div>
                <div class="sub-menu">
                    <a href="/admin">
                        <div class="sub-menu-item">
                            Dashboard
                        </div>
                    </a>

                    <a href="/logout">
                        <div class="sub-menu-item">
                            Logout
                        </div>
                    </a>
                </div>
            </div>
        @endif

    </header>
    <main class="content">

        @yield('body')

    </main>
    @if(\HummNGIN\Util\Debug::isDebugMode())
        <div class='debug-bar'>
            <div class='container'>
                @foreach(\HummNGIN\Util\Debug::GetDebug() as $key => $value)

                    @if ($key === 'db')

                        @foreach($value as $db)
                            <div class="db_call" onclick="showSqlResult(this)">
                                <span class="1"><b>db</b>: <?=$db['sql']?></span>
                                <div class="data">
                                    <div class="sql"><?=$db['sql']?></div>
                                    <pre><?=$db['response']?></pre>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div><b><?=$key?></b>: <?=$value?></div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <footer>
        <p>HummNGIN <a href="https://bartulacode.pl">BartulaCode.pl</a></p>
    </footer>
</div>


</body>

</html>
