<?php
/** Quản lý tài khoản - chỉ Admin */
class UserController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        if (Auth::role() !== "Admin") {
            echo "<script>
                    alert('Bạn không có quyền truy cập trang này!');
                    window.location.href='index.php';
                  </script>";
            exit();
        }

        $user     = $this->model("User");
        $thongbao = "";
        $loi      = "";

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            $id = (int) $_GET["xoa"];

            if ($id === (int) ($_SESSION["MaTaiKhoan"] ?? 0)) {
                $loi = "Không thể xóa tài khoản đang đăng nhập!";
            } elseif ($user->delete($id)) {
                $thongbao = "Xóa tài khoản thành công!";
            } else {
                $loi = "Không thể xóa tài khoản!";
            }
        }

        // ----- THÊM / SỬA (cùng một form, phân biệt bằng id ẩn) -----
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id          = (int) ($_POST["id"] ?? 0);
            $tenDangNhap = trim($_POST["TenDangNhap"] ?? "");
            $matKhau     = trim($_POST["MatKhau"] ?? "");
            $hoTenTK     = trim($_POST["HoTen"] ?? "");
            $vaiTroTK    = $_POST["VaiTro"] ?? "NhanVien";

            if ($tenDangNhap === "" || $hoTenTK === "") {
                $loi = "Vui lòng nhập đầy đủ tên đăng nhập và họ tên!";
            } elseif ($id === 0) {
                // THÊM
                if ($matKhau === "") {
                    $loi = "Vui lòng nhập mật khẩu!";
                } elseif ($user->usernameExists($tenDangNhap)) {
                    $loi = "Tên đăng nhập đã tồn tại!";
                } elseif ($user->create($tenDangNhap, $matKhau, $hoTenTK, $vaiTroTK)) {
                    $thongbao = "Thêm tài khoản thành công!";
                } else {
                    $loi = "Có lỗi khi thêm tài khoản!";
                }
            } else {
                // SỬA
                if ($user->update($id, $tenDangNhap, $matKhau, $hoTenTK, $vaiTroTK)) {
                    $thongbao = "Cập nhật tài khoản thành công!";
                } else {
                    $loi = "Có lỗi khi cập nhật tài khoản!";
                }
            }
        }

        $edit     = isset($_GET["sua"]) ? $user->find((int) $_GET["sua"]) : null;
        $timkiem  = trim($_GET["timkiem"] ?? "");
        $result   = $user->all($timkiem);

        $total       = $user->count();
        $totalAdmin  = $user->count("Admin");
        $totalDoctor = $user->count("BacSi");
        $totalStaff  = $user->count("NhanVien");

        $this->render(
            "users/index",
            compact("thongbao", "loi", "edit", "timkiem", "result",
                    "total", "totalAdmin", "totalDoctor", "totalStaff"),
            ["title" => "Quản lý tài khoản", "css" => "users"]
        );
    }
}
