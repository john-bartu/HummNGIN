<?php

namespace HummNGIN\Guard;


use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;

class AdminGuard implements IGuard
{
    public static function Auth(): bool
    {
        return Auth::user()->getRole() == Role::ADMIN;
    }

    public static function UnauthorizedResponse(): RedirectResponse
    {
        return new RedirectResponse("/");
    }
}