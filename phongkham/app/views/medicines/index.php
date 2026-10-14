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
                Phòng Khám
            </h2>

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


        <!-- BÁC SĨ - CHỈ ADMIN -->

        <?php if ($laAdmin): ?>

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

        <?php endif; ?>


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


        <!-- HỒ SƠ KHÁM - CHỈ ADMIN -->

        <?php if ($laAdmin): ?>

            <li>

                <a href="index.php?page=medical_records">

                    <span class="menu-icon">
                        📋
                    </span>

                    <span class="menu-text">
                        Hồ sơ khám
                    </span>

                </a>

            </li>

        <?php endif; ?>


        <!-- THUỐC -->

        <li>

            <a href="index.php?page=medicines"
               class="active">

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


        <!-- TÀI KHOẢN - CHỈ ADMIN -->

        <?php if ($laAdmin): ?>

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

        <?php endif; ?>


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


<!-- =====================================================
     MAIN
===================================================== -->

<div class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <div>

            <h1>
                Quản lý thuốc
            </h1>

            <p>
                Quản lý danh mục và số lượng thuốc
            </p>

        </div>


        <div class="user-box">

            <div class="avatar">

                <?php
                echo htmlspecialchars($chuCaiDau);
                ?>

            </div>


            <div class="user-info">

                <strong>

                    <?php
                    echo htmlspecialchars($hoTen);
                    ?>

                </strong>

            </div>

        </div>

    </div>


    <!-- CONTENT -->

    <div class="content">


        <!-- THỐNG KÊ -->

        <div class="stats">


            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $tongThuoc; ?>
                    </h3>

                    <p>
                        Loại thuốc
                    </p>

                </div>

                <div class="stat-icon">
                    💊
                </div>

            </div>


            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $tongSoLuong; ?>
                    </h3>

                    <p>
                        Tổng số lượng
                    </p>

                </div>

                <div class="stat-icon">
                    📦
                </div>

            </div>


            <div class="stat-card">

                <div>

                    <h3>
                        <?php echo $thuocSapHet; ?>
                    </h3>

                    <p>
                        Thuốc sắp hết
                    </p>

                </div>

                <div class="stat-icon">
                    ⚠️
                </div>

            </div>


        </div>


        <!-- THÔNG BÁO -->

        <?php if ($thongBao != ""): ?>

            <div class="alert">

                <?php
                echo htmlspecialchars($thongBao);
                ?>

            </div>

        <?php endif; ?>


        <!-- FORM THÊM / SỬA -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>

                        <?php

                        if ($thuocSua) {

                            echo "✏️ Cập nhật thuốc";

                        } else {

                            echo "➕ Thêm thuốc";

                        }

                        ?>

                    </h2>

                    <p>
                        Nhập thông tin thuốc
                    </p>

                </div>

            </div>


            <?php if ($thuocSua): ?>


                <!-- FORM SỬA -->

                <form method="POST">


                    <input
                        type="hidden"
                        name="MaThuoc"
                        value="<?php
                        echo htmlspecialchars(
                            $thuocSua["MaThuoc"]
                        );
                        ?>"
                    >


                    <div class="form-grid">


                        <div class="form-group">

                            <label>
                                Tên thuốc *
                            </label>

                            <input
                                type="text"
                                name="tenThuoc"
                                value="<?php
                                echo htmlspecialchars(
                                    $thuocSua["TenThuoc"]
                                );
                                ?>"
                                placeholder="Ví dụ: Paracetamol"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Đơn vị tính *
                            </label>

                            <input
                                type="text"
                                name="donViTinh"
                                value="<?php
                                echo htmlspecialchars(
                                    $thuocSua["DonViTinh"]
                                );
                                ?>"
                                placeholder="Viên, chai, hộp..."
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Đơn giá *
                            </label>

                            <input
                                type="number"
                                name="donGia"
                                value="<?php
                                echo htmlspecialchars(
                                    $thuocSua["DonGia"]
                                );
                                ?>"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Số lượng *
                            </label>

                            <input
                                type="number"
                                name="soLuong"
                                value="<?php
                                echo htmlspecialchars(
                                    $thuocSua["SoLuong"]
                                );
                                ?>"
                                min="0"
                                required
                            >

                        </div>


                        <div class="form-group full">

                            <label>
                                Mô tả
                            </label>

                            <textarea
                                name="moTa"
                                placeholder="Nhập mô tả thuốc..."
                            ><?php
                            echo htmlspecialchars(
                                $thuocSua["MoTa"] ?? ""
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
                            💾 Cập nhật
                        </button>


                        <a
                            href="index.php?page=medicines"
                            class="btn btn-secondary"
                        >
                            ❌ Hủy
                        </a>

                    </div>


                </form>


            <?php else: ?>


                <!-- FORM THÊM -->

                <form method="POST">


                    <div class="form-grid">


                        <div class="form-group">

                            <label>
                                Tên thuốc *
                            </label>

                            <input
                                type="text"
                                name="tenThuoc"
                                placeholder="Ví dụ: Paracetamol"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Đơn vị tính *
                            </label>

                            <input
                                type="text"
                                name="donViTinh"
                                placeholder="Viên, chai, hộp..."
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Đơn giá *
                            </label>

                            <input
                                type="number"
                                name="donGia"
                                min="0"
                                step="0.01"
                                placeholder="0"
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Số lượng *
                            </label>

                            <input
                                type="number"
                                name="soLuong"
                                min="0"
                                placeholder="0"
                                required
                            >

                        </div>


                        <div class="form-group full">

                            <label>
                                Mô tả
                            </label>

                            <textarea
                                name="moTa"
                                placeholder="Nhập mô tả thuốc..."
                            ></textarea>

                        </div>


                    </div>


                    <div class="form-buttons">

                        <button
                            type="submit"
                            name="them"
                            class="btn btn-primary"
                        >
                            ➕ Thêm thuốc
                        </button>


                        <button
                            type="reset"
                            class="btn btn-secondary"
                        >
                            🔄 Làm lại
                        </button>

                    </div>


                </form>


            <?php endif; ?>


        </div>


        <!-- TÌM KIẾM -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>
                        🔎 Tìm kiếm thuốc
                    </h2>

                    <p>
                        Tìm theo tên thuốc, đơn vị hoặc mô tả
                    </p>

                </div>

            </div>


            <form method="GET">
            <input type="hidden" name="page" value="medicines">


                <div class="search-box">


                    <input
                        type="text"
                        name="timkiem"
                        value="<?php
                        echo htmlspecialchars($tuKhoa);
                        ?>"
                        placeholder="Nhập tên thuốc..."
                    >


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        🔎 Tìm kiếm
                    </button>


                    <?php if ($tuKhoa != ""): ?>

                        <a
                            href="index.php?page=medicines"
                            class="btn btn-secondary"
                        >
                            ✕ Xóa tìm kiếm
                        </a>

                    <?php endif; ?>


                </div>


            </form>


        </div>


        <!-- DANH SÁCH THUỐC -->

        <div class="card">


            <div class="card-title">

                <div>

                    <h2>
                        💊 Danh sách thuốc
                    </h2>

                    <p>

                        Tổng cộng

                        <strong>

                            <?php

                            echo $result
                                ? count($result)
                                : 0;

                            ?>

                        </strong>

                        thuốc được hiển thị

                    </p>

                </div>

            </div>


            <div class="table-wrapper">


                <table>


                    <thead>

                        <tr>

                            <th>
                                Mã thuốc
                            </th>

                            <th>
                                Tên thuốc
                            </th>

                            <th>
                                Đơn vị
                            </th>

                            <th>
                                Đơn giá
                            </th>

                            <th>
                                Số lượng
                            </th>

                            <th>
                                Mô tả
                            </th>

                            <th>
                                Thao tác
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if (
                        $result &&
                        !empty($result)
                    ): ?>


                        <?php foreach ($result as $row): ?>


                            <tr>


                                <!-- MÃ THUỐC -->

                                <td>

                                    <span class="id-badge">

                                        #

                                        <?php
                                        echo htmlspecialchars(
                                            $row["MaThuoc"]
                                        );
                                        ?>

                                    </span>

                                </td>


                                <!-- TÊN THUỐC -->

                                <td>

                                    <strong>

                                        <?php
                                        echo htmlspecialchars(
                                            $row["TenThuoc"]
                                        );
                                        ?>

                                    </strong>

                                </td>


                                <!-- ĐƠN VỊ -->

                                <td>

                                    <?php
                                    echo htmlspecialchars(
                                        $row["DonViTinh"]
                                    );
                                    ?>

                                </td>


                                <!-- ĐƠN GIÁ -->

                                <td>

                                    <span class="price">

                                        <?php
                                        echo number_format(
                                            $row["DonGia"],
                                            0,
                                            ",",
                                            "."
                                        );
                                        ?>

                                        đ

                                    </span>

                                </td>


                                <!-- SỐ LƯỢNG -->

                                <td>


                                    <?php

                                    $classSoLuong =
                                        ($row["SoLuong"] <= 10)
                                        ? "low"
                                        : "normal";

                                    ?>


                                    <div
                                        class="quantity <?php
                                        echo $classSoLuong;
                                        ?>"
                                    >

                                        <?php
                                        echo htmlspecialchars(
                                            $row["SoLuong"]
                                        );
                                        ?>

                                    </div>


                                    <?php if (
                                        $row["SoLuong"] <= 10
                                    ): ?>

                                        <div class="low-badge">

                                            ⚠️ Sắp hết

                                        </div>

                                    <?php endif; ?>


                                </td>


                                <!-- MÔ TẢ -->

                                <td>

                                    <?php

                                    if (
                                        !empty(
                                            $row["MoTa"]
                                        )
                                    ) {

                                        echo nl2br(
                                            htmlspecialchars(
                                                $row["MoTa"]
                                            )
                                        );

                                    } else {

                                        echo
                                            "<span style='color:#999'>Không có</span>";
                                    }

                                    ?>

                                </td>


                                <!-- THAO TÁC -->

                                <td>

                                    <div class="actions">


                                        <!-- SỬA -->

                                        <a
                                            href="index.php?page=medicines&sua=<?php
                                            echo $row["MaThuoc"];
                                            ?>"
                                            class="btn btn-warning btn-small"
                                        >
                                            ✏️ Sửa
                                        </a>


                                        <!-- XÓA -->

                                        <a
                                            href="index.php?page=medicines&xoa=<?php
                                            echo $row["MaThuoc"];
                                            ?>"
                                            class="btn btn-danger btn-small"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa thuốc này không?');"
                                        >
                                            🗑️ Xóa
                                        </a>


                                    </div>

                                </td>


                            </tr>


                        <?php endforeach; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="7"
                                class="empty"
                            >

                                📭 Chưa có thuốc nào.

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>

                </table>


            </div>


        </div>


    </div>


</div>
