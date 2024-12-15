/*
In this kata, your task is to create all permutations of a non-empty input string and remove duplicates, if present.

Create as many "shufflings" as you can!

Examples:

With input 'a':
Your function should return: ['a']

With input 'ab':
Your function should return ['ab', 'ba']

With input 'abc':
Your function should return ['abc','acb','bac','bca','cab','cba']

With input 'aabb':
Your function should return ['aabb', 'abab', 'abba', 'baab', 'baba', 'bbaa']

Note: The order of the permutations doesn't matter.

Good luck!
*/
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