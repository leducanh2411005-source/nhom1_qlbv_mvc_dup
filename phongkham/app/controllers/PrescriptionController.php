<?php
/** Quản lý đơn thuốc (chi tiết đơn thuốc) */
class PrescriptionController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $prescription = $this->model("Prescription");
        $thongBao     = "";
        $loaiThongBao = "";

        // ----- XÓA (trả thuốc về kho) -----
        if (isset($_GET["xoa"])) {
            $maChiTiet = (int) $_GET["xoa"];

            if ($maChiTiet > 0) {
                [$ok, $thongBao] = $prescription->remove($maChiTiet);
                $loaiThongBao = $ok ? "success" : "error";
            }
        }

        // ----- THÊM (trừ thuốc trong kho) -----
        if (isset($_POST["them"])) {
            $maHoSo   = (int) ($_POST["MaHoSo"] ?? 0);
            $maThuoc  = (int) ($_POST["MaThuoc"] ?? 0);
            $soLuong  = (int) ($_POST["SoLuong"] ?? 0);
            $cachDung = trim($_POST["CachDung"] ?? "");

            if ($maHoSo <= 0 || $maThuoc <= 0 || $soLuong <= 0 || $cachDung === "") {
                $thongBao = "Vui lòng nhập đầy đủ thông tin!";
                $loaiThongBao = "error";
            } else {
                [$ok, $thongBao] = $prescription->add($maHoSo, $maThuoc, $soLuong, $cachDung);
                $loaiThongBao = $ok ? "success" : "error";
            }
        }

        // ----- SỬA (điều chỉnh lại kho) -----
        if (isset($_POST["sua"])) {
            $maChiTiet = (int) ($_POST["MaChiTiet"] ?? 0);
            $maHoSo    = (int) ($_POST["MaHoSo"] ?? 0);
            $maThuoc   = (int) ($_POST["MaThuoc"] ?? 0);
            $soLuong   = (int) ($_POST["SoLuong"] ?? 0);
            $cachDung  = trim($_POST["CachDung"] ?? "");

            if ($maChiTiet <= 0 || $maHoSo <= 0 || $maThuoc <= 0 || $soLuong <= 0 || $cachDung === "") {
                $thongBao = "Vui lòng nhập đầy đủ thông tin!";
                $loaiThongBao = "error";
            } else {
                [$ok, $thongBao] = $prescription->change($maChiTiet, $maHoSo, $maThuoc, $soLuong, $cachDung);
                $loaiThongBao = $ok ? "success" : "error";
            }
        }

        $maSua    = (int) ($_GET["sua"] ?? 0);
        $duLieuSua = $maSua > 0 ? $prescription->find($maSua) : null;

        // Dữ liệu cho các ô chọn trong form
        $resultHoSoList = $this->model("MedicalRecord")->listForSelect();
        $resultThuocList = $prescription->medicineList();

        $tuKhoa = trim($_GET["timkiem"] ?? "");
        $resultDanhSach = $prescription->all($tuKhoa);

        $thongKe     = $prescription->stats();
        $tongDon     = $thongKe["tongDon"];
        $tongSoLuong = $thongKe["tongSoLuong"];
        $tongTien    = $thongKe["tongTien"];

        $this->render(
            "prescriptions/index",
            compact("thongBao", "loaiThongBao", "duLieuSua", "resultHoSoList", "resultThuocList",
                    "tuKhoa", "resultDanhSach", "tongDon", "tongSoLuong", "tongTien"),
            ["title" => "Quản lý đơn thuốc", "css" => "prescriptions"]
        );
    }
}
