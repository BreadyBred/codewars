function spinWords(string){
  let words = string.split(" ");
  let reversed;
  for (let i = 0; i < words.length; i++){
    if (words[i].length >= 5){
      reversed = "";
      for (let y = words[i].length - 1; y >= 0; y--) 
        reversed += words[i][y];
      words[i] = reversed;
    }
  }
  reversedString = words.join(" ");
  return reversedString;
}