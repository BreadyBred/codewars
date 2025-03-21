"""
We want to generate all the numbers of three digits where:

    the sum of their digits is equal to 10
    their digits are in increasing order (the numbers may have two or more equal contiguous digits)

The numbers that fulfill these constraints are: [118, 127, 136, 145, 226, 235, 244, 334]. There are 8 numbers in total with 118 being the lowest and 334 being the greatest.
Task

Implement a function which receives two arguments:

    the sum of digits (sum)
    the number of digits (count)

This function should return three values:

    the total number of values which have count digits that add up to sum and are in increasing order
    the lowest such value
    the greatest such value

Note: if there are no values which satisfy these constaints, you should return an empty value (refer to the examples to see what exactly is expected).
Examples

find_all(10, 3)  =>  [8, 118, 334]
find_all(27, 3)  =>  [1, 999, 999]
find_all(84, 4)  =>  []

Features of the random tests:

    Number of tests: 112
    Sum of digits value between 20 and 65
    Amount of digits between 2 and 17
"""
def find_all(sum_digits, count):
    def backtrack(current_num, current_sum, current_length, last_digit):
        if current_length == count:
            if current_sum == sum_digits:
                results.append(int(current_num))
            return
        
        if current_length > count or current_sum > sum_digits:
            return
        
        start = last_digit if last_digit is not None else 1
        for digit in range(start, 10):
            if current_sum + digit > sum_digits:
                break
            
            backtrack(
                current_num + str(digit), 
                current_sum + digit, 
                current_length + 1, 
                digit
            )
    
    results = []
    
    backtrack('', 0, 0, None)
    if not results:
        return []
    
    return [len(results), min(results), max(results)]