<!-- ==================================================
     SIDEBAR
================================================== -->

<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">
            🏥
        </div>

        <div>

            <h2>Phòng Khám</h2>

            <span>
                Hệ thống quản lý
            </span>

        </div>

    </div>


    <ul class="menu">


        <!-- TRANG CHỦ -->

        <li>

            <a href="index.php?page=dashboard">

                <span class="menu-icon">
                    🏠
                </span>

                <span class="menu-text">
                    Trang chủ
                </span>

            </a>

        </li>


        <!-- BỆNH NHÂN -->

        <li>

            <a href="index.php?page=patients">

                <span class="menu-icon">
                    👤
                </span>

                <span class="menu-text">
                    Bệnh nhân
                </span>

            </a>

        </li>


        <!-- ==================================================
             BÁC SĨ
             CHỈ ADMIN NHÌN THẤY
        ================================================== -->

        <?php if ($vaiTro === "Admin") { ?>

            <li>

                <a href="index.php?page=doctors">

                    <span class="menu-icon">
                        👨‍⚕️
                    </span>

                    <span class="menu-text">
                        Bác sĩ
                    </span>

                </a>

            </li>

        <?php } ?>


        <!-- LỊCH KHÁM -->

        <li>

            <a href="index.php?page=appointments">

                <span class="menu-icon">
                    📅
                </span>

                <span class="menu-text">
                    Lịch khám
                </span>

            </a>

        </li>


        <!-- HỒ SƠ KHÁM -->

        <li>

            <a
                href="index.php?page=medical_records"
                class="active"
            >

                <span class="menu-icon">
                    📋
                </span>

                <span class="menu-text">
                    Hồ sơ khám
                </span>

            </a>

        </li>


        <!-- THUỐC -->

        <li>

            <a href="index.php?page=medicines">

                <span class="menu-icon">
                    💊
                </span>

                <span class="menu-text">
                    Thuốc
                </span>

            </a>

        </li>


        <!-- ĐƠN THUỐC -->

        <li>

            <a href="index.php?page=prescriptions">

                <span class="menu-icon">
                    🧾
                </span>

                <span class="menu-text">
                    Đơn thuốc
                </span>

            </a>

        </li>


        <!-- TÀI KHOẢN
             CHỈ ADMIN -->

        <?php if ($vaiTro === "Admin") { ?>

            <li>

                <a href="index.php?page=users">

                    <span class="menu-icon">
                        👥
                    </span>

                    <span class="menu-text">
                        Tài khoản
                    </span>

                </a>

            </li>

        <?php } ?>


        <!-- ĐĂNG XUẤT -->

        <li>

            <a href="index.php?page=logout">

                <span class="menu-icon">
                    🚪
                </span>

                <span class="menu-text">
                    Đăng xuất
                </span>

            </a>

        </li>


    </ul>

</div>


<!-- ==================================================
     MAIN
================================================== -->

<div class="main">


    <!-- ==================================================
         TOPBAR
    ================================================== -->

    <div class="topbar">

        <div>

            <h1>
                Quản lý hồ sơ khám
            </h1>

            <p>
                Quản lý thông tin khám và điều trị bệnh nhân
            </p>

        </div>


        <div class="user-box">


            <div class="avatar">

                <?php

                $hoten =
                    $_SESSION["hoten"]
                    ?? "U";

                echo strtoupper(
                    substr($hoten, 0, 1)
                );

                ?>

            </div>


            <div class="user-info">

                <strong>

                    <?php

                    echo htmlspecialchars(
                        $_SESSION["hoten"]
                        ?? "Người dùng"
                    );

                    ?>

                </strong>


                <span>

                    <?php

                    echo htmlspecialchars(
                        $vaiTro
                    );

                    ?>

                </span>

            </div>


        </div>

    </div>


    <!-- ==================================================
         CONTENT
    ================================================== -->

    <div class="content">


        <!-- ==================================================
             THỐNG KÊ
        ================================================== -->

        <div class="stats">


            <!-- TỔNG HỒ SƠ -->

            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $tongHoSo; ?>
                    </h3>

                    <p>
                        Tổng hồ sơ khám
                    </p>

                </div>


                <div class="stat-icon">
                    📋
                </div>

            </div>


            <!-- HÔM NAY -->

            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $hoSoHomNay; ?>
                    </h3>

                    <p>
                        Hồ sơ khám hôm nay
                    </p>

                </div>


                <div class="stat-icon">
                    📅
                </div>

            </div>


            <!-- BỆNH NHÂN -->

            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $benhNhanCoHoSo; ?>
                    </h3>

                    <p>
                        Bệnh nhân đã có hồ sơ
                    </p>

                </div>


                <div class="stat-icon">
                    👤
                </div>

            </div>


        </div>


        <!-- ==================================================
             THÔNG BÁO
        ================================================== -->

        <?php if ($thongBao !== "") { ?>

            <div class="alert">

                <?php
                echo htmlspecialchars(
                    $thongBao
                );
                ?>

            </div>

        <?php } ?>


        <!-- ==================================================
             FORM THÊM / SỬA
        ================================================== -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>

                        <?php

                        if ($hoSoSua) {

                            echo
                                "✏️ Cập nhật hồ sơ khám";

                        } else {

                            echo
                                "➕ Thêm hồ sơ khám";
                        }

                        ?>

                    </h2>


                    <p>
                        Nhập đầy đủ thông tin khám bệnh
                    </p>

                </div>

            </div>


            <!-- ==================================================
                 FORM SỬA
            ================================================== -->

            <?php if ($hoSoSua) { ?>


                <form
                    method="POST"
                    onsubmit="
                        return confirm(
                            'Bạn có chắc chắn muốn cập nhật hồ sơ này không?'
                        );
                    "
                >


                    <input
                        type="hidden"
                        name="MaHoSo"
                        value="<?php
                            echo (int)$hoSoSua["MaHoSo"];
                        ?>"
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

                                $resultBenhNhan2 = $resultBenhNhan;


                                if ($resultBenhNhan2) {

                                    foreach ($resultBenhNhan2 as $bn) {

                                        $selected =
                                            (
                                                $bn["MaBenhNhan"]
                                                ==
                                                $hoSoSua["MaBenhNhan"]
                                            )
                                            ? "selected"
                                            : "";

                                ?>

                                    <option
                                        value="<?php
                                            echo (int)
                                                $bn["MaBenhNhan"];
                                        ?>"
                                        <?php
                                            echo $selected;
                                        ?>
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $bn["HoTen"]
                                        );

                                        ?>

                                    </option>

                                <?php

                                    }
                                }

                                ?>

                            </select>

                        </div>


                        <!-- BÁC SĨ -->

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

                                $resultBacSi2 = $resultBacSi;


                                if ($resultBacSi2) {

                                    foreach ($resultBacSi2 as $bs) {

                                        $selected =
                                            (
                                                $bs["MaBacSi"]
                                                ==
                                                $hoSoSua["MaBacSi"]
                                            )
                                            ? "selected"
                                            : "";

                                ?>

                                    <option
                                        value="<?php
                                            echo (int)
                                                $bs["MaBacSi"];
                                        ?>"
                                        <?php
                                            echo $selected;
                                        ?>
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $bs["HoTen"]
                                        );


                                        if (
                                            !empty(
                                                $bs["ChuyenKhoa"]
                                            )
                                        ) {

                                            echo
                                                " - "
                                                .
                                                htmlspecialchars(
                                                    $bs["ChuyenKhoa"]
                                                );
                                        }

                                        ?>

                                    </option>

                                <?php

                                    }
                                }

                                ?>

                            </select>

                        </div>


                        <!-- NGÀY KHÁM -->

                        <div class="form-group">

                            <label>
                                Ngày khám *
                            </label>


                            <input
                                type="date"
                                name="ngayKham"
                                value="<?php
                                    echo htmlspecialchars(
                                        $hoSoSua["NgayKham"]
                                    );
                                ?>"
                                required
                            >

                        </div>


                        <!-- TRIỆU CHỨNG -->

                        <div class="form-group full">

                            <label>
                                Triệu chứng *
                            </label>


                            <textarea
                                name="trieuChung"
                                placeholder="Nhập triệu chứng của bệnh nhân..."
                                required
                            ><?php

                                echo htmlspecialchars(
                                    $hoSoSua["TrieuChung"]
                                );

                            ?></textarea>

                        </div>


                        <!-- CHẨN ĐOÁN -->

                        <div class="form-group full">

                            <label>
                                Chẩn đoán *
                            </label>


                            <textarea
                                name="chanDoan"
                                placeholder="Nhập chẩn đoán của bác sĩ..."
                                required
                            ><?php

                                echo htmlspecialchars(
                                    $hoSoSua["ChanDoan"]
                                );

                            ?></textarea>

                        </div>


                        <!-- KẾT QUẢ -->

                        <div class="form-group full">

                            <label>
                                Kết quả / Hướng điều trị *
                            </label>


                            <textarea
                                name="ketQua"
                                placeholder="Nhập kết quả khám hoặc hướng điều trị..."
                                required
                            ><?php

                                echo htmlspecialchars(
                                    $hoSoSua["KetQua"]
                                );

                            ?></textarea>

                        </div>


                    </div>


                    <div class="form-buttons">


                        <button
                            type="submit"
                            name="sua"
                            class="btn btn-primary"
                        >
                            💾 Cập nhật hồ sơ
                        </button>


                        <a
                            href="index.php?page=medical_records"
                            class="btn btn-secondary"
                        >
                            ❌ Hủy
                        </a>


                    </div>


                </form>


            <?php } else { ?>


                <!-- ==================================================
                     FORM THÊM
                ================================================== -->

                <form
                    method="POST"
                    onsubmit="
                        return kiemTraForm();
                    "
                >


                    <div class="form-grid">


                        <!-- BỆNH NHÂN -->

                        <div class="form-group">

                            <label>
                                Bệnh nhân *
                            </label>


                            <select
                                name="maBenhNhan"
                                id="maBenhNhan"
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
                                        value="<?php
                                            echo (int)
                                                $bn["MaBenhNhan"];
                                        ?>"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $bn["HoTen"]
                                        );

                                        ?>

                                    </option>

                                <?php

                                    }
                                }

                                ?>

                            </select>

                        </div>


                        <!-- BÁC SĨ -->

                        <div class="form-group">

                            <label>
                                Bác sĩ *
                            </label>


                            <select
                                name="maBacSi"
                                id="maBacSi"
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
                                        value="<?php
                                            echo (int)
                                                $bs["MaBacSi"];
                                        ?>"
                                    >

                                        <?php

                                        echo htmlspecialchars(
                                            $bs["HoTen"]
                                        );


                                        if (
                                            !empty(
                                                $bs["ChuyenKhoa"]
                                            )
                                        ) {

                                            echo
                                                " - "
                                                .
                                                htmlspecialchars(
                                                    $bs["ChuyenKhoa"]
                                                );
                                        }

                                        ?>

                                    </option>

                                <?php

                                    }
                                }

                                ?>

                            </select>

                        </div>


                        <!-- NGÀY KHÁM -->

                        <div class="form-group">

                            <label>
                                Ngày khám *
                            </label>


                            <input
                                type="date"
                                name="ngayKham"
                                id="ngayKham"
                                value="<?php
                                    echo date("Y-m-d");
                                ?>"
                                required
                            >

                        </div>


                        <!-- TRIỆU CHỨNG -->

                        <div class="form-group full">

                            <label>
                                Triệu chứng *
                            </label>


                            <textarea
                                name="trieuChung"
                                id="trieuChung"
                                placeholder="Nhập triệu chứng của bệnh nhân..."
                                required
                            ></textarea>

                        </div>


                        <!-- CHẨN ĐOÁN -->

                        <div class="form-group full">

                            <label>
                                Chẩn đoán *
                            </label>


                            <textarea
                                name="chanDoan"
                                id="chanDoan"
                                placeholder="Nhập chẩn đoán của bác sĩ..."
                                required
                            ></textarea>

                        </div>


                        <!-- KẾT QUẢ -->

                        <div class="form-group full">

                            <label>
                                Kết quả / Hướng điều trị *
                            </label>


                            <textarea
                                name="ketQua"
                                id="ketQua"
                                placeholder="Nhập kết quả khám hoặc hướng điều trị..."
                                required
                            ></textarea>

                        </div>


                    </div>


                    <div class="form-buttons">


                        <button
                            type="submit"
                            name="them"
                            class="btn btn-primary"
                        >
                            ➕ Thêm hồ sơ
                        </button>


                        <button
                            type="reset"
                            class="btn btn-secondary"
                        >
                            🔄 Làm lại
                        </button>


                    </div>


                </form>


            <?php } ?>


        </div>


        <!-- ==================================================
             TÌM KIẾM
        ================================================== -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>
                        🔎 Tìm kiếm hồ sơ
                    </h2>

                    <p>
                        Tìm theo bệnh nhân, bác sĩ,
                        triệu chứng hoặc chẩn đoán
                    </p>

                </div>

            </div>


            <form method="GET">
            <input type="hidden" name="page" value="medical_records">


                <div class="search-box">


                    <input
                        type="text"
                        name="timkiem"
                        value="<?php
                            echo htmlspecialchars(
                                $tuKhoa
                            );
                        ?>"
                        placeholder="Nhập tên bệnh nhân, bác sĩ, triệu chứng, chẩn đoán..."
                    >


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        🔎 Tìm kiếm
                    </button>


                    <?php if ($tuKhoa !== "") { ?>

                        <a
                            href="index.php?page=medical_records"
                            class="btn btn-secondary"
                        >
                            ✕ Xóa tìm kiếm
                        </a>

                    <?php } ?>


                </div>


            </form>


        </div>


        <!-- ==================================================
             DANH SÁCH HỒ SƠ
        ================================================== -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>
                        📋 Danh sách hồ sơ khám
                    </h2>


                    <p>

                        Tổng cộng

                        <strong>

                            <?php

                            echo
                                $result
                                ? count($result)
                                : 0;

                            ?>

                        </strong>

                        hồ sơ được hiển thị

                    </p>

                </div>

            </div>


            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                Mã hồ sơ
                            </th>

                            <th>
                                Bệnh nhân
                            </th>

                            <th>
                                Bác sĩ
                            </th>

                            <th>
                                Ngày khám
                            </th>

                            <th>
                                Triệu chứng
                            </th>

                            <th>
                                Chẩn đoán
                            </th>

                            <th>
                                Kết quả
                            </th>

                            <th>
                                Thao tác
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    if (
                        $result
                        &&
                        !empty($result)
                    ) {


                        foreach ($result as $row) {

                    ?>


                        <tr>


                            <!-- MÃ HỒ SƠ -->

                            <td>

                                <span class="id-badge">

                                    #

                                    <?php

                                    echo
                                        (int)
                                        $row["MaHoSo"];

                                    ?>

                                </span>

                            </td>


                            <!-- BỆNH NHÂN -->

                            <td>

                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $row["TenBenhNhan"]
                                    );

                                    ?>

                                </strong>

                            </td>


                            <!-- BÁC SĨ -->

                            <td>

                                <div class="doctor-name">

                                    <?php

                                    echo htmlspecialchars(
                                        $row["TenBacSi"]
                                    );

                                    ?>

                                </div>


                                <?php

                                if (
                                    !empty(
                                        $row["ChuyenKhoa"]
                                    )
                                ) {

                                ?>

                                    <div class="specialty">

                                        <?php

                                        echo htmlspecialchars(
                                            $row["ChuyenKhoa"]
                                        );

                                        ?>

                                    </div>

                                <?php } ?>


                            </td>


                            <!-- NGÀY KHÁM -->

                            <td class="date">

                                <?php

                                if (
                                    !empty(
                                        $row["NgayKham"]
                                    )
                                ) {

                                    echo date(
                                        "d/m/Y",
                                        strtotime(
                                            $row["NgayKham"]
                                        )
                                    );

                                } else {

                                    echo "--";

                                }

                                ?>

                            </td>


                            <!-- TRIỆU CHỨNG -->

                            <td>

                                <div class="text-cell">

                                    <?php

                                    echo nl2br(
                                        htmlspecialchars(
                                            $row["TrieuChung"]
                                        )
                                    );

                                    ?>

                                </div>

                            </td>


                            <!-- CHẨN ĐOÁN -->

                            <td>

                                <div class="text-cell">

                                    <?php

                                    echo nl2br(
                                        htmlspecialchars(
                                            $row["ChanDoan"]
                                        )
                                    );

                                    ?>

                                </div>

                            </td>


                            <!-- KẾT QUẢ -->

                            <td>

                                <div class="text-cell">

                                    <?php

                                    echo nl2br(
                                        htmlspecialchars(
                                            $row["KetQua"]
                                        )
                                    );

                                    ?>

                                </div>

                            </td>


                            <!-- THAO TÁC -->

                            <td>

                                <div class="actions">


                                    <!-- SỬA -->

                                    <a
                                        href="index.php?page=medical_records&sua=<?php
                                            echo (int)
                                                $row["MaHoSo"];
                                        ?>"
                                        class="btn btn-warning btn-small"
                                    >
                                        ✏️ Sửa
                                    </a>


                                    <!-- XÓA -->

                                    <a
                                        href="index.php?page=medical_records&xoa=<?php
                                            echo (int)
                                                $row["MaHoSo"];
                                        ?>"
                                        class="btn btn-danger btn-small"
                                        onclick="
                                            return confirm(
                                                'Bạn có chắc chắn muốn xóa hồ sơ này không?'
                                            );
                                        "
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

                                📭

                                <?php

                                if ($tuKhoa !== "") {

                                    echo
                                        "Không tìm thấy hồ sơ phù hợp.";

                                } else {

                                    echo
                                        "Chưa có hồ sơ khám nào.";

                                }

                                ?>

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


</div>


<!-- ==================================================
     JAVASCRIPT
================================================== -->

<script>

function kiemTraForm() {

    const maBenhNhan =
        document.getElementById(
            "maBenhNhan"
        ).value;

    const maBacSi =
        document.getElementById(
            "maBacSi"
        ).value;

    const ngayKham =
        document.getElementById(
            "ngayKham"
        ).value;

    const trieuChung =
        document.getElementById(
            "trieuChung"
        ).value.trim();

    const chanDoan =
        document.getElementById(
            "chanDoan"
        ).value.trim();

    const ketQua =
        document.getElementById(
            "ketQua"
        ).value.trim();


    if (
        maBenhNhan === "" ||
        maBacSi === "" ||
        ngayKham === "" ||
        trieuChung === "" ||
        chanDoan === "" ||
        ketQua === ""
    ) {

        alert(
            "⚠️ Vui lòng nhập đầy đủ thông tin hồ sơ khám!"
        );

        return false;
    }


    return true;
}

</script>
