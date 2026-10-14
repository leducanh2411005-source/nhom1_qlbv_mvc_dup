<?php
/**
 * Controller (lớp cha): nhận yêu cầu, gọi Model, rồi chọn View để hiển thị.
 */
abstract class Controller
{
    /** Nạp một model trong thư mục app/models */
    protected function model(string $name)
    {
        require_once __DIR__ . "/../models/" . $name . ".php";
        return new $name();
    }

    /**
     * Hiển thị View.
     *  $view : tên view, ví dụ "patients/index"
     *  $data : mảng dữ liệu, mỗi phần tử trở thành một biến trong view
     *  $meta : title (tiêu đề tab trình duyệt), css (file css riêng của trang),
     *          layout (false nếu view tự có đủ <html>)
     */
    protected function render(string $view, array $data = [], array $meta = []): void
    {
        // Các biến luôn có sẵn cho mọi view
        $hoTen       = $_SESSION["hoten"] ?? ($_SESSION["dangnhap"] ?? "Người dùng");
        $hoTenUser   = $hoTen;
        $vaiTro      = $_SESSION["vaitro"] ?? "Người dùng";
        $vaiTroXuLy  = strtolower(trim($vaiTro));
        $laAdmin     = Auth::isAdmin();
        $laNhanVien  = Auth::isStaff();
        $chuCaiDau   = mb_strtoupper(mb_substr($hoTen, 0, 1, "UTF-8"), "UTF-8");

        extract($data);

        $pageTitle = $meta["title"] ?? "Quản lý phòng khám";
        $pageCss   = $meta["css"] ?? null;

        // layout = false: view tự có đầy đủ <html> (ví dụ trang đăng nhập)
        $useLayout = $meta["layout"] ?? true;

        if ($useLayout) {
            require __DIR__ . "/../views/layouts/header.php";
        }

        require __DIR__ . "/../views/" . $view . ".php";

        if ($useLayout) {
            require __DIR__ . "/../views/layouts/footer.php";
        }
    }
}
