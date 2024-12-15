/*
Write a function which makes a list of strings representing all of the ways you can balance n pairs of parentheses
Examples

balancedParens(0) => [""]
balancedParens(1) => ["()"]
balancedParens(2) => ["()()","(())"]
balancedParens(3) => ["()()()","(())()","()(())","(()())","((()))"]
*/
function balancedParens(n) {
	const result = [];

	function generateParentheses(str, open, close) {
		if (open === 0 && close === 0) {
			result.push(str);
			return;
		}

		if (open > 0)
			generateParentheses(str + '(', open - 1, close);
		if (close > open)
			generateParentheses(str + ')', open, close - 1);
	}

	generateParentheses('', n, n);
	
	return result;
}