# In this example you have to validate if a user input string is alphanumeric. The given string is not nil/null/NULL/None, so you don't have to check that.
# 
# The string has the following conditions to be alphanumeric:
# 
#     At least one character ("" is not valid)
#     Allowed characters are uppercase / lowercase latin letters and digits from 0 to 9
#     No whitespaces / underscore

.global alphanum

# A0 <bool> alphanum(A0 <const char *> s)
alphanum:
    lbu t0, 0(a0)
    beqz t0, return_false

check_loop:
    lbu t0, 0(a0)

    beqz t0, return_true

    li t1, 48    # '0'
    blt t0, t1, return_false
    li t1, 57    # '9'
    ble t0, t1, next_char

    li t1, 65    # 'A'
    blt t0, t1, return_false
    li t1, 90    # 'Z'
    ble t0, t1, next_char

    li t1, 97    # 'a'
    blt t0, t1, return_false
    li t1, 122   # 'z'
    bgt t0, t1, return_false

next_char:
    addi a0, a0, 1
    j check_loop

return_false:
    li a0, 0
    ret

return_true:
    li a0, 1
    ret