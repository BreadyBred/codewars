def ip_to_int(ip):
    octets = ip.split('.')
    return (int(octets[0]) << 24) + (int(octets[1]) << 16) + (int(octets[2]) << 8) + int(octets[3])

def ips_between(ip1, ip2):
    int_ip1 = ip_to_int(ip1)
    int_ip2 = ip_to_int(ip2)
    return int_ip2 - int_ip1