function encode(str) {
    const map = {
        'G': 'A', 'g': 'a',
        'A': 'G', 'a': 'g',
        'D': 'E', 'd': 'e',
        'E': 'D', 'e': 'd',
        'R': 'Y', 'r': 'y',
        'Y': 'R', 'y': 'r',
        'P': 'O', 'p': 'o',
        'O': 'P', 'o': 'p',
        'L': 'U', 'l': 'u',
        'U': 'L', 'u': 'l',
        'K': 'I', 'k': 'i',
        'I': 'K', 'i': 'k'
    };
    return str.replace(/[GgAaDdEeRrYyPpOoLlUuKkIi]/g, char => map[char]);
}

function decode(str) {
    const map = {
        'A': 'G', 'a': 'g',
        'G': 'A', 'g': 'a',
        'E': 'D', 'e': 'd',
        'D': 'E', 'd': 'e',
        'Y': 'R', 'y': 'r',
        'R': 'Y', 'r': 'y',
        'O': 'P', 'o': 'p',
        'P': 'O', 'p': 'o',
        'U': 'L', 'u': 'l',
        'L': 'U', 'l': 'u',
        'I': 'K', 'i': 'k',
        'K': 'I', 'k': 'i'
    };
    return str.replace(/[AaGgEdDeRrYyPpOoLuUlKiIk]/g, char => map[char]);
}