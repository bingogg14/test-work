<?php

if (! function_exists('get_percentage')) {
    function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round($number / ($total / 100), 2);
        }

        return 0;
    }
}