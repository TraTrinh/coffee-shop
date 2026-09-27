# ☕ Coffee Shop — Website đặt cà phê trực tuyến

Đồ án môn học: website đặt đồ uống cho quán cà phê, xây dựng bằng **Laravel 12**. Có giao diện cho khách hàng và trang quản trị cho quản lý quán.

## Tính năng

**Khách hàng**
- Xem thực đơn, lọc theo danh mục, xem chi tiết món với giá theo size
- Giỏ hàng: thêm, sửa số lượng, xóa món
- Đặt hàng không cần tài khoản: giao tận nơi hoặc nhận tại quán
- Tra cứu đơn hàng bằng mã đơn + số điện thoại
- Đăng ký / đăng nhập: khách đã đăng nhập xem được lịch sử đơn của mình ở trang tra cứu

**Quản trị**
- Dashboard thống kê doanh thu (Chart.js)
- Quản lý danh mục và sản phẩm (thêm, sửa, xóa, upload ảnh)
- Quản lý đơn hàng, cập nhật trạng thái đơn

## Công nghệ

- Backend: Laravel 12, PHP 8.2, Eloquent ORM, Laravel Breeze
- Frontend: Blade, Bootstrap 5, Chart.js, Vite
- Database: MySQL / MariaDB

## Yêu cầu môi trường

- PHP >= 8.2
- Composer 2.x
- Node.js >= 20 và npm
- MySQL hoặc MariaDB (có thể dùng XAMPP)

## Cài đặt

```bash
git clone https://github.com/TraTrinh/coffee-shop.git
cd coffee-shop

composer install
npm install && npm run build

cp .env.example .env        # Windows CMD: copy .env.example .env
php artisan key:generate
```

Tạo database trống tên `coffee_shop`, rồi sửa file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coffee_shop
DB_USERNAME=root
DB_PASSWORD=
```

Tạo bảng và dữ liệu mẫu:

```bash
php artisan migrate --seed
php artisan storage:link
```

## Chạy project

```bash
php artisan serve
```

Mở trình duyệt tại http://127.0.0.1:8000

## Tài khoản mặc định

| Vai trò | Email | Mật khẩu |
|---|---|---|
| Admin | admin@coffee.test | admin123 |

Khách hàng có thể tự đăng ký tài khoản tại `/register`.

## Cấu trúc thư mục chính

```
app/Http/Controllers   # Controller cho khách hàng và admin
app/Http/Middleware    # IsAdmin: chặn người không phải admin
app/Models             # Category, Product, Order, OrderItem, User
app/Services           # CartService: giỏ hàng lưu trong session
resources/views        # Giao diện Blade (menu, cart, checkout, track, admin...)
routes/web.php         # Định tuyến
database/migrations    # Cấu trúc bảng
database/seeders       # Dữ liệu mẫu
```