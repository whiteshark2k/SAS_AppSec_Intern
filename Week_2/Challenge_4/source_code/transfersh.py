import socket
import os

def upload_file(filename, s):
    try:
        header = f"PUT /{filename} HTTP/1.1\r\nHost: transfer.sh\r\nConnection: close\r\n"
        contentLength = "Content-Length: " + str(os.path.getsize(filename)) + "\r\n\r\n"
        f = open(filename, 'rb')
        request = bytes(header + contentLength, 'utf-8') + f.read() + b'\r\n'
        s.send(request)
        print("Link download: " + s.recv(8192).decode('utf-8').split("\n")[-1])

    except Exception:
        print("File co the khong ton tai!")

def download_file(link, s):
    try:
        item = link.split("transfer.sh")[1]
        filename = "recv_" + link.split("/")[4]
        request = (
            f"GET {item} HTTP/1.1\r\nHost: transfer.sh\r\nAccept: */*\r\nConnection: close\r\n\r\n")
        s.send(bytes(request, 'utf-8'))
        
        res = b''
        while True:
            data = s.recv(8192)
            if not data:
                break
            #print(data)
            res += data
        
        body = res.split(b"\r\n\r\n", 1)[1]
        #print(body)
        f = open(filename, 'wb')
        f.write(body)
        f.close()
        print("Da luu thanh cong file " + filename)
        
    except Exception:
            print("Link co the khong dung!")
            
           
def main():
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    ipaddr = socket.gethostbyname('transfer.sh')
    s.connect((ipaddr, 80))
    s.settimeout(5)

    print("[1] Upload file")
    print("[2] Download file")
    choice = input("Nhap lua chon (1/2): ")

    if choice == '1':
        filename = input("Nhap ten file muon upload: ")
        upload_file(filename, s)
    elif choice == '2':
        link = input("Nhap link can download: ")
        #link = "http://transfer.sh/1FmSNIW/test.pdf"
        download_file(link.strip(" ").strip("\n"),s)

main()
