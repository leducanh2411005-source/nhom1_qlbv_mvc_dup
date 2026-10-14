<?php
/** Model Hồ sơ khám - làm việc với bảng hosokham */
class MedicalRecord extends Model
{
    private string $selectJoin =
        "SELECT hs.*, bn.HoTen AS TenBenhNhan, bs.HoTen AS TenBacSi, bs.ChuyenKhoa
         FROM hosokham hs
         INNER JOIN benhnhan bn ON hs.MaBenhNhan = bn.MaBenhNhan
         INNER JOIN bacsi bs ON hs.MaBacSi = bs.MaBacSi";

    public function all(string $keyword = ""): array
    {
        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                $this->selectJoin . "
                 WHERE bn.HoTen LIKE ? OR bs.HoTen LIKE ? OR hs.TrieuChung LIKE ?
                    OR hs.ChanDoan LIKE ? OR hs.KetQua LIKE ?
                 ORDER BY hs.NgayKham DESC, hs.MaHoSo DESC",
                "sssss",
                [$like, $like, $like, $like, $like]
            );
        }

        return $this->fetchAll($this->selectJoin . " ORDER BY hs.NgayKham DESC, hs.MaHoSo DESC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM hosokham WHERE MaHoSo = ?", "i", [$id]);
    }

    public function create(array $d): bool
    {
        return $this->execute(
            "INSERT INTO hosokham (MaBenhNhan, MaBacSi, NgayKham, TrieuChung, ChanDoan, KetQua)
             VALUES (?, ?, ?, ?, ?, ?)",
            "iissss",
            [$d["maBenhNhan"], $d["maBacSi"], $d["ngayKham"], $d["trieuChung"], $d["chanDoan"], $d["ketQua"]]
        );
    }

    public function update(int $id, array $d): bool
    {
        return $this->execute(
            "UPDATE hosokham
             SET MaBenhNhan = ?, MaBacSi = ?, NgayKham = ?, TrieuChung = ?, ChanDoan = ?, KetQua = ?
             WHERE MaHoSo = ?",
            "iissssi",
            [$d["maBenhNhan"], $d["maBacSi"], $d["ngayKham"], $d["trieuChung"], $d["chanDoan"], $d["ketQua"], $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM hosokham WHERE MaHoSo = ?", "i", [$id]);
    }

    public function count(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM hosokham");
    }

    public function countToday(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM hosokham WHERE NgayKham = CURDATE()");
    }

    public function countDistinctPatients(): int
    {
        return (int) $this->scalar("SELECT COUNT(DISTINCT MaBenhNhan) FROM hosokham");
    }

    /** 5 hồ sơ mới nhất (dùng ở trang chủ) */
    public function recent(int $limit = 5): array
    {
        return $this->fetchAll(
            "SELECT hosokham.MaHoSo, hosokham.NgayKham, hosokham.TrieuChung, hosokham.ChanDoan,
                    benhnhan.HoTen AS TenBenhNhan, bacsi.HoTen AS TenBacSi
             FROM hosokham
             INNER JOIN benhnhan ON hosokham.MaBenhNhan = benhnhan.MaBenhNhan
             INNER JOIN bacsi ON hosokham.MaBacSi = bacsi.MaBacSi
             ORDER BY hosokham.MaHoSo DESC
             LIMIT ?",
            "i",
            [$limit]
        );
    }

    /** Danh sách hồ sơ rút gọn cho ô chọn ở form đơn thuốc */
    public function listForSelect(): array
    {
        return $this->fetchAll(
            "SELECT hs.MaHoSo, hs.NgayKham, bn.HoTen AS TenBenhNhan
             FROM hosokham hs
             INNER JOIN benhnhan bn ON hs.MaBenhNhan = bn.MaBenhNhan
             ORDER BY hs.MaHoSo DESC"
        );
    }

    public function exists(int $id): bool
    {
        return $this->find($id) !== null;
    }
}
