<?php
/** Trang chủ: thống kê tổng quan */
class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $dashboard = $this->model("Dashboard");

        $tongBenhNhan  = $dashboard->countTable("benhnhan");
        $tongBacSi     = $dashboard->countTable("bacsi");
        $tongLichKham  = $dashboard->countTable("lichkham");
        $tongHoSo      = $dashboard->countTable("hosokham");
        $tongThuoc     = $dashboard->countTable("thuoc");
        $tongDonThuoc  = $dashboard->countTable("chitietdonthuoc");

        $resultLichHomNay = $this->model("Appointment")->today(date("Y-m-d"), 5);

        // Hồ sơ khám gần đây chỉ dành cho Admin
        $resultHoSoGanDay = Auth::isAdmin()
            ? $this->model("MedicalRecord")->recent(5)
            : [];

        $this->render(
            "dashboard/index",
            compact(
                "tongBenhNhan", "tongBacSi", "tongLichKham", "tongHoSo",
                "tongThuoc", "tongDonThuoc", "resultLichHomNay", "resultHoSoGanDay"
            ),
            ["title" => "Trang chủ - Quản lý phòng khám", "css" => "dashboard"]
        );
    }
}
