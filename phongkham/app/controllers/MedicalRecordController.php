<?php
/** Quản lý hồ sơ khám - chỉ Admin và Bác sĩ */
class MedicalRecordController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        if (!in_array(Auth::role(), ["Admin", "BacSi"], true)) {
            redirect("dashboard");
        }

        $record   = $this->model("MedicalRecord");
        $thongBao = "";

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            $maHoSo = (int) $_GET["xoa"];

            if ($maHoSo > 0) {
                if ($record->delete($maHoSo)) {
                    redirect("medical_records");
                }
                $thongBao = "❌ Không thể xóa hồ sơ: " . $record->error;
            }
        }

        // ----- THÊM -----
        if (isset($_POST["them"])) {
            $data = $this->formData();

            if ($this->isInvalid($data)) {
                $thongBao = "⚠️ Vui lòng nhập đầy đủ thông tin hồ sơ khám!";
            } elseif ($record->create($data)) {
                redirect("medical_records");
            } else {
                $thongBao = "❌ Có lỗi khi thêm hồ sơ: " . $record->error;
            }
        }

        // ----- SỬA -----
        if (isset($_POST["sua"])) {
            $maHoSo = (int) ($_POST["MaHoSo"] ?? 0);
            $data   = $this->formData();

            if ($maHoSo <= 0 || $this->isInvalid($data)) {
                $thongBao = "⚠️ Vui lòng nhập đầy đủ thông tin hồ sơ khám!";
            } elseif ($record->update($maHoSo, $data)) {
                redirect("medical_records");
            } else {
                $thongBao = "❌ Có lỗi khi sửa hồ sơ: " . $record->error;
            }
        }

        $idSua   = (int) ($_GET["sua"] ?? 0);
        $hoSoSua = $idSua > 0 ? $record->find($idSua) : null;

        // Dữ liệu cho các ô chọn trong form
        $resultBenhNhan = $this->model("Patient")->allByName();
        $resultBacSi    = $this->model("Doctor")->allByName();

        $tuKhoa = trim($_GET["timkiem"] ?? "");
        $result = $record->all($tuKhoa);

        $tongHoSo        = $record->count();
        $hoSoHomNay      = $record->countToday();
        $benhNhanCoHoSo  = $record->countDistinctPatients();

        $this->render(
            "medical_records/index",
            compact("thongBao", "hoSoSua", "resultBenhNhan", "resultBacSi", "tuKhoa",
                    "result", "tongHoSo", "hoSoHomNay", "benhNhanCoHoSo"),
            ["title" => "Quản lý hồ sơ khám", "css" => "medical_records"]
        );
    }

    private function formData(): array
    {
        return [
            "maBenhNhan" => (int) ($_POST["maBenhNhan"] ?? 0),
            "maBacSi"    => (int) ($_POST["maBacSi"] ?? 0),
            "ngayKham"   => trim($_POST["ngayKham"] ?? ""),
            "trieuChung" => trim($_POST["trieuChung"] ?? ""),
            "chanDoan"   => trim($_POST["chanDoan"] ?? ""),
            "ketQua"     => trim($_POST["ketQua"] ?? ""),
        ];
    }

    private function isInvalid(array $d): bool
    {
        return $d["maBenhNhan"] <= 0 || $d["maBacSi"] <= 0 || $d["ngayKham"] === ""
            || $d["trieuChung"] === "" || $d["chanDoan"] === "" || $d["ketQua"] === "";
    }
}
