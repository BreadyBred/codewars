<?php
/*
Given an array of integers, return a new array with each value doubled.

For example:

[1, 2, 3] --> [2, 4, 6]
*/
function maps(array $arr): array{
	$double_array = [];
	
	foreach($arr as $value) {
		$double_array[] = $value*2;
	}
	
	return $double_array;
}
?>