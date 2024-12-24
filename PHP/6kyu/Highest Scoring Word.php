<?php
/*
Given a string of words, you need to find the highest scoring word.

Each letter of a word scores points according to its position in the alphabet: a = 1, b = 2, c = 3 etc.

For example, the score of abad is 8 (1 + 2 + 1 + 4).

You need to return the highest scoring word as a string.

If two words score the same, return the word that appears earliest in the original string.

All letters will be lowercase and all inputs will be valid.
*/
function high($sentence) {
    $words = explode(' ', $sentence);
    $highest_word_score = 0;
    $highest_scoring_word = '';

    foreach ($words as $word) {
        $word_score = 0;

        for ($i = 0; $i < strlen($word); $i++) {
            $word_score += ord($word[$i]) - ord('a') + 1;
        }

        if ($word_score > $highest_word_score) {
            $highest_word_score = $word_score;
            $highest_scoring_word = $word;
        }
    }

    return $highest_scoring_word;
}
?>