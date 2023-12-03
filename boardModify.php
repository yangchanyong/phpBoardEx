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
      <form action="boardModifyOk.php?bno='.$bno.'" method="post">
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">제목</span>
          <input type="text" class="form-control" name="title" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"  value="'.$row['title'].'">
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">작성자</span>
          <input type="text" class="form-control" name="writer" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"  value="'.$row['writer'].'">
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-default">작성일</span>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="'.$row['regdate'].'">
        </div>
        <div class="input-group mb-3">
          <textarea type="text" class="form-control" name="content" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" style="min-height: 300px;">'.$row['content'].'</textarea>
        </div>
      ';
    }else {
      echo "쿼리 실행 실패 : ".$connect->error;
    }
    $result->free();
    echo'
      <div class="d-flex justify-content-center">
        <a class="btn btn-outline-primary align-center m-1" href="boardDetail.php?bno='.$bno.'">이전으로</a>
        <button class="btn btn-outline-warning m-1" type="submit">수정하기</button>
        <a class="btn btn-outline-danger text-center m-1" href="boardDelete.php?bno='.$bno.'">삭제하기</a>
      </div>
      </form>
    '
    ?>


  <?php include './layout/footer.php' ; ?>

</body>

</html>