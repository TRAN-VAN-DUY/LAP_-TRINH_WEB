<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Form Đăng ký</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light-subtle">
  <div class="container-fluid py-5">
    <div class="card shadow-lg mx-auto border-0" style="max-width: 95%;">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">📝 Đăng ký thông tin</h4>
      </div>

      <div class="card-body bg-white">
        <form>
          <!-- Họ & Tên -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="ho" class="form-label fw-semibold">Họ</label>
              <input type="text" class="form-control border-primary-subtle" id="ho" placeholder="Nhập họ của bạn">
            </div>
            <div class="col-md-6">
              <label for="ten" class="form-label fw-semibold">Tên</label>
              <input type="text" class="form-control border-primary-subtle" id="ten" placeholder="Nhập tên của bạn">
            </div>
          </div>

          <!-- Mật khẩu -->
          <div class="mb-3">
            <label for="matkhau" class="form-label fw-semibold">Mật khẩu</label>
            <input type="password" class="form-control border-secondary-subtle" id="matkhau" placeholder="Nhập mật khẩu">
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control border-secondary-subtle" id="email" placeholder="Nhập email">
          </div>

          <!-- Ngày sinh & Giới tính -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="ngaysinh" class="form-label fw-semibold">Ngày sinh</label>
              <input type="date" class="form-control border-info-subtle" id="ngaysinh">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold d-block">Giới tính</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gioitinh" id="nam" value="Nam">
                <label class="form-check-label" for="nam">Nam</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gioitinh" id="nu" value="Nữ">
                <label class="form-check-label" for="nu">Nữ</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gioitinh" id="khac" value="Khác">
                <label class="form-check-label" for="khac">Khác</label>
              </div>
            </div>
          </div>

          <!-- Thành phố -->
          <div class="mb-3">
            <label for="thanhpho" class="form-label fw-semibold">Thành phố</label>
            <select class="form-select border-success-subtle" id="thanhpho">
              <option selected disabled>-- Mời chọn --</option>
              <option>Hà Nội</option>
              <option>Đà Nẵng</option>
              <option>TP. Hồ Chí Minh</option>
            </select>
          </div>

          <!-- Sở thích -->
          <div class="mb-3">
            <label class="form-label fw-semibold d-block">Sở thích</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="doc-sach">
              <label class="form-check-label" for="doc-sach">📖 Đọc sách</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="nghe-nhac">
              <label class="form-check-label" for="nghe-nhac">🎵 Nghe nhạc</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="xem-phim">
              <label class="form-check-label" for="xem-phim">🎬 Xem phim</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="bong-da">
              <label class="form-check-label" for="bong-da">⚽ Bóng đá</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="cau-long">
              <label class="form-check-label" for="cau-long">🏸 Cầu lông</label>
            </div>
          </div>

          <!-- Mô tả -->
          <div class="mb-4">
            <label for="mota" class="form-label fw-semibold">Mô tả bản thân</label>
            <textarea class="form-control border-secondary-subtle" id="mota" rows="4" placeholder="Giới thiệu về bạn..."></textarea>
          </div>

          <!-- Nút -->
          <div class="d-flex gap-3">
            <button type="submit" class="btn btn-success px-4">✅ Đăng ký</button>
            <button type="reset" class="btn btn-outline-secondary px-4">🔁 Làm lại</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
