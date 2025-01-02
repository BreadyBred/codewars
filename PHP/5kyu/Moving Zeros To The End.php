<?php
/*
Write an algorithm that takes an array and moves all of the zeros to the end, preserving the order of the other elements.

moveZeros([false,1,0,1,2,0,1,3,"a"]) // returns[false,1,1,2,1,3,"a",0,0]
*/
function moveZeros(array $items): array {
    $nonZeros = [];
    $zeros = [];

    foreach ($items as $item) {
        if ($item == 0 && is_numeric($item)) {
            $zeros[] = 0;
        } else {
            $nonZeros[] = $item;
        }
    }

    return array_merge($nonZeros, $zeros);
}
?>