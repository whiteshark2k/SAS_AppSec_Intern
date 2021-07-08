# The Web Application Hacker's Handbook - Second Edition - Note

## Chapter 1: Web Application (In)security

Các Web App đã phát triển từ "kho lưu trữ thông tin tĩnh" thành các ứng dụng với nhiều chức năng phức tạp để xử lý dữ liệu nhảy cảm và thực thi các tác vụ trong cuộc sống. Trong quá trình phát triển này, nhiều yếu tố đã khiến cho mặt bằng chung các Web App bảo mật kém đi. Trong hơn 100 web app được test:

- Broken Authentication (62%): Lỗ hổng trong cơ chế xác thực, có thể bị khai thác để tấn công vét cạn, guess weak password hay vượt qua xác thực.

- Broken Access Controls (71%): Lỗ hổng trong cơ chế phân quyền, có thể bị hacker khai thác để xem thông tin nhạy cảm của người dùng hoặc thực hiện thành vi vượt quyền.

- SQL Injection (32%): Lỗ hổng trong khâu kiểm tra đầu vào, có thể bị hacker khai thác để sumbit câu SQL lên back-end CSDL và thực thi ngay trên CSDL -> Có thể lấy dữ liệu, can thiệp vào logic của ứng dụng hoặc RCE.

- Cross-site Scripting (94%): Lỗ hổng này cho phép hacker tấn công phía client-side, chiếm phiên đăng nhập, ...

- Information Leakage (78%): Through defective error handling or other behavior -> lộ thông tin nhạy cảm -> bị hacker khai thác

- Cross-Site request forgery (92%): Lỗ hổng cho phép kẻ tấn công giả mạo người dùng, trang web độc hại sẽ thực hiện hành vi giả mạo quyền của người dùng mà họ không hề hay biết.

**Nguyên nhân chính**: Do người dùng có thể submit nội dung tùy ý. Input từ phía người dùng có thể là mã độc nên cần phải lọc và xem xét kĩ lưỡng.

## Chapter 2: Core Defense Mechanisms

> "The fundamental security problem with web applications — that all user input is untrusted — gives rise to a number of security mechanisms that applications use to defend themselves against attack"

Các cơ chế phòng thủ của Web App kết hợp các yếu tố cốt lỗi sau:

### Handling user access

Xử lý quyền truy cập của người dùng tới dữ liệu và các chức năng của ứng dụng để đề phòng họ có được quyền truy cập trái phép.

- Authenticaion: Cơ chế xác thực người dùng.

- Session management: Quản lý phiên.

- Access Control: Quản lý quyền truy cập.

### Handling user input

Xử lý đầu vào của người dùng đến các chức năng của Web App để ngăn đầu vào không đúng định dạng gây ra hành vi không mong muốn.

- Varieties of Input

- Approaches to Input Handling

    - "Reject Known Bad": Kiểm tra trong black-list

    - "Accept Known Good": Kiểm tra trong white-list

    - Santitization: Các kí tự nguy hiểm trong input sẽ được encoded hoặc escaped trước khi xử lý. Ví dụ HTML tag được escaped thành `&lt;` hoặc `&gt;`

    - Safe Data Handling: Sử dụng các phương pháp lập trình an toàn để tránh lỗ hổng. Ví dụ SQLi ....

    - Semantic Checks

- Boundary Validation: Mỗi đơn vị riêng biệt trên server-side sẽ tự kiểm duyệt input của mình.

- Multistep Validation and Canonicalization: Canonicalization là quá trình convert kí tự thành kí tự thông thường.  

### Handling Attackers**

Xử lý khi bị tấn công, ứng dụng sẽ đưa ra những biện pháp phòng thủ và tấn công để ngăn cản hacker.

- Handling errors: Xử lý các unexpected errors cẩn thận và in ra thông báo lỗi phù hợp tới người dùng, không được trả về thông điệp hệ thống hoặc thông tin debug.

- Maintaining audit logs: Logs dùng để phát hiện và điều tra các xâm nhập trái phép vào ứng dụng. Audit Logs hiệu quả thường ghi lại thời gian mỗi sự kiện, địa chỉ IP của request và tài khoản người dùng (nếu đã đăng nhập)

- Alerting Administrators: Các cơ chế cảnh báo cho admin phải chính xác, tin cậy và không tạo quá nhiều cảnh báo khiến chúng có thể bị bỏ qua

- Reacting to attacks

### Managing the Application

Quản lý ứng dụng bằng cách cho phép quản trị viên giám sát hoạt động của nó.

## Chapter 3: Web Application Technologies

The HTTP Protocol

Web Functionality

Encoding Schemes

## Chapter 4: Mapping the Application

### Enumerating Content and Functionality

- Duyệt toàn bộ nội dung của trang web.

Web spidering

- Gửi request, nhận response, lưu lại đường dẫn và lặp lại liên tục -> Duyệt toàn bộ đường dẫn.
- Kiểm tra file robots.txt -> Đôi khi chứa các đường dẫn nhạy cảm.
- Spider cần có token phiên để duyệt -> Nhiều lúc bị chặn
- Spider có thể nguy hiểm trong một vài trường hợp, bị xóa tài khoản, tắt CSDL, ...

User-Directed Spidering

- Duyệt các đường dẫn thủ công nhưng proxy sẽ lưu lại các request/response.
- Lợi ích:
    - Có thể handle được những web app sử dụng cơ chế điều hướng không bình thường.
    - Người dùng kiểm soát được input
    - Người dùng có thể login và để trình duyệt kiểm soát tokens
    - Có thể tránh được các đường dẫn độc hại

Discovering Hidden Content

- Có những đường dẫn, tệp tin, nội dung thú vị nhưng spider không tìm thấy được như:
    - Các bản backup của file, có thể chứa source code
    - Các bản backup lưu trữ, có thể chứa sitemaps hoặc code snapshot, ...
    - Các chức năng mới đã được deploy trên server nhưng chưa được công khai
    - Các chức năng mặc định của ứng dụng web
    - Các phiên bản cũ của file
    - Các file config, có thể chứa dữ liệu nhạy cảm
    - Comment trong source code
    - File logs, có thể chưuas thông tin nhạy cảm.

- Brute-Force Techniques
    - Không phải code `200 OK` là tìm thấy và `404 Not Found` là không tìm thấy
    - `302 Found` - Nếu được điều hướng đến trang login tức là nội dung này cần phải được xác thực mới xem đc
    - `401 Unathorized` và `403 Forbidden` - Không truy cập được bởi người dùng
    - `500 Internal Server Error` - Có nghĩa có tham số chưa được submit

- Inference from Published Content
    - Một số ứng dụng web sử dụng các `naming scheme` cho các nội dung và chức năng -> lợi dụng điều đó để tìm kiếm thêm thông tin
    - Để ý cách devs sử dụng và viết tắt các từ và biến

- Use of public Information
    - Một số đường dẫn có thể tồn tại trong quá khứ còn giờ thì không, để tìm kiếm các đường dẫn này có thể sử dụng các công cụ tìm kiếm hoặc waybackmachine
    - Tìm kiếm các hãng thứ 3 tương tác với mục tiêu
    - Tìm kiếm thông tin về devs trên google hoặc các diễn đàn

- Leveraging the web server
    - Có thể khai thác các lỗ hổng để thu thập được thông tin
    - Sử dụng nikto

Application Pages Versus Functional Paths

- Xác định các trường hợp mà tên chức năng được truyền vào tham số. Ví dụ: `/admin.jsp?action=editUser`
- Xây dựng list các chức năng dựa trên đường dẫn như trên.

Discovering Hidden Parameters

- `debug=true`
- Sử dụng danh sách các tham số debug (debug, test, hid, source, ...) và các giá trị (true, yes, on, 1, ...)

### Analyzing the Application



## Chapter 5: Bypassing Client-Side Controls

## Chapter 6: Attacking Authentication

## Chapter 7: Attacking Session Management

## Chapter 8: Attacking Access Controls

## Chapter 9: Attacking Data Stores

## Chapter 10: Attacking Back-End Components

## Chapter 11: Attacking Application Logic

## Chapter 12: Attacking Users: Cross-Site Scripting

## Chapter 13: Attacking Users: Other Techniques

## Chapter 14: Automating Customized Attacks

## Chapter 15: Exploiting Information Disclosure

## Chapter 16: Attacking Native Compiled Application

## Chapter 17: Attacking Application Architecture

## Chapter 18: Attacking the Application Server

## Chapter 19: Finding Vulnerabilities in Source Code

## Chapter 20: A Web Application Hacker's Toolkit

## Chapter 21: A Web Application Hacker's Methodology