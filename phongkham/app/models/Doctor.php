<?php
/** Model Bác sĩ - làm việc với bảng bacsi */
class Doctor extends Model
{
    public function all(string $keyword = ""): array
    {
        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                "SELECT * FROM bacsi
                 WHERE HoTen LIKE ? OR SoDienThoai LIKE ? OR ChuyenKhoa LIKE ?
                    OR Khoa LIKE ? OR ChuyenMon LIKE ?
                 ORDER BY MaBacSi DESC",
                "sssss",
                [$like, $like, $like, $like, $like]
            );
        }

        return $this->fetchAll("SELECT * FROM bacsi ORDER BY MaBacSi DESC");
    }

    /** Danh sách xếp theo tên (dùng cho ô chọn bác sĩ ở form) */
    public function allByName(): array
    {
        return $this->fetchAll("SELECT * FROM bacsi ORDER BY HoTen ASC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM bacsi WHERE MaBacSi = ?", "i", [$id]);
    }

    public function count(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM bacsi");
    }

    public function create(array $d): bool
    {
        return $this->execute(
            "INSERT INTO bacsi (HoTen, GioiTinh, SoDienThoai, ChuyenKhoa, Khoa, ChuyenMon)
             VALUES (?, ?, ?, ?, ?, ?)",
            "ssssss",
            [$d["hoTen"], $d["gioiTinh"], $d["soDienThoai"], $d["chuyenKhoa"], $d["khoa"], $d["chuyenMon"]]
        );
    }

    public function update(int $id, array $d): bool
    {
        return $this->execute(
            "UPDATE bacsi
             SET HoTen = ?, GioiTinh = ?, SoDienThoai = ?, ChuyenKhoa = ?, Khoa = ?, ChuyenMon = ?
             WHERE MaBacSi = ?",
            "ssssssi",
            [$d["hoTen"], $d["gioiTinh"], $d["soDienThoai"], $d["chuyenKhoa"], $d["khoa"], $d["chuyenMon"], $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM bacsi WHERE MaBacSi = ?", "i", [$id]);
    }
}
