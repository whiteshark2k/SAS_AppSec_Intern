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

### Handling Attackers

Xử lý khi bị tấn công, ứng dụng sẽ đưa ra những biện pháp phòng thủ và tấn công để ngăn cản hacker.

- Handling errors: Xử lý các unexpected errors cẩn thận và in ra thông báo lỗi phù hợp tới người dùng, không được trả về thông điệp hệ thống hoặc thông tin debug.

- Maintaining audit logs: Logs dùng để phát hiện và điều tra các xâm nhập trái phép vào ứng dụng. Audit Logs hiệu quả thường ghi lại thời gian mỗi sự kiện, địa chỉ IP của request và tài khoản người dùng (nếu đã đăng nhập)

- Alerting Administrators: Các cơ chế cảnh báo cho admin phải chính xác, tin cậy và không tạo quá nhiều cảnh báo khiến chúng có thể bị bỏ qua

- Reacting to attacks

### Managing the Application

Quản lý ứng dụng bằng cách cho phép quản trị viên giám sát hoạt động của nó.

## Chapter 3: Web Application Technologies

### The HTTP Protocol

### Web Functionality

### Encoding Schemes

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

Key areas to investigate

- Chức năng chính của úng dụng
- Off-site links, thông báo lỗi, admin/logging fuctions, use of redirects
- Các cơ chế bảo mật như quản lý phiên, quản lý truy cập, cơ chế xác thực, supporting logic (đăng kí, thay đổi mật khẩu, khôi phục tài khoản)
- Toàn bộ vị trí nhận input từ người dùng
- Công nghệ, nền tảng mà phía client-side sử dụng.
- Công nghệ, nền tảng mà phía server-side sử dụng.

Identifying Entry Points for User Input

- Key locations
    - Every URL String up to the query string marker
    - Every parameter submitted within the URL query string
    - Every parameter submitted within the body of a `POST` request
    - Every cookie
    - Every other HTTP header that the application might process - `User-Agent,Referer,Accept, Accept-Language,Host` headers
- URL File Paths
    - REST-style URLs có thể dùng để truy vấn dữ liệu. Ví dụ: `http://eis/shop/browse/electronics/iPhong3G/`, `electronic` và `iPhone3G` should be treated as parameters to store a search function
- Request Parameters
    - Request Parameter đôi khi không sử dụng format `name=value`
    - Một số nonstandard parameter formats:
        - `/dir/file;foo=bar&foo2=bar2`
        - `/dir/file?foo=bar$foo2=bar2`
        - `/dir/file/foo%3dbar%26foo2%3dbar2`
        - `/dir/foo.bar/file`
        - `/dir/foo=bar/file`
        - `/dir/file?param=foo:bar`
        - `/dir/file?data=%3cfoo%3ebar%3c%2ffoo%3e%3cfoo2%3ebar2%3c%2ffoo2%3e`
- HTTP Headers
    - Nhiều web app sử dụng HHTP header như `Referer` hay `User-Agent` và 2 header này cần phải được kiểm tra đầu vào.
    - Một số Web app sẽ xử lý header `Referer` sâu hơn để xác định người người dùng đến từ trang nào.
    - Header `User-Agent` cho biết thông tin về thiết bị của ngườ dùng.
    - Header `X-Forwarded-For` có thể cung cấp địa chỉ IP
- Out-of-Band Channels
    - A web mail application that processes and renders email messeages received via SMTP
    - A publishing application that contains a function to retrieve content via HTTP from another server.
    - An intrusion detection application that gathers data using a network sniffer and presents this using a web application interface
    - Any kind of application thajt provides an API interface for use by non-browser user agents

Identifying Server-Side Technologies

- Banner Grabbing
    - HTTP `server` header đôi khi cung cấp rất nhiều thông tin hữu ích
    - Ngoài ra có thể tìm đƯợc thông tin trong:
        - Templates used to build HTML pages
        - Custom HTTP headers
        - URL query string parameters
- HTTP Fingerprinting
    - In principle, any item of information returned by the server may be customized or even deliberately falsified, and banners
    like the Server header are no exception.
    - Httprecon
- File Extensions
    - `ASP` = Microsoft Active Server Pages
    - `ASPX` = Microsoft ASP.NET
    - `JSP` = Java Server Pages
    - `CFM` = Cold fusion
    - `PHP` = The PHP lang
    - `D2W` = WebSphere
    - `PL` = the Perl lang
    - `PY` = python lang
    - `DLL` = usually compiled native code (c or c++)
    - `NSF` or `NTF` = Lotus Domino
- Directory Names
    - `servlet` = Java servlets
    - `pls` = Oracle Application Server PL/SQL gateway
    - `cfdocs` or `cfide` = Cold Fusion
    - `SilverStream` = The SilverStream web server
    - `WebObjects` or `{function}.woa` = Apple WebObjects
    - `rails` = Ruby on Rails
- Session Tokens
    - `JSESSIONID` = The Java Platform
    - `ASPSESSIONID` = Microsoft IIS Server
    - `ASP.NET_SessionId` = Microsft ASP.NET
    - `CFID/CFTOKEN` = Cold Fusion
    - `PHPSESSID` = PHP
- Third-Party Code Components
    - Một số web app dùng code của ứng dụng thứ 3 cho chức năng như giỏ hàng, đăng nhập, ... Code này có thể tải về test local.

Identifying Server-Side Functionality

- Dissecting Requests
    - URL có thể cung cấp nhiều thông tin nhạy cảm như frameworks, debug options, database, ...
- Extrapolating Application Behavior
    - Một số chức năng và code có thể được tái sử dụng, có nghĩa là có thể sử dụng chức năng/code đó trên toàn bộ ứng dụng web
    - Ví dụ nếu tìm thấy lỗ hổng trong code tại 1 vị trí thì có thể khai thác trên toàn bộ ứng dụng
    - Một số phần của web app xử lý lỗi cẩn thận nhưng một số thì lại không
- Isolating Unique Application Behavior

Mapping the Attack Surface

- Client-side validation — Checks may not be replicated on the server
- Database interaction — SQL injection
- File uploading and downloading — Path traversal vulnerabilities, stored cross-site scripting
- Display of user-supplied data — Cross-site scripting
- Dynamic redirects — Redirection and header injection attacks
- Social networking features — username enumeration, stored cross-site scripting
- Login — Username enumeration, weak passwords, ability to use brute force
- Multistage login — Logic flaws
- Session state — Predictable tokens, insecure handling of tokens
- Access controls — Horizontal and vertical privilege escalation
- User impersonation functions — Privilege escalation
- Use of cleartext communications — Session hijacking, capture of credentials and other sensitive data
- Off-site links — Leakage of query string parameters in the Referer header
- Interfaces to external systems — Shortcuts in the handling of sessions and/or access controls
- Error messages — Information leakage
- E-mail interaction — E-mail and/or command injection
- Native code components or interaction — Buffer overfl ows
- Use of third-party application components — Known vulnerabilities
- Identifi able web server software — Common confi guration weaknesses, known software bugs

### Summary

Core Methodology

- Mannual browsing and user-directed spidering to enumerate the application’s visible content and functionality
- Use of  brute force combined with human inference and intuition to discover as much hidden content as possible
- An intelligent analysis of the application to identify its key functionality, behavior, security mechanisms, and technologies
- An assessment of the application’s attack surface, highlighting the most promising functions and behavior for more focused probing into exploitable vulnerabilities

## Chapter 5: Bypassing Client-Side Controls

### Transmitting Data Via the Client

Hidden Form Fields

- Hidden HTML form là các form có type=hidden, sẽ ko hiển thị on-screen để người dùng có thể sửa tuy nhiên có thể dùng proxy để chặn bắt và sửa form hidden.

HTTP Cookies

- Tương tự Hidden form, không hiển thị on-screen nhưng có thể dùng proxy để chặn bắt và sửa.

URL Parameters

- Tương tự, một số web app dùng URL để transmit data ví dụ `http://mdsec.net/shop/?prod=3&pricecode=32` có thể dùng proxy để bắt chặn và sửa.

The Referer Header

- Dùng để kiểm tra xem người dùng có đến từ trang nhất định không, ví dụ để devs kiểm tra xem người dùng gửi yêu cầu resetPasword có đến từ trang admin.ashx hay không
- Có thể sửa để lập tức resetPassword mà không cần phải qua trang admin.ashx

Opaque Data

- Dữ liệu đôi khi được mã hóa hoặc obfuscate (làm nhiễu)

The ASP.NET ViewState

- ASP.NET sử dụng cơ chế transmit opaque data via client gọi là ViewState
- ViewState là một hidden field đc tạo ra mặc định, chứa thông tin về trạng thái của page đã được serialized.
- ViewStata parameter is actually a Base64-encoded string
- By default, the ASP.NET platform protects the ViewState from tampering by adding a keyed hash to it (known as MAC protection)

### Capturing User Data: HTML Forms

- Devs có thể thực thi các chính sách và kiểm duyệt input mà người dùng gửi lên thông qua HTML Forms. Tuy nhiên vẫn có thể bypass các chính cách hay cơ chế kiểm duyệt này

Length Limits

- `Quantity: <input type=”text” name=”quantity” maxlength=”1”> <br/>` trình duyệt sẽ ko cho người dùng nhập quá 1 kí tự vào input field, tuy nhiên có thể chặn bắt và sửa thuộc tính maxlength

Script-Based Validation

- Có thể disable JavaScript, tuy nhiên có thể break trang web
- Còn cách khác là nhập giá trị "known good" vào form, submit sau đó chặn bắt và sửa lại thành giá trị mong muốn.

Disabled Elements

- Nếu phần tử của HTML form đƯợc gắn cờ là disabled thì sẽ ko được gửi lên server.
- Phần tử này có thể được dùng trong quá khứ và giờ vẫn hữu ích

### Capturing User Data: Browser Extensions

Common Browser Extension Technologies

- Được biên dịch thành intermediate bytecode
- Được thực thi trong máy ảo cung cấp môi trường sandbox
- Có thể sử dụng remoting framework để serialization để transmit cấu trúc dữ liệu phức tạp hoặc đối tượng qua HTTP
- Một số extension technologies: java, flash, silverlight

Approaches to Browser Extensions

- Có thể chặn bắt request/response của Extensions
- Có thể decompile bytecode để phân tích

Intercepting Traffic from Browser Extensions

- Sử dụng proxy để chặn bắt
- Handling Serialized Data
    - Dữ liệu được serialized để transmit
    - Không được phá vỡ format khi de-serializing
    - Java Serialized object = `Content-Type: application/x-java-serialized-object`
    - Flash Serialized object = `Content-Type: application/x-amf`
    - Silverlight Serialization = `Content-Type: application/soap+msbin1`
    - Tool: BurpSuite -> DSer
- Obstacles to Intercepting Traffic from Browser Extensions

Decompiling Browser Extensions

- Downloading the Bytecode
- Decompiling the Bytecode
- Working on the source code
- Coping with bytecode obfuscation

Attaching a Debugger

- Tool: JavaSnoop

Native Client Components

- Tool: OllyDbg vs IDA Pro

### Handling Client-Side Data Securely

Transmitting Data Via the Client

- Nếu dev cần gửi dữ liệu từ client thì phải signed hoặc mã hóa để tránh dữ liệu bị giả mạo.
- Tuy nhiên việc sign/mã hóa có 2 vấn đề:
    - Một số dữ liệu có thể bị giả mạo bằng kĩ thuật replay attack
    - Nếu biết bản rõ và bản mã -> có thể tìm được hệ mật để tấn công

Validating Client-Generated Data

- Dữ liệu từ phía người dùng luôn có thể là độc hại dù cho sử dụng bất cứ cơ chế nào đi nữa
- Cách an toàn nhất là kiểm duyệt mọi dữ liệu trên server-side

Logging and Alerting

- Các hoạt động khả nghi phải được ghi lại
- Các cảnh báo nên đc đưa ra trong thời gian thực
- Nếu phát hiện hành vi nguy hiểm thì nên ngắt phiên người dùng.

## Chapter 6: Attacking Authentication

### Authentication Technologies

- HTML forms-based authentication
- Multifactor mechanisms, such as those combining passwords and physical tokens
- Client SSL certificates and/or smartcards
- HTTP basic and digest authentication
- Windows-integrated authentication using NTLM or Kerberos
- Authentication services

### Design Flaws in Authentication Mechanisms

Bad Passwords

- Very short or blank
- Common dictionary words or names
- The same as the username
- Still set to a default value

Brute-Forcible Login

- Không giới hạn số lần nhập -> bị brute force

Verbose Failure messages

- Thông điệp lỗi cho biết rõ là username hay password ko hợp lệ -> tạo điều kiện brute force

Vulnerable Transmission of Credentials

- Nếu web app sử dụng HTTP thì có thể bị nghe trộm, evasdroppers có thể nằm tại:
    - Mạng LAN của user
    - User's IT department
    - User's ISP
    - Internet backbone
    - The ISP hosting the application
    - IT department managing the application
- Kể cả nếu sử dụng HTTPS thì chưa chắc an toàn:
    - Credentials được transmit dưới dạng string có thể sẽ được lưu trong lịch sử duyệt web, logs, ... Kẻ tấn công nếu chiếm được nguồn lưu trữ này thì có thể trích xuất ra credentials
    - Một số app lưu trữ credentials trong cookie
    - `302` Redirect URL without user knowledge

Password Change Functionality

- Thông điệp lỗi cung cấp thông tin người dùng ko hợp lệ hay ko
- Không giới hạn lần đoán trường "existing password"
- Chỉ kiểm tra 2 trường "new password" và "confirm new password" sau khi đã kiểm tra trường "old password" có đúng hay không -> có thểb ị khai thác.

Forgotten Password Functionality

- Có thể chiếm quyền điều khiển tài khoản
- Câu hỏi bảo mật không an toàn
- Có thể bị khai thác tính năng "hint"
- OTP hoặc challenges có thể bị khai thác

"Remember Me" Functionality

- Có thể bị khai thác khi kiểm tra cookie cho người dùng có tồn tại hay ko
- Cookie có thể là ID chứ không phải username, ID này có thể bị đoán được
- Cookie có thể bị chiếm được bằng kĩ thuật XSS

User Impersonation Functionality

- Một số app cho phép admin quản lý tài khoản người dùng, chức năng này có thể bị khai thác:
    - Có thể chức năng này ẩn nhưng không được bảo vệ
    - Có thể tin tưởng người dùng thông qua cookie
    - Có thể bị khai thác leo thang đqcj quyền
    - Backdoor

Incomplete Validation of Credentials

- Một số web app chỉ cắt/sử dụng x kí tự trong cred
- Một số web app không phân biệt chữ hoa và thường
- Một số web app loại bỏ đi kí tự đặc biệt

Nonunique Usernames

- Nếu 2 user có chung username nhưng khác mật khẩu thì có thể bị break
- Dễ dàng bị brute force

Predictable Usernames

- Username sinh tự động có thể bị đoán (VD cust5331, cust5332, ...)

Predictable Initial Passwords

- Password sinh tự động có thể bị đoán

Insecure Distribution of Credentials

- SMS hoặc URLs kích hoạt tài khoản không bị hạn chế về thời gian sử dụng, ... 

### Implementation Flaws in Authentication

Fail-Open Login Mechanisms

- Phía back-end không xử lý lỗi kĩ lưỡng nên khi người dùng sumbit input gây lỗi có thể được xác thực.

Defects in Multistage Login Mechanisms

- Một vài quá trình trong cơ chế xác thực không an toàn

Insecure Storage of Credentials

- Password không được mã hóa hoặc mã hóa yếu trong CSDL

### Securing Authentication

Use Strong Credentials

- Yêu cầu mật khẩu đáp ứng khắt khe các tiêu chí an toàn
- Usernames phải độc nahats
- Các creds do hệ thống sinh tự động phải chứa entropy

Handle Credentials Secretively

- Dữ liệu transmit phải được bảo vệ
- Creds phải được mã hóa và transmit an toàn

Validate Credentials Properly

- Passwords should be validated in full
- The application should be aggressive in defending itself against unexpected events occurring during login processing
- All authentication logic should be closely code-reviewed
- Multistage logins should be strictly controlled

Prevent Information Leakage

- Không trả về thông điệp báo lỗi chi tiết mà chỉ là thông báo chung để tránh bị enumeration
- Enumeration cũng có thể diễn ra theo các cách khác
- Nếu giới hạn lần thử thì cũng không nên cho phép người dùng biết giới hạn là bao nhiêu để chặn automation

Prevent Brute-Force Attacks

Prevent Misuse of the Password Change Function

- Chỉ cho phép sử dụng chức năng sau khi đã được xác thực.
- Yêu cầu xác thực lại lần nữa để tránh XSS
- Nên thông báo cho người dùng qua email, ...

Prevent Misuse of the Account Recovery Function

- Không nên sử dụng tính năng "hint"

Log, Monitor, and Notify

## Chapter 7: Attacking Session Management

### The Need for State

- HTTP = Stateless
- Session token được gán với người dùng duy nhất
- Tuy nhiên có 2 điểm yếu:
    - Điểm yếu trong khâu sinh session token
    - Điểm yếu trong khâu xử lý session token

Alternatives to Sessions

- HTTP Authentication - trình duyệt sẽ submit cred mỗi lần request
- Sessionless state mechanisms - App gửi tất cả các dữ liệu cần thiết 1 lần duy nhất trong "binary blob"

### Weaknesses in Token Generation

- Token yếu, dễ đoán hoặc ko đc quản lý an toàn có thể bị khai thác không chỉ để login mà còn:
    - Khôi phục password
    - Token trong hidden form fields tránh CSRF
    - Token trong chức năng "Remember me"

Meaningful Tokens

- Token có nghĩa - là một phần của thông tin người dùng mã hóa...

Predictable Tokens

- Sequential tokens
- Concealed sequences
- Time dependancy
- Weak random number generation

Encrypted Tokens

- Token có thể bị giải mã nếu sử dụng thuật toán yếu

### Weaknesses in Session Token Handling

Disclosure of Tokens on the Network

- Kĩ thuật tấn công Man-in-the-Middle có thể chiếm được token

Disclosure of Tokens in Logs

- Nếu web app chứa lỗ hổng LFI thì có thể bị chiếm đc token

Vulnerable Mapping of Tokens to Sessions

- Lỗ hổng trong khâu ánh xạ token sang phiên
- Token tĩnh, không được hủy bỏ sau khi phiên kết thúc có thể bị khai thác

Vulnerable Session Termination

- Lỗ hổng trong khâu kết thúc phiên, ví dụ như đăng xuất, ...

Client Exposure to Token Hijacking

- Client bị tấn công XSS chiếm token
- Client bị tấn công CSRF chiếm token

Liberal Cookie Scope

### Securing Session Management

Generate Strong Tokens

- Use an extremely large set of possible values
- Contain a strong source of pseudorandomness, ensuring an even and unpredictable spread of tokens across the range of possible values
- Examples ò pseudorandom item can be ADDED to token:
    - Source IP Address and Port Number
    - The `User-Agent` header
    - The time of the request in milliseconds

Protect Tokens Throughout Their Life Cycle

- Chỉ transmit token qua HTTPS
- Khi người dùng logout phải kết thúc toàn bộ phiên liên quan
- Áp dụng thời gian hết hạn token
- Dũng cơ chế 2FA hoặc reauth để ngăn chặn CSRF

Log, Monitor, and Alert

## Chapter 8: Attacking Access Controls

### Common Vulnerabilities

Có 3 kiểu tấn công vào kiểm soát truy cập chính:

- Vertical Privilege Escalation: Leo thang đặc quyền dọc, khi người dùng có thể thực thi các chức năng quản trị
- Horizontal Privilege Escalation: Leo thang đặc quyền ngang, khi người dùng có thể xem hoặc sửa nội dung mà không được cho phép
- Business logic exploitation: Khi người dùng khai thác lỗ hổng trong ứng dụng để đạt đc quyền truy cập tới key resource

Completely Unprotected Functionality

- Các chức năng, tài nguyên nhạy cảm ko được bảo vệ, ví dụ mọi người dùng đều có thể truy cập trang `https://wahh-app.com/admin/`

Identifier-Based Functions

- ID của tài nguyên được pass thẳng vào URL, người dùng khác nếu sử dụng URL này có thể xem được tài nguyên nhạy cảm. Ví dụ: `https://wahh-app.com/ViewDocument.php?docid=1280149120`

Multistage Functions

- Quá trình kiểm tra quyền truy cập chỉ diễn ra ở 1 giai đoạn trong multistage -> có thể bị khai thác

Static Files

Platform Misconfiguration

Insecure Access Control Methods

- Parameter-Based Access Control: `https://wahh-app.com/login/home.jsp?admin=true`
- Referer-Based Access Control: Chỉnh sửa `Referer` HTTP Header
- Localtion-Based Access Control: 
    - Using a web proxy that is based in the required location
    - Using a VPN that terminates in the required location
    - Using a mobile device that supports data roaming
    - Direct manipulation of client-side mechanisms for geolocation

### Attacking Access Controls

Testing with Different User Accounts

Testing Multistage Processes

Testing with Limited Access

Testing Direct Access to Methods

Testing Controls Over Static Resources

Testing Restrictions on HTTP Methods

### Securing Access Controls

A Multilayered Privilege Model

- The application server can be used to control access to entire URL paths on the basis of user roles that are defi ned at the application server tier.
- The application can employ a different database account when carrying out the actions of different users. For users who should only be querying data (not updating it), an account with read-only privileges should be used.
- Fine-grained control over access to different database tables can be implemented within the database itself, using a table of privileges.
- The operating system accounts used to run each component in the infrastructure can be restricted to the least powerful privileges that the component actually requires.

## Chapter 9: Attacking Data Stores

### Injecting into Interpreted Contexts

Bypassing a Login
- `' OR 1=1--`

### Injecting into SQL

Exploiting a Basic Vulnerability

Injecting into Different Statement Types

- `SELECT` statements
- `INSERT` statements
- `UPDATE` statements
- `DELETE` statements

Finding SQL Injection Bugs

- Injecting into String Data:
    - Oracle: `'||'FOO`
    - MS-SQL: `'+'FOO`
    - MySQL: `' 'FOO`
- Injecting into Numeric Data
- Injecting into the Query Structure

Fingerprinting the Database

- The following examples show how the string `services` could be constructed on the common types of database:
    - Oracle: `'serv'||'ices'`
    - MS-SQL: `'serv'+'ices'`
    - MySQL: `'serv' 'ices'`
- Numeric data
    - Oracle: `BITAND(1,1)-BITAND(1,1)`
    - MS-SQL: `@@PACK_RECEIVED-@@PACK_RECEIVED`
    - MySQL: `CONNECTION_ID()-CONNECTION_ID()`

The UNION Operator

- Sử dụng `UNION SELECT` tuy nhiên kết quả từ 2 lệnh `SELECT` phải có cùng số cột và kiểu dữ liệu

Extracting Useful Data

Extracting Data with UNION

- Oracle: `SELECT table_name||’:’||column_name FROM all_tab_columns`
- MS-SQL: `SELECT table_name+’:’+column_name from information_schema.columns`
- MySQL: `SELECT CONCAT(table_name,’:’,column_name) from information_schema.columns`

Bypassing Filters

- Avoiding Blocked Characters
    - Sử dụng ASCII code
    - Nếu kí tự comment `--` bị block thì tạo payload ko cần sử dụng nó ví dụ `‘ or 1=1--` -> `‘ or ‘a’=’a`
- Circumventing Simple Validation
    - Thay vì sử dụng `SELECT` thì có thể sử dụng:
    - `SeLeCt`
    - `%00SELECT`
    - `SELSELECTECT`
    - `%53%45%4c%45%43%54`
    - `%2553%2545%254c%2545%2543%2554`
- Using SQL Comments
    - Sử dụng kí tự `/*` và `*/` để tạo khoảng trống trong payload
    - Ví dụ: `SELECT/*foo*/username,password/*foo*/FROM/*foo*/users`
    - Ví dụ: `SEL/*foo*/ECT username,password FR/*foo*/OM users`
- Exploiting Defective Filters

Second-Order SQL Injection

Advanced Exploitation

- Retrieving Data as Numbers
    - ASCII - trả về ASCII code
    - SUBSTRING - cắt string
    - `SUBSTRING(‘Admin’,1,1)` = A
    - `ASCII(‘A’)` = 65
    - -> `ASCII(SUBSTR(‘Admin’,1,1))` = 65
- Using an Out-of-Band Channel

Beyond SQL Injection: Escalating the Database Attack

Using SQL Exploitation Tools

SQL Syntax and Error Reference

Preventing SQL Injection

### Injecting into NoSQL

Injecting into MongoDB

- Trong JavaScript, `//` có nghĩa là comment, tuy nhiên để hàm $js luôn trả về true ko cần `//` là sử dụng `a’ || 1==1 || ‘a’==’a`, khi đó trở thành : `(this.username == ‘a’ || 1==1) || (‘a’==’a’ & this.password == ‘aaa’);`

### Injecting into XPath

Subverting Application Logic

Informed XPath Injection

Blind XPath Injection

Finding XPath Injection Flaws

Preventing XPath Injection


### Injecting into LDAP

Exploiting LDAP Injection

Finding LDAP Injection Flaws

Preventing LDAP Injection


## Chapter 10: Attacking Back-End Components

### Injecting OS Commands

Injecting Through Dynamic Execution

- PHP có hàm eval() sẽ thực thi code được pass vào function -> có thể bị khai thác

    `$storedsearch = $_GET['storedsearch']; eval("$storedsearch;");`

Finding OS Command Injection Flaws

- Một số kí tự phổ biến ` ; | & `

Preventing OS Command Injection

- Tránh gọi trực tiếp đến OS commands
- Sử dụng whitelist
- Sử dụng command API

### Manupulating File Paths

Preventing Path Traversal Vunlerabilites

- Kiểm tra xem input có chứa null bytes hoặc các kí tự dẫn đến path traversal hay không
- Nên sử dụng hard-coded list các loại file cho phép
- Nên sử dụng filesystem API phù hợp

### Injecting into XML Interpreters

XXE (XML External Entities)

- 

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