<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

<style>
    .employee-img {
        object-fit: cover;
        object-position: center 30%;
        /* căn giữa ngang, hơi lên trên (30% từ trên xuống) */
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
    <div id="employee-list" class="table-form">
        <div class="table-title text-center">📦 Liệt kê danh sách nhân viên</div>

        <form method="POST" action="#employee-list" class="mb-3">
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
                    <th>Ngày sinh</th>
                    <th>Số năm kinh nghiệm</th>
                    <th>Chức vụ</th>
                    <th>Tiểu sử</th>
                    <th>Trạng thái</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['timkiem'])) {
                    $tukhoa = mysqli_real_escape_string($mysqli, $_POST['tukhoa']);
                    $sql_lietke_nv = "SELECT * FROM tbl_nhanvien1 
                      WHERE tennhanvien LIKE '%$tukhoa%' 
                         OR manv LIKE '%$tukhoa%' 
                         OR chucvu LIKE '%$tukhoa%'
                      ORDER BY manv ASC";
                } else {
                    $sql_lietke_nv = "SELECT * FROM tbl_nhanvien1 ORDER BY manv ASC";
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
                        <td><?php echo date('d/m/Y', strtotime($row['tuoi'])); ?></td>
                        <td><?php echo $row['nam']; ?> năm</td>
                        <td><?php echo $row['chucvu']; ?></td>
                        <td><?php echo $row['tieusu']; ?></td>
                        <td>
                            <?php if ($row['tinhtrang'] == 'Kích hoạt') { ?>
                                <span style="color: green; font-weight: bold;">Kích hoạt</span>
                            <?php } else { ?>
                                <span style="color: red; font-weight: bold;">Ẩn</span>
                            <?php } ?>
                        </td>
                        <td>
                            <form method="GET" action="modules/quanlynhansu/xoa.php" style="display:inline;"
                                onsubmit="return confirm('Bạn có chắc muốn xóa nhân viên này không?');">
                                <input type="hidden" name="idnhanvien" value="<?php echo $row['id_nhanvien']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm mt-2">Xóa</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-sm btn-edit mt-2" data-bs-toggle="modal"
                                data-bs-target="#editEmployeeModal" data-id="<?php echo $row['id_nhanvien']; ?>"
                                data-manv="<?php echo htmlspecialchars($row['manv']); ?>"
                                data-tennhanvien="<?php echo htmlspecialchars($row['tennhanvien']); ?>"
                                data-ngaysinh="<?php echo date('Y-m-d', strtotime($row['tuoi'])); ?>"
                                data-nam="<?php echo htmlspecialchars($row['nam']); ?>"
                                data-tieusu="<?php echo htmlspecialchars($row['tieusu']); ?>"
                                data-luong="<?php echo htmlspecialchars($row['luong']); ?>"
                                data-chucvu="<?php echo htmlspecialchars($row['chucvu']); ?>"
                                data-tinhtrang="<?php echo htmlspecialchars($row['tinhtrang']); ?>"
                                data-hinhanh="modules/quanlynhansu/uploads/<?php echo htmlspecialchars($row['hinhanh']); ?>">
                                Sửa
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal sửa nhân viên -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEmployeeForm" method="POST" action="modules/quanlynhansu/xuly.php"
                enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Sửa thông tin nhân viên</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_nhanvien" id="edit-id">

                    <div class="mb-3">
                        <label for="edit-manv" class="form-label">Mã nhân viên</label>
                        <input type="text" class="form-control" id="edit-manv" name="manv" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-tennhanvien" class="form-label">Tên nhân viên</label>
                        <input type="text" class="form-control" id="edit-tennhanvien" name="tennhanvien" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-ngaysinh" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="edit-ngaysinh" name="ngaysinh" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-nam" class="form-label">Số năm kinh nghiệm</label>
                        <input type="number" class="form-control" id="edit-nam" name="nam" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-tieusu" class="form-label">Tiểu sử</label>
                        <textarea class="form-control" id="edit-tieusu" name="tieusu" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-luong" class="form-label">Lương</label>
                        <input type="number" class="form-control" id="edit-luong" name="luong" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit-chucvu" class="form-label">Chức vụ</label>
                        <select class="form-select" id="edit-chucvu" name="chucvu" required>
                            <option value="">Chọn chức vụ</option>
                            <option>Nhân viên</option>
                            <option>Quản lý</option>
                            <option>Giám đốc</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-tinhtrang" class="form-label">Tình trạng</label>
                        <select class="form-select" id="edit-tinhtrang" name="tinhtrang" required>
                            <option value="">Chọn tình trạng</option>
                            <option>Kích hoạt</option>
                            <option>Ẩn</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit-hinhanh" class="form-label">Hình ảnh</label>
                        <input type="file" class="form-control" id="edit-hinhanh" name="hinhanh">
                        <img id="current-hinhanh" src="" alt="Ảnh hiện tại"
                            style="max-width: 150px; margin-top:10px; border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name="suanhanvien" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const manv = this.dataset.manv;
                const tennhanvien = this.dataset.tennhanvien;
                const ngaysinh = this.dataset.ngaysinh;
                const nam = this.dataset.nam;
                const tieusu = this.dataset.tieusu;
                const luong = this.dataset.luong;
                const chucvu = this.dataset.chucvu;
                const tinhtrang = this.dataset.tinhtrang;
                const hinhanh = this.dataset.hinhanh;

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-manv').value = manv;
                document.getElementById('edit-tennhanvien').value = tennhanvien;
                document.getElementById('edit-ngaysinh').value = ngaysinh;
                document.getElementById('edit-nam').value = nam;
                document.getElementById('edit-tieusu').value = tieusu;
                document.getElementById('edit-luong').value = luong;
                document.getElementById('edit-chucvu').value = chucvu;
                document.getElementById('edit-tinhtrang').value = tinhtrang;
                document.getElementById('current-hinhanh').src = hinhanh;

                modal.show();
            });
        });
    });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var message = <?php echo json_encode($message); ?>;
    if (message) {
      var modal = new bootstrap.Modal(document.getElementById('addEmployeeModal'));
      modal.show();
    }
  });
</script>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');
    if (alert) {
      setTimeout(() => {
        // Bootstrap 5 alert dismiss
        const alertInstance = bootstrap.Alert.getOrCreateInstance(alert);
        alertInstance.close();
      }, 2000);
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');
    if (alert) {
      setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
        bsAlert.close();
      }, 2000);
    }
  });
</script>