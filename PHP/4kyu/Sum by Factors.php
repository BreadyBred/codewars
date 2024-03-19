function sumOfDivided($lst) {
    $factors = [];
    foreach ($lst as $num)
        for ($i = 2; $i <= abs($num); $i++)
            if ($num % $i == 0 && isPrime($i))
                $factors[$i] = ($factors[$i] ?? 0) + $num;
    ksort($factors);

    $result = [];
    foreach ($factors as $factor => $sum)
        $result[] = [$factor, $sum];

    return $result;
}

function isPrime($num) {
    if ($num <= 1)
        return false;
    for ($i = 2; $i <= sqrt($num); $i++)
        if ($num % $i == 0)
            return false;
    return true;
}