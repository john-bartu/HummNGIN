<?php

namespace HummNGIN\Guard;

use HummNGIN\Core\Http\RedirectResponse;

interface IGuard
{
    public static function Auth();

    public static function UnauthorizedResponse(): RedirectResponse;

}