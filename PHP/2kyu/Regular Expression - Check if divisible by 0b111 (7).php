<?php
/*
Create a regular expression capable of evaluating binary strings (which consist of only 1's and 0's) and determining whether the given string represents a number divisible by 7.

Note:

    Empty strings should be rejected.
    Your solution should reject strings with any character other than 0 and 1.
    No leading 0's will be tested unless the string exactly denotes 0.
*/
const solution = '/^((0+)|(((11)|(10(((01)|(000))|(1((11)|(100))))*((001)|(1(0|(101))))))(01*((0(0|(101)))|(0((11)|(100))(((01)|(000))|(1((11)|(100))))*((001)|(1(0|(101)))))))*1))+$/';
?>