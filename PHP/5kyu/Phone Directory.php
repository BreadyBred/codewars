<?php
/*
John keeps a backup of his old personal phone book as a text file. On each line of the file he can find the phone number (formated as +X-abc-def-ghij where X stands for one or two digits), the corresponding name between < and > and the address.

Unfortunately everything is mixed, things are not always in the same order; parts of lines are cluttered with non-alpha-numeric characters (except inside phone number and name).

Examples of John's phone book lines:

"/+1-541-754-3010 156 Alphand_St. <J Steeve>\n"

" 133, Green, Rd. <E Kustur> NY-56423 ;+1-541-914-3010!\n"

"<Anastasia> +48-421-674-8974 Via Quirinal Roma\n"

Could you help John with a program that, given the lines of his phone book and a phone number num returns a string for this number : "Phone => num, Name => name, Address => adress"
Examples:

s = "/+1-541-754-3010 156 Alphand_St. <J Steeve>\n 133, Green, Rd. <E Kustur> NY-56423 ;+1-541-914-3010!\n"

phone(s, "1-541-754-3010") should return "Phone => 1-541-754-3010, Name => J Steeve, Address => 156 Alphand St."

    It can happen that there are many people for a phone number num, then return : "Error => Too many people: num"

    or it can happen that the number num is not in the phone book, in that case return: "Error => Not found: num"

Notes

    Codewars stdout doesn't print part of a string when between < and >

    You can see other examples in the test cases.

    JavaScript random tests completed by @matt c.
*/
function phone($strng, $num) {
    $lines = preg_split('/\r\n|\r|\n/', $strng);
    $matches = [];
    
    foreach ($lines as $line) {
        if (empty(trim($line))) continue;
        
        // Extract phone numbers that match our format
        if (preg_match('/\+(\d+-\d+-\d+-\d+)/', $line, $phoneMatch)) {
            $phoneNumber = $phoneMatch[1];
            
            if ($phoneNumber == $num) {
                if (preg_match('/<([^>]+)>/', $line, $nameMatch)) {
                    $name = trim($nameMatch[1]);
                    
                    // Get the address by removing phone number and name
                    $address = $line;
                    $address = str_replace('+' . $phoneNumber, '', $address);
                    $address = preg_replace('/<[^>]+>/', '', $address);
                    
                    // Clean the address
                    $address = preg_replace('/[^\w\s,.-]/', ' ', $address);
                    $address = str_replace('_', ' ', $address);
                    
                    // Normalize spaces
                    $address = preg_replace('/\s+/', ' ', $address);
                    $address = trim($address, " ,-");
                    
                    // Remove specific comma patterns like "city, state" by replacing with a space
                    $address = preg_replace('/,\s+(?=[A-Z]{2}-\d+|[A-Z][a-z])/', ' ', $address);
                    
                    $matches[] = [
                        'name' => $name,
                        'address' => $address
                    ];
                }
            }
        }
    }

    if (count($matches) == 0) {
        return "Error => Not found: $num";
    } elseif (count($matches) > 1) {
        return "Error => Too many people: $num";
    } else {
        return "Phone => $num, Name => {$matches[0]['name']}, Address => {$matches[0]['address']}";
    }
}
?>