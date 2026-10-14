<?php
/**
 * Model (lớp cha): chứa các hàm truy vấn dùng chung.
 * Mọi câu SQL đều dùng prepared statement để tránh SQL Injection.
 * Các model con (Patient, Doctor, ...) chỉ cần gọi fetchAll / fetchOne / execute.
 */
abstract class Model
{
    protected mysqli $db;

    // Thông báo lỗi của lần thao tác gần nhất (controller dùng để hiển thị)
    public string $error = "";

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** Lấy nhiều dòng, trả về mảng các mảng kết hợp */
    protected function fetchAll(string $sql, string $types = "", array $params = []): array
    {
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            $this->error = $this->db->error;
            return [];
        }

        if ($types !== "") {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            $this->error = $stmt->error;
            $stmt->close();
            return [];
        }

        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    }

    /** Lấy đúng 1 dòng (hoặc null nếu không có) */
    protected function fetchOne(string $sql, string $types = "", array $params = []): ?array
    {
        $rows = $this->fetchAll($sql, $types, $params);
        return $rows[0] ?? null;
    }

    /** Lấy 1 giá trị đơn (ví dụ COUNT(*)) */
    protected function scalar(string $sql, string $types = "", array $params = [])
    {
        $row = $this->fetchOne($sql, $types, $params);
        return $row ? array_values($row)[0] : 0;
    }

    /** Chạy INSERT / UPDATE / DELETE, trả về true/false */
    protected function execute(string $sql, string $types = "", array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            $this->error = $this->db->error;
            return false;
        }

        if ($types !== "") {
            $stmt->bind_param($types, ...$params);
        }

        $ok = $stmt->execute();

        if (!$ok) {
            $this->error = $stmt->error;
        }

        $stmt->close();

        return $ok;
    }
}
