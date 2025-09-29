<?php
    session_start();
    if(isset($_POST['dangky'])){
        $tenkhachhang = $_POST['hovaten'];
        $email = $_POST['email'];
        $dienthoai = $_POST['dienthoai'];
        $diachi = $_POST['diachi'];
        $matkhau = md5($_POST['matkhau']);
        $sql_dangky = mysqli_query($mysqli,"INSERT INTO tbl_dangky1(tenkhachhang,email,dienthoai,diachi,matkhau) VALUE('".$tenkhachhang."','".$email."','".$dienthoai."','".$diachi."','".$matkhau."')");
        if($sql_dangky){
            echo '<p style="color:green">Bạn đã đăng ký thành công</p>';
            $_SESSION['dangky'] = $tenkhachhang;
            $_SESSION['id_khachhang'] = mysqli_insert_id($mysqli);
            header('Location:index.php');
        }
    }
?>

<?php
    include('config/config.php');
    if(isset($_POST['dangnhap'])){
        $taikhoan=$_POST['username'];
        $matkhau=md5($_POST['password']);
        $sql = "SELECT * FROM tbl_dangky1 WHERE email ='".$taikhoan."' AND matkhau ='".$matkhau."' LIMIT 1";
        $row = mysqli_query($mysqli,$sql);
        $count = mysqli_num_rows($row);
        if($count > 0){
            $_SESSION['dangnhap'] = $taikhoan;
            header("Location:index.php");
        }else{
            echo '<script>alert("Tài khoản hoặc mật khẩu không đúng, vui lòng nhập lại.");</script>';
            header("Location:login.php");
        }
    }
?> 

<div class="d-flex justify-content-end align-items-center p-3" style="background-color: #007BFF;">
    <?php if (isset($_SESSION['dangnhap'])): ?>
        <a href="index.php?dangxuat=1" class="btn btn-danger">
            Đăng xuất : <?php echo $_SESSION['dangnhap']; ?>
        </a>
    <?php else: ?>
        <div class="d-flex gap-2">
      <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#loginModal">
        Đăng nhập
      </button>
      <button class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#registerModal">
        Đăng ký
      </button>
    </div>
    <?php endif; ?>
</div>

<?php
// Xử lý đăng nhập
$username = $password = "";
$loginErrors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangnhap"])) {
  function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
  }

  $username = test_input($_POST["username"] ?? '');
  $password = test_input($_POST["password"] ?? '');

  if (empty($username)) $loginErrors['username'] = "Vui lòng nhập tên đăng nhập";
  if (empty($password)) $loginErrors['password'] = "Vui lòng nhập mật khẩu";

  // Nếu không lỗi, bạn có thể kiểm tra DB tại đây
}
?>

<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control <?= isset($loginErrors['username']) ? 'is-invalid' : '' ?>" name="username" id="username" value="<?= htmlspecialchars($username) ?>">
          <div class="invalid-feedback"><?= $loginErrors['username'] ?? '' ?></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" class="form-control <?= isset($loginErrors['password']) ? 'is-invalid' : '' ?>" name="password" id="password">
          <div class="invalid-feedback"><?= $loginErrors['password'] ?? '' ?></div>
        </div>

        <div class="text-end">
          <a href="#" id="goToRegister" class="small text-decoration-none">Chưa có tài khoản? Đăng ký</a>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" name="dangnhap" class="btn btn-primary w-100">Đăng nhập</button>
      </div>
    </form>
  </div>
</div>

<!-- Mở lại modal login nếu có lỗi -->
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangnhap"]) && !empty($loginErrors)): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
      loginModal.show();
    });
  </script>
<?php endif; ?>


<?php
// Khởi tạo biến
$hoten = $email = $dienthoai = $diachi = $matkhau = "";
$errors = [];

// Xử lý form đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangky"])) {
  function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
  }

  $hoten = test_input($_POST["hovaten"] ?? '');
  $email = test_input($_POST["email"] ?? '');
  $dienthoai = test_input($_POST["dienthoai"] ?? '');
  $diachi = test_input($_POST["diachi"] ?? '');
  $matkhau = test_input($_POST["matkhau"] ?? '');

  // Validation
  if (empty($hoten)) $errors['hovaten'] = "Vui lòng nhập họ tên";
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ";
  if (empty($dienthoai)) $errors['dienthoai'] = "Vui lòng nhập số điện thoại";
  if (empty($diachi)) $errors['diachi'] = "Vui lòng nhập địa chỉ";
  if (empty($matkhau)) $errors['matkhau'] = "Vui lòng nhập mật khẩu";

  // Nếu không có lỗi, bạn có thể xử lý lưu CSDL ở đây
}
?>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Đăng ký thành viên</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Họ và tên</label>
          <input type="text" class="form-control <?= isset($errors['hovaten']) ? 'is-invalid' : '' ?>" name="hovaten" value="<?= htmlspecialchars($hoten) ?>">
          <div class="invalid-feedback"><?= $errors['hovaten'] ?? '' ?></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="text" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?= htmlspecialchars($email) ?>">
          <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Điện thoại</label>
          <input type="text" class="form-control <?= isset($errors['dienthoai']) ? 'is-invalid' : '' ?>" name="dienthoai" value="<?= htmlspecialchars($dienthoai) ?>">
          <div class="invalid-feedback"><?= $errors['dienthoai'] ?? '' ?></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Địa chỉ</label>
          <input type="text" class="form-control <?= isset($errors['diachi']) ? 'is-invalid' : '' ?>" name="diachi" value="<?= htmlspecialchars($diachi) ?>">
          <div class="invalid-feedback"><?= $errors['diachi'] ?? '' ?></div>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" class="form-control <?= isset($errors['matkhau']) ? 'is-invalid' : '' ?>" name="matkhau">
          <div class="invalid-feedback"><?= $errors['matkhau'] ?? '' ?></div>
        </div>

        <div class="text-end">
            <a href="#" id="goToLogin" class="small text-decoration-none">Đăng nhập nếu đã có tài khoản</a>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" name="dangky" class="btn btn-primary w-100">Đăng ký</button>
      </div>
    </form>
  </div>
</div>

<!-- Tự động mở lại modal nếu có lỗi -->
<?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dangky"]) && !empty($errors)): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
      registerModal.show();
    });
  </script>
<?php endif; ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const goToLogin = document.getElementById('goToLogin');
    const goToRegister = document.getElementById('goToRegister');

    if (goToLogin) {
      goToLogin.addEventListener('click', function (e) {
        e.preventDefault();
        const regModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        regModal.hide();

        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        setTimeout(() => loginModal.show(), 300);
      });
    }

    if (goToRegister) {
      goToRegister.addEventListener('click', function (e) {
        e.preventDefault();
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        loginModal.hide();

        const regModal = new bootstrap.Modal(document.getElementById('registerModal'));
        setTimeout(() => regModal.show(), 300);
      });
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

