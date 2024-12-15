<!--
Given the string representations of two integers, return the string representation of the sum of those integers.

For example:

sumStrings('1','2') // => '3'

A string representation of an integer will contain no characters besides the ten numerals "0" to "9".

I have removed the use of BigInteger and BigDecimal in java

Python: your solution need to work with huge numbers (about a milion digits), converting to int will not work.
-->

<!--
For small numbers
function sum_strings($a, $b) {
  return strval(($a+0) + ($b+0));
}
For big numbers
-->
<?php
function sum_strings($a, $b) {
  if ($a == '0' && $b == '0')
    return '0';
  
  $result = '';
  $carry = 0;
  $len1 = strlen($a);
  $len2 = strlen($b);
  $maxLen = max($len1, $len2);
    
  $a = str_pad($a, $maxLen, '0', STR_PAD_LEFT);
  $b = str_pad($b, $maxLen, '0', STR_PAD_LEFT);
    
  for ($i = $maxLen - 1; $i >= 0; $i--) {
      $digit1 = (int)$a[$i];
      $digit2 = (int)$b[$i];
      $sum = $digit1 + $digit2 + $carry;
      $carry = floor($sum / 10);
      $result = ($sum % 10) . $result;
  }
    
  if ($carry > 0)
      $result = $carry . $result;    
  $result = ltrim($result, '0');
    
  return $result;
}
?>