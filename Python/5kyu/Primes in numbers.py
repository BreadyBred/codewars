'''
Given a positive number n > 1 find the prime factor decomposition of n. The result will be a string with the following form :

 "(p1**n1)(p2**n2)...(pk**nk)"

with the p(i) in increasing order and n(i) empty if n(i) is 1.
'''
def prime_factor_decomposition(n):
    factors = []
    divisor = 2
    
    while n > 1:
        if n % divisor == 0:
            count = 0
            while n % divisor == 0:
                n //= divisor
                count += 1
            factors.append((divisor, count))
        divisor += 1
    
    return factors

def prime_factors(n):
    factors = prime_factor_decomposition(n)
    result = ""
    
    for factor, power in factors:
        if power == 1:
            result += f"({factor})"
        else:
            result += f"({factor}**{power})"
    
    return result