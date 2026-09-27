# ☕ Coffee Shop

Website đặt đồ uống cho quán cà phê, xây dựng bằng **Laravel 12**. Có giao diện cho khách hàng và trang quản trị cho quản lý quán.

## Tính năng

**Khách hàng**
- Xem thực đơn, chọn món và size
- Giỏ hàng: thêm, sửa số lượng, xóa món
- Đặt hàng (checkout) và tra cứu trạng thái đơn hàng
- Đăng ký / đăng nhập

**Quản trị**
- Quản lý món, danh mục, đơn hàng
- Thống kê doanh thu bằng biểu đồ (Chart.js)

## Công nghệ

- Backend: Laravel 12, PHP 8.2, Eloquent ORM
- Frontend: Blade, Bootstrap, Vite
- Database: MySQL / MariaDB

## Yêu cầu

- PHP >= 8.2
- Composer
- Node.js (bản LTS) và npm
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

Tạo một database trống (ví dụ `coffee_shop`), rồi sửa file `.env`:

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
| Admin | `admin@coffee.test` | `admin123` |

## Cấu trúc thư mục chính

```
app/Http/Controllers   # Xử lý logic
app/Models             # Model Eloquent
resources/views        # Giao diện Blade (menu, cart, checkout, admin...)
routes/web.php         # Định tuyến
database/migrations    # Cấu trúc bảng
database/seeders       # Dữ liệu mẫu
```
