#include <iostream>
#include <string.h>
#include <unistd.h>
using namespace std;

int main(){
    int euid = geteuid();
	string command = "id " + to_string(euid);
    system(command.c_str());
	
	// Dung de pause chuong trinh
    cin.get();
    return 0;
}