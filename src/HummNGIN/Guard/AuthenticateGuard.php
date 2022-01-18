<?php

namespace HummNGIN\Guard;

use HummNGIN\Core\Auth;
use HummNGIN\Core\Http\RedirectResponse;
use HummNGIN\Core\Http\Response;

class AuthenticateGuard extends AuthGuard
{
    static int $roleId = Role::USER;

    public static final function hasAccess(): bool
    {
        if (!parent::hasAccess()) {
            return false;
        }
        return self::hasUserRole(static::$roleId);
    }

    public static function hasUserRole(int $role): bool
    {
        return Auth::user()->getRole() == $role;
    }

    public static function noAccessResponse(): RedirectResponse
    {
        if (parent::hasAccess())
            return new RedirectResponse("/", Response::HTTP_FORBIDDEN);
        else
            // If not authorized we cannot tell if he is authenticated
            return parent::noAccessResponse();
    }
}