/*
Write a function which receives 4 digits and returns the latest time of day that can be built with those digits.

The time should be in HH:MM format.

Examples:

digits: 1, 9, 8, 3 => result: "19:38"
digits: 9, 1, 2, 5 => result: "21:59" (19:25 is also a valid time, but 21:59 is later)

Notes

    Result should be a valid 24-hour time, between 00:00 and 23:59.
    Only inputs which have valid answers are tested.
*/
function latestClock(a, b, c, d) {
    const digits = [a, b, c, d];

    let maxTime = -1;
    let maxTimeStr = "";

    const perms = permute(digits);

    for (const perm of perms) {
        const hours = perm[0] * 10 + perm[1];
        const minutes = perm[2] * 10 + perm[3];

        if (hours < 24 && minutes < 60) {
            const currTime = hours * 60 + minutes;
            if (currTime > maxTime) {
                maxTime = currTime;
                maxTimeStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
            }
        }
    }
  
    return maxTimeStr;
}

function permute(arr) {
    if (arr.length === 1)
        return [arr];

    const result = [];

    for (let i = 0; i < arr.length; i++) {
        const val = arr[i];
        const copy = arr.slice(0, i).concat(arr.slice(i + 1));

        const perms = permute(copy);

        for (const perm of perms)
            result.push([val, ...perm]);
    }

    return result;
}
