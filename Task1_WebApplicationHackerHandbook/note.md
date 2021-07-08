# The Web Application Hacker's Handbook - Second Edition

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

- **Handling user access**: Xử lý quyền truy cập của người dùng tới dữ liệu và các chức năng của ứng dụng để đề phòng họ có được quyền truy cập trái phép.

- **Handling user input**: Xử lý đầu vào của người dùng đến các chức năng của Web App để ngăn đầu vào không đúng định dạng gây ra hành vi không mong muốn.

- **Handling Attackers**: Xử lý khi bị tấn công, ứng dụng sẽ đưa ra những biện pháp phòng thủ và tấn công để ngăn cản hacker.

- **Managing the Application**: Quản lý ứng dụng bằng cách cho phép quản trị viên giám sát hoạt động của nó.

### 1. Handling User Access

Có thể quản lý quyền truy cập của người dùng thông qua bộ ba cơ chế:

#### 1.1. Authenticaion

> Authenticating a user involves establishing that the user is in fact who he claims to be. Without this facility, the application   would need to treat all users as anonymous — the lowest possible level of trust.

#### 1.2. Session management

> After successfully logging in to the application, the user accesses various pages and functions, making a series of HTTP requests from his browser. At the same time, the application receives countless other requests from different users, some of whom are authenticated and some of whom are anonymous. To enforce effective access control, the application needs a way to identify and process the series of requests that originate from each unique user.

> Virtually all web applications meet this requirement by creating a session for each user and issuing the user a token that identifi es the session. The session itself is a set of data structures held on the server that track the state of the user’s interaction with the application. The token is a unique string that the application maps to the session.

#### 1.3. Access Control

> An application might support numerous user roles, each involving different combinations of specific privileges. Individual users may be permitted to access a subset of the total data held within the application. Specific functions may implement transaction limits and other checks, all of which need to be properly enforced based on the user’s identity

### 2. Handling user input

#### 2.1. Varieties of Input

#### 2.2. Approaches to Input Handling

> "Reject Known Bad"

> "Accept Known Good"

> Santitization

> Safe Data Handling

> Semantic Checks

#### 2.3. Boundary Validation

#### 2.4. Multistep Validation and Canonicalization

### 3. Handling Attackers

#### 3.1. Handling errors

#### 3.2. Maintaining audit logs

#### 3.3. Alerting Administrators

#### 3.4. Reacting to attacks

### 4. Managing the Application

## Chapter 3: Web Application Technologies

### 1. The HTTP Protocol

### 2. Web Functionality

### 3. Encoding Schemes

## Chapter 4: Mapping the Application

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