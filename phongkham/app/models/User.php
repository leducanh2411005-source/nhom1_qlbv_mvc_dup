<?php
/** Model Tài khoản - làm việc với bảng taikhoan */
class User extends Model
{
    /** Kiểm tra đăng nhập, trả về thông tin tài khoản hoặc null */
    public function authenticate(string $username, string $password): ?array
    {
        return $this->fetchOne(
            "SELECT * FROM taikhoan WHERE TenDangNhap = ? AND MatKhau = ?",
            "ss",
            [$username, $password]
        );
    }

    public function all(string $keyword = ""): array
    {
        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                "SELECT * FROM taikhoan
                 WHERE TenDangNhap LIKE ? OR HoTen LIKE ? OR VaiTro LIKE ?
                 ORDER BY MaTaiKhoan DESC",
                "sss",
                [$like, $like, $like]
            );
        }

        return $this->fetchAll("SELECT * FROM taikhoan ORDER BY MaTaiKhoan DESC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM taikhoan WHERE MaTaiKhoan = ?", "i", [$id]);
    }

    public function usernameExists(string $username): bool
    {
        return $this->fetchOne(
            "SELECT MaTaiKhoan FROM taikhoan WHERE TenDangNhap = ?",
            "s",
            [$username]
        ) !== null;
    }

    public function create(string $username, string $password, string $hoTen, string $vaiTro): bool
    {
        return $this->execute(
            "INSERT INTO taikhoan (TenDangNhap, MatKhau, HoTen, VaiTro) VALUES (?, ?, ?, ?)",
            "ssss",
            [$username, $password, $hoTen, $vaiTro]
        );
    }

    /** Cập nhật tài khoản; nếu $password rỗng thì giữ nguyên mật khẩu cũ */
    public function update(int $id, string $username, string $password, string $hoTen, string $vaiTro): bool
    {
        if ($password === "") {
            return $this->execute(
                "UPDATE taikhoan SET TenDangNhap = ?, HoTen = ?, VaiTro = ? WHERE MaTaiKhoan = ?",
                "sssi",
                [$username, $hoTen, $vaiTro, $id]
            );
        }

        return $this->execute(
            "UPDATE taikhoan SET TenDangNhap = ?, MatKhau = ?, HoTen = ?, VaiTro = ? WHERE MaTaiKhoan = ?",
            "ssssi",
            [$username, $password, $hoTen, $vaiTro, $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM taikhoan WHERE MaTaiKhoan = ?", "i", [$id]);
    }

    public function count(string $role = ""): int
    {
        if ($role === "") {
            return (int) $this->scalar("SELECT COUNT(*) FROM taikhoan");
        }

        return (int) $this->scalar("SELECT COUNT(*) FROM taikhoan WHERE VaiTro = ?", "s", [$role]);
    }
}
