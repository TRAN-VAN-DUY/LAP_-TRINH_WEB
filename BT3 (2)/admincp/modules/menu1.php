<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

<style>
    .employee-img {
        object-fit: cover;
        object-position: center 30%;
        height: 250px;
        width: 100%;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    /* Các phần đã có sẵn */
    .birthday-header:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .employee-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .employee-card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .bg-light {
        background-color: #f0f2f5;
    }

    .table-form {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        margin-bottom: 40px;
    }

    .form-title,
    .table-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
        padding: 12px;
        border-radius: 8px;
    }

    .form-title {
        background-color: #d4edda;
    }

    .table-title {
        background-color: #ffe0b2;
    }

    .product-img {
        max-width: 100px;
        border-radius: 8px;
    }

    thead tr.bg-black {
        background-color: #000 !important;
        color: #fff;
    }

    td,
    th {
        vertical-align: middle !important;
        text-align: center;
    }

    .text-danger {
        color: red;
    }

    .text-primary {
        color: #337ab7;
    }

    .control-label {
        padding-left: 10px;
    }

    /* Hiệu ứng cho tiêu đề màu cam */
    .table-title {
        cursor: pointer;
        /* thành bàn tay */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .table-title:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }

    /* Hiệu ứng cho từng dòng nhân viên */
    .table-form table tbody tr {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        /* thành bàn tay */
    }

    .table-form table tbody tr:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        background-color: #f9f9f9;
        /* nhấn nền nhẹ */
    }

    .btn-search {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .btn-search:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }

    .form-control:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: text;
    }
</style>


<!-- Container tiêu đề (có hiệu ứng động) -->
<div class="container my-4">
    <div class="text-center p-5 rounded my-4 birthday-header"
        style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); color: #b22222;">
        <h1>
            <i class="fa-solid fa-cake-candles me-3" style="color: #b22222;"></i>
            Các nhân viên sinh nhật tháng <?php echo date('m'); ?>
            <i class="fa-solid fa-star" style="font-size: 50px; color: #b22222; margin-left: 10px;"></i>
        </h1>
    </div>
</div>

<!-- Container danh sách nhân viên (đứng yên) -->
<div class="container my-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="row justify-content-center g-4">
            <?php
            $currentMonth = date('m');
            $sql_pro = "SELECT * FROM tbl_nhanvien1 WHERE MONTH(tuoi) = '$currentMonth' ORDER BY id_nhanvien DESC LIMIT 10";
            $query_pro = mysqli_query($mysqli, $sql_pro);

            while ($row = mysqli_fetch_array($query_pro)) {
                ?>
                <div class="col-md-4">
                    <div class="card employee-card h-100">
                        <img src="modules/quanlynhansu/uploads/<?php echo $row['hinhanh'] ?>"
                            class="card-img-top employee-img" alt="Ảnh nhân viên">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['tennhanvien'] ?></h5>
                            <p class="card-text">
                                <i class="fa-solid fa-birthday-cake"></i>
                                Sinh nhật: <?php echo date('d/m/Y', strtotime($row['tuoi'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="table-form">
        <div class="table-title text-center">📦 Liệt kê danh sách nhân viên</div>

        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="🔍 Tìm kiếm nhân viên theo tên..." name="tukhoa"
                    value="<?php echo isset($_POST['tukhoa']) ? htmlspecialchars($_POST['tukhoa']) : ''; ?>">
                <button class="btn btn-info" type="submit" name="timkiem">Search</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-black">
                    <th>STT</th>
                    <th>Mã nhân viên</th>
                    <th>Tên nhân viên</th>
                    <th>Hình ảnh</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['timkiem'])) {
                    $tukhoa = mysqli_real_escape_string($mysqli, $_POST['tukhoa']);
                    $sql_lietke_nv = "SELECT * FROM tbl_nhanvien1 WHERE tennhanvien LIKE '%$tukhoa%' ORDER BY id_nhanvien ASC";
                } else {
                    $sql_lietke_nv = "SELECT * FROM tbl_nhanvien1 ORDER BY id_nhanvien ASC";
                }

                $query_lietke_nv = mysqli_query($mysqli, $sql_lietke_nv);
                $i = 0;
                while ($row = mysqli_fetch_array($query_lietke_nv)) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['manv']; ?></td>
                        <td><?php echo $row['tennhanvien']; ?></td>
                        <td>
                            <img src="modules/quanlynhansu/uploads/<?php echo $row['hinhanh']; ?>" class="product-img"
                                alt="ảnh nhân viên">
                        </td>
                        <td>
                            <?php if ($row['tinhtrang'] == 'Kích hoạt') { ?>
                                <span style="color: green; font-weight: bold;">Kích hoạt</span>
                            <?php } else { ?>
                                <span style="color: red; font-weight: bold;">Ẩn</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script