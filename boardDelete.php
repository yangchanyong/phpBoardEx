<?php
  include_once('./config/config.php');
  $connect = new mysqli($host, $user, $password, $database);
  $bno = $_GET['bno'];
  $query = "delete from tbl_board where bno = $bno";
  if($connect -> query($query)) {
    echo"<script>
      alert('삭제 성공!')
      window.location.replace('http://localhost:8081/boardEx/boardList.php');
    </script>";
  }else {
    echo'실패!';
  }
?>