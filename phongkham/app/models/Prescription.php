<?php
/**
 * Model Đơn thuốc - làm việc với bảng chitietdonthuoc.
 * Thêm / sửa / xóa đơn thuốc đều phải cập nhật lại số lượng tồn kho trong bảng thuoc,
 * nên các thao tác này dùng TRANSACTION: hoặc thành công cả hai, hoặc hủy cả hai.
 *
 * Các hàm create / update / delete trả về mảng [thành công (bool), thông báo (string)].
 */
class Prescription extends Model
{
    /** Danh sách chi tiết đơn thuốc kèm tên bệnh nhân, tên thuốc */
    public function all(string $keyword = ""): array
    {
        $sql = "SELECT ct.MaChiTiet, ct.MaHoSo, ct.SoLuong, ct.CachDung,
                       hs.NgayKham, bn.HoTen AS TenBenhNhan,
                       t.TenThuoc, t.DonViTinh, t.DonGia
                FROM chitietdonthuoc ct
                INNER JOIN hosokham hs ON ct.MaHoSo = hs.MaHoSo
                INNER JOIN benhnhan bn ON hs.MaBenhNhan = bn.MaBenhNhan
                INNER JOIN thuoc t ON ct.MaThuoc = t.MaThuoc";

        if ($keyword !== "") {
            $like = "%" . $keyword . "%";
            return $this->fetchAll(
                $sql . " WHERE bn.HoTen LIKE ? OR t.TenThuoc LIKE ? OR ct.CachDung LIKE ?
                         ORDER BY ct.MaChiTiet DESC",
                "sss",
                [$like, $like, $like]
            );
        }

        return $this->fetchAll($sql . " ORDER BY ct.MaChiTiet DESC");
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne(
            "SELECT MaChiTiet, MaHoSo, MaThuoc, SoLuong, CachDung
             FROM chitietdonthuoc WHERE MaChiTiet = ?",
            "i",
            [$id]
        );
    }

    /** Danh sách thuốc cho ô chọn ở form */
    public function medicineList(): array
    {
        return $this->fetchAll(
            "SELECT MaThuoc, TenThuoc, SoLuong, DonViTinh, DonGia FROM thuoc ORDER BY TenThuoc ASC"
        );
    }

    /** Thống kê: tổng số đơn, tổng số lượng, tổng tiền */
    public function stats(): array
    {
        $row = $this->fetchOne(
            "SELECT COUNT(*) AS TongDon, COALESCE(SUM(SoLuong), 0) AS TongSoLuong
             FROM chitietdonthuoc"
        );

        $tien = $this->scalar(
            "SELECT COALESCE(SUM(ct.SoLuong * t.DonGia), 0)
             FROM chitietdonthuoc ct
             INNER JOIN thuoc t ON ct.MaThuoc = t.MaThuoc"
        );

        return [
            "tongDon"      => (int) ($row["TongDon"] ?? 0),
            "tongSoLuong"  => (int) ($row["TongSoLuong"] ?? 0),
            "tongTien"     => (float) $tien,
        ];
    }

    // ------------------------------------------------------------------
    // Các hàm hỗ trợ nội bộ
    // ------------------------------------------------------------------

    private function stock(int $maThuoc): ?int
    {
        $row = $this->fetchOne("SELECT SoLuong FROM thuoc WHERE MaThuoc = ?", "i", [$maThuoc]);
        return $row === null ? null : (int) $row["SoLuong"];
    }

    private function recordExists(int $maHoSo): bool
    {
        return $this->fetchOne("SELECT MaHoSo FROM hosokham WHERE MaHoSo = ?", "i", [$maHoSo]) !== null;
    }

    /** Chạy một nhóm thao tác trong transaction; lỗi thì rollback */
    private function transaction(callable $work, string $successMessage): array
    {
        $this->db->begin_transaction();

        try {
            $work();
            $this->db->commit();
            return [true, $successMessage];
        } catch (Exception $e) {
            $this->db->rollback();
            return [false, $e->getMessage()];
        }
    }

    private function must(bool $ok, string $message): void
    {
        if (!$ok) {
            throw new Exception($message);
        }
    }

    // ------------------------------------------------------------------
    // XÓA
    // ------------------------------------------------------------------
    public function remove(int $id): array
    {
        $old = $this->find($id);

        if ($old === null) {
            return [false, "Không tìm thấy đơn thuốc cần xóa."];
        }

        return $this->transaction(function () use ($id, $old) {
            $this->must(
                $this->execute("DELETE FROM chitietdonthuoc WHERE MaChiTiet = ?", "i", [$id]),
                "Không thể xóa đơn thuốc."
            );

            // Trả số lượng thuốc về kho
            $this->must(
                $this->execute(
                    "UPDATE thuoc SET SoLuong = SoLuong + ? WHERE MaThuoc = ?",
                    "ii",
                    [(int) $old["SoLuong"], (int) $old["MaThuoc"]]
                ),
                "Không thể cập nhật lại số lượng thuốc."
            );
        }, "Xóa đơn thuốc thành công!");
    }

    // ------------------------------------------------------------------
    // THÊM
    // ------------------------------------------------------------------
    public function add(int $maHoSo, int $maThuoc, int $soLuong, string $cachDung): array
    {
        if (!$this->recordExists($maHoSo)) {
            return [false, "Hồ sơ khám không tồn tại!"];
        }

        $tonKho = $this->stock($maThuoc);

        if ($tonKho === null) {
            return [false, "Thuốc không tồn tại!"];
        }

        if ($soLuong > $tonKho) {
            return [false, "Số lượng thuốc trong kho không đủ! Hiện còn: " . $tonKho];
        }

        return $this->transaction(function () use ($maHoSo, $maThuoc, $soLuong, $cachDung) {
            $this->must(
                $this->execute(
                    "INSERT INTO chitietdonthuoc (MaHoSo, MaThuoc, SoLuong, CachDung)
                     VALUES (?, ?, ?, ?)",
                    "iiis",
                    [$maHoSo, $maThuoc, $soLuong, $cachDung]
                ),
                "Không thể thêm đơn thuốc."
            );

            // Trừ số lượng thuốc trong kho
            $this->must(
                $this->execute(
                    "UPDATE thuoc SET SoLuong = SoLuong - ? WHERE MaThuoc = ?",
                    "ii",
                    [$soLuong, $maThuoc]
                ),
                "Không thể cập nhật số lượng thuốc."
            );
        }, "Thêm đơn thuốc thành công!");
    }

    // ------------------------------------------------------------------
    // SỬA
    // ------------------------------------------------------------------
    public function change(int $id, int $maHoSo, int $maThuocMoi, int $soLuongMoi, string $cachDung): array
    {
        $old = $this->find($id);

        if ($old === null) {
            return [false, "Không tìm thấy đơn thuốc cần sửa!"];
        }

        if (!$this->recordExists($maHoSo)) {
            return [false, "Hồ sơ khám không tồn tại!"];
        }

        $maThuocCu  = (int) $old["MaThuoc"];
        $soLuongCu  = (int) $old["SoLuong"];

        // ---- Trường hợp 1: vẫn dùng đúng loại thuốc cũ, chỉ đổi số lượng ----
        if ($maThuocCu === $maThuocMoi) {
            $tonKho = $this->stock($maThuocMoi);

            if ($tonKho === null) {
                return [false, "Thuốc không tồn tại!"];
            }

            $toiDa = $tonKho + $soLuongCu;

            if ($soLuongMoi > $toiDa) {
                return [false, "Số lượng thuốc không đủ! Có thể sử dụng tối đa: " . $toiDa];
            }

            $chenhLech = $soLuongMoi - $soLuongCu;

            return $this->transaction(function () use ($id, $maHoSo, $soLuongMoi, $cachDung, $chenhLech, $maThuocMoi) {
                $this->must(
                    $this->execute(
                        "UPDATE chitietdonthuoc SET MaHoSo = ?, SoLuong = ?, CachDung = ?
                         WHERE MaChiTiet = ?",
                        "iisi",
                        [$maHoSo, $soLuongMoi, $cachDung, $id]
                    ),
                    "Không thể cập nhật đơn thuốc."
                );

                $this->must(
                    $this->execute(
                        "UPDATE thuoc SET SoLuong = SoLuong - ? WHERE MaThuoc = ?",
                        "ii",
                        [$chenhLech, $maThuocMoi]
                    ),
                    "Không thể cập nhật kho thuốc."
                );
            }, "Cập nhật đơn thuốc thành công!");
        }

        // ---- Trường hợp 2: đổi sang loại thuốc khác ----
        $tonKhoMoi = $this->stock($maThuocMoi);

        if ($tonKhoMoi === null) {
            return [false, "Thuốc mới không tồn tại!"];
        }

        if ($soLuongMoi > $tonKhoMoi) {
            return [false, "Thuốc mới không đủ số lượng! Hiện còn: " . $tonKhoMoi];
        }

        return $this->transaction(
            function () use ($id, $maHoSo, $maThuocMoi, $soLuongMoi, $cachDung, $maThuocCu, $soLuongCu) {
                $this->must(
                    $this->execute(
                        "UPDATE chitietdonthuoc
                         SET MaHoSo = ?, MaThuoc = ?, SoLuong = ?, CachDung = ?
                         WHERE MaChiTiet = ?",
                        "iiisi",
                        [$maHoSo, $maThuocMoi, $soLuongMoi, $cachDung, $id]
                    ),
                    "Không thể cập nhật đơn thuốc."
                );

                // Trả thuốc cũ về kho
                $this->must(
                    $this->execute(
                        "UPDATE thuoc SET SoLuong = SoLuong + ? WHERE MaThuoc = ?",
                        "ii",
                        [$soLuongCu, $maThuocCu]
                    ),
                    "Không thể trả thuốc cũ về kho."
                );

                // Trừ thuốc mới
                $this->must(
                    $this->execute(
                        "UPDATE thuoc SET SoLuong = SoLuong - ? WHERE MaThuoc = ?",
                        "ii",
                        [$soLuongMoi, $maThuocMoi]
                    ),
                    "Không thể trừ thuốc mới."
                );
            },
            "Cập nhật đơn thuốc thành công!"
        );
    }
}
