<?php
/** Quản lý bác sĩ - chỉ Admin và Nhân viên được vào */
class DoctorController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        if (!in_array(Auth::role(), ["Admin", "NhanVien"], true)) {
            redirect("dashboard");
        }

        $doctor   = $this->model("Doctor");
        $thongBao = "";

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            if ($doctor->delete((int) $_GET["xoa"])) {
                redirect("doctors");
            }
            $thongBao = "Không thể xóa bác sĩ: " . $doctor->error;
        }

        // ----- THÊM -----
        if (isset($_POST["them"])) {
            $data = $this->formData();

            if (in_array("", $data, true)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin bác sĩ!";
            } elseif ($doctor->create($data)) {
                redirect("doctors");
            } else {
                $thongBao = "Có lỗi khi thêm bác sĩ: " . $doctor->error;
            }
        }

        // ----- SỬA -----
        if (isset($_POST["sua"])) {
            $id   = (int) ($_POST["MaBacSi"] ?? 0);
            $data = $this->formData();

            if ($id <= 0 || in_array("", $data, true)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin bác sĩ!";
            } elseif ($doctor->update($id, $data)) {
                redirect("doctors");
            } else {
                $thongBao = "Có lỗi khi sửa bác sĩ: " . $doctor->error;
            }
        }

        $bacSiSua = isset($_GET["sua"]) ? $doctor->find((int) $_GET["sua"]) : null;

        $tuKhoa  = isset($_GET["timkiem"]) ? trim($_GET["timkiem"]) : "";
        $result  = $doctor->all($tuKhoa);
        $tongBacSi = $doctor->count();

        $this->render(
            "doctors/index",
            compact("thongBao", "bacSiSua", "tuKhoa", "result", "tongBacSi"),
            ["title" => "Quản lý bác sĩ", "css" => "doctors"]
        );
    }

    private function formData(): array
    {
        return [
            "hoTen"       => trim($_POST["hoTen"] ?? ""),
            "gioiTinh"    => trim($_POST["gioiTinh"] ?? ""),
            "soDienThoai" => trim($_POST["soDienThoai"] ?? ""),
            "chuyenKhoa"  => trim($_POST["chuyenKhoa"] ?? ""),
            "khoa"        => trim($_POST["khoa"] ?? ""),
            "chuyenMon"   => trim($_POST["chuyenMon"] ?? ""),
        ];
    }
}
