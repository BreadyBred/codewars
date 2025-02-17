<?php
/*
Instructions

Given a mathematical expression as a string you must return the result as a number.
Numbers

Number may be both whole numbers and/or decimal numbers. The same goes for the returned result.
Operators

You need to support the following mathematical operators:

    Multiplication *
    Division / (as floating point division)
    Addition +
    Subtraction -

Operators are always evaluated from left-to-right, and * and / must be evaluated before + and -.
Parentheses

You need to support multiple levels of nested parentheses, ex. (2 / (2 + 3.33) * 4) - -6
Whitespace

There may or may not be whitespace between numbers and operators.

An addition to this rule is that the minus sign (-) used for negating numbers and parentheses will never be separated by whitespace. I.e all of the following are valid expressions.

1-1    // 0
1 -1   // 0
1- 1   // 0
1 - 1  // 0
1- -1  // 2
1 - -1 // 2
1--1   // 2

6 + -(4)   // 2
6 + -( -4) // 10

And the following are invalid expressions

1 - - 1    // Invalid
1- - 1     // Invalid
6 + - (4)  // Invalid
6 + -(- 4) // Invalid

Validation

You do not need to worry about validation - you will only receive valid mathematical expressions following the above rules.
Restricted APIs

NOTE: eval is disallowed in your solution.
*/
function tokenize(string $expression): array {
    $expression = preg_replace('/\s+/', '', $expression);

    $tokens = [];
    $num = '';
    $len = strlen($expression);

    for($i = 0; $i < $len; $i++) {
        $char = $expression[$i];

        if($char === '-' && ($i === 0 || $expression[$i-1] === '(' || 
            in_array($expression[$i-1], ['+', '-', '*', '/']))) {
            if ($i + 1 < $len && is_numeric($expression[$i+1])) {
                $num .= $char;
                continue;
            }
        }

        if(is_numeric($char) || $char === '.') {
            $num .= $char;
            continue;
        }

        if($num !== '') {
            $tokens[] = floatval($num);
            $num = '';
        }

        if(in_array($char, ['+', '-', '*', '/', '(', ')'])) {
            $tokens[] = $char;
        }
    }

    if($num !== '') {
        $tokens[] = floatval($num);
    }

    return $tokens;
}

function parseExpression(array &$tokens, int &$pos): float {
    $result = parseTerm($tokens, $pos);

    while($pos < count($tokens)) {
        $token = $tokens[$pos];

        if($token === '+' || $token === '-') {
            $op = $token;
            $pos++;
            $value = parseTerm($tokens, $pos);
            $result = ($op === '+') ? $result + $value : $result - $value;
        } else {
            break;
        }
    }

    return $result;
}

function parseTerm(array &$tokens, int &$pos): float {
    $result = parseFactor($tokens, $pos);

    while($pos < count($tokens)) {
        $token = $tokens[$pos];

        if($token === '*' || $token === '/') {
            $op = $token;
            $pos++;
            $value = parseFactor($tokens, $pos);
            $result = ($op === '*') ? $result * $value : $result / $value;
        } else {
            break;
        }
    }

    return $result;
}

function parseFactor(array &$tokens, int &$pos): float {
    if($pos >= count($tokens)) {
        throw new Exception("Unexpected end of expression");
    }

    $token = $tokens[$pos];

    if(is_numeric($token)) {
        $pos++;
        return $token;
    }

    if($token === '(') {
        $pos++;
        $result = parseExpression($tokens, $pos);

        if($pos >= count($tokens) || $tokens[$pos] !== ')') {
            throw new Exception("Missing closing parenthesis");
        }

        $pos++;
        return $result;
    }

    if($token === '-') {
        $pos++;
        return -parseFactor($tokens, $pos);
    }

    throw new Exception("Unexpected token: " . $token);
}

function calc(string $expression): float {
    $tokens = tokenize($expression);
    $pos = 0;

    return parseExpression($tokens, $pos);
}
?>