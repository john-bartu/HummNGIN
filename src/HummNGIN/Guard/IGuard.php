<?php

namespace HummNGIN\Guard;

use HummNGIN\Core\Http\RedirectResponse;

interface IGuard
{
    /**
     * Returns if user has access to bypass this guard
     * @return bool
     */
    public static function hasAccess(): bool;

    /**
     * Default redirect response which can be used if user has no access
     * @return RedirectResponse
     */
    public static function noAccessResponse(): RedirectResponse;

}
