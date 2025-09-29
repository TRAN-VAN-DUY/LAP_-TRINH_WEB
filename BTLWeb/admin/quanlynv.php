<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý nhân viên</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <style>
    .bg-light {
      background-color: #f0f2f5;
    }

    .table-form {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      margin-bottom: 40px;
    }

    .form-title, .table-title {
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

    td, th {
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
  </style>
</head>
<body class="bg-light">

<div class="container" style="padding-top: 50px; padding-bottom: 50px;">

  <!-- Thêm nhân viên -->
  <div class="table-form">
    <div class="form-title text-center">📝 Thêm nhân viên mới</div>
    <form>
      <table class="table">
        <tbody>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Tên nhân viên</label></td>
            <td><input type="text" class="form-control" placeholder="Nhập tên nhân viên"></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Mã nhân viên</label></td>
            <td><input type="text" class="form-control" placeholder="VD: NV001"></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Tuổi</label></td>
            <td><input type="number" class="form-control" placeholder="VD: 20"></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Số năm kinh nghiệm</label></td>
            <td><input type="number" class="form-control" placeholder="VD: 5"></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Hình ảnh</label></td>
            <td><input type="file" class="form-control"></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Tiểu sử</label></td>
            <td><textarea class="form-control" rows="2"></textarea></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Nội dung</label></td>
            <td><textarea class="form-control" rows="3"></textarea></td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Chức vụ</label></td>
            <td>
              <select class="form-control">
                <option selected disabled>Chọn chức vụ</option>
                <option>Nhân viên</option>
                <option>Quản lý</option>
                <option>Giám đốc</option>
              </select>
            </td>
          </tr>
          <tr class="form-group">
            <td class="text-left"><label class="control-label">Tình trạng</label></td>
            <td>
              <select class="form-control">
                <option selected disabled>Chọn tình trạng</option>
                <option>Kích hoạt</option>
                <option>Ẩn</option>
              </select>
            </td>
          </tr>
          <tr>
            <td></td>
            <td class="text-right">
              <button type="submit" class="btn btn-success">Thêm nhân viên</button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>

  <!-- Danh sách nhân viên -->
  <div class="table-form">
    <div class="table-title text-center">📦 Liệt kê danh sách nhân viên</div>

    <div style="margin-bottom: 20px;">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="🔍 Tìm kiếm sản phẩm theo tên, mã, chức vụ...">
        <span class="input-group-btn">
          <button class="btn btn-info" type="button">Search</button>
        </span>
      </div>
    </div>

    <table class="table table-bordered table-striped">
      <thead>
        <tr class="bg-black">
          <th>STT</th>
          <th>Mã nhân viên</th>
          <th>Tên nhân viên</th>
          <th>Hình ảnh</th>
          <th>Tuổi</th>
          <th>Số năm kinh nghiệm</th>
          <th>Chức vụ</th>
          <th>Tiểu sử</th>
          <th>Trạng thái</th>
          <th>Quản lý</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>GD002</td>
          <td>Pond Naravit</td>
          <td><img src="../images/pond.jpg" class="product-img" alt="caro"></td>
          <td>24</td>
          <td>15</td>
          <td>Giám đốc</td>
          <td>Naravit Lertratkosum còn có nghệ danh là Pond, là một diễn viên người Thái Lan trực thuộc GMMTV. Anh bắt đầu được biết đến qua vai chính Mork trong phim Fish Upon the Sky năm 2021, một bộ phim truyền hình được sản xuất bởi GMMTV.</td>
          <td><span class="label label-success">Kích hoạt</span></td>
          <td><a href="#" class="text-danger">Xóa</a> | <a href="#" class="text-primary">Sửa</a></td>
        </tr>
        <tr>
          <td>2</td>
          <td>NV001</td>
          <td>Phuwin Tangsakyuen</td>
          <td><img src="../images/phuwin.jpg" class="product-img" alt="jadore"></td>
          <td>23</td>
          <td>2</td>
          <td>Nhân viên</td>
          <td>Phuwin Tangsakyuen là một diễn viên người Thái Lan trực thuộc GMMTV. Anh bắt đầu được biết đến qua vai chính Pattawee trong phim Fish Upon the Sky năm 2021, một bộ phim truyền hình được sản xuất bởi GMMTV. Năm 2022 - 2023 anh tái kết hợp cùng Naravit Lertratkosum cho ra mắt bộ phim Never Let Me Go.</td>
          <td><span class="label label-success">Kích hoạt</span></td>
          <td><a href="#" class="text-danger">Xóa</a> | <a href="#" class="text-primary">Sửa</a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
