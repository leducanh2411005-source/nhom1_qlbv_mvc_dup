<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        <span>🏥</span>
        PHÒNG KHÁM
    </div>

    <div class="menu-title">
        Quản lý
    </div>

    <div class="menu">

        <a href="index.php?page=dashboard">
            🏠 Trang chủ
        </a>

        <a href="index.php?page=patients">
            👤 Bệnh nhân
        </a>

        <a href="index.php?page=doctors">
            👨‍⚕️ Bác sĩ
        </a>

        <a href="index.php?page=appointments">
            📅 Lịch khám
        </a>

        <a href="index.php?page=medical_records">
            📋 Hồ sơ khám
        </a>

        <a href="index.php?page=medicines">
            💊 Thuốc
        </a>

        <a href="index.php?page=prescriptions">
            🧾 Đơn thuốc
        </a>

        <a href="index.php?page=users" class="active">
            👥 Tài khoản
        </a>

        <a href="index.php?page=logout" class="logout"
           onclick="return confirm('Bạn có chắc muốn đăng xuất không?');">
            🚪 Đăng xuất
        </a>

    </div>

</div>


<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>Quản lý tài khoản</h1>

            <p>
                Quản lý tài khoản đăng nhập hệ thống phòng khám
            </p>

        </div>

        <div class="user">

            <div class="avatar">

                <?php
                echo strtoupper(
                    substr($_SESSION["hoten"], 0, 1)
                );
                ?>

            </div>

            <div class="user-info">

                <strong>
                    <?= htmlspecialchars($_SESSION["hoten"]) ?>
                </strong>

                <small>
                    <?= htmlspecialchars($_SESSION["vaitro"]) ?>
                </small>

            </div>

        </div>

    </div>


    <!-- THÔNG BÁO -->

    <?php if ($thongbao != ""): ?>

        <div class="success">
            ✅ <?= htmlspecialchars($thongbao) ?>
        </div>

    <?php endif; ?>


    <?php if ($loi != ""): ?>

        <div class="error">
            ❌ <?= htmlspecialchars($loi) ?>
        </div>

    <?php endif; ?>


    <!-- THỐNG KÊ -->

    <div class="stats">

        <div class="stat">
            <h3>Tổng tài khoản</h3>
            <p><?= $total ?></p>
        </div>

        <div class="stat">
            <h3>Quản trị viên</h3>
            <p><?= $totalAdmin ?></p>
        </div>

        <div class="stat">
            <h3>Bác sĩ</h3>
            <p><?= $totalDoctor ?></p>
        </div>

        <div class="stat">
            <h3>Nhân viên</h3>
            <p><?= $totalStaff ?></p>
        </div>

    </div>


    <!-- FORM -->

    <div class="card">

        <div class="card-title">

            <?= $edit ? "✏️ Sửa tài khoản" : "➕ Thêm tài khoản" ?>

        </div>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $edit["MaTaiKhoan"] ?? 0 ?>"
            >

            <div class="form-grid">

                <!-- TÊN ĐĂNG NHẬP -->

                <div class="form-group">

                    <label>
                        Tên đăng nhập *
                    </label>

                    <input
                        type="text"
                        name="TenDangNhap"
                        placeholder="Nhập tên đăng nhập"
                        required
                        value="<?= htmlspecialchars($edit["TenDangNhap"] ?? "") ?>"
                    >

                </div>


                <!-- MẬT KHẨU -->

                <div class="form-group">

                    <label>
                        Mật khẩu *
                    </label>

                    <input
                        type="password"
                        name="MatKhau"
                        placeholder="<?= $edit ? "Để trống nếu không đổi" : "Nhập mật khẩu" ?>"
                        <?= $edit ? "" : "required" ?>
                    >

                    <?php if ($edit): ?>

                        <div class="note">
                            Để trống nếu muốn giữ mật khẩu cũ.
                        </div>

                    <?php endif; ?>

                </div>


                <!-- HỌ TÊN -->

                <div class="form-group">

                    <label>
                        Họ và tên *
                    </label>

                    <input
                        type="text"
                        name="HoTen"
                        placeholder="Nhập họ và tên"
                        required
                        value="<?= htmlspecialchars($edit["HoTen"] ?? "") ?>"
                    >

                </div>


                <!-- VAI TRÒ -->

                <div class="form-group">

                    <label>
                        Vai trò
                    </label>

                    <select name="VaiTro">

                        <option
                            value="Admin"
                            <?= (($edit["VaiTro"] ?? "") == "Admin") ? "selected" : "" ?>
                        >
                            Quản trị viên
                        </option>

                        <option
                            value="BacSi"
                            <?= (($edit["VaiTro"] ?? "") == "BacSi") ? "selected" : "" ?>
                        >
                            Bác sĩ
                        </option>

                        <option
                            value="NhanVien"
                            <?= (($edit["VaiTro"] ?? "NhanVien") == "NhanVien") ? "selected" : "" ?>
                        >
                            Nhân viên
                        </option>

                    </select>

                </div>

            </div>


            <!-- BUTTON -->

            <div class="buttons">

                <button
                    type="submit"
                    class="btn-primary"
                >
                    <?= $edit ? "💾 Cập nhật" : "➕ Thêm tài khoản" ?>
                </button>

                <?php if ($edit): ?>

                    <a
                        href="index.php?page=users"
                        class="btn btn-cancel"
                    >
                        Hủy
                    </a>

                <?php endif; ?>

            </div>

        </form>

    </div>


    <!-- TÌM KIẾM -->

    <div class="card">

        <div class="card-title">
            🔎 Tìm kiếm tài khoản
        </div>

        <form
            method="GET"
            class="search"
        >
            <input type="hidden" name="page" value="users">

            <input
                type="text"
                name="timkiem"
                placeholder="Nhập tên đăng nhập, họ tên hoặc vai trò..."
                value="<?= htmlspecialchars($timkiem) ?>"
            >

            <button
                type="submit"
                class="btn-primary"
            >
                🔎 Tìm kiếm
            </button>

            <?php if ($timkiem != ""): ?>

                <a
                    href="index.php?page=users"
                    class="btn btn-cancel"
                >
                    Xóa tìm kiếm
                </a>

            <?php endif; ?>

        </form>

    </div>


    <!-- DANH SÁCH -->

    <div class="card">

        <div class="card-title">
            👥 Danh sách tài khoản
        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Mã</th>

                        <th>Tên đăng nhập</th>

                        <th>Họ và tên</th>

                        <th>Vai trò</th>

                        <th>Thao tác</th>

                    </tr>

                </thead>

                <tbody>

                <?php if (!empty($result)): ?>

                    <?php foreach ($result as $row): ?>

                        <tr>

                            <td>
                                <?= $row["MaTaiKhoan"] ?>
                            </td>

                            <td>
                                <strong>
                                    <?= htmlspecialchars($row["TenDangNhap"]) ?>
                                </strong>
                            </td>

                            <td>
                                <?= htmlspecialchars($row["HoTen"]) ?>
                            </td>

                            <td>

                                <?php

                                if ($row["VaiTro"] == "Admin") {

                                    echo '<span class="badge badge-admin">
                                            Quản trị viên
                                          </span>';

                                } elseif ($row["VaiTro"] == "BacSi") {

                                    echo '<span class="badge badge-doctor">
                                            Bác sĩ
                                          </span>';

                                } else {

                                    echo '<span class="badge badge-staff">
                                            Nhân viên
                                          </span>';
                                }

                                ?>

                            </td>

                            <td>

                                <div class="actions">

                                    <a
                                        href="index.php?page=users&sua=<?= $row["MaTaiKhoan"] ?>"
                                        class="btn btn-edit"
                                    >
                                        ✏️ Sửa
                                    </a>

                                    <?php if ($row["MaTaiKhoan"] != $_SESSION["MaTaiKhoan"]): ?>

                                        <a
                                            href="index.php?page=users&xoa=<?= $row["MaTaiKhoan"] ?>"
                                            class="btn btn-delete"
                                            onclick="return confirm('Bạn có chắc muốn xóa tài khoản này không?');"
                                        >
                                            🗑️ Xóa
                                        </a>

                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="5"
                            class="empty"
                        >
                            Không tìm thấy tài khoản nào.
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
