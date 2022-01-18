<?php

namespace HummNGIN\Tests;

use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{

    /**
     * @dataProvider availableUrls
     */
    public function testPage($url, $status_code)
    {
        list($status) = get_headers($url);
//        print_r($status);
        $this->assertEquals(true, str_contains($status, $status_code));
    }

    public function availableUrls(): array
    {
        // test with this values
        return array(
            "/login 200" => ['http://localhost/login', 200],
            "/logout 200" => ['http://localhost/logout', 200],
            "/ 302" => ['http://localhost/', 302,],
            "/historia 302" => ['http://localhost/historia', 302],
            "/hist 404" => ['http://localhost/hist', 404]
        );
    }
}
