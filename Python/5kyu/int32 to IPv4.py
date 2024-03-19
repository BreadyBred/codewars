def int32_to_ip(num):
    binary = bin(num)[2:].zfill(32)
    octets = [binary[i:i+8] for i in range(0, 32, 8)]
    decimal_octets = [int(octet, 2) for octet in octets]
    
    return '.'.join(map(str, decimal_octets))