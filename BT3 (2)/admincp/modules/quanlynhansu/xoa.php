<?php
include('../../config/config.php'); // Đường dẫn tùy theo vị trí file của bạn

if (isset($_GET['idnhanvien'])) {
    $id = (int)$_GET['idnhanvien'];

    // Lấy ảnh hiện tại để xóa file (nếu có)
    $sql_get = mysqli_query($mysqli, "SELECT hinhanh FROM tbl_nhanvien1 WHERE id_nhanvien = $id LIMIT 1");
    $row = mysqli_fetch_assoc($sql_get);

    if ($row) {
        $hinhanh = $row['hinhanh'];
        $filePath = "uploads/" . $hinhanh;

        if (file_exists($filePath) && !empty($hinhanh)) {
            unlink($filePath);
        }
    }

    // Xóa dữ liệu nhân viên trong database
    $sql_delete = "DELETE FROM tbl_nhanvien1 WHERE id_nhanvien = $id";
    if (mysqli_query($mysqli, $sql_delete)) {
        $_SESSION['message'] = "Xóa nhân viên thành công!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Xóa nhân viên thất bại: " . mysqli_error($mysqli);
        $_SESSION['message_type'] = "danger";
    }

    // Quay về trang chính (thay đổi đường dẫn nếu cần)
    header('Location: ../../index.php');
    exit();
} else {
    $_SESSION['message'] = "Không có nhân viên được chọn để xóa.";
    $_SESSION['message_type'] = "warning";
    header('Location: ../../index.php');
    exit();
}
?>
