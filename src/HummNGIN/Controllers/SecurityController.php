<?php

namespace HummNGIN\Controllers;

use JetBrains\PhpStorm\Pure;
use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;
use HummNGIN\Core\Http\Response;
use HummNGIN\Repository\UserRepository;

class SecurityController extends AppController
{

    private UserRepository $userRepository;

    #[Pure] public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login(): int|Response|null
    {

        if (Auth::check()) {
            return new RedirectResponse("/");
        }

        if (!$this->isPost()) {
            return $this->render_layout('login');
        }

        $email = $_POST['email'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render_layout('login', ['messages' => ['Użytkownik nie został znaleziony']]);
        }

        if (!password_verify($_POST['password'], $user->getPassword())) {
            return $this->render_layout('login', ['messages' => ['Wprowadzono nieprawidłowe hasło!']]);
        }

        Auth::login($user);
        return new RedirectResponse("/");
    }

    public function logout(): ?Response
    {
        Auth::logout();
        return $this->render_layout('login', ['messages' => ['Wylogowano!']]);
    }

    public function register()
    {

        if (Auth::check()) {
            return new RedirectResponse("/");
        }

        if (!$this->isPost()) {
            return $this->render_layout('register');
        }

        $email = $_POST['email'];
        $nickName = $_POST['name'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if ($user) {
            return $this->render_layout('login', ['messages' => ['Użytkownik o podanym adresie e-mail już istnieje, spróbuj się zalogować, lub zresetuj hasło jeżeli ten adres należy do Ciebie.']]);
        }

        $this->userRepository->addUser($nickName, $email, password_hash($password, PASSWORD_DEFAULT));

        return $this->render_layout('login',
            ['messages' => ['Konto zostało utworzone.', 'Możesz się teraz zalogować przy użyciu wprowadzonych danych.']]
        );
    }
}