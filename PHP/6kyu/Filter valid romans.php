function valid_romans($arr): array {
    $valid_romans = [];
    foreach ($arr as $numeral)
        if (!empty($numeral) && preg_match('/^(M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3}))$/', $numeral))
            $valid_romans[] = $numeral;
    return $valid_romans;
}