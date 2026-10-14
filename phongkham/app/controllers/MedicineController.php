<?php
/** Quản lý thuốc */
class MedicineController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $medicine = $this->model("Medicine");
        $thongBao = "";

        // ----- XÓA -----
        if (isset($_GET["xoa"])) {
            $maThuoc = (int) $_GET["xoa"];

            if ($maThuoc <= 0) {
                $thongBao = "⚠️ Mã thuốc không hợp lệ.";
            } elseif ($medicine->isUsed($maThuoc)) {
                $thongBao = "⚠️ Không thể xóa thuốc này vì thuốc đã được sử dụng trong đơn thuốc.";
            } elseif ($medicine->delete($maThuoc)) {
                redirect("medicines");
            } else {
                $thongBao = "❌ Không thể xóa thuốc: " . $medicine->error;
            }
        }

        // ----- THÊM -----
        if (isset($_POST["them"])) {
            $loi = $this->validate($data);

            if ($loi !== "") {
                $thongBao = $loi;
            } elseif ($medicine->create($data)) {
                redirect("medicines");
            } else {
                $thongBao = "❌ Có lỗi khi thêm thuốc: " . $medicine->error;
            }
        }

        // ----- SỬA -----
        if (isset($_POST["sua"])) {
            $maThuoc = (int) ($_POST["MaThuoc"] ?? 0);
            $loi     = $this->validate($data);

            if ($maThuoc <= 0) {
                $thongBao = "⚠️ Mã thuốc không hợp lệ.";
            } elseif ($loi !== "") {
                $thongBao = $loi;
            } elseif ($medicine->update($maThuoc, $data)) {
                redirect("medicines");
            } else {
                $thongBao = "❌ Có lỗi khi sửa thuốc: " . $medicine->error;
            }
        }

        $idSua    = (int) ($_GET["sua"] ?? 0);
        $thuocSua = $idSua > 0 ? $medicine->find($idSua) : null;

        $tuKhoa = isset($_GET["timkiem"]) ? trim($_GET["timkiem"]) : "";
        $result = $medicine->all($tuKhoa);

        $tongThuoc   = $medicine->count();
        $tongSoLuong = $medicine->totalQuantity();
        $thuocSapHet = $medicine->lowStockCount();

        $this->render(
            "medicines/index",
            compact("thongBao", "thuocSua", "tuKhoa", "result",
                    "tongThuoc", "tongSoLuong", "thuocSapHet"),
            ["title" => "Quản lý thuốc", "css" => "medicines"]
        );
    }

    /**
     * Kiểm tra dữ liệu form. Trả về chuỗi lỗi ("" nếu hợp lệ)
     * và đưa dữ liệu đã chuẩn hóa ra biến $data (truyền tham chiếu).
     */
    private function validate(&$data): string
    {
        $tenThuoc  = trim($_POST["tenThuoc"] ?? "");
        $donViTinh = trim($_POST["donViTinh"] ?? "");
        $donGia    = $_POST["donGia"] ?? "";
        $soLuong   = $_POST["soLuong"] ?? "";
        $moTa      = trim($_POST["moTa"] ?? "");

        if ($tenThuoc === "" || $donViTinh === "" || $donGia === "" || $soLuong === "") {
            return "⚠️ Vui lòng nhập đầy đủ thông tin thuốc!";
        }
        if (!is_numeric($donGia)) {
            return "⚠️ Đơn giá phải là số.";
        }
        if (!is_numeric($soLuong)) {
            return "⚠️ Số lượng phải là số.";
        }
        if (floatval($donGia) < 0) {
            return "⚠️ Đơn giá không được nhỏ hơn 0.";
        }
        if (intval($soLuong) < 0) {
            return "⚠️ Số lượng không được nhỏ hơn 0.";
        }

        $data = [
            "tenThuoc"  => $tenThuoc,
            "donViTinh" => $donViTinh,
            "donGia"    => floatval($donGia),
            "soLuong"   => intval($soLuong),
            "moTa"      => $moTa,
        ];

        return "";
    }
}
