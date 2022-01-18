<?php
/** @noinspection PhpUnusedAliasInspection */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $tittle ?? "Tittle not provided" ?></title>
    <link rel="stylesheet" href="/public/stylesheets/main.css">
</head>
<body>
<nav>
    <div class="site-title">
        <img class="logo" src="https://new.powtorkionline.pl/historia-favicon.png" alt="logo">

        <span class="title-text">Powtórki Online</span>
    </div>

    <a class="nav-item" href="/rozdzialy">
        <span class="nav-item-fold color-border-chapter ">&nbsp;</span>
        <span class="nav-text">Lista Rozdziałów</span>
    </a>
    <p class="nav-item nav-item-header items-center nav-symbol">
        <span class="nav-text">Wiedza podstawowa:</span>
    </p>
    <a class="nav-item items-centernav-symbol" href="/1/lekcje">
        <span class="nav-item-fold color-border-lesson ">&nbsp;</span>
        <img src="/public/document.svg" class="nav-symbol" alt="lesson symbol">
        <span class="nav-text">Lekcje</span>
    </a>
    <a class="nav-item items-centernav-symbol" href="/1/lekcje">
        <span class="nav-item-fold color-border-video ">&nbsp;</span>
        <img src="/public/video.svg" class="nav-symbol" alt="video symbol">
        <span class="nav-text">Lekcje Video</span>
    </a>
    <a class="nav-item items-centernav-symbol" href="/1/materialy">
        <span class="nav-item-fold color-border-document ">&nbsp;</span>
        <img src="/public/document.svg" class="nav-symbol" alt="document symbol">
        <span class="nav-text">Materiały do nauki</span>
    </a>

    <a class="nav-item items-centernav-symbol" href="/1/mapy-mysli">
        <span class="nav-item-fold color-border-mind-map ">&nbsp;</span>
        <img src="/public/map.svg" class="nav-symbol" alt="map symbol">
        <span class="nav-text">Mapy myśli</span>
    </a>

    <p class="nav-item nav-item-header items-center nav-symbol">
        <span class="nav-text">Uzupełnienia:</span>
    </p>
    <a class="nav-item items-centernav-symbol" href="/1/postacie">
        <span class="nav-item-fold color-border-character ">&nbsp;</span>
        <img src="/public/character.svg" class="nav-symbol" alt="character symbol">
        <span class="nav-text">Indeksy postaci</span>
    </a>

    <a class="nav-item items-centernav-symbol" href="/1/pojecia">
        <span class="nav-item-fold color-border-dictionary  ">&nbsp;</span>
        <img src="/public/dictionary.svg" class="nav-symbol" alt="dictionary symbol">
        <span class="nav-text">Terminy i pojęcia</span>
    </a>
    <a class="nav-item items-centernav-symbol" href="/1/kalendarium">
        <span class="nav-item-fold color-border-calendar  ">&nbsp;</span>
        <img src="/public/calendar.svg" class="nav-symbol" alt="calendar symbol">
        <span class="nav-text">Kalendarium</span>
    </a>

    <p class="nav-item nav-item-header items-center nav-symbol">
        <span class="nav-text">Sprawdź wiedzę:</span>
    </p>
    <a class="nav-item items-centernav-symbol" href="/1/pytania">
        <span class="nav-item-fold color-border-quiz ">&nbsp;</span>
        <img src="/public/quiz.svg" class="nav-symbol" alt="quiz symbol">
        <span class="nav-text">Quizy</span>
    </a>

    <a class="nav-item  items-centernav-symbol" href="/1/pytania-odpowiedzi">
        <span class="nav-item-fold color-border-qa  ">&nbsp;</span>
        <img src="/public/qa.svg" class="nav-symbol" alt="qa symbol">
        <span class="nav-text">Pytania i odpowiedzi</span>
    </a>
</nav>
<div class="page">
    <header>
        Powtórki Online
    </header>
    <main class="content">


        @yield('body')


    </main>

    <div class='debug-bar'>
        <div class='container'>
            @foreach(Router::GetDebug() as $key => $value)
                <div><b><?=$key?></b>: <?=$value?></div>
            @endforeach
        </div>
    </div>
    <footer>
        <p> Projekt i wykonanie strony: <a href="https://janbartula.pl">JanBartula.pl</a></p>
        <p>Powtórki Online 2022</p>
        <p>Merytoryka: <a href="https://joannabedkowska.pl">JoannaBędkowska.pl</a></p>

    </footer>
</div>


</body>

</html>
