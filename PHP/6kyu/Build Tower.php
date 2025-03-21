<?php
/*
Build Tower

Build a pyramid-shaped tower, as an array/list of strings, given a positive integer number of floors. A tower block is represented with "*" character.

For example, a tower with 3 floors looks like this:

[
  "  *  ",
  " *** ", 
  "*****"
]

And a tower with 6 floors looks like this:

[
  "     *     ", 
  "    ***    ", 
  "   *****   ", 
  "  *******  ", 
  " ********* ", 
  "***********"
]
*/
function tower_builder(int $n): array {
    $tower = [];
    
    for($i = 1; $i <= $n; $i++) {
        $stars = str_repeat('*', (2 * $i) - 1);
        $padding = str_repeat(' ', $n - $i);
        $tower[] = $padding . $stars . $padding;
    }
    
    return $tower;
}
?>