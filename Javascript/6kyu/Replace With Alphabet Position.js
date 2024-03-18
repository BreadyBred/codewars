function alphabetPosition(text) {
    let result = "";
    text = text.toLowerCase();
    
    for (let i = 0; i < text.length; i++) {
        let char = text[i];
        if (char.match(/[a-z]/i)) {
            let position = char.charCodeAt(0) - 'a'.charCodeAt(0) + 1;
            result += position + " ";
        }
    }
    return result.trim();
}