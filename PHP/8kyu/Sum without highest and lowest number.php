function sumArray($array) {
  sort($array);
  $nbr = 0;
  for ($i = 1; $i < count($array)-1; $i++)
    $nbr += $array[$i];
  return $nbr;
}