import serial.tools.list_ports

ser = serial.Serial('/dev/cu.usbserial-B001AJAA', 9600, timeout=None,
                     parity=serial.PARITY_NONE, stopbits=serial.STOPBITS_ONE)
while 1:
    s = ser.readline(200)
    print(s)
ser.close()


print("Done")