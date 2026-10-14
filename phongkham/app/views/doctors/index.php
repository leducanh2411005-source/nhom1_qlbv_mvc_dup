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

            <span>
                QUẢN LÝ HỆ THỐNG
            </span>

        </div>

    </div>


    <div class="menu">

        <a href="index.php?page=dashboard">

            <span>🏠</span>

            Trang chủ

        </a>


        <a href="index.php?page=patients">

            <span>👤</span>

            Bệnh nhân

        </a>
        <?php
        // Chỉ Admin và Nhân viên được nhìn thấy menu Bác sĩ
        if ($vaiTro == "Admin" || $vaiTro == "NhanVien") {
        ?>
        <a href="index.php?page=doctors" class="active">
            <span>👨‍⚕️</span>
            Bác sĩ
        </a>
        <?php
        }
        ?>


        <a href="index.php?page=appointments">

            <span>📅</span>

            Lịch khám

        </a>


        <a href="index.php?page=medical_records">

            <span>📋</span>

            Hồ sơ khám

        </a>


        <a href="index.php?page=medicines">

            <span>💊</span>

            Thuốc

        </a>


        <a href="index.php?page=prescriptions">

            <span>🧾</span>

            Đơn thuốc

        </a>


        <?php

        if ($vaiTro == "Admin") {

        ?>

            <a href="index.php?page=users">

                <span>👥</span>

                Tài khoản

            </a>

        <?php

        }

        ?>


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
                Quản lý bác sĩ
            </h1>

            <p>
                Quản lý thông tin đội ngũ bác sĩ của phòng khám
            </p>

        </div>


        <div class="user-info">

            <div class="avatar">

                <?php

                echo strtoupper(
                    substr(
                        $hoTenUser,
                        0,
                        1
                    )
                );

                ?>

            </div>


            <div>

                <strong>

                    <?php

                    echo htmlspecialchars(
                        $hoTenUser
                    );

                    ?>

                </strong>


                <small>

                    <?php

                    echo htmlspecialchars(
                        $vaiTro
                    );

                    ?>

                </small>

            </div>

        </div>

    </div>


    <!-- THÔNG BÁO -->

    <?php

    if ($thongBao != "") {

    ?>

        <div class="alert">

            ⚠️
            <?php

            echo htmlspecialchars(
                $thongBao
            );

            ?>

        </div>

    <?php

    }

    ?>


    <!-- ==============================
         FORM THÊM / SỬA
    ============================== -->

    <div class="card">

        <div class="card-title">

            <h2>

                <?php

                if ($bacSiSua) {

                    echo "✏️ Sửa thông tin bác sĩ";

                } else {

                    echo "➕ Thêm bác sĩ";

                }

                ?>

            </h2>


            <div class="doctor-count">

                Tổng bác sĩ:

                <strong>

                    <?php

                    echo $tongBacSi;

                    ?>

                </strong>

            </div>

        </div>


        <?php

        if ($bacSiSua) {

        ?>

            <!-- FORM SỬA -->

            <form method="POST">

                <input
                    type="hidden"
                    name="MaBacSi"
                    value="<?php echo $bacSiSua["MaBacSi"]; ?>"
                >


                <div class="form-grid">


                    <div class="form-group">

                        <label>
                            Họ và tên *
                        </label>

                        <input
                            type="text"
                            name="hoTen"
                            value="<?php echo htmlspecialchars($bacSiSua["HoTen"]); ?>"
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

                            <option
                                value="Nam"
                                <?php
                                if (
                                    $bacSiSua["GioiTinh"]
                                    == "Nam"
                                )
                                    echo "selected";
                                ?>
                            >
                                Nam
                            </option>

                            <option
                                value="Nữ"
                                <?php
                                if (
                                    $bacSiSua["GioiTinh"]
                                    == "Nữ"
                                )
                                    echo "selected";
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
                            value="<?php echo htmlspecialchars($bacSiSua["SoDienThoai"]); ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Khoa *
                        </label>

                        <input
                            type="text"
                            name="khoa"
                            value="<?php echo htmlspecialchars($bacSiSua["Khoa"]); ?>"
                            placeholder="VD: Khoa Nội"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Chuyên khoa *
                        </label>

                        <input
                            type="text"
                            name="chuyenKhoa"
                            value="<?php echo htmlspecialchars($bacSiSua["ChuyenKhoa"]); ?>"
                            placeholder="VD: Nội khoa"
                            required
                        >

                    </div>


                    <div class="form-group form-full">

                        <label>
                            Chuyên môn / Có thể chữa *
                        </label>

                        <input
                            type="text"
                            name="chuyenMon"
                            value="<?php echo htmlspecialchars($bacSiSua["ChuyenMon"]); ?>"
                            placeholder="VD: Tim mạch, huyết áp..."
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
                        href="index.php?page=doctors"
                        class="btn btn-secondary"
                    >
                        ❌ Hủy
                    </a>

                </div>

            </form>


        <?php

        } else {

        ?>


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
                            placeholder="Nhập họ và tên bác sĩ"
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


                    <div class="form-group">

                        <label>
                            Khoa *
                        </label>

                        <input
                            type="text"
                            name="khoa"
                            placeholder="VD: Khoa Nội"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Chuyên khoa *
                        </label>

                        <input
                            type="text"
                            name="chuyenKhoa"
                            placeholder="VD: Nội khoa"
                            required
                        >

                    </div>


                    <div class="form-group form-full">

                        <label>
                            Chuyên môn / Có thể chữa *
                        </label>

                        <input
                            type="text"
                            name="chuyenMon"
                            placeholder="VD: Tim mạch, huyết áp, tiểu đường..."
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

                        ➕ Thêm bác sĩ

                    </button>

                </div>

            </form>


        <?php

        }

        ?>

    </div>


    <!-- ==============================
         TÌM KIẾM
    ============================== -->

    <div class="card">

        <div class="card-title">

            <h2>
                🔎 Tìm kiếm bác sĩ
            </h2>

        </div>


        <form
            method="GET"
            class="search-box"
        >
            <input type="hidden" name="page" value="doctors">

            <input
                type="text"
                name="timkiem"
                value="<?php echo htmlspecialchars($tuKhoa); ?>"
                placeholder="Tìm theo tên, số điện thoại, khoa, chuyên khoa..."
            >


            <button
                type="submit"
                class="btn btn-primary"
            >
                🔎 Tìm kiếm
            </button>


            <a
                href="index.php?page=doctors"
                class="btn btn-secondary"
            >
                🔄 Làm mới
            </a>

        </form>

    </div>


    <!-- ==============================
         DANH SÁCH BÁC SĨ
    ============================== -->

    <div class="card">

        <div class="card-title">

            <h2>
                👨‍⚕️ Danh sách bác sĩ
            </h2>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Mã BS
                        </th>

                        <th>
                            Họ tên
                        </th>

                        <th>
                            Giới tính
                        </th>

                        <th>
                            Số điện thoại
                        </th>

                        <th>
                            Khoa
                        </th>

                        <th>
                            Chuyên khoa
                        </th>

                        <th>
                            Chuyên môn
                        </th>

                        <th>
                            Thao tác
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    if (
                        $result &&
                        !empty($result)
                    ) {

                        foreach ($result as $row) {

                    ?>

                        <tr>

                            <td>

                                <strong>

                                    #
                                    <?php
                                    echo $row["MaBacSi"];
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <span class="doctor-name">

                                    👨‍⚕️

                                    <?php

                                    echo htmlspecialchars(
                                        $row["HoTen"]
                                    );

                                    ?>

                                </span>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $row["GioiTinh"]
                                );

                                ?>

                            </td>


                            <td>

                                📞

                                <?php

                                echo htmlspecialchars(
                                    $row["SoDienThoai"]
                                );

                                ?>

                            </td>


                            <td>

                                <span class="specialty">

                                    🏥

                                    <?php

                                    echo htmlspecialchars(
                                        $row["Khoa"]
                                    );

                                    ?>

                                </span>

                            </td>


                            <td>

                                <span class="specialty">

                                    🩺

                                    <?php

                                    echo htmlspecialchars(
                                        $row["ChuyenKhoa"]
                                    );

                                    ?>

                                </span>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $row["ChuyenMon"]
                                );

                                ?>

                            </td>


                            <td>

                                <div class="action-buttons">


                                    <a
                                        href="index.php?page=doctors&sua=<?php echo $row["MaBacSi"]; ?>"
                                        class="btn btn-edit"
                                    >

                                        ✏️ Sửa

                                    </a>


                                    <a
                                        href="index.php?page=doctors&xoa=<?php echo $row["MaBacSi"]; ?>"
                                        class="btn btn-delete"

                                        onclick="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này không?');"
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
                                colspan="8"
                                class="empty"
                            >

                                🩺

                                Không tìm thấy bác sĩ nào.

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
