<?php

use App\Core\Application;

if (!function_exists('app')) {
    function app()
    {
        return Application::$app;
    }
}

if (!function_exists('truncate_number')) {
    function truncate_number($number, $precision = 2)
    {
        // Zero causes issues, and no need to truncate
        if (0 == (float)$number) {
            return $number;
        }
        // Are we negative?
        $negative = $number / abs($number);
        // Cast the number to a positive to solve rounding
        $number = abs($number);
        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);
        // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        return floor($number * $precision) / $precision * $negative;
    }
}

if (!function_exists('searchForKeyInObj')) {
    function searchForKeyInObj($search, $object, $array)
    {
        foreach ($array as $key => $val) {
            if ($val->$object === $search) {
                return $key;
            }
        }
        return null;
    }
}

if (!function_exists('searchForKeyInArr')) {
    function searchForKeyInArr($search, $element, $array)
    {
        foreach ($array as $key => $val) {
            if ($val[$element] === $search) {
                return $key;
            }
        }
        return null;
    }
}


if (!function_exists('getTotalOf')) {
    /**
     * Get the total of an integer field using php array_reduce
     *
     * @param  array $cart
     * @param  string $field
     */
    function getTotalOf(array $cart, string $field): float
    {
        //reduce and round the output to 2 decimal points
        return
            round(
                array_reduce(
                    $cart,
                    function ($accumulator, $item) use ($field) {
                        return $accumulator + $item[$field];
                    },
                    0
                ),
                2
            );
    }
}
