<?php
  $bno = $_GET['bno'];
  $title = $_POST['title'];
  $writer = $_POST['writer'];
  $content = $_POST['content'];
  if(isset($_POST["title"]) && isset($_POST["writer"]) && isset($_POST["content"])) {
    include_once('./config/config.php');
    
    $connect = new mysqli($host, $user, $password, $database);

    $query = "
      update tbl_board 
      set title = '$title', writer = '$writer', content = '$content'
      where bno = '$bno'
    ";

    if($connect -> query($query)) { 
      echo "
        <script>
          alert('수정완료!');
          window.location.replace('http://localhost:8081/boardEx/boardList.php');
        </script>
      ";
    }
  }