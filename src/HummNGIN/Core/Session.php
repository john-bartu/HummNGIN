<?php

namespace HummNGIN\Core;


class Session
{
    public static function get(string $key, $default_value = null)
    {
        self::ensureSessionStarted();
        return $_SESSION[$key] ?? $default_value;
    }

    private static function ensureSessionStarted()
    {
        if (!self::isStarted()) {
            throw new \Exception("Session not started");
        }
    }

    public static function isStarted(): bool
    {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    public static function start()
    {
        ini_set('session.use_strict_mode', 1);
        session_start();
        if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
            session_destroy();
            session_start();
        }
    }

    public static function set(string $key, $value)
    {
        self::ensureSessionStarted();
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        self::ensureSessionStarted();
        return array_key_exists($key, $_SESSION);
    }

    public static function remove(string $key)
    {
        self::ensureSessionStarted();
        unset($_SESSION[$key]);
    }

    public static function count(): int
    {
        self::ensureSessionStarted();
        return count($_SESSION);
    }

    public static function getContent(): array
    {
        self::ensureSessionStarted();
        return $_SESSION;
    }

    public static function Regenerate()
    {

        // Call session_create_id() while session is active to
        // make sure collision free.
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        // WARNING: Never use confidential strings for prefix!
        $newid = session_create_id('myprefix-');
        // Set deleted timestamp. Session data must not be deleted immediately for reasons.
        $_SESSION['deleted_time'] = time();
        // Finish session
        session_commit();
        // Make sure to accept user defined session ID
        // NOTE: You must enable use_strict_mode for normal operations.
        ini_set('session.use_strict_mode', 0);
        // Set new custom session ID
        session_id($newid);
        // Start with custom session ID
        session_start();

    }
}