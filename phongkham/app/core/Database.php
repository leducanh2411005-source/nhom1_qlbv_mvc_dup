<?php
/**
 * Database: tạo MỘT kết nối mysqli duy nhất dùng chung cho toàn bộ ứng dụng (Singleton).
 */
class Database
{
    private static ?mysqli $conn = null;

    public static function connect(): mysqli
    {
        if (self::$conn === null) {
            $cfg = require __DIR__ . "/../../config/database.php";

            self::$conn = new mysqli(
                $cfg["host"],
                $cfg["username"],
                $cfg["password"],
                $cfg["database"]
            );

            if (self::$conn->connect_error) {
                die("Lỗi kết nối database: " . self::$conn->connect_error);
            }

            self::$conn->set_charset($cfg["charset"]);
        }

        return self::$conn;
    }
}
