#!/bin/bash

echo "[Thong tin he thong]"
echo "Ten may: `hostname`"
#echo "Ten ban phan phoi: `head -1 /etc/issue | cut -d '\' -f 1`"
echo "Ten ban phan phoi: `egrep '^(NAME)=' /etc/os-release | cut -d '"' -f 2`"
echo "Phien ban he dieu hanh: `egrep '^(VERSION)=' /etc/os-release | cut -d '"' -f 2`"
echo 
echo "[Thong tin CPU]"
echo "Ten: `egrep -m1 '^model name' /proc/cpuinfo | cut -d ":" -f 2 `"
echo "Toc do: `egrep -m1 '^cpu MHz' /proc/cpuinfo | cut -d ":" -f 2 ` MHz"
echo "Kien truc: `uname -m`"
echo 
echo "[Dung luong trong tren o dia]"
echo "`df -t ext4 -h --output=source,avail`"
echo
echo "[Thong tin mang]"
echo "`ifconfig | grep 'inet'`"
echo
echo "[Danh sach user]"
echo "`cut -d : -f 1 /etc/passwd | sort`"
echo
echo "[Cac tien trinh dang chay voi quyen root]"
echo "`ps -U root -u root -o comm= | sort`"
echo
echo "[Cac port dang mo]"
echo "`netstat -tuwanp4 2>/dev/null | awk '{print $4}' | grep ':' | cut -d ":" -f 2 | sort -n | uniq`"
echo 
echo "[Danh sach cac thu muc tren he thong cho phep other co quyen ghi]"
echo "`sudo find / -type d -perm /o=w`"
echo
echo "[Danh sach cac goi phan mem duoc cai dat tren he thon]"
echo "`dpkg -l | awk '{printf("%-50s %-10s\n",$2,$3);};'`"