<?php
require_once('../lib/sess_start.php');
sess_start();
require_once('../lib/dbconnect.php');
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>With Your Theater</title>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="../bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/main.css">

</head>
<!-- <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> -->

    <body>
      <header>
        <!-- 웹용 header -->
        <div class="w_header">
          <ul class="member_menu">


          </ul>
          <h1><a href="/" style="">With Your Theater</a></h1>
          <nav>
            <div class="nav_wrap">
              <div class="nav_menu">
                <ul class="nav_depth1">
                  <li class="menu1"><a href="/info.php">공연 정보</a></li>
                  <li class="menu2"><a href="/board.php">후기 공유</a></li>
                  <li class="menu3"><a href="/donation.php">후원 하기</a></li>
                  <?php  ?>
                </ul>

              </div>
          </nav>
        </div>
        <!-- 웹용 header -->
      </header>


      <!-- preparing for searching -->
      <?php
/*
      $substring = '';

        if(isset($_GET['searchColumn'])){
          $searchColumn = $_GET['searchColumn'];
          $substring .= '&amp;searchColumn='.$searchColumn;
        }
        if(isset($_GET['searchText'])){
          $searchText=$_GET['searchText'];
          $substring .= '&amp;searchText='.$searchText;
        }
        if (isset($searchColumn)&&isset($searchText)){
          //문법이 굉장히 곤란함. $searchText를 {}로 감싸야 가능했음.
          if (strcmp($searchColumn,'both')==0){
            // echo '둘다 ';
            $searchSql = " WHERE title LIKE '%{$searchText}%' OR content LIKE '%{$searchText}%'";
          } else{
            // echo '둘중하나';
            $searchSql = " WHERE ".$searchColumn." LIKE '%{$searchText}%' ";

          }
        } else{
          $searchSql = '';
          $searchColumn ='';
          $searchText='';

        }
        */

       ?>
       <!-- preparing for search done -->


       <!-- preparing for paging -->
       <?php

       // setting vars : page, list, block
       if (isset($_GET['page'])){
         $page = $_GET['page'];
       } else{
         $page = 1;
       }
       $list = 10;
       $block = 5;

       if (mysqli_connect_error()){
         die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
       } else {
         $s_point = ($page-1) * $list;

         $sql = "SELECT * FROM comment WHERE uid = '{$_SESSION['uid']}'";
         $sql .= " ORDER BY article_id DESC LIMIT $s_point,$list";
         $res = $conn->query($sql);
         if($res === false){
           echo mysqli_error($conn);
         }
         $total = mysqli_num_rows($res);

       }

       // var_dump($res);
       if($total==0){
         // echo '글 없음';
         $emptyData = '<tr><td class="textCenter" colspan="5">댓글이 존재하지 않습니다.</td></tr>';
       } else{
         // echo '글 있음';
       }


       $pageNum = ceil($total/$list);
       //전체 페이지 수는 토탈데이터/페이지 수
       $blockNum = ceil($pageNum/$block);
       //전체 블록 수는 페이지수/블록 수
       $nowBlock = ceil($page/$block);
       //현재 페이지가 위치한 해당 블록
       //예컨대 7페이지면, 7/5 -> 1블록의 2번째에 위치하고잇음

       //페이지의 최대 최소 구현
       $s_page = ($nowBlock * $block) - ($block -1);
       if($s_page<=1){
         $s_page=1;
       }
       $e_page = $nowBlock*$block;
       if($pageNum<=$e_page){
         $e_page=$pageNum;
       }

       ?>
       <!-- preparing for paging done -->





      <?php
      //위에는 페이징을 위해 전체 데이터를 추리고, 작업하는 select sql문이엇고,
      //이제는 실제로 limit을 걸어서 데이터 뽑아오기
      if (mysqli_connect_error()){
        die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
      } else {
        // $s_point = ($page-1) * $list;
        //
        // $sql = "SELECT * FROM comment WHERE uid = '{$_SESSION['uid']}'";
        // $sql .= " ORDER BY article_id DESC LIMIT $s_point,$list";
        // $res = $conn->query($sql);
        // if($res === false){
        //   echo mysqli_error($conn);
        // }
      }
      ?>

      <div class="post-element">
      <div class="board-header" style ="color:#000;font-size:18px; font-weight:700px;text-align:center">
        내가 작성한 댓글 (<?php echo $total ?> 개)

      </div>
      <article class="boardArticle">
      <!-- <h3 style="text-align:center;">후기 공유</h3> -->
      <table class="table" style="width:100%; margin:10px auto;">
      <caption class ="readHide"></caption>
      <thead>
        <tr>
          <th scope="col" class="article_no" style="width:10%">글번호</th>
          <th scope="col" class="article_title" style="width:60%;padding-left:12px !important;" >댓글내용</th>
          <th scope="col" class="article_date" style="width:15%;text-align:center;">날짜</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if(isset($emptyData)){
          echo $emptyData;
        } else{
          //정렬 순서대로 관계배열이 하나씩 순차 감소하면서 출력됨
          while($row=mysqli_fetch_assoc($res)){

         ?>

         <?php
         // echo $row['article_id'];
         ?>
         <?php
         // var_dump($row);
         ?>




         <tr>

        <td scope="col" class="article_no" style="width:10%"><?php echo $row['article_id'] ?></th>
          <!-- 제목 클릭 시 content?article_id= 로 넘겨야한다 -->
        <!-- article_id를 알고있으니, comment테이블에서, 해당 article_id와 일치하는 comment 갯수가져오기 -->

          <th scope="col" class="article_title" style="width:60%;padding-left:12px !important;" ><a style="color:#000000; font-weight:500;" href="/content.php?article_id=<?php echo $row['article_id'] ?>"><?php echo $row['content'] ?></th>
        <td scope="col" class="article_date" style="width:15%;text-align:center;"><?php echo $row['wdate'] ?></th>

        </tr>
      <?php }
      } ?>


      </tbody>
      </table>
      </article>

      </div>




      <!-- paging start -->




      <div id="pagination">
        <div class="btn-group btn-pagination">
          <?php if($s_page-1 ==0){
            $substring='';
            ?>
            <a class="btn btn-default" href="/my/comments.php?page=1">처음</a>
          <a class="btn btn-default" href="/my/comments.php?page=1<?php echo $substring ?>">이전</a>
        <?php } else {  ?>
          <a class="btn btn-default" href="/my/comments.php?page=1">처음</a>
          <a class="btn btn-default" href="/my/comments.php?page=<?php echo $s_page-1 ?>">이전</a>
          <?php } ?>

          <?php
          for ($p = $s_page;$p<=$e_page;$p++){
            //현재페이지부터 시작해서 해당 블록의 마지막페이지까지 페이징 버튼 생성
           ?>
           <a href="/board.php?page=<?php echo $p ?>" class = "btn btn-default"><?php echo $p ?></a>


        <?php } ?>
        <a class="btn btn-default" href="/my/comments.php?page=<?php echo $e_page+1 ?>">다음
        </a>
        <?php if($s_page-1 ==0){
          $substring='';
          ?>
          <a class="btn btn-default" href="/my/comments.php?page=1<?php ?>">끝</a>
        <?php } else { ?>


        <a class="btn btn-default" href="/my/comments.php?page=<?php echo $pageNum ?>">끝</a>
<?php } ?>

        </div>

      </div>










      <footer>
        <div class="footer_wrap_tdn">
          <div class="footer_wrap">
            <dl>
              <dt>With Your Theater</dt>
              <dd>
                위드유어씨어터(주) 서울특별시 마포구 신수로8길 11<br />Copyright@ 이준규<br /><br />
              </dd>
            </dl>

          </div>
        </div>
      </footer>

    </body>
    </html>
