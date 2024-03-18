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