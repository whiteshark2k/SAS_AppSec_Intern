#include <iostream>
#include <bits/stdc++.h>
using namespace std;

int main(){
    string user = "";
    string password = "";

    cout << "Nhap ten user: ";
    getline(cin, user);
    
    cout << "Nhap password: ";
    getline(cin, password);
    
    string command = "sudo echo -e '" + password + "\\n" + password + "' | " + "sudo passwd " + user;
    
    system(command.c_str());
    return 0;
}