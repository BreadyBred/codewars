<!--
Your classmates asked you to copy some paperwork for them. You know that there are 'n' classmates and the paperwork has 'm' pages.

Your task is to calculate how many blank pages do you need. If n < 0 or m < 0 return 0.
-->
<?php
function paperwork(int $n, int $m): int {
  return ($m > 0 && $n > 0) ? $m * $n : 0;
}
?>