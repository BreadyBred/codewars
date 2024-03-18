def solution(lst):
    ranges = []
    start = lst[0]
    for i in range(1, len(lst)):
        if lst[i] != lst[i-1] + 1:
            if start == lst[i-1]:
                ranges.append(str(start))
            elif start == lst[i-1] - 1:
                ranges.extend([str(start), str(lst[i-1])])
            else:
                ranges.append(str(start) + '-' + str(lst[i-1]))
            start = lst[i]
    if start == lst[-1]:
        ranges.append(str(start))
    elif start == lst[-1] - 1:
        ranges.extend([str(start), str(lst[-1])])
    else:
        ranges.append(str(start) + '-' + str(lst[-1]))
    return ','.join(ranges)