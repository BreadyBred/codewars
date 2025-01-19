<?php
/*
Given a 2D array and a number of generations, compute n timesteps of Conway's Game of Life.

The rules of the game are:

    Any live cell with fewer than two live neighbours dies, as if caused by underpopulation.
    Any live cell with more than three live neighbours dies, as if by overcrowding.
    Any live cell with two or three live neighbours lives on to the next generation.
    Any dead cell with exactly three live neighbours becomes a live cell.

Each cell's neighborhood is the 8 cells immediately around it (i.e. Moore Neighborhood). The universe is infinite in both the x and y dimensions and all cells are initially dead - except for those specified in the arguments. The return value should be a 2d array cropped around all of the living cells. (If there are no living cells, then return [[]].)

For illustration purposes, 0 and 1 will be represented as ░░ and ▓▓ blocks respectively (PHP: plain black and white squares). You can take advantage of the htmlize function to get a text representation of the universe, e.g.:

echo htmlize($cells) . "\r\n";
*/
function get_generation(array $cells, int $generations): array {
    if($generations === 0 || empty($cells) || empty($cells[0])) {
        return $cells;
    }

    $current = $cells;

    for($gen = 0; $gen < $generations; $gen++) {
        $bounds = get_boundaries($current);

        if(empty($bounds)) {
            return [[]];
        }

        $expanded = create_expanded_grid($current, $bounds);

        $next = [];
        for($i = 0; $i < count($expanded); $i++) {
            $next[$i] = [];

            for($j = 0; $j < count($expanded[0]); $j++) {
                $neighbors = count_neighbors($expanded, $i, $j);
                $next[$i][$j] = should_cell_live($expanded[$i][$j], $neighbors);
            }
        }

        $current = crop_grid($next);
    }

    return $current;
}

function get_boundaries(array $grid): array {
    if(empty($grid) || empty($grid[0])) {
        return [];
    }

    $minRow = count($grid);
    $maxRow = -1;
    $minCol = count($grid[0]);
    $maxCol = -1;
    
    for($i = 0; $i < count($grid); $i++) {
        for($j = 0; $j < count($grid[0]); $j++) {
            if($grid[$i][$j] === 1) {
                $minRow = min($minRow, $i);
                $maxRow = max($maxRow, $i);
                $minCol = min($minCol, $j);
                $maxCol = max($maxCol, $j);
            }
        }
    }

    return $maxRow === -1 ? [] : [
        'minRow' => $minRow,
        'maxRow' => $maxRow,
        'minCol' => $minCol,
        'maxCol' => $maxCol
    ];
}

function create_expanded_grid(array $grid, array $bounds): array {
    $rows = count($grid);
    $cols = count($grid[0]);
    $expanded = array_fill(0, $rows + 2, array_fill(0, $cols + 2, 0));

    for($i = 0; $i < $rows; $i++) {
        for($j = 0; $j < $cols; $j++) {
            $expanded[$i + 1][$j + 1] = $grid[$i][$j];
        }
    }

    return $expanded;
}

function count_neighbors(array $grid, int $row, int $col): int {
    $count = 0;
    $directions = [
        [-1, -1], [-1, 0], [-1, 1],
        [0, -1],           [0, 1],
        [1, -1],  [1, 0],  [1, 1]
    ];
    
    foreach($directions as [$dx, $dy]) {
        $newRow = $row + $dx;
        $newCol = $col + $dy;

        if($newRow >= 0 && $newRow < count($grid) && 
            $newCol >= 0 && $newCol < count($grid[0])) {
            $count += $grid[$newRow][$newCol];
        }
    }

    return $count;
}

function should_cell_live(int $current, int $neighbors): int {
    if($current === 1) {
        return ($neighbors === 2 || $neighbors === 3) ? 1 : 0;
    }

    return $neighbors === 3 ? 1 : 0;
}

function crop_grid(array $grid): array {
    $bounds = get_boundaries($grid);

    if(empty($bounds)) {
        return [[]];
    }

    $result = [];
    for($i = $bounds['minRow']; $i <= $bounds['maxRow']; $i++) {
        $row = [];

        for($j = $bounds['minCol']; $j <= $bounds['maxCol']; $j++) {
            $row[] = $grid[$i][$j];
        }

        $result[] = $row;
    }
    
    return $result;
}
?>