#!/bin/bash

runForTheFirstTime(){
	old=$1
	new=$2
	
	if [ ! -e $old ]
	then
		who > $old
	fi
	
	if [ ! -e $new ]
	then
		touch $new
	fi
}

# Init
old='/home/linhtd99/old'
new='/home/linhtd99/new'

runForTheFirstTime $old $new

who > $new

while read -r line
do
	exist=$(grep -w "$line" -m 1 $old | cut -d " " -f 1)
	if [ ! $exist ]
	then
		echo -e "User" "$(echo "$line" | awk '{print $1;}')" "dang nhap thanh cong vao thoi gian" "$(echo "$line" | awk '{print $4;}')" "$(echo "$line" | awk '{print $3;}')" > /var/log/sshmonitor.log
	fi
done < $new

cat /var/log/sshmonitor.log | mail -s "sshmonitor.log" "root@localhost"

cat $new > $old