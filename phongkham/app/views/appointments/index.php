<!-- ==================================================
     SIDEBAR
================================================== -->

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

        <a href="index.php?page=patients">

            <span>👤</span>

            Bệnh nhân

        </a>


        <!-- BÁC SĨ CHỈ ADMIN -->

        <?php if ($laAdmin) { ?>

            <a href="index.php?page=doctors">

                <span>👨‍⚕️</span>

                Bác sĩ

            </a>

        <?php } ?>


        <!-- LỊCH KHÁM -->

        <a
            href="index.php?page=appointments"
            class="active"
        >

            <span>📅</span>

            Lịch khám

        </a>


        <!-- HỒ SƠ KHÁM CHỈ ADMIN -->

        <?php if ($laAdmin) { ?>

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


        <!-- ĐƠN THUỐC -->

        <a href="index.php?page=prescriptions">

            <span>🧾</span>

            Đơn thuốc

        </a>


        <!-- TÀI KHOẢN CHỈ ADMIN -->

        <?php if ($laAdmin) { ?>

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


<!-- ==================================================
     MAIN
================================================== -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Quản lý lịch khám
            </h1>

            <p>
                Quản lý lịch hẹn khám của bệnh nhân
            </p>

        </div>


        <div class="user-info">

            <div class="avatar">

                <?php

                echo htmlspecialchars(
                    strtoupper(
                        mb_substr(
                            $hoTenUser,
                            0,
                            1,
                            "UTF-8"
                        )
                    )
                );

                ?>

            </div>


            <div>

                <strong>
                    <?php echo htmlspecialchars($hoTenUser); ?>
                </strong>

                <small>
                    <?php echo htmlspecialchars($vaiTro); ?>
                </small>

            </div>

        </div>

    </div>


    <!-- THÔNG BÁO -->

    <?php if ($thongBao != "") { ?>

        <div class="alert">

            ⚠️
            <?php echo htmlspecialchars($thongBao); ?>

        </div>

    <?php } ?>


    <!-- ==================================================
         FORM THÊM / SỬA
    ================================================== -->

    <?php if ($laAdmin || $laNhanVien) { ?>

    <div class="card">

        <div class="card-title">

            <h2>

                <?php

                if ($lichKhamSua) {
                    echo "✏️ Sửa lịch khám";
                } else {
                    echo "➕ Thêm lịch khám";
                }

                ?>

            </h2>


            <div class="appointment-count">

                <span class="count-box count-total">

                    Tổng:
                    <?php echo $tongLichKham; ?>

                </span>


                <span class="count-box count-waiting">

                    Chưa khám:
                    <?php echo $tongChuaKham; ?>

                </span>


                <span class="count-box count-done">

                    Đã khám:
                    <?php echo $tongDaKham; ?>

                </span>

            </div>

        </div>


        <?php if ($lichKhamSua) { ?>

        <!-- FORM SỬA -->

        <form method="POST">

            <input
                type="hidden"
                name="MaLichKham"
                value="<?php echo $lichKhamSua["MaLichKham"]; ?>"
            >


            <div class="form-grid">


                <!-- BỆNH NHÂN -->

                <div class="form-group">

                    <label>
                        Bệnh nhân *
                    </label>

                    <select
                        name="maBenhNhan"
                        required
                    >

                        <option value="">
                            -- Chọn bệnh nhân --
                        </option>

                        <?php

                        if ($resultBenhNhan) {

                            foreach ($resultBenhNhan as $bn) {

                        ?>

                            <option
                                value="<?php echo $bn["MaBenhNhan"]; ?>"
                                <?php
                                if (
                                    $lichKhamSua["MaBenhNhan"]
                                    == $bn["MaBenhNhan"]
                                ) {
                                    echo "selected";
                                }
                                ?>
                            >

                                <?php echo htmlspecialchars($bn["HoTen"]); ?>

                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>

                </div>


                <!-- BÁC SĨ CHỈ ADMIN -->

                <?php if ($laAdmin) { ?>

                <div class="form-group">

                    <label>
                        Bác sĩ *
                    </label>

                    <select
                        name="maBacSi"
                        required
                    >

                        <option value="">
                            -- Chọn bác sĩ --
                        </option>

                        <?php

                        if ($resultBacSi) {

                            foreach ($resultBacSi as $bs) {

                        ?>

                            <option
                                value="<?php echo $bs["MaBacSi"]; ?>"
                                <?php
                                if (
                                    $lichKhamSua["MaBacSi"]
                                    == $bs["MaBacSi"]
                                ) {
                                    echo "selected";
                                }
                                ?>
                            >

                                <?php echo htmlspecialchars($bs["HoTen"]); ?>

                                <?php

                                if (!empty($bs["ChuyenKhoa"])) {
                                    echo " - " .
                                        htmlspecialchars($bs["ChuyenKhoa"]);
                                }

                                ?>

                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>

                </div>

                <?php } else { ?>

                    <!--
                        NHÂN VIÊN KHÔNG HIỂN THỊ BÁC SĨ.
                        Vẫn gửi lại MaBacSi cũ để không làm mất dữ liệu.
                    -->

                    <input
                        type="hidden"
                        name="maBacSi"
                        value="<?php echo intval($lichKhamSua["MaBacSi"]); ?>"
                    >

                <?php } ?>


                <!-- NGÀY KHÁM -->

                <div class="form-group">

                    <label>
                        Ngày khám *
                    </label>

                    <input
                        type="date"
                        name="ngayKham"
                        value="<?php echo htmlspecialchars($lichKhamSua["NgayKham"]); ?>"
                        required
                    >

                </div>


                <!-- GIỜ KHÁM -->

                <div class="form-group">

                    <label>
                        Giờ khám *
                    </label>

                    <input
                        type="time"
                        name="gioKham"
                        value="<?php echo htmlspecialchars($lichKhamSua["GioKham"]); ?>"
                        required
                    >

                </div>


                <!-- TRẠNG THÁI -->

                <div class="form-group">

                    <label>
                        Trạng thái *
                    </label>

                    <select
                        name="trangThai"
                        required
                    >

                        <option
                            value="Chua kham"
                            <?php
                            if (
                                $lichKhamSua["TrangThai"] == "Chua kham" ||
                                $lichKhamSua["TrangThai"] == "Chưa khám"
                            ) {
                                echo "selected";
                            }
                            ?>
                        >
                            Chưa khám
                        </option>


                        <option
                            value="Da kham"     
                            <?php
                            if (
                                $lichKhamSua["TrangThai"] == "Da kham" ||
                                $lichKhamSua["TrangThai"] == "Đã khám"
                            ) {
                                echo "selected";
                            }
                            ?>
                        >
                            Đã khám
                        </option>


                        <option
                            value="Huy"
                            <?php
                            if (
                                $lichKhamSua["TrangThai"] == "Huy" ||
                                $lichKhamSua["TrangThai"] == "Hủy"
                            ) {
                                echo "selected";
                            }
                            ?>
                        >
                            Hủy
                        </option>

                    </select>

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
                    href="index.php?page=appointments"
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


                <!-- BỆNH NHÂN -->

                <div class="form-group">

                    <label>
                        Bệnh nhân *
                    </label>

                    <select
                        name="maBenhNhan"
                        required
                    >

                        <option value="">
                            -- Chọn bệnh nhân --
                        </option>

                        <?php

                        if (
                            $resultBenhNhan &&
                            !empty($resultBenhNhan)
                        ) {

                            foreach ($resultBenhNhan as $bn) {

                        ?>

                            <option
                                value="<?php echo $bn["MaBenhNhan"]; ?>"
                            >

                                <?php echo htmlspecialchars($bn["HoTen"]); ?>

                            </option>

                        <?php

                            }

                        } else {

                        ?>

                            <option value="">
                                Chưa có bệnh nhân
                            </option>

                        <?php } ?>

                    </select>

                </div>


                <!-- BÁC SĨ CHỈ ADMIN -->

                <?php if ($laAdmin) { ?>

                <div class="form-group">

                    <label>
                        Bác sĩ *
                    </label>

                    <select
                        name="maBacSi"
                        required
                    >

                        <option value="">
                            -- Chọn bác sĩ --
                        </option>

                        <?php

                        if (
                            $resultBacSi &&
                            !empty($resultBacSi)
                        ) {

                            foreach ($resultBacSi as $bs) {

                        ?>

                            <option
                                value="<?php echo $bs["MaBacSi"]; ?>"
                            >

                                <?php echo htmlspecialchars($bs["HoTen"]); ?>

                                <?php

                                if (!empty($bs["ChuyenKhoa"])) {
                                    echo " - " .
                                        htmlspecialchars($bs["ChuyenKhoa"]);
                                }

                                ?>

                            </option>

                        <?php

                            }

                        } else {

                        ?>

                            <option value="">
                                Chưa có dữ liệu
                            </option>

                        <?php } ?>

                    </select>

                </div>

                <?php } else { ?>

                    <!--
                        Nhân viên không nhìn thấy trường bác sĩ.
                        Giá trị mặc định 0 sẽ được kiểm tra ở PHP.
                    -->

                    <input
                        type="hidden"
                        name="maBacSi"
                        value="0"
                    >

                <?php } ?>


                <!-- NGÀY KHÁM -->

                <div class="form-group">

                    <label>
                        Ngày khám *
                    </label>

                    <input
                        type="date"
                        name="ngayKham"
                        value="<?php echo date("Y-m-d"); ?>"
                        required
                    >

                </div>


                <!-- GIỜ KHÁM -->

                <div class="form-group">

                    <label>
                        Giờ khám *
                    </label>

                    <input
                        type="time"
                        name="gioKham"
                        required
                    >

                </div>


                <!-- TRẠNG THÁI -->

                <div class="form-group">

                    <label>
                        Trạng thái *
                    </label>

                    <select
                        name="trangThai"
                        required
                    >

                        <option value="">
                            -- Chọn trạng thái --
                        </option>

                        <option value="Chua kham">
                            Chưa khám
                        </option>

                        <option value="Da kham">
                            Đã khám
                        </option>

                        <option value="Huy">
                            Hủy
                        </option>

                    </select>

                </div>

            </div>


            <div style="margin-top:20px;">

                <button
                    type="submit"
                    name="them"
                    class="btn btn-primary"
                >
                    ➕ Thêm lịch khám
                </button>

            </div>

        </form>

        <?php } ?>

    </div>

    <?php } ?>


    <!-- ==================================================
         TÌM KIẾM
    ================================================== -->

    <div class="card">

        <div class="card-title">

            <h2>
                🔎 Tìm kiếm lịch khám
            </h2>

        </div>


        <form
            method="GET"
            class="search-box"
        >
            <input type="hidden" name="page" value="appointments">

            <input
                type="text"
                name="timkiem"
                value="<?php echo htmlspecialchars($tuKhoa); ?>"
                placeholder="<?php
                    echo $laAdmin
                        ? 'Tìm theo bệnh nhân, bác sĩ, chuyên khoa, ngày khám...'
                        : 'Tìm theo bệnh nhân, ngày khám, trạng thái...';
                ?>"
            >


            <button
                type="submit"
                class="btn btn-primary"
            >
                🔎 Tìm kiếm
            </button>


            <a
                href="index.php?page=appointments"
                class="btn btn-secondary"
            >
                🔄 Làm mới
            </a>

        </form>

    </div>


    <!-- ==================================================
         DANH SÁCH
    ================================================== -->

    <div class="card">

        <div class="card-title">

            <h2>
                📅 Danh sách lịch khám
            </h2>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            Mã lịch
                        </th>

                        <th>
                            Bệnh nhân
                        </th>


                        <?php if ($laAdmin) { ?>

                            <th>
                                Bác sĩ
                            </th>

                            <th>
                                Chuyên khoa
                            </th>

                        <?php } ?>


                        <th>
                            Ngày khám
                        </th>

                        <th>
                            Giờ khám
                        </th>

                        <th>
                            Trạng thái
                        </th>


                        <?php if ($laAdmin || $laNhanVien) { ?>

                            <th>
                                Thao tác
                            </th>

                        <?php } ?>

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


                        <!-- MÃ -->

                        <td>

                            <strong>
                                #<?php echo $row["MaLichKham"]; ?>
                            </strong>

                        </td>


                        <!-- BỆNH NHÂN -->

                        <td>

                            <span class="patient-name">

                                👤

                                <?php

                                echo htmlspecialchars(
                                    $row["TenBenhNhan"]
                                );

                                ?>

                            </span>

                        </td>


                        <!-- BÁC SĨ CHỈ ADMIN -->

                        <?php if ($laAdmin) { ?>

                        <td>

                            👨‍⚕️

                            <?php

                            echo htmlspecialchars(
                                $row["TenBacSi"]
                            );

                            ?>

                        </td>


                        <!-- CHUYÊN KHOA -->

                        <td>

                            <?php

                            if (!empty($row["ChuyenKhoa"])) {

                            ?>

                                <span class="specialty">

                                    <?php

                                    echo htmlspecialchars(
                                        $row["ChuyenKhoa"]
                                    );

                                    ?>

                                </span>

                            <?php

                            } else {

                                echo "---";

                            }

                            ?>

                        </td>

                        <?php } ?>


                        <!-- NGÀY -->

                        <td>

                            📅

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime($row["NgayKham"])
                            );

                            ?>

                        </td>


                        <!-- GIỜ -->

                        <td>

                            🕐

                            <strong>

                                <?php

                                echo date(
                                    "H:i",
                                    strtotime($row["GioKham"])
                                );

                                ?>

                            </strong>

                        </td>


                        <!-- TRẠNG THÁI -->

                        <td>

                            <?php

                            echo hienThiTrangThai(
                                $row["TrangThai"]
                            );

                            ?>

                        </td>


                        <!-- THAO TÁC -->

                        <?php if ($laAdmin || $laNhanVien) { ?>

                        <td>

                            <div class="action-buttons">


                                <a
                                    href="index.php?page=appointments&sua=<?php echo $row["MaLichKham"]; ?>"
                                    class="btn btn-edit"
                                >
                                    ✏️ Sửa
                                </a>


                                <a
                                    href="index.php?page=appointments&xoa=<?php echo $row["MaLichKham"]; ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khám này không?');"
                                >
                                    🗑️ Xóa
                                </a>


                            </div>

                        </td>

                        <?php } ?>


                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td
                            colspan="<?php
                                if ($laAdmin) {
                                    echo "8";
                                } else {
                                    echo "6";
                                }
                            ?>"
                            class="empty"
                        >

                            📅

                            Chưa có lịch khám nào.

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


</div>
