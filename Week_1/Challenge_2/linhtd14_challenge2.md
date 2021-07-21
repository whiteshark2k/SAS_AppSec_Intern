# Challenge 2: Lập trình linux/sticky bit

## 1. Lý thuyết

- Cờ r, w, x:
  - r (Read): Quyền đọc 
  - w (Write): Quyền viết 
  - x: (Execute): Quyền thực thi
    - 7 = 1 + 2 + 4 = rwx
    - 6 = 2 + 4 = rw
    - 5 = 1 + 4 = rx
    - 4 = r
    - 3 = 1 + 2 = wx
    - 2 = w
    - 1 = x
- Lệnh `chown`: Thay đổi chủ sỡ hữu của file/folder
  - `chown user filename(s)` hoặc `chown user /folder`
  - `chown :group filename(s)` hoặc `chown :group /folder`
- Lệnh `chmod`: Thay đổi quyền truy cập của người dùng tới file/folder
  - `chmod 777 filename` hoặc `chmod 777 /folder`
  - 3 vị trị lần lượt là quyền truy cập của owner, owner group và other.
  - Hoặc có thể dùng: `chmod u+x filename` - thêm quyền execute cho owner
- Cờ đặc biệt **setuid**
  - Thường được sử dụng trên các file thực thi. Quyền này cho phép file được thực thi với quyền của chủ sở hữu file đó. Ví dụ: nếu một file sở hữu bởi user **root** và được set SUID bit, thì bất kể ai thực thi file, nó sẽ luôn chạy với các đặc quyền của user **root**
  - Cú pháp: `chmod u+s filename(s)`
- Cờ đặc biệt **setgid**
  - Tương tự như setuid. Quyền này cho phép file thực thi với các đặc quyền của group sỡ hữu file đó
  - Cú pháp: `chmod g+s filename(s)`
- Cờ đặc biệt **sticky bit**
  - Được dùng để ngăn chặn việc người dùng này xóa file của người dùng kia. Chỉ duy nhất owner và root mới có quyền **rename** hay **delete** file đó, vì thế còn được gọi là **restricted deletion bit**
  - Cú pháp: `chmod +t filename(s)`
- **Real UserID, Effective UserID, Saved UserID**:
  - **RUID** là UID của người dùng khởi chạy tiến trình. Nó quyết định xem tiến trình đó có thể truy cập những tệp tin nào
  - **EUID** tương tự như UID nhưng nó giúp cho hệ điều hành quyết định xem tiến trình có được phép truy cập vào tài nguyên mà chỉ người dùng root truy cập được hay không
  - **Saved UID** được sử dụng khi một tiến trình đang chạy với đặc quyền cao (root) cần thực hiện một số công việc với đặc quyền thấp. Để làm được điều này thì tiến trình tạm thời chuyển sang tài khoản đặc quyền thấp
  - Sử dụng `id` có thể lấy được **RUID** và **EUID**
- Khác biệt giữa hàm `setuid` và `seteuid`
  - If the user is root or the program is set-user-ID-root, special care must be taken. The **setuid()** function checks the effective user ID of the caller and if it is the superuser, all process-related user ID's are set to uid. After this has occurred, it is impossible for the program to regain root privileges.
  - Thus, a set-user-ID-root program wishing to temporarily drop root privileges, assume the identity of an unprivileged user, and then regain root privileges afterward cannot use **setuid()**. You can accomplish this with **seteuid**.

## 2. Bài tập thực hành

1. **Set password cho 1 user bất kỳ bằng quyền người dùng thường.** 

   - *Mô tả: có 3 user: A, B, C. Chương trình tên là: mypasswd. Khi đăng nhập bằng user A. Chạy chương trình ./mypasswd. Chương trình sẽ hỏi tên user và mật khẩu mới. Nhập tên user B (hoặc C) và mật khẩu mới 123456a@ thì mật khẩu user B (hoặc C) sẽ được đổi sang 123456a@.*

   - Source code

     ```c++
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
     ```

   - Compile: `g++ -o mypasswd mypasswd.cpp`

   - Thay đổi owner thành **root**: `sudo chown root.root mypasswd`

   - Cấp quyền **setuid**: `sudo chmod u+s mypasswd`

   - Chạy: `./mypasswd`

   - Output:

     ```bash
     alice@ubuntu:~/Desktop/C2$ ./mypasswd 
     Nhap ten user: bob
     Nhap password: BrUt3_f0rC3_m3
     New password: Retype new password: passwd: password updated successfully
     ```

2. **Có 2 user thường, chạy tiến trình bằng quyền user1 nhưng thực hiện lệnh id thì in ra thông tin user2**

   - *Mô tả: có 2 user A, B. Chương trình tên là: myid. Khi đăng nhập bằng user A. Sau đó chạy chương trình ./myid thì sẽ in ra user B. Kiểm tra tiến trình myid bằng lệnh ps thì thấy user chạy là user B*

   - Source code

     ```cpp
     #include <iostream>
     #include <string.h>
     #include <unistd.h>
     using namespace std;
     
     int main(){
         int euid = geteuid();
         string command = "id " + to_string(euid);
         system(command.c_str());
     	
         //Dung de pause chuong trinh
         cin.get();
         return 0;
     }
     ```

   - Compile: `g++ -o myid myid.cpp`

   - Thay đổi owner thành **bob**: `sudo chown bob.bob myid`

   - Cấp quyền **setuid**: `sudo chmod u+s myid`

   - Chạy: `./myid`

   - Output

     ```bash
     alice@ubuntu:~/Desktop/C2$ ./myid
     uid=1001(bob) gid=1001(bob) groups=1001(bob)
     ```

     ```bash
     alice@ubuntu:~/Desktop/C2$ ls -la
     -rwsrwxr-x 1 bob      bob      19928 Jul 19 22:39 myid
     -rw-rw-r-- 1 alice    alice      231 Jul 19 22:39 myid.cpp
     
     alice@ubuntu:~/Desktop/C2$ ps -aux | grep "./myid"
     bob        5122  0.0  0.0   6108  3112 pts/0    S+   22:40   0:00 ./myid
     ```

     

