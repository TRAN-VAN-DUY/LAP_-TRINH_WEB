<?php
// Đếm số lượng nhân viên theo chức vụ
$sql_stats = "
  SELECT chucvu, COUNT(*) AS count
  FROM tbl_nhanvien1
  WHERE chucvu IN ('Nhân viên', 'Quản lý', 'Giám đốc')
  GROUP BY chucvu
";

$result = mysqli_query($mysqli, $sql_stats);

// Khởi tạo mảng chứa số lượng
$stats = [
    'Nhân viên' => 0,
    'Quản lý' => 0,
    'Giám đốc' => 0
];

// Lấy dữ liệu từ DB
while ($row = mysqli_fetch_assoc($result)) {
    $stats[$row['chucvu']] = $row['count'];
}
?>

<?php
// Kết nối $mysqli đã có

$sql_age_group = "
SELECT
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tuoi, CURDATE()) < 20 THEN 1 ELSE 0 END) AS duoi_20,
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tuoi, CURDATE()) BETWEEN 20 AND 25 THEN 1 ELSE 0 END) AS tu_20_den_25,
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tuoi, CURDATE()) BETWEEN 26 AND 35 THEN 1 ELSE 0 END) AS tu_26_den_35,
  SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tuoi, CURDATE()) > 35 THEN 1 ELSE 0 END) AS tren_35
FROM tbl_nhanvien1
";

$result = mysqli_query($mysqli, $sql_age_group);
$age_stats = mysqli_fetch_assoc($result);
?>

<?php
// Truy vấn đếm số lượng nhân viên theo nhóm năm kinh nghiệm
$sql_exp_group = "
SELECT
  SUM(CASE WHEN nam < 1 THEN 1 ELSE 0 END) AS duoi_1_nam,
  SUM(CASE WHEN nam BETWEEN 1 AND 3 THEN 1 ELSE 0 END) AS tu_1_den_3_nam,
  SUM(CASE WHEN nam BETWEEN 4 AND 7 THEN 1 ELSE 0 END) AS tu_4_den_7_nam,
  SUM(CASE WHEN nam > 7 THEN 1 ELSE 0 END) AS tren_7_nam
FROM tbl_nhanvien1
";

$result_exp = mysqli_query($mysqli, $sql_exp_group);
$exp_stats = mysqli_fetch_assoc($result_exp);
?>

<style>
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

    .table-form table:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
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

<div class="container" style="padding: 50px 0;">
    <div class="table-form">
        <div class="table-title text-center">📊 Thống kê số lượng nhân sự</div>

        <div class="row">
            <!-- Bảng số lượng bên trái -->
            <div class="col-md-6">
                <table class="table table-bordered" style="max-width: 400px; margin: 0 auto;">
                    <thead class="table-dark">
                        <tr>
                            <th>Chức vụ</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Giám đốc</td>
                            <td><?php echo isset($stats['Giám đốc']) ? $stats['Giám đốc'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Quản lý</td>
                            <td><?php echo isset($stats['Quản lý']) ? $stats['Quản lý'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Nhân viên</td>
                            <td><?php echo isset($stats['Nhân viên']) ? $stats['Nhân viên'] : 0; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Biểu đồ bên phải -->
            <div style="max-width: 600px; margin: 0 auto;">
                <canvas id="staffChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 50px 0;">
    <div class="table-form">
        <div class="table-title text-center mb-4">📊 Thống kê nhân sự theo độ tuổi</div>

        <div class="row">
            <!-- Bảng số lượng bên trái -->
            <div class="col-md-6">
                <table class="table table-bordered" style="max-width: 100%; margin: 0 auto;">
                    <thead class="table-dark">
                        <tr>
                            <th>Nhóm tuổi</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dưới 20</td>
                            <td><?= $age_stats['duoi_20'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Từ 20 đến 25</td>
                            <td><?= $age_stats['tu_20_den_25'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Từ 26 đến 35</td>
                            <td><?= $age_stats['tu_26_den_35'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Trên 35</td>
                            <td><?= $age_stats['tren_35'] ?? 0 ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Biểu đồ bên phải -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <canvas id="ageChart" style="max-width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding: 50px 0;">
    <div class="table-form">
        <div class="table-title text-center mb-4">📊 Thống kê số năm kinh nghiệm</div>
        <div class="row">
            <!-- Bảng số lượng bên trái -->
            <div class="col-md-6">
                <table class="table table-bordered" style="max-width: 100%; margin: 0 auto;">
                    <thead class="table-dark">
                        <tr>
                            <th>Nhóm năm kinh nghiệm</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dưới 1 năm</td>
                            <td><?= $exp_stats['duoi_1_nam'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Từ 1 đến 3 năm</td>
                            <td><?= $exp_stats['tu_1_den_3_nam'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Từ 4 đến 7 năm</td>
                            <td><?= $exp_stats['tu_4_den_7_nam'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Trên 7 năm</td>
                            <td><?= $exp_stats['tren_7_nam'] ?? 0 ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Biểu đồ bên phải -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <canvas id="expChart" style="max-width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>



<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ageChart').getContext('2d');
    const ageChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Dưới 20', '20-25', '26-35', 'Trên 35'],
            datasets: [{
                label: 'Số lượng',
                data: [
                    <?= $age_stats['duoi_20'] ?? 0 ?>,
                    <?= $age_stats['tu_20_den_25'] ?? 0 ?>,
                    <?= $age_stats['tu_26_den_35'] ?? 0 ?>,
                    <?= $age_stats['tren_35'] ?? 0 ?>
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function (value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('staffChart').getContext('2d');

        const staffChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Giám đốc', 'Quản lý', 'Nhân viên'],
                datasets: [{
                    label: 'Số lượng',
                    data: [
                        <?= isset($stats['Giám đốc']) ? $stats['Giám đốc'] : 0 ?>,
                        <?= isset($stats['Quản lý']) ? $stats['Quản lý'] : 0 ?>,
                        <?= isset($stats['Nhân viên']) ? $stats['Nhân viên'] : 0 ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',  // đỏ cho Giám đốc
                        'rgba(54, 162, 235, 0.7)',  // xanh cho Quản lý
                        'rgba(75, 192, 192, 0.7)'   // xanh lá cho Nhân viên
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                return Number.isInteger(value) ? value : null;  // Chỉ hiển thị số nguyên
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxExp = document.getElementById('expChart').getContext('2d');

        const expChart = new Chart(ctxExp, {
            type: 'bar',
            data: {
                labels: ['Dưới 1 năm', '1-3 năm', '4-7 năm', 'Trên 7 năm'],
                datasets: [{
                    label: 'Số lượng nhân viên',
                    data: [
                        <?= $exp_stats['duoi_1_nam'] ?? 0 ?>,
                        <?= $exp_stats['tu_1_den_3_nam'] ?? 0 ?>,
                        <?= $exp_stats['tu_4_den_7_nam'] ?? 0 ?>,
                        <?= $exp_stats['tren_7_nam'] ?? 0 ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.7)',    // màu cam
                        'rgba(153, 102, 255, 0.7)',   // tím
                        'rgba(255, 205, 86, 0.7)',    // vàng nhạt
                        'rgba(54, 162, 235, 0.7)'     // xanh dương
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function (value) {
                                return Number.isInteger(value) ? value : null;
                            }
                        }
                    }
                }
            }
        });
    });
</script>