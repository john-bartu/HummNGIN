<?php

namespace HummNGIN\Util;

use Exception;
use PDO;
use HummNGIN\Core\Auth;
use HummNGIN\Core\Database;
use HummNGIN\Core\Session;

class Debug
{
    private static array $debug = [];
    private static bool $isDebugging = false;

    public static function DebugStart()
    {
        self::$isDebugging = true;
    }

    public static function GetDebug(): array
    {
        self::Additional();
        Debug::Debug("response_time", microtime(true));

        $end_time = self::$debug["response_time"];
        $start_time = self::$debug["request_time"];

        unset(self::$debug["response_time"]);
        unset(self::$debug["request_time"]);

        self::Debug("Response Time", floor(($end_time - $start_time) * 1000) . "ms");

        try {
            $status = (new Database())->connect()->getAttribute(PDO::ATTR_CONNECTION_STATUS);
            self::Debug("DB Status", $status);
        } catch (Exception $e) {
            self::Debug("DB Status", $e->getMessage());
        }

        return self::$debug;
    }

    private static function Additional()
    {
        if (Session::isStarted()) {
            self::Debug("Session", "Started");
            self::Debug("Logged In", Auth::check() ? "[" . Auth::id() . "] " . Auth::user()->getName() : "No");
            self::Debug("Logged At", Auth::check() ? date('H:i:s, d-m-Y', Auth::getLoginTime()) : "No");
            self::Debug("SessionData", json_encode(Session::getContent()));
            self::Debug("Server Time", date('H:i:s, d-m-Y'));
        } else {
            self::Debug("Session", "Not Started");
        }
    }

    public static function Debug($key, $value)
    {
        if (self::isDebugMode())
            Debug::$debug[$key] = $value;
    }

    public static function Database($value)
    {
        if (self::isDebugMode())
            Debug::$debug['db'][] = $value;
    }

    public static function isDebugMode(): bool
    {
        return self::$isDebugging;
    }

    public static function DebugMode(bool $debug)
    {
        self::$isDebugging = $debug;
    }

}