<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">
            🏥
        </div>

        <div>

            <h2>
                PHÒNG KHÁM
            </h2>

            <span>
                QUẢN LÝ HỆ THỐNG
            </span>

        </div>

    </div>


    <div class="menu">


        <!-- TRANG CHỦ -->

        <a
            href="index.php?page=dashboard"
            class="active"
        >

            <span>🏠</span>

            Trang chủ

        </a>


        <!-- BỆNH NHÂN -->

        <a href="index.php?page=patients">

            <span>👤</span>

            Bệnh nhân

        </a>


        <!-- =================================================
             BÁC SĨ - CHỈ ADMIN
        ================================================== -->

        <?php if ($laAdmin) { ?>

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


        <!-- =================================================
             HỒ SƠ KHÁM - CHỈ ADMIN
        ================================================== -->

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


        <!-- =================================================
             TÀI KHOẢN - CHỈ ADMIN
        ================================================== -->

        <?php if ($laAdmin) { ?>

            <a href="index.php?page=users">

                <span>👥</span>

                Tài khoản

            </a>

        <?php } ?>


        <!-- ĐĂNG XUẤT -->

        <a
            href="index.php?page=logout"
            onclick="
                return confirm(
                    'Bạn có chắc muốn đăng xuất không?'
                );
            "
        >

            <span>🚪</span>

            Đăng xuất

        </a>


    </div>

</div>


<!-- =====================================================
     MAIN
===================================================== -->

<div class="main">


    <!-- =================================================
         TOPBAR
    ================================================== -->

    <div class="topbar">

        <div>

            <h1>
                Trang chủ
            </h1>

            <p>
                Tổng quan hệ thống quản lý phòng khám
            </p>

        </div>


        <div class="user-info">

            <div class="avatar">

                <?php

                $kyTuDau =
                    mb_substr(
                        $hoTen,
                        0,
                        1,
                        "UTF-8"
                    );

                echo htmlspecialchars(
                    mb_strtoupper(
                        $kyTuDau,
                        "UTF-8"
                    )
                );

                ?>

            </div>


            <div>

                <strong>

                    <?php

                    echo htmlspecialchars(
                        $hoTen
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


    <!-- =================================================
         WELCOME
    ================================================== -->

    <div class="welcome">

        <h2>

            Xin chào,
            <?php
            echo htmlspecialchars($hoTen);
            ?>
            ! 👋

        </h2>


        <p>

            Chào mừng bạn đến với hệ thống
            quản lý phòng khám.
            Chúc bạn có một ngày làm việc hiệu quả!

        </p>

    </div>


    <!-- =================================================
         THỐNG KÊ
    ================================================== -->

    <div class="stats">


        <!-- BỆNH NHÂN -->

        <div class="stat-card">

            <div class="stat-icon">
                👤
            </div>

            <div class="stat-info">

                <small>
                    Tổng bệnh nhân
                </small>

                <strong>
                    <?php
                    echo $tongBenhNhan;
                    ?>
                </strong>

            </div>

        </div>


        <!-- LỊCH KHÁM -->

        <div class="stat-card">

            <div class="stat-icon">
                📅
            </div>

            <div class="stat-info">

                <small>
                    Tổng lịch khám
                </small>

                <strong>
                    <?php
                    echo $tongLichKham;
                    ?>
                </strong>

            </div>

        </div>


        <!-- THUỐC -->

        <div class="stat-card">

            <div class="stat-icon">
                💊
            </div>

            <div class="stat-info">

                <small>
                    Loại thuốc
                </small>

                <strong>
                    <?php
                    echo $tongThuoc;
                    ?>
                </strong>

            </div>

        </div>


        <!-- ĐƠN THUỐC -->

        <div class="stat-card">

            <div class="stat-icon">
                🧾
            </div>

            <div class="stat-info">

                <small>
                    Đơn thuốc
                </small>

                <strong>
                    <?php
                    echo $tongDonThuoc;
                    ?>
                </strong>

            </div>

        </div>


    </div>


    <!-- =================================================
         CHỨC NĂNG NHANH
    ================================================== -->

    <div class="quick-actions">


        <!-- BỆNH NHÂN -->

        <a
            href="index.php?page=patients"
            class="quick-action"
        >

            <div class="icon">
                👤
            </div>

            <strong>
                Quản lý bệnh nhân
            </strong>

            <small>
                Thêm và quản lý thông tin bệnh nhân
            </small>

        </a>


        <!-- LỊCH KHÁM -->

        <a
            href="index.php?page=appointments"
            class="quick-action"
        >

            <div class="icon">
                📅
            </div>

            <strong>
                Lịch khám
            </strong>

            <small>
                Quản lý lịch khám của bệnh nhân
            </small>

        </a>


        <!-- THUỐC -->

        <a
            href="index.php?page=medicines"
            class="quick-action"
        >

            <div class="icon">
                💊
            </div>

            <strong>
                Quản lý thuốc
            </strong>

            <small>
                Quản lý thuốc trong phòng khám
            </small>

        </a>


        <!-- ĐƠN THUỐC -->

        <a
            href="index.php?page=prescriptions"
            class="quick-action"
        >

            <div class="icon">
                🧾
            </div>

            <strong>
                Đơn thuốc
            </strong>

            <small>
                Quản lý đơn thuốc
            </small>

        </a>


    </div>


    <!-- =================================================
         NỘI DUNG
    ================================================== -->

    <div class="content-grid">


        <!-- =================================================
             LỊCH KHÁM HÔM NAY
        ================================================== -->

        <div class="card">

            <div class="card-header">

                <h2>
                    📅 Lịch khám hôm nay
                </h2>

                <a
                    href="index.php?page=appointments"
                    class="view-all"
                >
                    Xem tất cả →
                </a>

            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Giờ
                            </th>

                            <th>
                                Bệnh nhân
                            </th>

                            <?php if ($laAdmin) { ?>

                                <th>
                                    Bác sĩ
                                </th>

                            <?php } ?>

                            <th>
                                Trạng thái
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        if (
                            $resultLichHomNay &&
                            !empty($resultLichHomNay)
                        ) {

                            foreach ($resultLichHomNay as $row) {

                        ?>

                            <tr>

                                <td>

                                    <strong>

                                        <?php

                                        echo date(
                                            "H:i",
                                            strtotime(
                                                $row["GioKham"]
                                            )
                                        );

                                        ?>

                                    </strong>

                                </td>


                                <td>

                                    <span class="patient-name">

                                        <?php

                                        echo htmlspecialchars(
                                            $row["TenBenhNhan"]
                                        );

                                        ?>

                                    </span>

                                </td>


                                <?php if ($laAdmin) { ?>

                                    <td>

                                        <span class="doctor-name">

                                            <?php

                                            echo htmlspecialchars(
                                                $row["TenBacSi"]
                                            );

                                            ?>

                                        </span>

                                    </td>

                                <?php } ?>


                                <td>

                                    <?php

                                    echo hienThiTrangThai(
                                        $row["TrangThai"]
                                    );

                                    ?>

                                </td>

                            </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td
                                    colspan="<?php
                                    echo $laAdmin ? 4 : 3;
                                    ?>"
                                    class="empty"
                                >

                                    📅
                                    Hôm nay chưa có lịch khám.

                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- =================================================
             HỒ SƠ KHÁM
             CHỈ ADMIN NHÌN THẤY
        ================================================== -->

        <?php if ($laAdmin) { ?>

            <div class="card">

                <div class="card-header">

                    <h2>
                        📋 Hồ sơ khám gần đây
                    </h2>

                    <a
                        href="index.php?page=medical_records"
                        class="view-all"
                    >
                        Xem tất cả →
                    </a>

                </div>


                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Bệnh nhân
                                </th>

                                <th>
                                    Bác sĩ
                                </th>

                                <th>
                                    Ngày khám
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            if (
                                $resultHoSoGanDay &&
                                !empty($resultHoSoGanDay)
                            ) {

                                foreach ($resultHoSoGanDay as $row) {

                            ?>

                                <tr>

                                    <td>

                                        <span
                                            class="patient-name"
                                        >

                                            <?php

                                            echo htmlspecialchars(
                                                $row["TenBenhNhan"]
                                            );

                                            ?>

                                        </span>

                                    </td>


                                    <td>

                                        <span
                                            class="doctor-name"
                                        >

                                            <?php

                                            echo htmlspecialchars(
                                                $row["TenBacSi"]
                                            );

                                            ?>

                                        </span>

                                    </td>


                                    <td>

                                        <?php

                                        echo date(
                                            "d/m/Y",
                                            strtotime(
                                                $row["NgayKham"]
                                            )
                                        );

                                        ?>

                                    </td>

                                </tr>

                            <?php

                                }

                            } else {

                            ?>

                                <tr>

                                    <td
                                        colspan="3"
                                        class="empty"
                                    >

                                        📋
                                        Chưa có hồ sơ khám.

                                    </td>

                                </tr>

                            <?php

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        <?php } ?>


        <!-- =================================================
             NẾU LÀ NHÂN VIÊN
             HIỂN THỊ THÊM THẺ HƯỚNG DẪN
        ================================================== -->

        <?php if ($laNhanVien) { ?>

            <div class="card">

                <div class="card-header">

                    <h2>
                        📌 Chức năng của nhân viên
                    </h2>

                </div>


                <p
                    style="
                        color:#6b7280;
                        line-height:1.8;
                        font-size:14px;
                    "
                >

                    Bạn đang đăng nhập với vai trò
                    <strong>Nhân viên</strong>.

                    <br><br>

                    Bạn có quyền sử dụng:

                    <br>

                    👤 Quản lý bệnh nhân

                    <br>

                    📅 Quản lý lịch khám

                    <br>

                    💊 Quản lý thuốc

                    <br>

                    🧾 Quản lý đơn thuốc

                </p>

            </div>

        <?php } ?>


    </div>


</div>
