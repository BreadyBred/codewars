<!--
Write a function which calculates the average of the numbers in a given list.

Note: Empty arrays should return 0.
-->
<?php
function find_average($array): float {
	return (count($array) == 0) ? 0 : array_sum($array) / count($array);;
}
?>