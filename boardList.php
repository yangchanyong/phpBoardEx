<!DOCTYPE html>
<html lang="ko">
<?php include('./layout/head.php'); ?>

<body>
  <?php include './layout/header.php'; ?>

  <!-- board insert modal button start -->
  <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#boardInsertModal">
    글 작성
  </button>
  <!-- board insert modal button end -->

  <table class="table">
    <thead>
      <tr>
        <th scope="col">글번호</th>
        <th scope="col">제목</th>
        <th scope="col">작성자</th>
        <th scope="col">작성일</th>
      </tr>
    </thead>
    <tbody>

      <?php 
          // db 접속정보
          include_once('./config/config.php');
          // db연결
          $connect = new mysqli($host, $user, $password, $database);

          // 게시물 5개씩 보기
          $amount = 5;
          // page 번호
          $pageNum = isset($_GET["pageNum"]) ? $_GET["pageNum"] : 1;
          // 카테고리가 있을경우 ex)1. 공지사항 2. 자유게시판
          $category = 1;
          //pagination 출력 개수
          $pagination = 3;

          // pagination을 위한 게시글의 총 합을 가져오는 쿼리
          $query = "select count(*) as total from tbl_board";
          // 쿼리 실행문
          $result = $connect -> query($query);
          // 실행된 쿼리의 컬럼을 배열로 저장
          $row = $result -> fetch_assoc();
          // 게시물의 총 갯수
          $total = $row['total'];
          echo "총 게시물 갯수 : ".$total.'<br>';
          // 총갯수 / 출력될 게시물의 갯수 = 총합 페이지
          $totalPage = ceil($total / $amount);
          echo "전체 페이지 수 : ".$totalPage.'<br>';
          $start = ($pageNum -1) * $amount;

          $totalBlock = ceil($totalPage / $pagination);
          echo "totalBlock = ".$totalBlock.'<br>';

          $nowBlock = ceil($pageNum / $pagination);
          echo 'nowBlock = '.$nowBlock.'<br>';
          /* paging : 블럭 당 시작 페이지 번호 = (해당 글의 블럭번호 - 1) * 블럭당 페이지 수 + 1 */
          $s_pageNum = ($nowBlock - 1) * $pagination + 1;
          echo 's_pageNum = '.$s_pageNum;
          // 데이터가 0개인 경우
          if($s_pageNum <= 0){
              $s_pageNum = 1;
          };

          /* paging : 블럭 당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭 당 페이지 수 */
          $e_pageNum = $nowBlock * $pagination;
          // 마지막 번호가 전체 페이지 수를 넘지 않도록
          if($e_pageNum > $totalPage){
              $e_pageNum = $totalPage;
          };

          // board query
          $query = "select * from tbl_board order by bno desc limit $start, $amount";
          $result = $connect -> query($query);
          
          if($result) {
            // row변수에 컬럼값을 배열로 저장
            while($row = $result -> fetch_assoc()) {
              echo '
              <tr>
              <th scope="row">'.$row['bno'].
              '
              <td>
              <a href="boardDetail.php?bno='.$row['bno'].'">'.$row['title'].'</a>
              </td>
              <td>'.$row['writer'].'</td>
              <td>'.$row['regdate'].'</td>
              
              </th>
              </tr>
              ';
            }
            $result->free();
            echo '
            ';
          }else {
            echo "쿼리 실행 실패 : ".$connect->error;
          }
          
          ?>
    </tbody>
  </table>

  <!-- pagination start -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center my-5">
      <?php
        if($pageNum > 1) {
          echo '
          <li class="page-item">
            <a class="page-link" href="boardList.php?pageNum='.($pageNum-1).'" aria-label="Previous">
              <span aria-hidden="true">prev</span>
            </a>
          </li>
          ';
        }
        for($printPage = $s_pageNum; $printPage <= $e_pageNum; $printPage++) {
          echo '
            <li class="page-item '.(($pageNum == $printPage) ? "active" : "").'">
              <a class="page-link" href="boardList.php?pageNum='.$printPage.'">'.$printPage.'</a>
            </li>
          ';
        }
        if($pageNum < $totalPage) {
          echo '
            <li class="page-item">
              <a class="page-link" href="boardList.php?pageNum='.($pageNum+1).'" aria-label="Next">
                <span aria-hidden="true">next</span>
              </a>
            </li>
          ';
        }
      ?>
    </ul>
  </nav>
  <!-- pagination end -->

  <!-- boardInsertModal start -->
  <div class="modal fade" id="boardInsertModal" tabindex="-1" aria-labelledby="boardInsertModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="boardInsertModalLabel">글 작성</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
          <div class="modal-body">

            <div class="mb-3">
              <label for="title" class="form-label">제목</label>
              <input type="text" class="form-control" id="title" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
              <label for="writer" class="form-label">작성자</label>
              <input type="text" class="form-control" id="writer" name="writer">
            </div>

            <div class="mb-3 form-floating">
              <textarea class="form-control" id="content" name="content" style="min-height: 300px;"
                placeholder="Leave a comment here"></textarea>
              <label for="content" class="form-label">내용을 입력해주세요</label>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            <button type="button" class="btn btn-primary" id="insertBtn">작성하기</button>
          </div>
      </div>
      </form>
    </div>
  </div>
  <!-- boardInsertModal end -->

  <?php include './layout/footer.php' ; ?>


</body>
<script>
$(document).ready(function() {

  // 게시글 insert start
  $('#insertBtn').click(function() {
    var title = $('#title').val();
    var writer = $('#writer').val();
    var content = $('#content').val();

    $.ajax({
      url: "boardInsert.php",
      method: "POST",
      data: {
        title: title,
        writer: writer,
        content: content
      },
      success: function(data) {
        alert('게시글이 성공적으로 작성되었습니다.');
        $('#boardInsertModal').modal('hide');
        window.location.reload();
      },
      error: function(error) {
        console.log(error);
      }
    })
  })
  // 게시글 insert end

})
</script>

</html>