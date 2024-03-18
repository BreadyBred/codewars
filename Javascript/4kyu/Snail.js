snail = function snail(array) {
    const result = [];
    while (array.length) {
        result.push(...array.shift());
        array.forEach(row => result.push(row.pop()));
        array.reverse().forEach(row => row.reverse());
    }
    return result;
}