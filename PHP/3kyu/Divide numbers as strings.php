<?php
/*
Divide numbers as strings

    Input can be integer, negative, zero, or decimal in string format.
    Input may be very large.
    Input won't have leading or trailing zeroes.
    Result should be returned as strings without leading or trailing zeroes.
    Recurring results should be to 20 decimal places. i.e. 1/3 should return 0.33333333333333333333. Just stop computing when your result gets to 20 decimal places. (i.e. no need to compute to 21 decimal places and round to 20 decimal places).
    If divisor is zero, throw Error (Exception in PHP).
    0.00000000000000000000 is just 0.

You may first attempt Voile's Divide integers as strings as an appetizer.
*/
function compareStrings($a, $b) {
    $a = ltrim($a, '0');
    $b = ltrim($b, '0');
    if ($a === '') $a = '0';
    if ($b === '') $b = '0';
    if (strlen($a) != strlen($b)) return strlen($a) - strlen($b);
    return strcmp($a, $b);
}

function subtractStrings($a, $b) {
    $a = ltrim($a, '0') ?: '0';
    $b = ltrim($b, '0') ?: '0';
    $a = str_pad($a, max(strlen($a), strlen($b)), '0', STR_PAD_LEFT);
    $b = str_pad($b, strlen($a), '0', STR_PAD_LEFT);
    $result = '';
    $borrow = 0;
    
    for ($i = strlen($a) - 1; $i >= 0; $i--) {
        $digit = intval($a[$i]) - intval($b[$i]) - $borrow;
        if ($digit < 0) {
            $digit += 10;
            $borrow = 1;
        } else {
            $borrow = 0;
        }
        $result = $digit . $result;
    }
    return $result === '' ? '0' : ltrim($result, '0');
}

function largeDiv($a, $b) {
    if ($b === '0') throw new Exception();
    if ($a === '0') return '0';

    $isNegative = (strpos($a, '-') === 0) !== (strpos($b, '-') === 0);
    $a = ltrim($a, '-');
    $b = ltrim($b, '-');
    
    $aDecPos = strpos($a, '.');
    $bDecPos = strpos($b, '.');
    
    $aShift = $aDecPos !== false ? strlen($a) - $aDecPos - 1 : 0;
    $bShift = $bDecPos !== false ? strlen($b) - $bDecPos - 1 : 0;
    
    $a = str_replace('.', '', $a);
    $b = str_replace('.', '', $b);
    
    $b = ltrim($b, '0');
    if ($b === '') throw new Exception();
    
    $extraZeros = 20 + abs($aShift - $bShift);
    $a = $a . str_repeat('0', $extraZeros);
    
    $quotient = '';
    $position = 0;
    $decimalPos = strlen($a) - $extraZeros - $aShift + $bShift;
    $dividend = '';
    
    for ($i = 0; $i < strlen($a); $i++) {
        $dividend .= $a[$i];
        $quotientDigit = '0';
        
        if (compareStrings($dividend, $b) >= 0) {
            $count = 0;
            while (compareStrings($dividend, $b) >= 0) {
                $dividend = subtractStrings($dividend, $b);
                $count++;
            }
            $quotientDigit = (string)$count;
        }
        
        if ($i == $decimalPos) $quotient .= '.';
        $quotient .= $quotientDigit;
        
        if (strlen($quotient) > $decimalPos + 21) break;
    }
    
    if (strpos($quotient, '.') !== false) {
        $parts = explode('.', $quotient);
        $parts[0] = ltrim($parts[0], '0');
        if ($parts[0] === '') $parts[0] = '0';
        $parts[1] = substr($parts[1], 0, 20);
        $quotient = $parts[0] . '.' . $parts[1];
    } else {
        $quotient = ltrim($quotient, '0');
        if ($quotient === '') $quotient = '0';
    }

    if (strpos($quotient, '.') !== false) {
        $quotient = rtrim($quotient, '0');
        $quotient = rtrim($quotient, '.');
    }
    
    return ($isNegative ? '-' : '') . $quotient;
}
?>