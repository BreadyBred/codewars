<?php
/*
Given a non-empty array of integers, return the result of multiplying the values together in order. Example:

[1, 2, 3, 4] => 1 * 2 * 3 * 4 = 24
*/
function grow(array $a):int {
  $result = $a[0];
  for($i = 1; $i < count($a); $i++) {
    $result*=$a[$i];
  }
  
  return $result;
}
?>