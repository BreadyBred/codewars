<?php
/*
Your task in this Kata is to emulate text justification in monospace font. You will be given a single-lined text and the expected justification width. The longest word will never be greater than this width.

Here are the rules:

	Use spaces to fill in the gaps between words.
	Each line should contain as many words as possible.
	Use '\n' to separate lines.
	Last line should not terminate in '\n'
	'\n' is not included in the length of a line.
	Gaps between words can't differ by more than one space.
	Lines should end with a word not a space.
	Large gaps go first, then smaller ones ('Lorem--ipsum--dolor--sit-amet,' (2, 2, 2, 1 spaces)).
	Last line should not be justified, use only one space between words.
	Lines with one word do not need gaps ('somelongword\n').

Example with width=30:

Lorem  ipsum  dolor  sit amet,
consectetur  adipiscing  elit.
Vestibulum    sagittis   dolor
mauris,  at  elementum  ligula
tempor  eget.  In quis rhoncus
nunc,  at  aliquet orci. Fusce
at   dolor   sit   amet  felis
suscipit   tristique.   Nam  a
imperdiet   tellus.  Nulla  eu
vestibulum    urna.    Vivamus
tincidunt  suscipit  enim, nec
ultrices   nisi  volutpat  ac.
Maecenas   sit   amet  lacinia
arcu,  non dictum justo. Donec
sed  quam  vel  risus faucibus
euismod.  Suspendisse  rhoncus
rhoncus  felis  at  fermentum.
Donec lorem magna, ultricies a
nunc    sit    amet,   blandit
fringilla  nunc. In vestibulum
velit    ac    felis   rhoncus
pellentesque. Mauris at tellus
enim.  Aliquam eleifend tempus
dapibus. Pellentesque commodo,
nisi    sit   amet   hendrerit
fringilla,   ante  odio  porta
lacus,   ut   elementum  justo
nulla et dolor.

Also you can always take a look at how justification works in your text editor or directly in HTML (css: text-align: justify).

Have fun :)
*/
function justify($str, $len) {
	$words = explode(' ', $str);
	$lines = [];
	$current_line = [];

	foreach($words as $word) {
		$test_line = implode(' ', array_merge($current_line, [$word]));

		if(strlen($test_line) <= $len) {
			$current_line[] = $word;
		} else {
			$lines[] = $current_line;
			$current_line = [$word];
		}
	}

	if(!empty($current_line)) {
		$lines[] = $current_line;
	}

	$justified_lines = [];

	for($i = 0; $i < count($lines) - 1; $i++) {
		$justified_lines[] = justify_line($lines[$i], $len);
	}

	$justified_lines[] = implode(' ', $lines[count($lines) - 1]);

	return implode("\n", $justified_lines);
}

function justify_line($line_words, $len) {
	$line_str = implode(' ', $line_words);
	$extra_spaces = $len - strlen($line_str);

	if(count($line_words) === 1) {
		return $line_words[0];
	}

	$gaps = count($line_words) - 1;
	$space = intdiv($extra_spaces, $gaps);
	$remainder = $extra_spaces % $gaps;

	$justified_line = '';

	foreach($line_words as $index => $word) {
		$justified_line .= $word;

		if($index < $gaps) {
			$justified_line .= str_repeat(' ', 1 + $space + ($index < $remainder ? 1 : 0));
		}
	}

	return $justified_line;
}
?>