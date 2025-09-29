<?php
if (isset($_SESSION['message'])) {
  $msgType = $_SESSION['message_type'] ?? 'info';
  $msg = $_SESSION['message'];
  unset($_SESSION['message'], $_SESSION['message_type']);
  echo "<div class='alert alert-$msgType alert-dismissible fade show' role='alert' 
        style='
            position: fixed; 
            top: 20px; 
            left: 50%; 
            transform: translateX(-50%);
            z-index: 1050; 
            min-width: 300px; 
            max-width: 600px;
            text-align: center;
        '>
        $msg
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
?>

<?php
include('../../config/config.php'); // điều chỉnh đường dẫn phù hợp

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suanhanvien'])) {
    $id = $_POST['id_nhanvien'];
    $manv = mysqli_real_escape_string($mysqli, $_POST['manv']);
    $tennhanvien = mysqli_real_escape_string($mysqli, $_POST['tennhanvien']);
    $ngaysinh = mysqli_real_escape_string($mysqli, $_POST['ngaysinh']);
    $nam = (int) $_POST['nam'];
    $tieusu = mysqli_real_escape_string($mysqli, $_POST['tieusu']);
    $luong = (float) $_POST['luong'];
    $chucvu = mysqli_real_escape_string($mysqli, $_POST['chucvu']);
    $tinhtrang = mysqli_real_escape_string($mysqli, $_POST['tinhtrang']);

    // Xử lý upload ảnh mới nếu có
    if (!empty($_FILES['hinhanh']['name'])) {
        $hinhanh = time() . '_' . basename($_FILES['hinhanh']['name']);
        $upload_dir = 'uploads/'; // điều chỉnh đường dẫn
        $upload_path = $upload_dir . $hinhanh;

        if (move_uploaded_file($_FILES['hinhanh']['tmp_name'], $upload_path)) {
            $sql_update = "UPDATE tbl_nhanvien1 SET
                manv='$manv',
                tennhanvien='$tennhanvien',
                tuoi='$ngaysinh',
                nam='$nam',
                tieusu='$tieusu',
                luong='$luong',
                chucvu='$chucvu',
                tinhtrang='$tinhtrang',
                hinhanh='$hinhanh'
                WHERE id_nhanvien='$id'";
        } else {
            $_SESSION['message'] = "Lỗi upload ảnh.";
            $_SESSION['message_type'] = "danger";
            header('Location: ../index.php'); // đường dẫn về trang chính
            exit();
        }
    } else {
        $sql_update = "UPDATE tbl_nhanvien1 SET
            manv='$manv',
            tennhanvien='$tennhanvien',
            tuoi='$ngaysinh',
            nam='$nam',
            tieusu='$tieusu',
            luong='$luong',
            chucvu='$chucvu',
            tinhtrang='$tinhtrang'
            WHERE id_nhanvien='$id'";
    }

    if (mysqli_query($mysqli, $sql_update)) {
        $_SESSION['message'] = "Cập nhật nhân viên thành công!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Lỗi cập nhật: " . mysqli_error($mysqli);
        $_SESSION['message_type'] = "danger";
    }

    // Quay về trang chính sau khi xử lý
    header('Location: ../../index.php'); // điều chỉnh đường dẫn
    exit();
} else {
    header('Location: ../../index.php');
    exit();
}

