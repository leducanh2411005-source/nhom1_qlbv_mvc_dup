<?php
/** Model Bệnh nhân - làm việc với bảng benhnhan */
class Patient extends Model
{
    /** Danh sách bệnh nhân, có thể lọc theo từ khóa */
    public function all(string $keyword = ""): array
    {
        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                "SELECT * FROM benhnhan
                 WHERE HoTen LIKE ? OR SoDienThoai LIKE ? OR DiaChi LIKE ?
                 ORDER BY MaBenhNhan DESC",
                "sss",
                [$like, $like, $like]
            );
        }

        return $this->fetchAll("SELECT * FROM benhnhan ORDER BY MaBenhNhan DESC");
    }

    /** Danh sách rút gọn xếp theo tên (dùng cho ô chọn bệnh nhân ở form) */
    public function allByName(): array
    {
        return $this->fetchAll("SELECT * FROM benhnhan ORDER BY HoTen ASC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM benhnhan WHERE MaBenhNhan = ?", "i", [$id]);
    }

    public function count(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM benhnhan");
    }

    public function create(array $d): bool
    {
        return $this->execute(
            "INSERT INTO benhnhan (HoTen, NgaySinh, GioiTinh, SoDienThoai, DiaChi)
             VALUES (?, ?, ?, ?, ?)",
            "sssss",
            [$d["hoTen"], $d["ngaySinh"], $d["gioiTinh"], $d["soDienThoai"], $d["diaChi"]]
        );
    }

    public function update(int $id, array $d): bool
    {
        return $this->execute(
            "UPDATE benhnhan
             SET HoTen = ?, NgaySinh = ?, GioiTinh = ?, SoDienThoai = ?, DiaChi = ?
             WHERE MaBenhNhan = ?",
            "sssssi",
            [$d["hoTen"], $d["ngaySinh"], $d["gioiTinh"], $d["soDienThoai"], $d["diaChi"], $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM benhnhan WHERE MaBenhNhan = ?", "i", [$id]);
    }
}
