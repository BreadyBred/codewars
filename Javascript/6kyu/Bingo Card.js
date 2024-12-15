/*
Write the function get_card()/getCard(). The card must be returned as an array of Bingo style numbers:

[ 'B14', 'B12', 'B5', 'B6', 'B3', 'I28', 'I27', ... ]

The numbers must be in the order of their column: B, I, N, G, O. Within the columns the order of the numbers is random. 
*/
function getCard() {
	bingoCard = [];
	arrayBingo = [
		// longueur, préfixe, min, max
		5, "B", 1, 15,
		5, "I", 16, 30,
		4, "N", 31, 45,
		5, "G", 46, 60,
		5, "O", 61, 75
	];
	for (let i = 0; i < arrayBingo.length; i+=4){
		for (let y = 0; y < arrayBingo[i]; y++){
		do {
			rdn = arrayBingo[i+1] + Math.floor(Math.random() * (arrayBingo[i+3] - arrayBingo[i+2] + 1) + arrayBingo[i+2])
		} while (bingoCard.includes(rdn))
		bingoCard.push(rdn);
		}
	}
  	return bingoCard;
}