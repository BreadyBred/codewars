def mystery(n):
    return n ^ (n >> 1)

def mystery_inv(n):
    result = 0
    while n:
        result ^= n
        n >>= 1
    return result

def name_of_mystery():
    return "Gray code"