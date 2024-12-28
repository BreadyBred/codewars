<?php
/*
Given a set of numbers, return the additive inverse of each. Each positive becomes negatives, and the negatives become positives.

[1, 2, 3, 4, 5] --> [-1, -2, -3, -4, -5]
[1, -2, 3, -4, 5] --> [-1, 2, -3, 4, -5]
[] --> []

You can assume that all values are integers. Do not mutate the input array.
*/
function invert(array $a): array {
  for($i = 0; $i < count($a); $i++) {
    $a[$i] = $a[$i] * -1;
  }
  
  return $a;
  
  /* OR */
  
  $b = [];
  foreach($a as $value) {
    $b[] = $value * -1;
  }
  
  return $b;
}
?>