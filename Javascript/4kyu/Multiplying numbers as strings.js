/*
This is the first part. You can solve the second part here when you are done with this. Multiply two numbers! Simple!

    The arguments are passed as strings.
    The numbers may be way very large
    Answer should be returned as a string
    The returned "number" should not start with zeros e.g. 0123 is invalid

Note: 100 randomly generated tests!
*/
/*
For small numbers
function multiply(a, b) {
  const result = BigInt(a) * BigInt(b);
  return result.toString();
}
For big numbers
*/
function multiply(a, b) {
  let product = Array(a.length + b.length).fill(0);
  
  for (let i = a.length - 1; i >= 0; i--) {
    for (let j = b.length - 1; j >= 0; j--) {
      const tempProduct = Number(a[i]) * Number(b[j]);
      const sum = tempProduct + product[i + j + 1];
      
      product[i + j + 1] = sum % 10;
      product[i + j] += Math.floor(sum / 10);
    }
  }
  
  return product.join('').replace(/^0+/, '') || '0';
}