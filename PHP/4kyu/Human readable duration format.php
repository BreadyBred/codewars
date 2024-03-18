function format_duration($seconds) {
    if ($seconds == 0)
        return "now";

    $intervals = array(
        array('year', 365 * 24 * 3600),
        array('day', 24 * 3600),
        array('hour', 3600),
        array('minute', 60),
        array('second', 1)
    );

    $parts = array();
    foreach ($intervals as $interval) {
        list($name, $duration) = $interval;
        $count = intval($seconds / $duration);
        $seconds %= $duration;
        if ($count)
            $parts[] = "{$count} {$name}" . ($count > 1 ? 's' : '');
    }

    return implode(', ', array_slice($parts, 0, -1))
        . (count($parts) > 1 ? ' and ' : '')
        . end($parts);
}