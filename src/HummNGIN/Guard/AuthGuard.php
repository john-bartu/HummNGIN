<?php

namespace HummNGIN\Guard;


use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;
use HummNGIN\Core\Router\Router;

class AuthGuard implements IGuard
{
    public static function Auth(): bool
    {
        return Auth::check();
    }

    public static function UnauthorizedResponse(): RedirectResponse
    {
        return new RedirectResponse("/login");
    }
}