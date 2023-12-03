<?php
  if(isset($_POST["title"]) && isset($_POST["writer"]) && isset($_POST["content"])) {
    include_once('./config/config.php');
    
    $connect = new mysqli($host, $user, $password, $database);

    $title = mysqli_real_escape_string($connect, $_POST["title"]);
    $writer = mysqli_real_escape_string($connect, $_POST["writer"]);
    $content = mysqli_real_escape_string($connect, $_POST["content"]);
    $query = "insert into tbl_board(title, writer, content) values('$title', '$writer', '$content')";

    if ($connect->query($query)) {
      echo '성공!';
    } else {
      echo '쿼리 실행 실패 : ' . $connect->error;
    }
  }


?>