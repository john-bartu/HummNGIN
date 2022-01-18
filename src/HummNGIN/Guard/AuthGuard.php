<?php

namespace HummNGIN\Guard;

use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;

class AuthGuard implements IGuard
{
    public static function hasAccess(): bool
    {
        return Auth::check();
    }

    public static function noAccessResponse(): RedirectResponse
    {
        return new RedirectResponse("/login");
    }
}