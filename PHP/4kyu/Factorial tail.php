<?php
/*
The problem

How many zeroes are at the end of the factorial of 10? 10! = 3628800, i.e. there are 2 zeroes. 16! (or 0x10!) in hexadecimal would be 0x130777758000, which has 3 zeroes.
Scalability

Unfortunately, machine integer numbers has not enough precision for larger values. Floating point numbers drop the tail we need. We can fall back to arbitrary-precision ones - built-ins or from a library, but calculating the full product isn't an efficient way to find just the tail of a factorial. Calculating 100'000! in compiled language takes around 10 seconds. 1'000'000! would be around 10 minutes, even using efficient Karatsuba algorithm
Your task

is to write a function, which will find the number of zeroes at the end of (number) factorial in arbitrary radix = base for larger numbers.

    base is an integer from 2 to 256
    number is an integer from 1 to 1'000'000

Note Second argument: number is always declared, passed and displayed as a regular decimal number. If you see a test described as 42! in base 20 it's 4210 not 4220 = 8210.
*/
function zeroes($base, $number) {
    $prime_factors = [];
    $temp_base = $base;

    for($i = 2; $i <= $temp_base; $i++) {
        $count = 0;

        while($temp_base % $i == 0) {
            $count++;
            $temp_base = (int)($temp_base / $i);
        }

        if($count > 0) {
            $prime_factors[$i] = $count;
        }
    }

    $min_zeros = PHP_INT_MAX;

    foreach($prime_factors as $prime => $power) {
        if($power == 0) continue;

        $count = 0;
        $p = $prime;
        while($p <= $number) {
            $count += (int) ($number / $p);
            $p *= $prime;
        }

        $zeros = (int) ($count / $power);
        $min_zeros = min($min_zeros, $zeros);
    }

    return $min_zeros === PHP_INT_MAX ? 0 : $min_zeros;
}
?>