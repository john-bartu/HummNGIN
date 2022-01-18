<?php

namespace HummNGIN\Core;

use HummNGIN\Models\User;

class Auth
{

    public static function login(User $user)
    {
        Session::set('user', $user);
        Session::set('user_logged_at', time());
    }

    public static function logout()
    {
        Session::Regenerate();
    }

    public static function user(): User
    {
        return Session::get('user');
    }


    public static function id(): int
    {
        if (self::check()) {
            /** @var User $user */
            $user = Session::get('user');
            return $user->getId();
        } else {
            return -1;
        }
    }

    public static function check(): bool
    {
        if (Session::has('user') && Session::has('user_logged_at')) {
            return Session::get('user_logged_at') + 7200 > time(); // two hours
        } else {
            return false;
        }
    }


    public static function getLoginTime()
    {
        if (self::check()) {
            return Session::get('user_logged_at');
        } else {
            return -1;
        }
    }

    public static function getName()
    {
        if (self::check()) {
            /** @var User $user */
            $user = Session::get('user');
            return $user->getName();
        } else {
            return -1;
        }
    }
}