<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
';
require_once('lib/sess_start.php');
sess_start();
require_once('lib/dbconnect.php');




?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>후기공유</title>
  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->

  <style >
    th{
      border-width:2px 0 1px;
      border-color: #d19494;
      border-style : solid;
      vertical-align: middle;



    }
  </style>
  <script type="text/javascript">
  function redirect(){
    alert("로그인이 필요한 서비스에요");
    location.replace("<?php echo "/login.php" ?>")
  }

  </script>



</head>


    <body>
      <header>
        <!-- 웹용 header -->
        <div class="w_header">
          <ul class="member_menu">
            <?php if (!isset($_SESSION['is_logged'])){
              echo '<li><a href="/login.php">로그인</a></li>
              <li><a href="/signup.php">회원가입</a></li>';

            } ?>
          </ul>
          <h1><a href="/" style="">With Your Theater</a></h1>
          <nav>
            <div class="nav_wrap">
              <div class="nav_menu">
                <ul class="nav_depth1">
                  <li class="menu1"><a href="/info.php">공연 정보</a></li>
                  <li class="menu2"><a href="/board.php">후기 공유</a></li>
                  <li class="menu3"><a href="/donation.php">후원 하기</a></li>
                  <li class="menu5"><a href="http://localhost:3000">채팅 하기</a></li>

                  <?php  ?>
                </ul>

              </div>
          </nav>
        </div>
        <!-- 웹용 header -->
      </header>

      <!-- preparing for searching -->
      <?php

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
        //페이징 시작 지점. 1페이지면 0일거고, 2페이지면 10, 3페이지면 20 ...

        // 검색 기능 추가 전의 질의문
        // $sql = "SELECT * FROM board ORDER BY article_id DESC";


        $sql = "SELECT * FROM board ";
        $sql .= $searchSql;
        $sql .= " ORDER BY article_id DESC";

        $res = $conn->query($sql);
        if($res === false){
          echo mysqli_error($conn);
        }
      }

      // var_dump($res);
      $total = mysqli_num_rows($res);
      if($total==0){
        // echo '글 없음';
        $emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
      } else{
        // echo '글 있음';
      }


      $pageNum = ceil($total/$list);
      //전체 페이지 수는 토탈데이터/페이지 당 게시글수. 당연.
      $blockNum = ceil($pageNum/$block);
      //전체 블록 수는 페이지수/블록 수. 전체페이지가 10페이진데 블록이 5개로 잡으면 블록의 총 갯수는 2개가됨.
      $nowBlock = ceil($page/$block);
      //현재 페이지가 위치한 해당 블록
      //예컨대 7페이지면, 7/5 -> 1블록의 2번째에 위치하고잇음. ceil이기 때문에 올림처리. 즉 2블록임.
      //올림처리하는 이유는 0번째 블록이 시작이아니라 1번째 블록부터 계산하기 위함.

      //페이지의 최대 최소 구현
      $s_page = ($nowBlock * $block) - ($block -1);
      //현재블록 *블록개수(5) - (블록갯수-1) -> 예컨대 1*5 - 5-1 2*5 - 5-1
      //1,6,11,16 의 규칙을 보면 1*5 -4 2*5-4 ... 의 규칙의 반복
      if($s_page<=1){
        $s_page=1;
      }
      $e_page = $nowBlock*$block;
      //현재블록의 마지막 페이지는 당연히 현블록 * 블록 1*5 2*5 3*5
      if($pageNum<=$e_page){
        $e_page=$pageNum;
      }

      // echo "현재 페이지는".$page."<br/>";
      // echo "현재 블록은".$nowBlock."<br/>";
      //
      // echo "현재 블록의 시작 페이지는".$s_page."<br/>";
      // echo "현재 블록의 끝 페이지는".$e_page."<br/>";
      //
      // echo "총 페이지는".$pageNum."<br/>";
      // echo "총 블록은".$blockNum."<br/>";
      ?>
      <!-- preparing for paging done -->




      <?php
      //위에는 페이징을 위해 전체 데이터를 추리고, 작업하는 select sql문이엇고,
      //이제는 실제로 limit을 걸어서 데이터 뽑아오기
      if (mysqli_connect_error()){
        die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
      } else {
        $s_point = ($page-1) * $list;

        // 검색기능 추가 전의 질의문
        // $sql = "SELECT * FROM board ORDER BY article_id DESC LIMIT $s_point,$list";
        $sql = "SELECT * FROM board ";
        $sql .= $searchSql;
        $sql .= " ORDER BY article_id DESC LIMIT $s_point,$list";
        $res = $conn->query($sql);
        if($res === false){
          echo mysqli_error($conn);
        }
      }
      ?>

<div class="post-element">
  <div class="board-header" style ="color:#000;font-size:18px; font-weight:700px;text-align:center">
    소중한 후기를 공유해주세요

  </div>
  <article class="boardArticle">
    <!-- <h3 style="text-align:center;">후기 공유</h3> -->
    <table class="table" style="width:100%; margin:10px auto;">
      <caption class ="readHide"></caption>
      <thead>
        <tr>
          <th scope="col" class="article_no" style="width:10%">번호</th>
          <th scope="col" class="article_title" style="width:60%;padding-left:12px !important;" >제목</th>
          <th scope="col" class="article_author" style="min-width:80px;text-align:center;" >작성자</th>
          <th scope="col" class="article_likes" style="min-width:45px;text-align:center;">추천</th>
          <th scope="col" class="article_date" style="width:15%;text-align:center;">날짜</th>
          <th scope="col" class="article_hit" style="min-width:45px;text-align:center;">조회</th>
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

         <?php
         $cntsql = "SELECT * FROM comment WHERE article_id=".$row['article_id'];
         $cntres = $conn->query($cntsql);
         // var_dump($cntres);
         if($cntres === false){
           echo mysqli_error($conn);
         }
         $cnttotal = mysqli_num_rows($cntres);
          ?>

         <tr>

        <td scope="col" class="article_no" style="width:10%"><?php echo $row['article_id'] ?></th>
          <!-- 제목 클릭 시 content?article_id= 로 넘겨야한다 -->
        <!-- article_id를 알고있으니, comment테이블에서, 해당 article_id와 일치하는 comment 갯수가져오기 -->

        <td scope="col" class="article_title" style="width:60%;padding-left:12px !important;" ><a style="color:#000000; font-weight:500;" href="/content.php?article_id=<?php echo $row['article_id'] ?>"> <?php echo $row['title']?><span style="color:#d19494;font-size:12px;font-weight:700;vertical-inline:middle;"><?php if($cnttotal>0) { echo ' ['.$cnttotal.']';} ?></span> </th>
        <td scope="col" class="article_author" style="min-width:80px;text-align:center;" ><?php echo $row['author'] ?></th>
        <td scope="col" class="article_likes" style="min-width:45px;text-align:center;"><?php echo $row['likes'] ?></th>
        <td scope="col" class="article_date" style="width:15%;text-align:center;"><?php echo $row['wdate'] ?></th>
        <td scope="col" class="article_hit" style="min-width:45px;text-align:center;"><?php echo $row['hit'] ?></th>
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
    <?php if($s_page-1 ==0){ ?>
      <a class="btn btn-default" href="/board.php?page=1">처음</a>
    <a class="btn btn-default" href="/board.php?page=1<?php echo $substring ?>">이전</a>
  <?php } else {  ?>
    <a class="btn btn-default" href="/board.php?page=1">처음</a>
    <a class="btn btn-default" href="/board.php?page=<?php echo $s_page-1 ?>">이전</a>
    <?php } ?>

    <?php
    for ($p = $s_page;$p<=$e_page;$p++){
      //현재페이지부터 시작해서 해당 블록의 마지막페이지까지 페이징 버튼 생성
     ?>
     <a href="/board.php?page=<?php echo $p ?>" class = "btn btn-default"><?php echo $p ?></a>


  <?php } ?>
  <a class="btn btn-default" href="/board.php?page=<?php echo $e_page+1 ?>">다음
  </a>
  <a class="btn btn-default" href="/board.php?page=<?php echo $pageNum ?>">끝</a>


  </div>

</div>

<form class="searchbar" action="board.php" method="get">
  <div class="" style="width: 100%;padding:5px 0px;">
    <select class="form-control" name="searchColumn">
      <option <?php echo $searchColumn=='title' ? 'selected="selected"' : null ?> value="title">제목</option>
      <option <?php echo $searchColumn=='content' ? 'selected="selected"' : null ?> value="content">내용</option>
      <option <?php echo $searchColumn=='both' ? 'selected="selected"' : null ?> value="both">제목+내용</option>

    </select>
    <input class="form-control"type="text" name="searchText" value="<?php echo isset($searchText) ? $searchText : null ?>" style="width:100%">
  </div>
  <div class="" style="width:100%;padding:5px">
    <button class="btn btn-default" type="submit" style="width:100%" name="">
      <i class="fa fa-search"></i>검색
    </button>

  </div>


</form>

<div class="list_bottom_btnbox" style="text-align:center">
  <?php if(!isset($_SESSION['is_logged'])) { ?>
    <button type="" class="btn btn-default"  onclick="redirect()">글쓰기</button>
  <?php } else{ ?>
<button type="" class="btn btn-default" onclick="location.href='create.php'">글쓰기</button>
  <?php } ?>


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
