<?php

if (!function_exists('joins')) {
    function joins($str1, $str2) {
        return $str1.'_'.$str2;
    }
}