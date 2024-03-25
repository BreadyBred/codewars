/*
Write a function, isItLetter or is_it_letter, which tells us if a given character is an, uppercase or lowercase, letter.
*/
function isItLetter(character) {
  letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"]
  // return (letters.indexOf(character.toLowerCase()) != -1) ? true : false
  return letters.includes(character.toLowerCase())
}