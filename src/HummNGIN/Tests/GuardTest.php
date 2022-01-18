<?php

namespace HummNGIN\Tests;

use PHPUnit\Framework\TestCase;
use HummNGIN\Core\Auth;
use HummNGIN\Core\Session;
use HummNGIN\Guard\AdminGuard;
use HummNGIN\Guard\AuthGuard;
use HummNGIN\Guard\Role;
use HummNGIN\Models\User;

class GuardTest extends TestCase
{
    /**
     * @test
     * @runInSeparateProcess
     */
    public function userShouldPassAuthGuard(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", Role::USER));
        $this->assertEquals(true, AuthGuard::hasAccess());
        Session::Regenerate();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function adminShouldPassAuthGuard(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", Role::ADMIN));
        $this->assertEquals(true, AuthGuard::hasAccess());
        Session::Regenerate();
    }


    /**
     * @test
     * @runInSeparateProcess
     */
    public function userShouldNotPassAdminGuard(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", Role::USER));
        $this->assertEquals(false, AdminGuard::hasAccess());
        Session::Regenerate();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function adminShouldPassAdminGuard(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", Role::ADMIN));
        $this->assertEquals(true, AdminGuard::hasAccess());
        Session::Regenerate();
    }
}
