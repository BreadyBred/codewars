<?php
/*
You are writing a three-pass compiler for a simple programming language into a small assembly language.

The programming language has this syntax:

    function   ::= '[' arg-list ']' expression

    arg-list   ::= nothing
	| variable arg-list

    expression ::= term
                 | expression '+' term
                 | expression '-' term

    term       ::= factor
                 | term '*' factor
                 | term '/' factor

    factor     ::= number
                 | variable
                 | '(' expression ')'

Variables are strings of alphabetic characters. Numbers are strings of decimal digits representing integers. So, for example, a function which computes a2 + b2 might look like:

    [ a b ] a*a + b*b

A function which computes the average of two numbers might look like:

    [ first second ] (first + second) / 2

You need write a three-pass compiler. All test cases will be valid programs, so you needn't concentrate on error-handling.

The first pass will be the method pass1 which takes a string representing a function in the original programming language and will return a (JSON) object that represents that Abstract Syntax Tree. The Abstract Syntax Tree must use the following representations:

    { 'op': '+', 'a': a, 'b': b }    // add subtree a to subtree b
    { 'op': '-', 'a': a, 'b': b }    // subtract subtree b from subtree a
    { 'op': '*', 'a': a, 'b': b }    // multiply subtree a by subtree b
    { 'op': '/', 'a': a, 'b': b }    // divide subtree a from subtree b
    { 'op': 'arg', 'n': n }          // reference to n-th argument, n integer
    { 'op': 'imm', 'n': n }          // immediate value n, n integer

Note: arguments are indexed from zero. So, for example, the function

[ x y ] ( x + y ) / 2 would look like:

    { 'op': '/', 'a': { 'op': '+', 'a': { 'op': 'arg', 'n': 0 },
                                   'b': { 'op': 'arg', 'n': 1 } },
                 'b': { 'op': 'imm', 'n': 2 } }

The second pass of the compiler will be called pass2. This pass will take the output from pass1 and return a new Abstract Syntax Tree (with the same format) with all constant expressions reduced as much as possible. So, if for example, the function is [ x ] x + 2*5, the result of pass1 would be:

    { 'op': '+', 'a': { 'op': 'arg', 'n': 0 },
                 'b': { 'op': '*', 'a': { 'op': 'imm', 'n': 2 },
                                   'b': { 'op': 'imm', 'n': 5 } } }

This would be passed into pass2 which would return:

    { 'op': '+', 'a': { 'op': 'arg', 'n': 0 },
                 'b': { 'op': 'imm', 'n': 10 } }

The third pass of the compiler is pass3. The pass3 method takes in an Abstract Syntax Tree and returns an array of strings. Each string is an assembly directive. You are working on a small processor with two registers (R0 and R1), a stack, and an array of input arguments. The result of a function is expected to be in R0. The processor supports the following instructions:

    "IM n"     // load the constant value n into R0
    "AR n"     // load the n-th input argument into R0
    "SW"       // swap R0 and R1
    "PU"       // push R0 onto the stack
    "PO"       // pop the top value off of the stack into R0
    "AD"       // add R1 to R0 and put the result in R0
    "SU"       // subtract R1 from R0 and put the result in R0
    "MU"       // multiply R0 by R1 and put the result in R0
    "DI"       // divide R0 by R1 and put the result in R0

So, one possible return value from pass3 given the Abstract Syntax Tree shown above from pass2 is:

    [ "IM 10", "SW", "AR 0", "AD" ]

Here is a simulator for the target machine. It takes an array of assembly instructions and an array of arguments and returns the result.

function simulate($asm, $argv) {
    list($r0, $r1) = [0, 0];
    $stack = [];
    foreach ($asm as $ins) {
        if (substr($ins, 0, 2) == 'IM' || substr($ins, 0, 2) == 'AR') {
            list($ins, $n) = [substr($ins, 0, 2), intval(substr($ins, 2))];
        }
        if ($ins == 'IM')      $r0 = $n;
        else if ($ins == 'AR') $r0 = $argv[$n];
        else if ($ins == 'SW') list($r0, $r1) = [$r1, $r0];
        else if ($ins == 'PU') array_push($stack, $r0);
        else if ($ins == 'PO') $r0 = array_pop($stack);
        else if ($ins == 'AD') $r0 += $r1;
        else if ($ins == 'SU') $r0 -= $r1;
        else if ($ins == 'MU') $r0 *= $r1;
        else if ($ins == 'DI') $r0 /= $r1;
    }
    return $r0;
}
*/
class Compiler {
    private $tokens;
    private $pos = 0;

    public function compile($program) {
        return $this->pass3($this->pass2($this->pass1($program)));
    }

    public function tokenize($program) {
        $tokens = preg_split('/\s+/', trim(preg_replace('/([-+*\/\(\)\[\]])/', ' $1 ', $program)));

        foreach($tokens as &$token) {
            if(is_numeric($token)) {
                $token = intval($token);
            }
        }

        return array_values(array_filter($tokens));
    }

    private function peek() {
        return ($this->pos < count($this->tokens)) ? $this->tokens[$this->pos] : null;
    }

    private function consume() {
        return $this->tokens[$this->pos++];
    }

    private function parseArgList() {
        $args = [];

        while(($token = $this->peek()) && !($token === ']')) {
            $args[] = $this->consume();
        }
      
        $this->consume();

        return $args;
    }

    private function parseExpression() {
        $left = $this->parseTerm();

        while(($token = $this->peek()) && ($token === '+' || $token === '-')) {
            $op = $this->consume();
            $right = $this->parseTerm();
            $left = ['op' => $op, 'a' => $left, 'b' => $right];
        }

        return $left;
    }

    private function parseTerm() {
        $left = $this->parseFactor();

        while(($token = $this->peek()) && ($token === '*' || $token === '/')) {
            $op = $this->consume();
            $right = $this->parseFactor();
            $left = ['op' => $op, 'a' => $left, 'b' => $right];
        }

        return $left;
    }

    private function parseFactor() {
        $token = $this->peek();

        if(is_numeric($token)) {
            $this->consume();
            return ['op' => 'imm', 'n' => $token];
        }

        if($token === '(') {
            $this->consume();
            $expr = $this->parseExpression();
            $this->consume(); // consume ')'
            return $expr;
        }

        $variable = $this->consume();
        return ['op' => 'arg', 'n' => array_search($variable, $this->args)];
    }
    
    public function pass1($program) {
        $this->tokens = $this->tokenize($program);
        $this->pos = 0;

        $this->consume();
        $this->args = $this->parseArgList();

        return $this->parseExpression();
    }

    public function pass2($ast) {
        if(!is_array($ast)) return $ast;

        if(isset($ast['a'])) $ast['a'] = $this->pass2($ast['a']);
        if(isset($ast['b'])) $ast['b'] = $this->pass2($ast['b']);

        if($ast['op'] === '+' || $ast['op'] === '-' || 
            $ast['op'] === '*' || $ast['op'] === '/') {
            if($ast['a']['op'] === 'imm' && $ast['b']['op'] === 'imm') {
                $a = $ast['a']['n'];
                $b = $ast['b']['n'];
                switch($ast['op']) {
                    case '+': return ['op' => 'imm', 'n' => $a + $b];
                    case '-': return ['op' => 'imm', 'n' => $a - $b];
                    case '*': return ['op' => 'imm', 'n' => $a * $b];
                    case '/': return ['op' => 'imm', 'n' => intval($a / $b)];
                }
            }
        }

        return $ast;
    }

    public function pass3($ast) {
        $instructions = [];

        $compile = function($node) use (&$instructions, &$compile) {
            if($node['op'] === 'imm') {
                $instructions[] = "IM " . $node['n'];
                return;
            }

            if($node['op'] === 'arg') {
                $instructions[] = "AR " . $node['n'];
                return;
            }

            $compile($node['a']);
            $instructions[] = "PU";
            $compile($node['b']);
            $instructions[] = "SW";
            $instructions[] = "PO";

            switch($node['op']) {
                case '+': $instructions[] = "AD"; break;
                case '-': $instructions[] = "SU"; break;
                case '*': $instructions[] = "MU"; break;
                case '/': $instructions[] = "DI"; break;
            }
        };

        $compile($ast);

        return $instructions;
    }
}
?>