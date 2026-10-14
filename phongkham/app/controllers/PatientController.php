<?php
/** Quản lý bệnh nhân (xem, tìm kiếm, thêm, sửa, xóa) */
class PatientController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $patient  = $this->model("Patient");
        $thongBao = "";

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            if ($patient->delete((int) $_GET["xoa"])) {
                redirect("patients");
            }
            $thongBao = "Không thể xóa bệnh nhân: " . $patient->error;
        }

        // ----- THÊM -----
        if (isset($_POST["them"])) {
            $data = $this->formData();

            if (in_array("", $data, true)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin bệnh nhân!";
            } elseif ($patient->create($data)) {
                redirect("patients");
            } else {
                $thongBao = "Có lỗi khi thêm bệnh nhân: " . $patient->error;
            }
        }

        // ----- SỬA -----
        if (isset($_POST["sua"])) {
            $id   = (int) ($_POST["MaBenhNhan"] ?? 0);
            $data = $this->formData();

            if ($id <= 0 || in_array("", $data, true)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin bệnh nhân!";
            } elseif ($patient->update($id, $data)) {
                redirect("patients");
            } else {
                $thongBao = "Có lỗi khi sửa bệnh nhân: " . $patient->error;
            }
        }

        // ----- LẤY BỆNH NHÂN ĐỂ SỬA -----
        $benhNhanSua = isset($_GET["sua"]) ? $patient->find((int) $_GET["sua"]) : null;

        // ----- TÌM KIẾM + DANH SÁCH -----
        $tuKhoa = isset($_GET["timkiem"]) ? trim($_GET["timkiem"]) : "";
        $result = $patient->all($tuKhoa);

        $tongBenhNhan = $patient->count();

        $this->render(
            "patients/index",
            compact("thongBao", "benhNhanSua", "tuKhoa", "result", "tongBenhNhan"),
            ["title" => "Quản lý bệnh nhân", "css" => "patients"]
        );
    }

    /** Lấy dữ liệu từ form (đã trim) */
    private function formData(): array
    {
        return [
            "hoTen"       => trim($_POST["hoTen"] ?? ""),
            "ngaySinh"    => trim($_POST["ngaySinh"] ?? ""),
            "gioiTinh"    => trim($_POST["gioiTinh"] ?? ""),
            "soDienThoai" => trim($_POST["soDienThoai"] ?? ""),
            "diaChi"      => trim($_POST["diaChi"] ?? ""),
        ];
    }
}
