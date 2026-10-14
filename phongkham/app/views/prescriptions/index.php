<!-- =====================================================
     SIDEBAR
===================================================== -->

<div class="sidebar">

    <div class="logo">
        QUẢN LÝ PHÒNG KHÁM
    </div>


    <!-- TRANG CHỦ -->

    <a href="index.php?page=dashboard"
       class="menu">

        🏠 Trang chủ

    </a>


    <!-- BỆNH NHÂN -->

    <a href="index.php?page=patients"
       class="menu">

        👤 Bệnh nhân

    </a>


    <!-- =================================================
         BÁC SĨ - CHỈ ADMIN
    ================================================== -->

    <?php if ($laAdmin) { ?>

        <a href="index.php?page=doctors"
           class="menu">

            👨‍⚕️ Bác sĩ

        </a>

    <?php } ?>


    <!-- LỊCH KHÁM -->

    <a href="index.php?page=appointments"
       class="menu">

        📅 Lịch khám

    </a>


    <!-- =================================================
         HỒ SƠ KHÁM - CHỈ ADMIN
    ================================================== -->

    <?php if ($laAdmin) { ?>

        <a href="index.php?page=medical_records"
           class="menu">

            📋 Hồ sơ khám

        </a>

    <?php } ?>


    <!-- THUỐC -->

    <a href="index.php?page=medicines"
       class="menu">

        💊 Thuốc

    </a>


    <!-- ĐƠN THUỐC -->

    <a href="index.php?page=prescriptions"
       class="menu active">

        🧾 Đơn thuốc

    </a>


    <!-- =================================================
         TÀI KHOẢN - CHỈ ADMIN
    ================================================== -->

    <?php if ($laAdmin) { ?>

        <a href="index.php?page=users"
           class="menu">

            👥 Tài khoản

        </a>

    <?php } ?>


    <!-- ĐĂNG XUẤT -->

    <a href="index.php?page=logout"
       class="menu"
       onclick="return confirm('Bạn có chắc muốn đăng xuất không?');">

        🚪 Đăng xuất

    </a>

</div>


<!-- =====================================================
     CONTENT
===================================================== -->

<div class="content">


    <!-- TOPBAR -->

    <div class="topbar">

        <h1>
            QUẢN LÝ ĐƠN THUỐC
        </h1>

        <div class="user">

            Xin chào:

            <strong>

                <?php
                echo htmlspecialchars(
                    $_SESSION["hoten"] ?? "Người dùng"
                );
                ?>

            </strong>

        </div>

    </div>


    <!-- =================================================
         THÔNG BÁO
    ================================================== -->

    <?php if ($thongBao != "") { ?>

        <div class="alert <?php echo $loaiThongBao; ?>">

            <?php
            echo htmlspecialchars($thongBao);
            ?>

        </div>

    <?php } ?>


    <!-- =================================================
         THỐNG KÊ
    ================================================== -->

    <div class="stats">

        <div class="stat-box">

            <div class="stat-title">
                Tổng chi tiết đơn thuốc
            </div>

            <div class="stat-number">

                <?php
                echo number_format($tongDon);
                ?>

            </div>

        </div>


        <div class="stat-box">

            <div class="stat-title">
                Tổng số lượng thuốc
            </div>

            <div class="stat-number">

                <?php
                echo number_format($tongSoLuong);
                ?>

            </div>

        </div>


        <div class="stat-box">

            <div class="stat-title">
                Tổng tiền thuốc
            </div>

            <div class="stat-number">

                <?php
                echo number_format(
                    $tongTien,
                    0,
                    ",",
                    "."
                );
                ?>

                đ

            </div>

        </div>

    </div>


    <!-- =================================================
         FORM THÊM / SỬA ĐƠN THUỐC
    ================================================== -->

    <div class="card">

        <h2 class="card-title">

            <?php

            if ($duLieuSua) {

                echo "✏️ Sửa đơn thuốc";

            } else {

                echo "➕ Thêm đơn thuốc";

            }

            ?>

        </h2>


        <form method="POST"
              action="index.php?page=prescriptions">


            <!-- ID KHI SỬA -->

            <?php if ($duLieuSua) { ?>

                <input
                    type="hidden"
                    name="MaChiTiet"
                    value="<?php
                    echo (int)$duLieuSua["MaChiTiet"];
                    ?>"
                >

            <?php } ?>


            <div class="form-grid">


                <!-- =================================================
                     HỒ SƠ KHÁM
                ================================================== -->

                <div class="form-group">

                    <label>
                        Hồ sơ khám *
                    </label>

                    <select
                        name="MaHoSo"
                        required
                    >

                        <option value="">
                            -- Chọn hồ sơ khám --
                        </option>


                        <?php

                        if ($resultHoSoList) {

                            foreach ($resultHoSoList as $hoSo) {

                                $selected = "";

                                if (
                                    $duLieuSua &&
                                    (int)$duLieuSua["MaHoSo"]
                                    ==
                                    (int)$hoSo["MaHoSo"]
                                ) {

                                    $selected = "selected";
                                }

                        ?>

                            <option
                                value="<?php
                                echo (int)$hoSo["MaHoSo"];
                                ?>"
                                <?php echo $selected; ?>
                            >

                                <?php

                                echo "HS"
                                    . (int)$hoSo["MaHoSo"]
                                    . " - "
                                    . htmlspecialchars(
                                        $hoSo["TenBenhNhan"]
                                    )
                                    . " - "
                                    . htmlspecialchars(
                                        $hoSo["NgayKham"]
                                    );

                                ?>

                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>

                </div>


                <!-- =================================================
                     THUỐC
                ================================================== -->

                <div class="form-group">

                    <label>
                        Thuốc *
                    </label>

                    <select
                        name="MaThuoc"
                        id="MaThuoc"
                        required
                    >

                        <option value="">
                            -- Chọn thuốc --
                        </option>


                        <?php

                        if ($resultThuocList) {

                            foreach ($resultThuocList as $thuoc) {

                                $selected = "";

                                if (
                                    $duLieuSua &&
                                    (int)$duLieuSua["MaThuoc"]
                                    ==
                                    (int)$thuoc["MaThuoc"]
                                ) {

                                    $selected = "selected";
                                }

                        ?>

                            <option
                                value="<?php
                                echo (int)$thuoc["MaThuoc"];
                                ?>"
                                data-stock="<?php
                                echo (int)$thuoc["SoLuong"];
                                ?>"
                                <?php echo $selected; ?>
                            >

                                <?php

                                echo htmlspecialchars(
                                    $thuoc["TenThuoc"]
                                );

                                echo " - Tồn: ";

                                echo (int)$thuoc["SoLuong"];

                                echo " ";

                                echo htmlspecialchars(
                                    $thuoc["DonViTinh"]
                                );

                                ?>

                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>


                    <div
                        class="stock-info"
                        id="stockInfo"
                    ></div>

                </div>


                <!-- =================================================
                     SỐ LƯỢNG
                ================================================== -->

                <div class="form-group">

                    <label>
                        Số lượng *
                    </label>

                    <input
                        type="number"
                        name="SoLuong"
                        id="SoLuong"
                        min="1"
                        required
                        value="<?php
                        echo $duLieuSua
                            ? (int)$duLieuSua["SoLuong"]
                            : "";
                        ?>"
                    >

                </div>


                <!-- =================================================
                     CÁCH DÙNG
                ================================================== -->

                <div class="form-group full">

                    <label>
                        Cách dùng *
                    </label>

                    <textarea
                        name="CachDung"
                        placeholder="Ví dụ: Uống 2 lần/ngày, mỗi lần 1 viên sau ăn"
                        required
                    ><?php

                    echo $duLieuSua
                        ? htmlspecialchars(
                            $duLieuSua["CachDung"]
                        )
                        : "";

                    ?></textarea>

                </div>


            </div>


            <!-- BUTTON -->

            <div class="buttons">


                <?php if ($duLieuSua) { ?>

                    <button
                        type="submit"
                        name="sua"
                        class="btn btn-primary"
                    >

                        💾 Cập nhật

                    </button>


                    <a
                        href="index.php?page=prescriptions"
                        class="btn btn-secondary"
                    >

                        Hủy sửa

                    </a>


                <?php } else { ?>

                    <button
                        type="submit"
                        name="them"
                        class="btn btn-primary"
                    >

                        ➕ Thêm đơn thuốc

                    </button>

                <?php } ?>


            </div>

        </form>

    </div>


    <!-- =================================================
         TÌM KIẾM
    ================================================== -->

    <div class="card">

        <h2 class="card-title">
            🔎 Tìm kiếm đơn thuốc
        </h2>


        <form
            method="GET"
            action="index.php?page=prescriptions"
            class="search-box"
        >
            <input type="hidden" name="page" value="prescriptions">

            <input
                type="text"
                name="timkiem"
                value="<?php
                echo htmlspecialchars($tuKhoa);
                ?>"
                placeholder="Nhập tên bệnh nhân, tên thuốc hoặc cách dùng..."
            >


            <button
                type="submit"
                class="btn btn-primary"
            >

                🔎 Tìm kiếm

            </button>


            <?php if ($tuKhoa != "") { ?>

                <a
                    href="index.php?page=prescriptions"
                    class="btn btn-secondary"
                >

                    ✕ Xóa tìm kiếm

                </a>

            <?php } ?>

        </form>

    </div>


    <!-- =================================================
         DANH SÁCH ĐƠN THUỐC
    ================================================== -->

    <div class="card">

        <h2 class="card-title">
            📋 Danh sách đơn thuốc
        </h2>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Mã</th>

                        <th>Bệnh nhân</th>

                        <th>Ngày khám</th>

                        <th>Thuốc</th>

                        <th>Số lượng</th>

                        <th>Đơn giá</th>

                        <th>Thành tiền</th>

                        <th>Cách dùng</th>

                        <th>Thao tác</th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    if (
                        $resultDanhSach &&
                        !empty($resultDanhSach)
                    ) {

                        foreach ($resultDanhSach as $row) {

                            $thanhTien =
                                (float)$row["SoLuong"]
                                *
                                (float)$row["DonGia"];

                    ?>

                        <tr>

                            <td>

                                <?php
                                echo (int)$row["MaChiTiet"];
                                ?>

                            </td>


                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $row["TenBenhNhan"]
                                    );
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $row["NgayKham"]
                                );
                                ?>

                            </td>


                            <td>

                                <strong>

                                    <?php
                                    echo htmlspecialchars(
                                        $row["TenThuoc"]
                                    );
                                    ?>

                                </strong>

                                <br>

                                <small>

                                    <?php
                                    echo htmlspecialchars(
                                        $row["DonViTinh"]
                                    );
                                    ?>

                                </small>

                            </td>


                            <td>

                                <?php
                                echo (int)$row["SoLuong"];
                                ?>

                            </td>


                            <td class="money">

                                <?php

                                echo number_format(
                                    (float)$row["DonGia"],
                                    0,
                                    ",",
                                    "."
                                );

                                ?>

                                đ

                            </td>


                            <td class="money">

                                <?php

                                echo number_format(
                                    $thanhTien,
                                    0,
                                    ",",
                                    "."
                                );

                                ?>

                                đ

                            </td>


                            <td>

                                <?php

                                echo nl2br(
                                    htmlspecialchars(
                                        $row["CachDung"]
                                    )
                                );

                                ?>

                            </td>


                            <td>

                                <div class="action">


                                    <!-- SỬA -->

                                    <a
                                        href="index.php?page=prescriptions&sua=<?php
                                        echo (int)$row["MaChiTiet"];
                                        ?>"
                                        class="btn btn-warning"
                                    >

                                        ✏️ Sửa

                                    </a>


                                    <!-- XÓA -->

                                    <a
                                        href="index.php?page=prescriptions&xoa=<?php
                                        echo (int)$row["MaChiTiet"];
                                        ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn xóa đơn thuốc này không? Số lượng thuốc sẽ được trả lại kho.');"
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
                                colspan="9"
                                class="empty"
                            >

                                <?php

                                if ($tuKhoa != "") {

                                    echo
                                        "Không tìm thấy đơn thuốc phù hợp với từ khóa.";

                                } else {

                                    echo
                                        "Chưa có đơn thuốc nào.";

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


<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>

const selectThuoc =
    document.getElementById("MaThuoc");

const stockInfo =
    document.getElementById("stockInfo");

const inputSoLuong =
    document.getElementById("SoLuong");


function hienThiTonKho() {

    if (!selectThuoc) {
        return;
    }

    const option =
        selectThuoc.options[
            selectThuoc.selectedIndex
        ];

    if (
        option &&
        option.value !== ""
    ) {

        const stock =
            option.getAttribute("data-stock");

        if (stock !== null) {

            stockInfo.innerHTML =
                "Số lượng hiện có trong kho: <strong>"
                + stock +
                "</strong>";

        } else {

            stockInfo.innerHTML = "";

        }

    } else {

        stockInfo.innerHTML = "";

    }

}


if (selectThuoc) {

    selectThuoc.addEventListener(
        "change",
        hienThiTonKho
    );

    hienThiTonKho();

}


if (inputSoLuong) {

    inputSoLuong.addEventListener(
        "input",
        function () {

            if (
                parseInt(this.value) < 1
            ) {

                this.value = 1;

            }

        }
    );

}

</script>
