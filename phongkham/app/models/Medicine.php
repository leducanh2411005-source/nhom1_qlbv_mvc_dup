<?php
/** Model Thuốc - làm việc với bảng thuoc */
class Medicine extends Model
{
    public function all(string $keyword = ""): array
    {
        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                "SELECT * FROM thuoc
                 WHERE TenThuoc LIKE ? OR DonViTinh LIKE ? OR MoTa LIKE ?
                 ORDER BY MaThuoc DESC",
                "sss",
                [$like, $like, $like]
            );
        }

        return $this->fetchAll("SELECT * FROM thuoc ORDER BY MaThuoc DESC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM thuoc WHERE MaThuoc = ?", "i", [$id]);
    }

    /** Thuốc đã nằm trong đơn thuốc nào chưa (nếu rồi thì không cho xóa) */
    public function isUsed(int $id): bool
    {
        return (int) $this->scalar(
            "SELECT COUNT(*) FROM chitietdonthuoc WHERE MaThuoc = ?",
            "i",
            [$id]
        ) > 0;
    }

    public function create(array $d): bool
    {
        return $this->execute(
            "INSERT INTO thuoc (TenThuoc, DonViTinh, DonGia, SoLuong, MoTa) VALUES (?, ?, ?, ?, ?)",
            "ssdis",
            [$d["tenThuoc"], $d["donViTinh"], $d["donGia"], $d["soLuong"], $d["moTa"]]
        );
    }

    public function update(int $id, array $d): bool
    {
        return $this->execute(
            "UPDATE thuoc SET TenThuoc = ?, DonViTinh = ?, DonGia = ?, SoLuong = ?, MoTa = ?
             WHERE MaThuoc = ?",
            "ssdisi",
            [$d["tenThuoc"], $d["donViTinh"], $d["donGia"], $d["soLuong"], $d["moTa"], $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM thuoc WHERE MaThuoc = ?", "i", [$id]);
    }

    public function count(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM thuoc");
    }

    public function totalQuantity(): int
    {
        return (int) $this->scalar("SELECT COALESCE(SUM(SoLuong), 0) FROM thuoc");
    }

    /** Số loại thuốc sắp hết (tồn kho <= 10) */
    public function lowStockCount(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM thuoc WHERE SoLuong <= 10");
    }
}
