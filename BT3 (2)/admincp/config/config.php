<?php
    $mysqli = new mysqli("localhost","root","","bt3");

    // Check connection
    if ($mysqli->connect_errno) {
      echo "Kết nối MYSQLi lỗi" . $mysqli->connect_error;
      exit();
    }
?>