<?php
/**
 * Router: đọc tham số ?page=... trên URL rồi gọi đúng Controller.
 * Ví dụ: index.php?page=patients  ->  PatientController::index()
 */
class Router
{
    // page trên URL  =>  [tên controller, tên hàm]
    private array $routes = [
        "dashboard"       => ["DashboardController", "index"],
        "login"           => ["AuthController", "login"],
        "logout"          => ["AuthController", "logout"],
        "patients"        => ["PatientController", "index"],
        "doctors"         => ["DoctorController", "index"],
        "appointments"    => ["AppointmentController", "index"],
        "medical_records" => ["MedicalRecordController", "index"],
        "medicines"       => ["MedicineController", "index"],
        "prescriptions"   => ["PrescriptionController", "index"],
        "users"           => ["UserController", "index"],
    ];

    public function dispatch(): void
    {
        $page = $_GET["page"] ?? "dashboard";

        if (!isset($this->routes[$page])) {
            http_response_code(404);
            die("404 - Không tìm thấy trang.");
        }

        [$controllerName, $method] = $this->routes[$page];

        require_once __DIR__ . "/../controllers/" . $controllerName . ".php";

        (new $controllerName())->$method();
    }
}
