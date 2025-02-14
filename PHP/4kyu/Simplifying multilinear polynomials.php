<?php
/*
When we attended middle school were asked to simplify mathematical expressions like "3x-yx+2xy-x" (or usually bigger), and that was easy-peasy ("2x+xy"). But tell that to your pc and we'll see!

Write a function: simplify, that takes a string in input, representing a multilinear non-constant polynomial in integers coefficients (like "3x-zx+2xy-x"), and returns another string as output where the same expression has been simplified in the following way ( -> means application of simplify):

    All possible sums and subtraction of equivalent monomials ("xy==yx") has been done, e.g.:

    "cb+cba" -> "bc+abc", "2xy-yx" -> "xy", "-a+5ab+3a-c-2a" -> "-c+5ab"

    All monomials appears in order of increasing number of variables, e.g.:

    "-abc+3a+2ac" -> "3a+2ac-abc", "xyz-xz" -> "-xz+xyz"

    If two monomials have the same number of variables, they appears in lexicographic order, e.g.:

    "a+ca-ab" -> "a-ab+ac", "xzy+zby" ->"byz+xyz"

    There is no leading + sign if the first coefficient is positive, e.g.:

    "-y+x" -> "x-y", but no restrictions for -: "y-x" ->"-x+y"

N.B. to keep it simplest, the string in input is restricted to represent only multilinear non-constant polynomials, so you won't find something like `-3+yx^2'. Multilinear means in this context: of degree 1 on each variable.

Warning: the string in input can contain arbitrary variables represented by lowercase characters in the english alphabet.

Good Work :)
*/
function simplify($poly) {
    $terms = parsePolynomial($poly);
    $combined = combineTerms($terms);
    $sorted = sortTerms($combined);
    return formatResult($sorted);
}

function parsePolynomial($poly) {
    preg_match_all('/[+-]?[^+-]+/', $poly, $matches);
    $terms = $matches[0];
    $parsed = [];

    foreach($terms as $term) {
        preg_match('/([+-]?\d*)(.*?)$/', $term, $parts);
        
        $coef = $parts[1];
        $vars = str_split($parts[2]);

        if ($coef === '' || $coef === '+') $coef = 1;
        else if ($coef === '-') $coef = -1;
        else $coef = intval($coef);

        sort($vars);
        $varStr = implode('', $vars);

        $parsed[] = [
            'coef' => $coef,
            'vars' => $varStr,
            'degree' => strlen($varStr)
        ];
    }

    return $parsed;
}

function combineTerms($terms) {
    $combined = [];

    foreach($terms as $term) {
        $vars = $term['vars'];
        if(!isset($combined[$vars])) {
            $combined[$vars] = $term;
        } else {
            $combined[$vars]['coef'] += $term['coef'];
        }
    }

    return array_filter($combined, function($term) {
        return $term['coef'] !== 0;
    });
}

function sortTerms($terms) {
    $array = array_values($terms);

    usort($array, function($a, $b) {
        if($a['degree'] !== $b['degree']) {
            return $a['degree'] - $b['degree'];
        }

        return strcmp($a['vars'], $b['vars']);
    });

    return $array;
}

function formatResult($terms) {
    if(empty($terms)) {
        return "0";
    }

    $result = '';
    $first = true;

    foreach($terms as $term) {
        $coef = $term['coef'];
        $vars = $term['vars'];

        if($first) {
            $first = false;
            if($coef < 0) {
                $result .= '-';
                $coef = abs($coef);
            }
        } else {
            $result .= ($coef < 0) ? '-' : '+';
            $coef = abs($coef);
        }

        if($coef !== 1 || $vars === '') {
            $result .= $coef;
        }

        $result .= $vars;
    }

    return $result;
}
?>