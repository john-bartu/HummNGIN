<?php

namespace HummNGIN\Util;

class ArrayUtil
{
    public static function array_group($array, $key_name): array
    {
        $new_array = array();

        foreach ($array as $key => $value) {
            $new_array[$value->get($key_name)][$key] = $value;
        }

        return $new_array;
    }
}