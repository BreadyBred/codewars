"""
An integer partition of n is a weakly decreasing list of positive integers which sum to n.

For example, there are 7 integer partitions of 5:

[5], [4,1], [3,2], [3,1,1], [2,2,1], [2,1,1,1], [1,1,1,1,1].

Write a function which returns the number of integer partitions of n. The function should be able to find the number of integer partitions of n for n at least as large as 100.
"""
def partitions(n):
    if n < 0:
        return 0
    if n == 0:
        return 1

    dp = [0] * (n + 1)
    dp[0] = 1

    for i in range(1, n + 1):
        for j in range(i, n + 1):
            dp[j] += dp[j - i]

    return dp[n]