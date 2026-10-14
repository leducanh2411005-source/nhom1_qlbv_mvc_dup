<?php
/** Chuyển hướng sang một trang (route) khác trong ứng dụng */
function redirect(string $page): void
{
    header("Location: index.php?page=" . $page);
    exit();
}

/** Hiển thị nhãn trạng thái lịch khám (dùng ở trang chủ và trang lịch khám) */
function hienThiTrangThai($trangThai)
{
    if ($trangThai == "Da kham" || $trangThai == "Đã khám") {
        return '<span class="status da-kham">Đã khám</span>';
    }

    if ($trangThai == "Huy" || $trangThai == "Hủy") {
        return '<span class="status huy">Đã hủy</span>';
    }

    return '<span class="status chua-kham">Chưa khám</span>';
}
