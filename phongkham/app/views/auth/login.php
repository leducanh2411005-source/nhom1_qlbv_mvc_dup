<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập - Quản lý phòng khám</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="login-box">

    <div class="login-logo">
        🏥
    </div>

    <h2>QUẢN LÝ PHÒNG KHÁM</h2>

    <p class="login-subtitle">
        Đăng nhập vào hệ thống
    </p>

    <?php if ($thongbao != "") { ?>

        <div class="thongbao">
            ⚠️ <?php echo $thongbao; ?>
        </div>

    <?php } ?>


    <form method="POST">

        <div class="form-group">

            <label>Tên đăng nhập</label>

            <input
                type="text"
                name="tenDangNhap"
                placeholder="Nhập tên đăng nhập"
                required
                autofocus
            >

        </div>


        <div class="form-group">

            <label>Mật khẩu</label>

            <input
                type="password"
                name="matKhau"
                placeholder="Nhập mật khẩu"
                required
            >

        </div>


        <button
            type="submit"
            name="dangnhap"
            class="btn-login"
        >
            🔐 ĐĂNG NHẬP
        </button>

    </form>


    <div class="login-footer">
        © 2026 - Hệ thống quản lý phòng khám
    </div>

</div>

</body>
</html>