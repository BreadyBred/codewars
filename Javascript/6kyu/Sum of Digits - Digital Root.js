function digitalRoot(n) {
  
  if (n.toString().length == 1)
    return n;
  
  let number;
  
  do{
    number = 0;
    for (let i = 0; i < n.toString().length; i++)
      number += parseInt(n.toString()[i]);
    n = number;
  } while (n.toString().length != 1);
  
  return n;
}