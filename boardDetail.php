<!DOCTYPE html>
<html lang="ko">
<?php include('./layout/head.php'); ?>

<body>
  <?php include './layout/header.php'; ?>

  <?php 
    include_once('./config/config.php');

    $connect = new mysqli($host, $user, $password, $database);
    $bno = $_GET['bno'];
    $query = "select * from tbl_board where bno = $bno";
    $result = $connect -> query($query);

    if($result) {
      $row = $result->fetch_assoc();
      echo '
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">제목</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" disabled value="'.$row['title'].'">
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">작성자</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" disabled value="'.$row['writer'].'">
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text" id="inputGroup-sizing-default">작성일</span>
        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" disabled value="'.$row['regdate'].'">
      </div>
      <div class="input-group mb-3">
        <textarea type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" style="min-height: 300px;" disabled>'.$row['content'].'</textarea>
      </div>
      ';
    }else {
      echo "쿼리 실행 실패 : ".$connect->error;
    }
    $result->free();
    
    echo'
      <div class="d-flex justify-content-center">
        <a class="btn btn-primary align-center m-1" href="boardList.php">목록으로</a>
        <a class="btn btn-warning text-white m-1" href="boardModify.php?bno='.$bno.'">수정하기</a>
        <a class="btn btn-danger text-center m-1" href="boardDelete.php?bno='.$bno.'">삭제하기</a>
      </div>
    '
    ?>


  <?php include './layout/footer.php' ; ?>

</body>

</html>