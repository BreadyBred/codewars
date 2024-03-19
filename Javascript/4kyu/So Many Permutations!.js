function permutations(input) {
    if (input.length <= 1) return [input];

    const perms = new Set();
    for (let i = 0; i < input.length; i++) {
        const char = input[i];
        const remainingChars = input.slice(0, i) + input.slice(i + 1);
        const innerPerms = permutations(remainingChars);
        innerPerms.forEach(perm => perms.add(char + perm));
    }

    return [...perms];
}