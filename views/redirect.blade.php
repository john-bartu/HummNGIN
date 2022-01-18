<?php
/** @noinspection PhpUnusedAliasInspection */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="2;url='<?=$redirect['url']?>'"/>
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
    <script src="/js/main.js" defer></script>
</head>
<body>
<div class="page">
    <header>

    </header>
    <main class="content">

        <div class="error-box">
            <h1 class="error-title">Error <?= $redirect['code'] ?></h1>
            <p class="error-content"><?= $redirect['reason'] ?></p>
            <p>Redirecting to: <code><?=$redirect['url']?></code></p>
        </div>

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




