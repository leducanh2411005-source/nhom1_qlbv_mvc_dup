<?php
/**
 * Quản lý lịch khám.
 * Admin, Nhân viên, Bác sĩ được xem; chỉ Admin và Nhân viên được thêm / sửa / xóa.
 */
class AppointmentController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $laAdmin    = Auth::isAdmin();
        $laNhanVien = Auth::isStaff();

        if (!$laAdmin && !$laNhanVien && !Auth::isDoctor()) {
            redirect("dashboard");
        }

        $canEdit     = $laAdmin || $laNhanVien;
        $appointment = $this->model("Appointment");
        $thongBao    = "";

        // Bác sĩ chỉ được xem: mọi thao tác ghi đều bị chặn
        if (!$canEdit && (isset($_GET["xoa"]) || isset($_POST["them"]) || isset($_POST["sua"]) || isset($_GET["sua"]))) {
            redirect("appointments");
        }

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            $id = (int) $_GET["xoa"];

            if ($id > 0) {
                if ($appointment->delete($id)) {
                    redirect("appointments");
                }
                $thongBao = "Không thể xóa lịch khám: " . $appointment->error;
            }
        }

        // ----- THÊM -----
        if (isset($_POST["them"])) {
            $data = $this->formData();

            if ($this->isInvalid($data)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin lịch khám!";
            } elseif ($appointment->create($data)) {
                redirect("appointments");
            } else {
                $thongBao = "Có lỗi khi thêm lịch khám: " . $appointment->error;
            }
        }

        // ----- SỬA -----
        if (isset($_POST["sua"])) {
            $id   = (int) ($_POST["MaLichKham"] ?? 0);
            $data = $this->formData();

            if ($id <= 0 || $this->isInvalid($data)) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin lịch khám!";
            } elseif ($appointment->update($id, $data)) {
                redirect("appointments");
            } else {
                $thongBao = "Có lỗi khi sửa lịch khám: " . $appointment->error;
            }
        }

        $lichKhamSua = isset($_GET["sua"]) ? $appointment->find((int) $_GET["sua"]) : null;

        // Dữ liệu cho các ô chọn trong form
        $resultBenhNhan = $this->model("Patient")->allByName();
        $resultBacSi    = $laAdmin ? $this->model("Doctor")->allByName() : [];

        $tuKhoa = isset($_GET["timkiem"]) ? trim($_GET["timkiem"]) : "";
        $result = $appointment->all($tuKhoa, $laAdmin);

        $tongLichKham  = $appointment->count();
        $tongChuaKham  = $appointment->countNotExamined();
        $tongDaKham    = $appointment->countExamined();

        $this->render(
            "appointments/index",
            compact("thongBao", "lichKhamSua", "resultBenhNhan", "resultBacSi", "tuKhoa",
                    "result", "tongLichKham", "tongChuaKham", "tongDaKham"),
            ["title" => "Quản lý lịch khám", "css" => "appointments"]
        );
    }

    private function formData(): array
    {
        return [
            "maBenhNhan" => (int) ($_POST["maBenhNhan"] ?? 0),
            "maBacSi"    => (int) ($_POST["maBacSi"] ?? 0),
            "ngayKham"   => trim($_POST["ngayKham"] ?? ""),
            "gioKham"    => trim($_POST["gioKham"] ?? ""),
            "trangThai"  => trim($_POST["trangThai"] ?? ""),
        ];
    }

    private function isInvalid(array $d): bool
    {
        return $d["maBenhNhan"] <= 0 || $d["maBacSi"] <= 0
            || $d["ngayKham"] === "" || $d["gioKham"] === "" || $d["trangThai"] === "";
    }
}
