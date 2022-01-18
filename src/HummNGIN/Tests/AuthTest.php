<?php

namespace HummNGIN\Tests;

use PHPUnit\Framework\TestCase;
use HummNGIN\Core\Auth;
use HummNGIN\Core\Session;
use HummNGIN\Guard\Role;
use HummNGIN\Models\User;

class AuthTest extends TestCase
{

    /**
     * @test
     * @runInSeparateProcess
     */
    public function beforeLoginAuthFalse(): void
    {
        Session::start();
        $this->assertEquals(false, Auth::check());
        Session::Regenerate();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function afterLoginShouldAuthTrue(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", 0));
        $this->assertEquals(true, Auth::check());
        Session::Regenerate();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function logoutAfterLoginAuthFalse(): void
    {
        Session::start();
        Auth::login(new User(0, "test@domain.pl", "pass", "test", Role::USER));
        Auth::logout();
        $this->assertEquals(false, Auth::check());
        Session::Regenerate();
    }


}
