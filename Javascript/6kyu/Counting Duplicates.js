function duplicateCount(text) {
    text = text.toLowerCase();
    
    const charCounts = {};
    
    for (let char of text) {
        charCounts[char] = (charCounts[char] || 0) + 1;
    }
    let duplicates = 0;
    for (let char in charCounts) {
        if (charCounts[char] > 1) {
            duplicates++;
        }
    }
    return duplicates;
}