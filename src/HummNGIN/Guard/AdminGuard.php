<?php

namespace HummNGIN\Guard;

class AdminGuard extends AuthenticateGuard
{
    static int $roleId = Role::ADMIN;
}