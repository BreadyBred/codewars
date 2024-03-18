function sumIntervals(intervals) {
    let sortedIntervals = intervals.slice().sort((a, b) => a[0] - b[0]);
    let result = 0;
    let currentStart = sortedIntervals[0][0];
    let currentEnd = sortedIntervals[0][1];
    
    for (let i = 1; i < sortedIntervals.length; i++) {
        let interval = sortedIntervals[i];
        if (interval[0] <= currentEnd) {
            currentEnd = Math.max(currentEnd, interval[1]);
        } else {
            result += currentEnd - currentStart;
            currentStart = interval[0];
            currentEnd = interval[1];
        }
    }
    
    result += currentEnd - currentStart;
    return result;
}