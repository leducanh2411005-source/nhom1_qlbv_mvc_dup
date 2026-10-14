<?php
/** Model Lịch khám - làm việc với bảng lichkham */
class Appointment extends Model
{
    /**
     * Danh sách lịch khám kèm tên bệnh nhân.
     * Admin xem thêm tên bác sĩ và chuyên khoa; nhân viên thì không.
     */
    public function all(string $keyword = "", bool $isAdmin = false): array
    {
        $select = "lichkham.MaLichKham, lichkham.MaBenhNhan, lichkham.MaBacSi,
                   lichkham.NgayKham, lichkham.GioKham, lichkham.TrangThai,
                   benhnhan.HoTen AS TenBenhNhan";
        $from = "FROM lichkham
                 INNER JOIN benhnhan ON lichkham.MaBenhNhan = benhnhan.MaBenhNhan";
        $where = "";
        $types = "";
        $params = [];

        if ($isAdmin) {
            $select .= ", bacsi.HoTen AS TenBacSi, bacsi.ChuyenKhoa AS ChuyenKhoa";
            $from .= " INNER JOIN bacsi ON lichkham.MaBacSi = bacsi.MaBacSi";
        }

        if ($keyword !== "") {
            $like = "%" . $keyword . "%";

            if ($isAdmin) {
                $where = "WHERE benhnhan.HoTen LIKE ? OR bacsi.HoTen LIKE ?
                             OR bacsi.ChuyenKhoa LIKE ? OR lichkham.NgayKham LIKE ?
                             OR lichkham.TrangThai LIKE ?";
                $types = "sssss";
                $params = [$like, $like, $like, $like, $like];
            } else {
                $where = "WHERE benhnhan.HoTen LIKE ? OR lichkham.NgayKham LIKE ?
                             OR lichkham.TrangThai LIKE ?";
                $types = "sss";
                $params = [$like, $like, $like];
            }
        }

        return $this->fetchAll(
            "SELECT $select $from $where
             ORDER BY lichkham.NgayKham DESC, lichkham.GioKham DESC",
            $types,
            $params
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne("SELECT * FROM lichkham WHERE MaLichKham = ?", "i", [$id]);
    }

    public function create(array $d): bool
    {
        return $this->execute(
            "INSERT INTO lichkham (MaBenhNhan, MaBacSi, NgayKham, GioKham, TrangThai)
             VALUES (?, ?, ?, ?, ?)",
            "iisss",
            [$d["maBenhNhan"], $d["maBacSi"], $d["ngayKham"], $d["gioKham"], $d["trangThai"]]
        );
    }

    public function update(int $id, array $d): bool
    {
        return $this->execute(
            "UPDATE lichkham
             SET MaBenhNhan = ?, MaBacSi = ?, NgayKham = ?, GioKham = ?, TrangThai = ?
             WHERE MaLichKham = ?",
            "iisssi",
            [$d["maBenhNhan"], $d["maBacSi"], $d["ngayKham"], $d["gioKham"], $d["trangThai"], $id]
        );
    }

    public function delete(int $id): bool
    {
        return $this->execute("DELETE FROM lichkham WHERE MaLichKham = ?", "i", [$id]);
    }

    public function count(): int
    {
        return (int) $this->scalar("SELECT COUNT(*) FROM lichkham");
    }

    public function countNotExamined(): int
    {
        return (int) $this->scalar(
            "SELECT COUNT(*) FROM lichkham WHERE TrangThai = 'Chua kham' OR TrangThai = 'Chưa khám'"
        );
    }

    public function countExamined(): int
    {
        return (int) $this->scalar(
            "SELECT COUNT(*) FROM lichkham WHERE TrangThai = 'Da kham' OR TrangThai = 'Đã khám'"
        );
    }

    /** 5 lịch khám đầu tiên của một ngày (dùng ở trang chủ) */
    public function today(string $date, int $limit = 5): array
    {
        return $this->fetchAll(
            "SELECT lichkham.MaLichKham, lichkham.NgayKham, lichkham.GioKham, lichkham.TrangThai,
                    benhnhan.HoTen AS TenBenhNhan, bacsi.HoTen AS TenBacSi
             FROM lichkham
             INNER JOIN benhnhan ON lichkham.MaBenhNhan = benhnhan.MaBenhNhan
             INNER JOIN bacsi ON lichkham.MaBacSi = bacsi.MaBacSi
             WHERE lichkham.NgayKham = ?
             ORDER BY lichkham.GioKham ASC
             LIMIT ?",
            "si",
            [$date, $limit]
        );
    }
}
