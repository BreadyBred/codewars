# Task
# Write a function that checks if two non-negative integers make an "interlocking binary pair".
# Interlock ?
#     numbers can be interlocked if their binary representations have no 1's in the same place
#     comparisons are made by bit position, starting from right to left (see the examples below)
#     when representations are of different lengths, the unmatched left-most bits are ignored
# 
# Examples
#     a = 9, b = 4
#     Stacking representations shows how they can interlock.
#      9    1001
#      4     100
#
#     Here, no 1's share any position, so the function returns true.
#     a = 3, b = 6
# 
#     These representations do not interlock.
#      3      11
#      6     110
# 
#     Finding they both have a 1 in the same position, the function returns false.
# 
# Input
# Two non-negative integers.
#
# Output
# Boolean true or false whether or not these integers are interlockable.
#
# Enjoy!

.global interlockable
# <-- A0 <bool> interlockable(A0 <unsigned long long> a, A1 <unsigned long long> b) -->
interlockable:
    # If both numbers are 0, they are interlockable
    beqz a0, interlockable_true
    beqz a1, interlockable_true

check_bits_loop:
    beqz a0, interlockable_true
    beqz a1, interlockable_true

    # Extract least significant bit from each number
    andi t0, a0, 1
    andi t1, a1, 1

    # If both bits are 1, not interlockable
    and t2, t0, t1
    bnez t2, interlockable_false

    # Shift both numbers right
    srli a0, a0, 1
    srli a1, a1, 1

    j check_bits_loop

interlockable_true:
    li a0, 1
    ret

interlockable_false:
    li a0, 0
    ret