<?php
/**
 * Auth: kiểm tra đăng nhập và phân quyền (thay cho config/auth.php cũ).
 */
class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check(): bool
    {
        return isset($_SESSION["dangnhap"]);
    }

    /** Chưa đăng nhập thì chuyển về trang login */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect("login");
        }
    }

    public static function role(): string
    {
        return $_SESSION["vaitro"] ?? "";
    }

    /** Chuẩn hóa vai trò: "Nhân viên", "nhanvien", "NhanVien" đều hiểu là nhân viên */
    public static function isAdmin(): bool
    {
        return strtolower(trim(self::role())) === "admin";
    }

    public static function isStaff(): bool
    {
        return in_array(strtolower(trim(self::role())), ["nhanvien", "nhân viên", "nhan vien"], true);
    }

    public static function isDoctor(): bool
    {
        return strtolower(trim(self::role())) === "bacsi";
    }

    public static function login(array $user): void
    {
        $_SESSION["MaTaiKhoan"] = $user["MaTaiKhoan"];
        $_SESSION["dangnhap"]   = $user["TenDangNhap"];
        $_SESSION["hoten"]      = $user["HoTen"];
        $_SESSION["vaitro"]     = $user["VaiTro"];
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
