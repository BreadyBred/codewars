<?php
/*
Given a number n, draw stairs using the letter "I", n tall and n wide, with the tallest in the top left.

For example n = 3 result in:

"I\n I\n  I"

or printed:

I
 I
  I

Another example, a 7-step stairs should be drawn like this:

I
 I
  I
   I
    I
     I
      I
*/
function draw_stairs($n){
  $stairs = "";
  
  for ($i = 0; $i < $n; $i++) {
    $stairs .= str_repeat(" ", $i) . "I";
    
    if ($i < $n - 1) {
      $stairs .= "\n";
    }
  }
  
  return $stairs;
}
?>