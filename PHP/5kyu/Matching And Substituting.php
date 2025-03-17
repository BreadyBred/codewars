<?php
/*
I got lots of files beginning like this:

Program title: Primes
Author: Kern
Corporation: Gold
Phone: +1-503-555-0091
Date: Tues April 9, 2005
Version: 6.7
Level: Alpha

Here we will work with strings like the string data above and not with files.

The function change(s, prog, version) given:

s=data, prog="Ladder" , version="1.1" will return:

"Program: Ladder Author: g964 Phone: +1-503-555-0090 Date: 2019-01-01 Version: 1.1"

Rules:

    The date should always be "2019-01-01".

    The author should always be "g964".

    Replace the current "Program Title" with the prog argument supplied to your function. Also remove "Title", so in the example case "Program Title: Primes" becomes "Program: Ladder".

    Remove the lines containing "Corporation" and "Level" completely.

    Phone numbers and versions must be in valid formats.

A valid version in the input string data is one or more digits followed by a dot, followed by one or more digits. So 0.6, 5.4, 14.275 and 1.99 are all valid, but versions like .6, 5, 14.2.7 and 1.9.9 are invalid.

A valid input phone format is +1-xxx-xxx-xxxx, where each x is a digit.

    If the phone or version format is not valid, return "ERROR: VERSION or PHONE".

    If the version format is valid and the version is anything other than 2.0, replace it with the version parameter supplied to your function. If it’s 2.0, don’t modify it.

    If the phone number is valid, replace it with "+1-503-555-0090".

Note

    You can see other examples in the "Sample tests".
*/
function change($s, $prog, $version) {
    $valid_phone = false;
    $valid_version = false;
    $result = [];
    $lines = explode("\n", $s);
    
    foreach ($lines as $line) {
        if (trim($line) === '') {
            continue;
        }
        
        if (preg_match('/^Program title:/i', $line)) {
            $result['program'] = "Program: " . $prog;
        }
        else if (preg_match('/^Author:/i', $line)) {
            $result['author'] = "Author: g964";
        }
        else if (preg_match('/^Phone:/i', $line)) {
            if (preg_match('/^Phone:\s+(\+1-\d{3}-\d{3}-\d{4})$/i', $line, $matches)) {
                $valid_phone = true;
                $result['phone'] = "Phone: +1-503-555-0090";
            }
        }
        else if (preg_match('/^Date:/i', $line)) {
            $result['date'] = "Date: 2019-01-01";
        }
        else if (preg_match('/^Version:/i', $line)) {
            if (preg_match('/^Version:\s+(\d+\.\d+)$/i', $line, $matches)) {
                if (preg_match('/^\d+\.\d+$/', $matches[1])) {
                    $valid_version = true;
                    $current_version = $matches[1];
                  
                    if ($current_version === "2.0") {
                        $result['version'] = "Version: 2.0";
                    } else {
                        $result['version'] = "Version: " . $version;
                    }
                }
            }
        }
    }
    
    if (!$valid_phone || !$valid_version) {
        return "ERROR: VERSION or PHONE";
    }
    
    $ordered_keys = ['program', 'author', 'phone', 'date', 'version'];
    $ordered_result = [];

    foreach ($ordered_keys as $key) {
        if (isset($result[$key])) {
            $ordered_result[] = $result[$key];
        }
    }
    
    return implode(" ", $ordered_result);
}
?>