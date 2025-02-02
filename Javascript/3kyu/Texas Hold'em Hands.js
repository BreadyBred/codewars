/*
Texas Hold'em is a Poker variant in which each player is given two "hole cards". Players then proceed to make a series of bets while five "community cards" are dealt. If there are more than one player remaining when the betting stops, a showdown takes place in which players reveal their cards. Each player makes the best poker hand possible using five of the seven available cards (community cards + the player's hole cards).

Possible hands are, in descending order of value:

    Straight-flush (five consecutive ranks of the same suit). Higher rank is better.
    Four-of-a-kind (four cards with the same rank). Tiebreaker is first the rank, then the rank of the remaining card.
    Full house (three cards with the same rank, two with another). Tiebreaker is first the rank of the three cards, then rank of the pair.
    Flush (five cards of the same suit). Higher ranks are better, compared from high to low rank.
    Straight (five consecutive ranks). Higher rank is better.
    Three-of-a-kind (three cards of the same rank). Tiebreaker is first the rank of the three cards, then the highest other rank, then the second highest other rank.
    Two pair (two cards of the same rank, two cards of another rank). Tiebreaker is first the rank of the high pair, then the rank of the low pair and then the rank of the remaining card.
    Pair (two cards of the same rank). Tiebreaker is first the rank of the two cards, then the three other ranks.
    Nothing. Tiebreaker is the rank of the cards from high to low.

Given hole cards and community cards, complete the function hand to return the type of hand (as written above, you can ignore case) and a list of ranks in decreasing order of significance, to use for comparison against other hands of the same type, of the best possible hand.

hand(["A:♠", "A♦"], ["J♣", "5♥", "10♥", "2♥", "3♦"])
// ...should return {type: "pair", ranks: ["A", "J", "10", "5"]}
hand(["A♠", "K♦"], ["J♥", "5♥", "10♥", "Q♥", "3♥"])
// ...should return {type: "flush", ranks: ["Q", "J", "10", "5", "3"]}

EDIT: for Straights with an Ace, only the ace-high straight is accepted. An ace-low straight is invalid (ie. A,2,3,4,5 is invalid). This is consistent with the author's reference solution. ~docgunthrop
*/
function hand(holeCards, communityCards) {
  const allCards = [...holeCards, ...communityCards];
  
  const getRank = card => card[0] === '1' ? '10' : card[0];
  const getSuit = card => card[card.length - 1];
  
  const rankValue = rank => {
    const values = {'A': 14, 'K': 13, 'Q': 12, 'J': 11, '10': 10};
    return values[rank] || parseInt(rank);
  };
  
  function getCombinations(arr, n) {
    if (n === 1) return arr.map(item => [item]);
    const combinations = [];
    
    arr.forEach((item, index) => {
      const smaller = arr.slice(index + 1);
      const subCombinations = getCombinations(smaller, n - 1);
      subCombinations.forEach(subComb => {
        combinations.push([item, ...subComb]);
      });
    });
    
    return combinations;
  }
  
  function evaluateHand(cards) {
    const ranks = cards.map(card => getRank(card));
    const suits = cards.map(card => getSuit(card));
    const rankCounts = {};
    ranks.forEach(rank => rankCounts[rank] = (rankCounts[rank] || 0) + 1);
    
    const sortedRanks = [...new Set(ranks)]
      .sort((a, b) => rankValue(b) - rankValue(a));
    const isFlush = new Set(suits).size === 1;
    
    let isStraight = false;
    if (sortedRanks.length === 5) {
      const values = sortedRanks.map(rankValue);
      isStraight = values.every((val, i) => 
        i === 0 || val === values[i - 1] - 1
      );
    }
    
    if (isFlush && isStraight) {
      return {
        type: "straight-flush",
        ranks: ranks.sort((a, b) => rankValue(b) - rankValue(a))
      };
    }
    
    const fourOfAKind = Object.entries(rankCounts)
      .find(([_, count]) => count === 4);
    if (fourOfAKind) {
      const kicker = sortedRanks.find(rank => rank !== fourOfAKind[0]);
      return {
        type: "four-of-a-kind",
        ranks: [fourOfAKind[0], kicker]
      };
    }
    
    const hasThreeOfKind = Object.values(rankCounts).includes(3);
    const hasPair = Object.values(rankCounts).includes(2);
    if (hasThreeOfKind && hasPair) {
      const threeRank = Object.entries(rankCounts)
        .find(([_, count]) => count === 3)[0];
      const pairRank = Object.entries(rankCounts)
        .find(([rank, count]) => count === 2 && rank !== threeRank)[0];
      return {
        type: "full house",
        ranks: [threeRank, pairRank]
      };
    }
    
    if (isFlush) {
      return {
        type: "flush",
        ranks: sortedRanks
      };
    }
    
    if (isStraight) {
      return {
        type: "straight",
        ranks: ranks.sort((a, b) => rankValue(b) - rankValue(a))
      };
    }
    
    if (hasThreeOfKind) {
      const threeRank = Object.entries(rankCounts)
        .find(([_, count]) => count === 3)[0];
      const kickers = sortedRanks
        .filter(rank => rank !== threeRank);
      return {
        type: "three-of-a-kind",
        ranks: [threeRank, ...kickers]
      };
    }
    
    const pairs = Object.entries(rankCounts)
      .filter(([_, count]) => count === 2)
      .map(([rank, _]) => rank)
      .sort((a, b) => rankValue(b) - rankValue(a));
    if (pairs.length === 2) {
      const kicker = sortedRanks
        .find(rank => !pairs.includes(rank));
      return {
        type: "two pair",
        ranks: [...pairs, kicker]
      };
    }
    
    if (hasPair) {
      const pairRank = Object.entries(rankCounts)
        .find(([_, count]) => count === 2)[0];
      const kickers = sortedRanks
        .filter(rank => rank !== pairRank);
      return {
        type: "pair",
        ranks: [pairRank, ...kickers]
      };
    }
    
    return {
      type: "nothing",
      ranks: sortedRanks
    };
  }
  
  const hands = getCombinations(allCards, 5)
    .map(cards => evaluateHand(cards));
  
  const handTypes = [
    "straight-flush", "four-of-a-kind", "full house", "flush",
    "straight", "three-of-a-kind", "two pair", "pair", "nothing"
  ];
  
  hands.sort((a, b) => {
    const typeCompare = handTypes.indexOf(a.type) - handTypes.indexOf(b.type);
    if (typeCompare !== 0) return typeCompare;
    
    for (let i = 0; i < Math.max(a.ranks.length, b.ranks.length); i++) {
      if (!a.ranks[i]) return 1;
      if (!b.ranks[i]) return -1;
      const valueCompare = rankValue(b.ranks[i]) - rankValue(a.ranks[i]);
      if (valueCompare !== 0) return valueCompare;
    }
    return 0;
  });
  
  return hands[0];
}