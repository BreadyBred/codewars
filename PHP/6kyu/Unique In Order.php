<?php
/*
Implement the function unique_in_order which takes as argument a sequence and returns a list of items without any elements with the same value next to each other and preserving the original order of elements.

For example:

uniqueInOrder("AAAABBBCCDAABBB") == {'A', 'B', 'C', 'D', 'A', 'B'}
uniqueInOrder("ABBCcAD")         == {'A', 'B', 'C', 'c', 'A', 'D'}
uniqueInOrder([1,2,2,3,3])       == {1,2,3}
*/
function uniqueInOrder($iterable) {
	$result = [];
	$previous = null;
  
	if(empty($iterable)) {
		return $result;
	}

	if(is_string($iterable)) {
		$iterable = str_split($iterable);
	}

	foreach($iterable as $current) {
		if($current !== $previous) {
			$result[] = $current;
			$previous = $current;
		}
	}

	return $result;
}
?>