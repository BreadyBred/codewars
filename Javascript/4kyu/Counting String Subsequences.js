function countSubsequences(needle, haystack) {
    const mod = 100000000;
    const n = needle.length;
    const m = haystack.length;

    const dp = new Array(n + 1).fill(0).map(() => new Array(m + 1).fill(0));

    for (let j = 0; j <= m; j++)
        dp[0][j] = 1;

    for (let i = 1; i <= n; i++) {
        for (let j = 1; j <= m; j++) {
            if (needle[i - 1] === haystack[j - 1])
                dp[i][j] = (dp[i - 1][j - 1] + dp[i][j - 1]) % mod;
            else
                dp[i][j] = dp[i][j - 1];
        }
    }

    return dp[n][m] % mod;
}