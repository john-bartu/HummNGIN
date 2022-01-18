@extends('template-box')

@section('body')

    <div class="heading-logo">
        <img src="/logo.png" alt="HummNGIN Logo">
    </div>

    <div class="page-login">
        <h1>Rejestracja</h1>

        <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo " <div class='message'>" . $message . "</div>";
            }
        }
        ?>

        <form class="form-login" action="/register" method="POST" onSubmit="return(validateRegister());" name="register_form" id="message_holder">
            <div class="form-field">
                <label>Adres E-mail:
                    <input class="form-input" name="email" type="text"
                           placeholder="Wpisz swój email np.: email@domena.pl" required>
                </label>
            </div>
            <div class="form-field">
                <label>Pseudonim
                    <input class="form-input" name="name" type="text" placeholder="Twój pseudonim np.: PilnyUczen"
                           required>
                </label>
            </div>
            <div class="form-field">
                <label>Hasło:
                    <input class="form-input" name="password" type="password" placeholder="Wymyśl np.: 'twoje_haslo'"
                           required>
                </label>
            </div>
            <div class="form-field">
                <label>Powtórz hasło:
                    <input class="form-input" name="confirmedPassword" type="password"
                           placeholder="Powtórz np.: 'twoje_haslo'" required>
                </label>
            </div>
            <div class="form-field">
                <button class="form-input" type="submit">Zarejestruj</button>
            </div>

            <div class="form-field" style="margin-top: 16px;">
                <a href="/login" class="form-field">
                    <span class="form-input">Mam już konto</span>
                </a>
            </div>
        </form>
    </div>
@endsection