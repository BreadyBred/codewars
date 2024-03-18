function rocks(int $n): int {
    $nbr = 0;
    for ($i = 1; $i <= $n; $i *= 10)
        $nbr += ($n - $i + 1);
    return $nbr;
}