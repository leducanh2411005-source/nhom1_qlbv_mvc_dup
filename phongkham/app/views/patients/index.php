<!-- ==============================
     SIDEBAR
============================== -->

<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">
            🏥
        </div>

        <div>
            <h2>PHÒNG KHÁM</h2>
            <span>QUẢN LÝ HỆ THỐNG</span>
        </div>

    </div>

    <div class="menu">

        <!-- TRANG CHỦ -->
        <a href="index.php?page=dashboard">
            <span>🏠</span>
            Trang chủ
        </a>

        <!-- BỆNH NHÂN -->
        <a href="index.php?page=patients" class="active">
            <span>👤</span>
            Bệnh nhân
        </a>

        <!-- =========================================
             CHỈ ADMIN MỚI ĐƯỢC THẤY BÁC SĨ
        ========================================== -->
        <?php if ($vaiTro == "Admin") { ?>

            <a href="index.php?page=doctors">
                <span>👨‍⚕️</span>
                Bác sĩ
            </a>

        <?php } ?>

        <!-- LỊCH KHÁM -->
        <a href="index.php?page=appointments">
            <span>📅</span>
            Lịch khám
        </a>

        <!-- =========================================
             CHỈ ADMIN MỚI ĐƯỢC THẤY HỒ SƠ KHÁM
        ========================================== -->
        <?php if ($vaiTro == "Admin") { ?>

            <a href="index.php?page=medical_records">
                <span>📋</span>
                Hồ sơ khám
            </a>

        <?php } ?>

        <!-- THUỐC -->
        <a href="index.php?page=medicines">
            <span>💊</span>
            Thuốc
        </a>

        <!-- =========================================
             ADMIN VÀ NHÂN VIÊN ĐƯỢC THẤY ĐƠN THUỐC
        ========================================== -->
        <?php if ($vaiTro == "Admin" || $vaiTro == "NhanVien") { ?>

            <a href="index.php?page=prescriptions">
                <span>🧾</span>
                Đơn thuốc
            </a>

        <?php } ?>

        <!-- =========================================
             CHỈ ADMIN MỚI ĐƯỢC THẤY TÀI KHOẢN
        ========================================== -->
        <?php if ($vaiTro == "Admin") { ?>

            <a href="index.php?page=users">
                <span>👥</span>
                Tài khoản
            </a>

        <?php } ?>

        <!-- ĐĂNG XUẤT -->
        <a href="index.php?page=logout">
            <span>🚪</span>
            Đăng xuất
        </a>

    </div>

</div>

<!-- ==============================
     MAIN
============================== -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Quản lý bệnh nhân
            </h1>

            <p>
                Quản lý thông tin bệnh nhân của phòng khám
            </p>

        </div>

        <div class="user-info">

            <div class="avatar">

                <?php

                echo strtoupper(
                    substr(
                        $hoTen,
                        0,
                        1
                    )
                );

                ?>

            </div>

            <div>

                <strong>
                    <?php
                    echo htmlspecialchars($hoTen);
                    ?>
                </strong>

                <small>
                    <?php
                    echo htmlspecialchars($vaiTro);
                    ?>
                </small>

            </div>

        </div>

    </div>

    <!-- THÔNG BÁO -->

    <?php if ($thongBao != "") { ?>

        <div class="alert">

            ⚠️

            <?php
            echo htmlspecialchars($thongBao);
            ?>

        </div>

    <?php } ?>

    <!-- THỐNG KÊ -->

    <div class="stat-card">

        <div class="stat-left">

            <small>
                TỔNG SỐ BỆNH NHÂN
            </small>

            <strong>
                <?php
                echo $tongBenhNhan;
                ?>
            </strong>

        </div>

        <div class="stat-icon">
            👤
        </div>

    </div>

    <!-- FORM THÊM / SỬA -->

    <div class="card">

        <div class="card-title">

            <h2>

                <?php

                if ($benhNhanSua) {

                    echo "✏️ Sửa thông tin bệnh nhân";

                } else {

                    echo "➕ Thêm bệnh nhân mới";

                }

                ?>

            </h2>

        </div>

        <?php if ($benhNhanSua) { ?>

            <!-- FORM SỬA -->

            <form method="POST">

                <input
                    type="hidden"
                    name="MaBenhNhan"
                    value="<?php echo $benhNhanSua["MaBenhNhan"]; ?>"
                >

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Họ và tên *
                        </label>

                        <input
                            type="text"
                            name="hoTen"
                            value="<?php echo htmlspecialchars($benhNhanSua["HoTen"]); ?>"
                            placeholder="Nhập họ và tên bệnh nhân"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Ngày sinh *
                        </label>

                        <input
                            type="date"
                            name="ngaySinh"
                            value="<?php echo htmlspecialchars($benhNhanSua["NgaySinh"]); ?>"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Giới tính *
                        </label>

                        <select name="gioiTinh" required>

                            <option value="">
                                -- Chọn giới tính --
                            </option>

                            <option
                                value="Nam"
                                <?php
                                if ($benhNhanSua["GioiTinh"] == "Nam") {
                                    echo "selected";
                                }
                                ?>
                            >
                                Nam
                            </option>

                            <option
                                value="Nữ"
                                <?php
                                if ($benhNhanSua["GioiTinh"] == "Nữ") {
                                    echo "selected";
                                }
                                ?>
                            >
                                Nữ
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>
                            Số điện thoại *
                        </label>

                        <input
                            type="text"
                            name="soDienThoai"
                            value="<?php echo htmlspecialchars($benhNhanSua["SoDienThoai"]); ?>"
                            placeholder="Nhập số điện thoại"
                            required
                        >

                    </div>

                    <div class="form-group form-full">

                        <label>
                            Địa chỉ *
                        </label>

                        <input
                            type="text"
                            name="diaChi"
                            value="<?php echo htmlspecialchars($benhNhanSua["DiaChi"]); ?>"
                            placeholder="Nhập địa chỉ bệnh nhân"
                            required
                        >

                    </div>

                </div>

                <div style="margin-top:20px;">

                    <button
                        type="submit"
                        name="sua"
                        class="btn btn-primary"
                    >
                        💾 Lưu thay đổi
                    </button>

                    <a
                        href="index.php?page=patients"
                        class="btn btn-secondary"
                    >
                        ❌ Hủy
                    </a>

                </div>

            </form>

        <?php } else { ?>

            <!-- FORM THÊM -->

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Họ và tên *
                        </label>

                        <input
                            type="text"
                            name="hoTen"
                            placeholder="Nhập họ và tên bệnh nhân"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Ngày sinh *
                        </label>

                        <input
                            type="date"
                            name="ngaySinh"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label>
                            Giới tính *
                        </label>

                        <select
                            name="gioiTinh"
                            required
                        >

                            <option value="">
                                -- Chọn giới tính --
                            </option>

                            <option value="Nam">
                                Nam
                            </option>

                            <option value="Nữ">
                                Nữ
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>
                            Số điện thoại *
                        </label>

                        <input
                            type="text"
                            name="soDienThoai"
                            placeholder="Nhập số điện thoại"
                            required
                        >

                    </div>

                    <div class="form-group form-full">

                        <label>
                            Địa chỉ *
                        </label>

                        <input
                            type="text"
                            name="diaChi"
                            placeholder="Nhập địa chỉ bệnh nhân"
                            required
                        >

                    </div>

                </div>

                <div style="margin-top:20px;">

                    <button
                        type="submit"
                        name="them"
                        class="btn btn-primary"
                    >
                        ➕ Thêm bệnh nhân
                    </button>

                </div>

            </form>

        <?php } ?>

    </div>

    <!-- TÌM KIẾM -->

    <div class="card">

        <div class="card-title">

            <h2>
                🔎 Tìm kiếm bệnh nhân
            </h2>

        </div>

        <form
            method="GET"
            class="search-box"
        >
            <input type="hidden" name="page" value="patients">

            <input
                type="text"
                name="timkiem"
                value="<?php echo htmlspecialchars($tuKhoa); ?>"
                placeholder="Nhập họ tên hoặc số điện thoại..."
            >

            <button
                type="submit"
                class="btn btn-primary"
            >
                🔎 Tìm kiếm
            </button>

            <a
                href="index.php?page=patients"
                class="btn btn-secondary"
            >
                🔄 Xóa tìm kiếm
            </a>

        </form>

    </div>

    <!-- DANH SÁCH BỆNH NHÂN -->

    <div class="card">

        <div class="card-title">

            <h2>
                👤 Danh sách bệnh nhân
            </h2>

            <div class="patient-count">

                Tổng bệnh nhân:

                <strong>
                    <?php
                    echo $tongBenhNhan;
                    ?>
                </strong>

            </div>

        </div>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Mã
                        </th>

                        <th>
                            Họ và tên
                        </th>

                        <th>
                            Ngày sinh
                        </th>

                        <th>
                            Giới tính
                        </th>

                        <th>
                            Số điện thoại
                        </th>

                        <th>
                            Địa chỉ
                        </th>

                        <th>
                            Thao tác
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($result && !empty($result)) {

                        foreach ($result as $row) {

                    ?>

                    <tr>

                        <td>

                            <?php
                            echo $row["MaBenhNhan"];
                            ?>

                        </td>

                        <td>

                            <span class="patient-name">

                                <?php
                                echo htmlspecialchars(
                                    $row["HoTen"]
                                );
                                ?>

                            </span>

                        </td>

                        <td>

                            <?php

                            if (!empty($row["NgaySinh"])) {

                                echo date(
                                    "d/m/Y",
                                    strtotime($row["NgaySinh"])
                                );

                            } else {

                                echo "---";

                            }

                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["GioiTinh"]
                            );
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["SoDienThoai"]
                            );
                            ?>

                        </td>

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["DiaChi"]
                            );
                            ?>

                        </td>

                        <td>

                            <div class="action-buttons">

                                <a
                                    href="index.php?page=patients&sua=<?php echo $row["MaBenhNhan"]; ?>"
                                    class="btn btn-edit"
                                >
                                    ✏️ Sửa
                                </a>

                                <a
                                    href="index.php?page=patients&xoa=<?php echo $row["MaBenhNhan"]; ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Bạn có chắc muốn xóa bệnh nhân này không?');"
                                >
                                    🗑️ Xóa
                                </a>

                            </div>

                        </td>

                    </tr>

                    <?php

                        }

                    } else {

                    ?>

                    <tr>

                        <td
                            colspan="7"
                            class="empty"
                        >
                            👤 Không tìm thấy bệnh nhân.
                        </td>

                    </tr>

                    <?php

                    }

                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
