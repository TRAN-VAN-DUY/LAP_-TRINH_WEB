<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

<?php
if (isset($_SESSION['message'])) {
  $type = $_SESSION['message_type'] ?? 'info';
  echo '<div class="alert alert-' . htmlspecialchars($type) . ' text-center" 
              style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050; min-width: 300px; max-width: 600px;">
              ' . htmlspecialchars($_SESSION['message']) . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  unset($_SESSION['message'], $_SESSION['message_type']);
}
?>

<style>
  /* Hiệu ứng hover cho nút Đăng xuất */
  a.btn-danger:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  button.btn:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .btn-add-employee:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
</style>
<?php

// Xử lý đăng xuất
if (isset($_GET['dangxuat']) && $_GET['dangxuat'] == 1) {
  unset($_SESSION['dangnhap']);
  header('Location:login.php');
  exit();
}
?>
<!-- Nút ở góc phải header -->
<div class="d-flex align-items-center p-3" style="background-color: rgb(182, 210, 236); color: #f8f9fa;">
  <!-- Logo chiếm 1/3 chiều ngang -->
  <div style="flex: 1; max-width: 33.33%;">
    <a href="index.php" style="display: flex; justify-content: center; align-items: center;">
      <img src="modules/quanlynhansu/uploads/GMMTV_Logo.svg.png" alt="Logo"
        style="max-height: 50px; max-width: 100%; object-fit: contain;">
    </a>
  </div>

  <!-- Phần nút chiếm 2/3 chiều ngang -->
  <div style="flex: 2; max-width: 66.66%;" class="d-flex justify-content-end gap-2 align-items-center">
    <a href="thongke.php" class="btn btn-warning text-white">
      <i class="fa-solid fa-chart-bar me-2"></i>Thống kê
    </a>
    <a id="btn-scroll-to-list" href="index.php#employee-list" class="btn btn-primary">
      <i class="fa-solid fa-users me-2"></i> Danh sách nhân viên
    </a>
    <button class="btn btn-success text-white btn-add-employee" data-bs-toggle="modal"
      data-bs-target="#addEmployeeModal">
      <i class="fa-solid fa-user-plus me-2"></i> Thêm nhân viên
    </button>
    <a href="index.php?dangxuat=1" class="btn btn-danger">
      Đăng xuất: <?php echo htmlspecialchars($_SESSION['dangnhap']); ?>
    </a>
  </div>
</div>


<?php
if (isset($_SESSION['message'])) {
  echo '<script>alert("' . $_SESSION['message'] . '");</script>';
  unset($_SESSION['message']);
}
?>


<?php
include('config/config.php');

$message = '';
$message_type = '';

// Khai báo biến giữ giá trị input (mặc định rỗng)
$input_tennhanvien = '';
$input_manv = '';
$input_ngaysinh = '';
$input_nam = '';
$input_tieusu = '';
$input_luong = '';
$input_chucvu = '';
$input_tinhtrang = '';

function test_input($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

// Xử lý form thêm nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["themnv"])) {
  $input_tennhanvien = test_input($_POST["tennhanvien"] ?? '');
  $input_manv = test_input($_POST["manv"] ?? '');
  $input_ngaysinh = test_input($_POST["ngaysinh"] ?? '');
  $input_nam = test_input($_POST["nam"] ?? '');
  $input_tieusu = test_input($_POST["tieusu"] ?? '');
  $input_luong = test_input($_POST["luong"] ?? '');
  $input_chucvu = test_input($_POST["chucvu"] ?? '');
  $input_tinhtrang = test_input($_POST["tinhtrang"] ?? '');

  $hinhanh = $_FILES['hinhanh']['name'] ?? '';
  $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'] ?? '';
  $hinhanh_save = time() . '_' . $hinhanh;

  // Validation
  $errors = [];
  if (empty($input_tennhanvien))
    $errors[] = "Vui lòng nhập tên nhân viên";
  if (empty($input_manv))
    $errors[] = "Vui lòng nhập mã nhân viên";
  if (empty($hinhanh))
    $errors[] = "Vui lòng chọn hình ảnh";
  if (empty($input_ngaysinh))
    $errors[] = "Vui lòng nhập ngày sinh";
  if (!is_numeric($input_nam) || $input_nam < 0)
    $errors[] = "Số năm kinh nghiệm không hợp lệ";
  if (empty($input_tieusu))
    $errors[] = "Vui lòng nhập tiểu sử";
  if (!is_numeric($input_luong) || $input_luong <= 0)
    $errors[] = "Lương phải lớn hơn 0";
  if (empty($input_chucvu))
    $errors[] = "Vui lòng chọn chức vụ";
  if (empty($input_tinhtrang))
    $errors[] = "Vui lòng chọn tình trạng";

  if (empty($errors)) {
    // Kiểm tra trùng mã nhân viên
    $check_manv = mysqli_query($mysqli, "SELECT * FROM tbl_nhanvien1 WHERE manv = '$input_manv' LIMIT 1");
    if (mysqli_num_rows($check_manv) > 0) {
      $message = "Mã nhân viên đã tồn tại, vui lòng nhập mã khác.";
      $message_type = 'danger';
    } else {
      // Upload ảnh
      $upload_path = 'modules/quanlynhansu/uploads/' . $hinhanh_save;
      if (move_uploaded_file($hinhanh_tmp, $upload_path)) {
        // Insert vào DB
        $sql_them = mysqli_query($mysqli, "
                    INSERT INTO tbl_nhanvien1 (tennhanvien, hinhanh, tuoi, chucvu, luong, tieusu, nam, tinhtrang, manv)
                    VALUES ('$input_tennhanvien', '$hinhanh_save', '$input_ngaysinh', '$input_chucvu', '$input_luong', '$input_tieusu', '$input_nam', '$input_tinhtrang', '$input_manv')
                ");

        if ($sql_them) {
          $message = "Thêm nhân viên thành công!";
          $message_type = 'success';

          // Reset lại các trường (trừ mã nhân viên về "0")
          $input_tennhanvien = '';
          $input_manv = '0';
          $input_ngaysinh = '';
          $input_nam = '';
          $input_tieusu = '';
          $input_luong = '';
          $input_chucvu = '';
          $input_tinhtrang = '';
        } else {
          $message = "Thêm nhân viên thất bại! Lỗi: " . mysqli_error($mysqli);
          $message_type = 'danger';
        }
      } else {
        $message = "Upload hình ảnh thất bại!";
        $message_type = 'danger';
      }
    }
  } else {
    $message = implode('<br>', $errors);
    $message_type = 'danger';
  }
}
?>

<!-- Modal thêm nhân viên -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="modal-header justify-content-center bg-success text-white">
          <h5 class="modal-title mb-0" id="addEmployeeModalLabel">Thêm nhân viên</h5>
          <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"
            aria-label="Đóng"></button>
        </div>

        <?php if (!empty($message)): ?>
          <div class="alert alert-<?php echo $message_type; ?> m-3" id="modalMessage"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Tên nhân viên</label>
            <input type="text" name="tennhanvien" class="form-control" required
              value="<?php echo htmlspecialchars($input_tennhanvien); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Mã nhân viên</label>
            <input type="text" name="manv" class="form-control" required
              value="<?php echo htmlspecialchars($input_manv); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Hình ảnh</label>
            <input type="file" name="hinhanh" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày sinh</label>
            <input type="date" name="ngaysinh" class="form-control" required
              value="<?php echo htmlspecialchars($input_ngaysinh); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Số năm kinh nghiệm</label>
            <input type="number" name="nam" class="form-control" min="0" required
              value="<?php echo htmlspecialchars($input_nam); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Tiểu sử</label>
            <input type="text" name="tieusu" class="form-control" required
              value="<?php echo htmlspecialchars($input_tieusu); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Lương</label>
            <input type="number" name="luong" class="form-control" min="1" required
              value="<?php echo htmlspecialchars($input_luong); ?>">
          </div>
          <div class="mb-3">
            <label class="control-label">Chức vụ</label>
            <select name="chucvu" class="form-select" required>
              <option disabled <?php echo empty($input_chucvu) ? 'selected' : ''; ?>>Chọn chức vụ</option>
              <option <?php echo ($input_chucvu === 'Nhân viên') ? 'selected' : ''; ?>>Nhân viên</option>
              <option <?php echo ($input_chucvu === 'Quản lý') ? 'selected' : ''; ?>>Quản lý</option>
              <option <?php echo ($input_chucvu === 'Giám đốc') ? 'selected' : ''; ?>>Giám đốc</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="control-label">Tình trạng</label>
            <select name="tinhtrang" class="form-select" required>
              <option disabled <?php echo empty($input_tinhtrang) ? 'selected' : ''; ?>>Chọn tình trạng</option>
              <option <?php echo ($input_tinhtrang === 'Kích hoạt') ? 'selected' : ''; ?>>Kích hoạt</option>
              <option <?php echo ($input_tinhtrang === 'Ẩn') ? 'selected' : ''; ?>>Ẩn</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" name="themnv" class="btn btn-success">Thêm nhân viên</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap CSS & JS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />



<script>
  // Đảm bảo DOM đã tải xong mới gán event
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btn-scroll-to-list');
    if (btn) {
      btn.addEventListener('click', function () {
        // Gửi event scroll đến danh sách ở menu.php
        // Vì là cùng trang, dùng scrollIntoView với id của phần cần đến
        var list = document.getElementById('employee-list');
        if (list) {
          list.scrollIntoView({ behavior: 'smooth' });
        }
      });
    }
  });
</script>
<script>
  window.addEventListener('load', () => {
    if (window.location.hash === '#employee-list') {
      const el = document.getElementById('employee-list');
      if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
      }
    }
  });
</script>