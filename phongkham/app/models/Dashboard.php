<?php
/** Model Trang chủ - các số liệu thống kê tổng quan */
class Dashboard extends Model
{
    // Chỉ cho đếm trong danh sách bảng này (tránh chèn tên bảng tùy ý vào SQL)
    private array $allowedTables = [
        "benhnhan", "bacsi", "lichkham", "hosokham", "thuoc", "chitietdonthuoc",
    ];

    public function countTable(string $table): int
    {
        if (!in_array($table, $this->allowedTables, true)) {
            return 0;
        }

        return (int) $this->scalar("SELECT COUNT(*) FROM $table");
    }
}
