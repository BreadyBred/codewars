<?php
/*
Create a function that takes a positive integer and returns the next bigger number that can be formed by rearranging its digits. For example:

12 ==> 21
513 ==> 531
2017 ==> 2071

If the digits can't be rearranged to form a bigger number, return -1 (or nil in Swift, None in Rust):

9 ==> -1
111 ==> -1
531 ==> -1
*/
function nextBigger($n) {
    $digits = str_split($n);
    $i = count($digits) - 2;
    
    while ($i >= 0 && $digits[$i] >= $digits[$i + 1])
        $i--;
    if ($i == -1)
        return -1;
    
    $j = count($digits) - 1;
    while ($digits[$j] <= $digits[$i])
        $j--;
    
    [$digits[$i], $digits[$j]] = [$digits[$j], $digits[$i]];
    
    array_splice($digits, $i + 1, null, array_reverse(array_slice($digits, $i + 1)));
    
    $result = (int)implode('', $digits);
    
    return $result > $n ? $result : -1;
}
?>