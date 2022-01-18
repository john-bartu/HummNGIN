<?php

namespace HummNGIN\Guard;

class AdminGuard extends AuthenticateGuard
{
    public static int $roleId = Role::ADMIN;
}