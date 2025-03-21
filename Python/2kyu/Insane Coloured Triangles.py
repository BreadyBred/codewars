"""
Disclaimer

This Kata is an insane step-up from Avanta's Kata, so I recommend to solve it first before trying this one.
Problem Description

A coloured triangle is created from a row of colours, each of which is red, green or blue. Successive rows, each containing one fewer colour than the last, are generated by considering the two touching colours in the previous row. If these colours are identical, the same colour is used in the new row. If they are different, the missing colour is used in the new row. This is continued until the final row, with only a single colour, is generated.

For example, different possibilities are:

Colour here:            G G        B G        R G        B R
Becomes colour here:     G          R          B          G

With a bigger example:

R R G B R G B B
 R B R G B R B
  G G B R G G
   G R G B G
    B B R R
     B G R
      R B
       G

You will be given the first row of the triangle as a string and its your job to return the final colour which would appear in the bottom row as a string. In the case of the example above, you would be given 'RRGBRGBB', and you should return 'G'.
Constraints

1 <= length(row) <= 10 ** 5

The input string will only contain the uppercase letters 'B', 'G' or 'R'.

The exact number of test cases will be as follows:

    100 tests of 100 <= length(row) <= 1000
    100 tests of 1000 <= length(row) <= 10000
    100 tests of 10000 <= length(row) <= 100000

Examples

triangle('B') == 'B'
triangle('GB') == 'R'
triangle('RRR') == 'R'
triangle('RGBG') == 'B'
triangle('RBRGBRB') == 'G'
triangle('RBRGBRBGGRRRBGBBBGG') == 'G'
"""
colors = set('RGB')
good_numbers = [1, 4, 10, 28, 82, 244, 730, 2188, 6562, 19684, 59050, 177148]

def simple_solve(guys):
    while len(guys) > 1:
        guys = [a if a == b else (colors-{a, b}).pop() for a, b in zip(guys, guys[1:])]
    return guys[0]

def closest_good_number(number, good_numbers):
    closest = sorted(good_numbers, key=lambda x: abs(x - number))
    for value in closest:
        if value <= number:
            return value

def sides_until_good(guys):
    if len(guys) < 4:
        return simple_solve(guys)

    good_number = closest_good_number(len(guys), good_numbers)
    size = len(guys) - good_number + 1

    left = guys[:size]
    right = guys[-size:]

    a = sides_until_good(left)
    b = sides_until_good(right)
    final = simple_solve((a, b))

    return final

def triangle(input):
    guy = sides_until_good(input)
    return guy