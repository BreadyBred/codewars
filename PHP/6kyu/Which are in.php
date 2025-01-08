<?php
/*
Given two arrays of strings a1 and a2 return a sorted array r in lexicographical order of the strings of a1 which are substrings of strings of a2.
Example 1:

a1 = ["arp", "live", "strong"]

a2 = ["lively", "alive", "harp", "sharp", "armstrong"]

returns ["arp", "live", "strong"]
Example 2:

a1 = ["tarp", "mice", "bull"]

a2 = ["lively", "alive", "harp", "sharp", "armstrong"]

returns []

Notes:
	Arrays are written in "general" notation. See "Your Test Cases" for examples in your language.
	In Shell bash a1 and a2 are strings. The return is a string where words are separated by commas.
	Beware: In some languages r must be without duplicates.
*/
function inArray($array1, $array2) {
	$common_values = [];

	foreach($array1 as $array1_value) {
		foreach($array2 as $array2_value) {
			if(strpos($array2_value, $array1_value) !== false) {
				$common_values[] = $array1_value;
			}
		}
	}

	$common_values = array_unique($common_values);
	sort($common_values);
	return $common_values;
}
?>