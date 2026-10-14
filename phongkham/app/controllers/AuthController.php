<?php
/** Đăng nhập / đăng xuất */
class AuthController extends Controller
{
    public function login(): void
    {
        $thongbao = "";

        if (isset($_POST["dangnhap"])) {
            $tenDangNhap = $_POST["tenDangNhap"] ?? "";
            $matKhau     = $_POST["matKhau"] ?? "";

            $user = $this->model("User")->authenticate($tenDangNhap, $matKhau);

            if ($user) {
                Auth::login($user);
                redirect("dashboard");
            }

            $thongbao = "Tên đăng nhập hoặc mật khẩu không đúng!";
        }

        $this->render("auth/login", ["thongbao" => $thongbao], ["layout" => false]);
    }

    public function logout(): void
    {
        Auth::logout();
        redirect("login");
    }
}
