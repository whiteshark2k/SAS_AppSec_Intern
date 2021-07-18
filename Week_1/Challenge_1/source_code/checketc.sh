#!/bin/bash

runForTheFirstTime(){
	list_old_file=$1
	list_current_file=$2
	dir=$3
	
	if [ ! -e $list_old_file ]
	then
		find $dir -type f > $list_old_file
	fi
	
	if [ ! -e $list_current_file ]
	then
		touch $list_current_file
	fi
}

checkForNewFile(){
	list_old_file=$1
	list_current_file=$2
	
	while read -r line
	do
		exist=$(grep -w $line -m 1 $list_old_file)
		if [ ! $exist ]
		then
			fileType=$(file -i "$line" | cut -d ' ' -f 2)
			if [ "$fileType" == "text/plain;" ]
			then
				echo -e "\n$line\n" >> /var/log/checketc.log
				head -n 10 "$line" >> /var/log/checketc.log
			else
				echo -e "\n$line\n" >> /var/log/checketc.log
			fi	
		fi
	done < $list_current_file	
}

checkForDeletedFile(){
	list_old_file=$1
	list_current_file=$2
	
	while read -r line
	do
		exist=$(grep -w $line -m 1 $list_current_file)
		if [ ! $exist ]
		then
			echo -e "$line\n" >> /var/log/checketc.log
		fi
	done < $list_old_file	
}

# Init
dir='/etc'
list_old_file='/home/linhtd99/list_old_file'
list_current_file='/home/linhtd99/list_current_file'

# Create lists and write list file to list_current_file
runForTheFirstTime $list_old_file $list_current_file $dir
find $dir -type f > $list_current_file

# Time
echo -e "[Log checketc - `date +%T` `date +%D`] \n" >> /var/log/checketc.log

# New file
echo -e "=== Danh sach file tao moi ===" >> /var/log/checketc.log
checkForNewFile $list_old_file $list_current_file

# Modified File
echo -e "\n=== Danh sach file sua doi ===\n" >> /var/log/checketc.log
modifiedFile=`sudo find /etc -mmin -30`
echo $modifiedFile |sed 's/ /\n/g' >> /var/log/checketc.log
echo >> /var/log/checketc.log

# Deleted File
echo -e "\n=== Danh sach file bi xoa === \n" >> /var/log/checketc.log
checkForDeletedFile $list_old_file $list_current_file

# Write list_current_file to list_old_file
cat $list_current_file > $list_old_file

cat /var/log/checketc.log | mail -s "checketc.log" "root@localhost"