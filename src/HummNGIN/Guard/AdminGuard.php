<?php

namespace HummNGIN\Guard;


use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;

class AdminGuard extends AuthGuard
{
    public static function Auth(): bool
    {

        if(!parent::Auth()){
            return false;
        }

        return Auth::user()->getRole() == Role::ADMIN;
    }

    public static function UnauthorizedResponse(): RedirectResponse
    {
        return new RedirectResponse("/");
    }
}