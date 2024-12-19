<?php
/*
PHP in Action #1 - Introduction to Superglobals [Fundamentals]
About this Kata Series

"PHP in Action" is a Kata Series authored by donaldsebleung which is specifically aimed at novice PHP programmers who have learnt the basic syntax and features of the PHP programming language in online courses such as Codecademy but do not know how to apply it in real-world situations. Hence, this Kata Series will focus on the practical aspects of PHP such as sending emails, form validation and setting cookies.

This Kata Series assumes that you have already learnt the fundamentals of PHP such as data types (e.g. strings, numbers, booleans), functions and basic OOP. A good indicator that you are ready for this Kata Series is if you can complete Multiply (8kyu) in PHP and the first four Kata in my Object-Oriented PHP Series without hesitation and without referring to external sources in the process. Since real-world PHP is commonly used in conjunction with HTML and CSS (and sometimes even Javascript), you will also be expected to have a basic understanding of the following programming languages. In certain Kata in this Series where form validation is involved, you may also be expected to be familiar with HTML forms, what attributes they have and how they work.
Lesson

As you may already be aware, each function has its own scope in PHP. What this means is if two separate functions both declared a variable with the exact same name, neither function will be aware that the other function contains a variable with the same name so neither function can affect the variable declared and defined in the other function in any way. This is also true concerning variables in the global scope - PHP code in the global scope cannot alter variables defined in functions and functions cannot alter variables defined in the global scope unless there is an explicit declaration:

$x = 13;
function increment_x() {
  $x++; // Will this increment the global variable $x every time the function is called?  We shall see ;)
}
increment_x();
echo $x; // 13
increment_x();
increment_x();
increment_x();
echo $x; // 13
for ($i = 0; $i < 100; $i++) increment_x();
echo $x; // Still 13

If you would like to remind yourself of how function scope works in PHP, you may want to complete this Kata before proceeding with this Kata.

However, in PHP, there are certain predefined variables that are superglobal. Superglobal variables (or more commonly called superglobals) are special variables that defy the laws of function scope in PHP - they can be accessed from any function in PHP, no matter how deeply nested, without having to explicitly declare them as global in the function. For example:

$GLOBALS['x'] = 1; // $GLOBALS is one of few superglobals in PHP - we will learn more about it later
function increment_x() {
  $GLOBALS['x']++;
}
echo $GLOBALS['x']; // 1
increment_x();
echo $GLOBALS['x']; // 2
increment_x();
increment_x();
increment_x();
echo $GLOBALS['x']; // 5

The following predefined variables in PHP are superglobals (according to W3Schools):

    $GLOBALS
    $_SERVER
    $_REQUEST
    $_POST
    $_GET
    $_FILES
    $_ENV
    $_COOKIE
    $_SESSION

We will learn more about each superglobal mentioned above in later Kata in this Series but for now you must be aware of what $GLOBALS is and what it does. As the name suggests, $GLOBALS is an associative array which contains all of the variables declared and defined in the global scope and the name of each key of the $GLOBALS array corresponds to the name of each global variable itself:

$x = 2;
$y = 5;
$hello_world = "Hello World";
echo $GLOBALS['x']; // 2
echo $GLOBALS['y']; // 5
echo $GLOBALS['hello_world']l // "Hello World"

The superglobal nature of $GLOBALS means that functions can directly access variables in the global scope via the $GLOBALS superglobal instead of declaring certain variables global before using it:

// This ... 
function increment_global_x() {
  global $x;
  $x++;
}

// ... is the same as this
function increment_global_x() {
  $GLOBALS['x']++;
}

Strictly speaking, directly accessing global variables using the superglobal $GLOBALS is not identical to accessing global variables by declaring it global in the function and then using it because by using $GLOBALS one can still declare/define a local variable with the same name within the function.
Task

Note: The lesson provided in this Kata is designed to teach you most, if not all, of the key concepts required to complete the Task in this Kata. However, if in doubt, you are strongly encouraged to conduct your own research.

Using your knowledge of superglobals, declare and define the following functions as instructed:

    double_global_num() - This function should receive no arguments and double the value of the global variable $num, preferably through accessing the superglobal $GLOBALS.
    set_query() - This function should receive an argument $query and set $_GET['query'] equal to $query.
    set_email() - This function should receive an argument $email and set $_POST['email'] equal to $email.
*/
function double_global_num() {
  $GLOBALS["num"] *= 2;
}
function set_query($query) {
  $_GET["query"] = $query;
}
function set_email($email) {
  $_POST["email"] = $email;
}
?>