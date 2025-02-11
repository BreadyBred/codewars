<?php
/*
Write a function that accepts a square matrix (N x N 2D array) and returns the determinant of the matrix.

How to take the determinant of a matrix -- it is simplest to start with the smallest cases:

A 1x1 matrix |a| has determinant a.

A 2x2 matrix [ [a, b], [c, d] ] or

|a  b|
|c  d|

has determinant: a*d - b*c.

The determinant of an n x n sized matrix is calculated by reducing the problem to the calculation of the determinants of n matrices ofn-1 x n-1 size.

For the 3x3 case, [ [a, b, c], [d, e, f], [g, h, i] ] or

|a b c|  
|d e f|  
|g h i|  

the determinant is: a * det(a_minor) - b * det(b_minor) + c * det(c_minor) where det(a_minor) refers to taking the determinant of the 2x2 matrix created by crossing out the row and column in which the element a occurs:

|- - -|
|- e f|
|- h i|  

Note the alternation of signs.

The determinant of larger matrices are calculated analogously, e.g. if M is a 4x4 matrix with first row [a, b, c, d], then:

det(M) = a * det(a_minor) - b * det(b_minor) + c * det(c_minor) - d * det(d_minor)
*/
function determinant(array $matrix): int {
    $n = count($matrix);

    if ($n === 1) {
        return (int)$matrix[0][0];
    }

    if ($n === 2) {
        return (int)($matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0]);
    }

    $det = 0;

    for ($j = 0; $j < $n; $j++) {
        $submatrix = [];
        for ($row = 1; $row < $n; $row++) {
            $subrow = [];
            for ($col = 0; $col < $n; $col++) {
                if ($col !== $j) {
                    $subrow[] = $matrix[$row][$col];
                }
            }
            $submatrix[] = $subrow;
        }

        $sign = ($j % 2 === 0) ? 1 : -1;
        $det += $sign * (int)$matrix[0][$j] * determinant($submatrix);
    }

    return (int)$det;
}
?>