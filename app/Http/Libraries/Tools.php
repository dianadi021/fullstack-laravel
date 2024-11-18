<?php

namespace App\Http\Libraries;

class Tools
{
    public function IsValidVal($val, $get = ["bool", "value", "equal"], $other = null)
    {
        if (isset($other) && !empty($other) && $get == "value") {
            return isset($val) && !empty($val) ? $val : $other;
        } else if (isset($other) && !empty($other) && $get == "equal") {
            return isset($val) && !empty($val) && $val === $other;
        } else if (isset($val) && !empty($val) && $get == "value") {
            return $val;
        } else {
            return isset($val) && !empty($val);
        }
    }
}
