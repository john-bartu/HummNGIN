@extends('template-box')

@section('body')


    <div class="heading-logo">
        <img src="/logo.png" alt="Powtórki Online Logo">
    </div>

    <div class="page-login">
        <h1>Logowanie</h1>

        <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo " <div class='message'>" . $message . "</div>";
            }
        }
        ?>

        <form class="form-login" action="/login" method="POST">
            <div class="form-field">
                <label>Adres E-mail:
                    <input class="form-input" name="email" type="text" placeholder="email@domena.pl">
                </label>
            </div>
            <div class="form-field">
                <label>Hasło:
                    <input class="form-input" name="password" type="password" placeholder="Twoje hasło">
                </label>
            </div>
            <div class="form-field">
                <button class="form-input" type="submit">Zaloguj</button>
            </div>
            <div class="form-field" style="margin-top: 16px;">
                <a href="/register" class="form-field">
                    <span class="form-input">Utwórz Konto</span>
                </a>
            </div>
        </form>


    </div>
@endsection