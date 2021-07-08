# The Web Application Hacker's Handbook - Second Edition - Hack steps

## Chapter 4: Mapping the Application

### 1. Enumerating Content and Functionality

Các kĩ thuật giúp thu thập, liệt kê toàn bộ nội dung của mục tiêu.

#### 1.1. Web Spidering

**TIP**: Một số web server có file "robots.txt" chứa danh sách các URL mà web app không muốn các công cụ tìm kiếm đánh chỉ mục. Đôi khi file này chứa các thông tin nhạy cảm nên một vài công cụ spidering thường kiểm tra file này và chuyển toàn bộ URL trong đó cho quá trình spidering -> Trong trường hợp này file "robots.txt" bị phản tác dụng, gây ảnh hưởng đến an toàn bảo mật ứng dụng web.

**WARNING**: Việc sử dụng Web Spider có thể dẫn đến hậu quả nghiêm trọng trong một số tình huống. Ví dụ nếu Web App sử dụng các chức năng quản trị như xóa người dùng, tắt CSDL, ... có thể được tìm thấy ngay tại site map và không được bảo vệ bởi cơ chế nào thì Web Spider có thể tìm thấy và thực thi các chức năng đó.

#### 1.2. User-Directed Spidering - Hack steps

1. Cài đặt trình duyệt sử dụng Burp hoặc WebScarab làm local proxy
2. Duyệt toàn bộ Web App bình thường, thử truy cập toàn bộ link/URL, submit và hoàn thành toàn bộ form có thể. Thử duyệt với JavaScript bật/tắt và cookie bật/tắt. Nhiều Web App có thể xử lý các cấu hình trình duyệt khác nhau nên bạn có thể tiếp cận các đường dẫn và nội dung khác nhau trong cùng 1 Web App.
3. Kiểm tra site map được tạo bởi proxy/spider tool và xác định xem nội dung hay chắc năng nào mà bạn không duyệt thủ công. Thiết lập cách spider duyệt từng mục.

#### 1.3. Discover Hidden Content - Hack steps

#### 1.4. Inference From Published Content - Hack steps

#### 1.5. Application Pages Versus Functional Paths - Hack steps

#### 1.6. Discovering Hidden Parameters - Hack steps

### 2. Analyzing the Application

#### 2.1. Identifying Server-Side Technologies - Hack steps

#### 2.2. Identifying Server-Side Functionality - Hack steps

#### 2.3. Extrapolating Application Behavior - Hack steps

#### 2.4. Isolating Unique Application Behavior - Hack steps

### Mapping the Application

### Key Functionality and Potential Vulnerabilities

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