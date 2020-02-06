<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">';
require_once('lib/sess_start.php');
sess_start();
require_once('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else {
  // 쿠키로 조회수 올리 해당 게시물에 해당하는 쿠키가 존재하지 않을 시 셋쿠키해준다.
  $article_id = $_GET['article_id'];
  if(!empty($article_id) && empty($_COOKIE['content?article_id_'.$article_id])) {
    //게시물 번호가 존재하고, 게시물에 해당하는 쿠키가 존재하지 않는다면,
    //조회수 증가시킨 후 해당 게시물 정보에 대한 쿠키를 셋팅해준다.
    $sql = "UPDATE board SET hit =hit + 1 WHERE article_id='{$article_id}'" ;
    $res = $conn ->query($sql);
    if($res === false) {
      ?>
      <script>
        alert('오류가 발생했습니다.');
        history.back();
      </script>
      <?php
    } else {
      setcookie('content?article_id_'.$article_id, TRUE, time() + (60 * 60 * 24), '/');
    }
  }
}


?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>With Your Theater</title>
  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="/css/main.css"> -->
  <!-- to use fa fa -->
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                  <?php  ?>
                </ul>

              </div>
          </nav>
        </div>
        <!-- 웹용 header -->
      </header>



      <?php
      if (mysqli_connect_error()){
        die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
      } else {
        // url에 달려있는 게시물 아이디를 가져온다
        $article_id = $_GET['article_id'];
        $sql = "SELECT title,content,author,likes,wdate,hit FROM board WHERE article_id = $article_id";
        $res = $conn->query($sql);
        if($res === false){
          echo mysqli_error($conn);
        }
        $total = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);
      }




      ?>

      <div class="post-element">
        <div class="board-header">
          <div class="board-title">
            <?php echo $row['title'] ?>
          </div>
          <br>
          <div class="board-author">
            <?php echo 'by '.$row['author'] ?>
          </div>
          <div class="bar">
            |
          </div>
          <div class="board-hit">
            <?php echo '조회 '.$row['hit'] ?>
          </div>
          <div class="bar">
            |
          </div>
          <div class="board-date">
            <?php echo $row['wdate'] ?>

          </div>

        </div>
        <!-- 게시물 헤더 끝 -->
        <div class="board-content" style="height:auto; max-width:100%">
          <?php echo $row['content'] ?>


        </div>



      </div>

      <div class="board-thumbs">




        <div class="likes-box">
          <!-- fetch()함수는 서버에 '' 파일을 요청하고, 그 응답에서 받은 결과값을 파싱하여, alert(text)를 수행하게된다 -->


          <?php
            $nck = $_SESSION['nickname'];
            // echo $article_id;
            //이 게시물을 조회하는 사람에 한하는 liketo 데이터를 불러온다
            //근데 문제는 해당 조건에 맞지않으면 sql문 오류가 날것.
            $sqllike = "SELECT * FROM liketo WHERE article_id='{$article_id}' AND nickname='{$_SESSION['nickname']}'";
            $reslike = $conn->query($sqllike);
            if($reslike === false){
              echo mysqli_error($conn);
            }

            $likenototal = mysqli_num_rows($reslike);
            if ($likenototal ==0){
              // echo 'hi';
              $sql = "INSERT INTO liketo (article_id,nickname) VALUES ('{$article_id}','{$_SESSION['nickname']}')";
              $res = $conn ->query($sql);
              if($res === false){
                echo mysqli_error($conn);
              }
            } else {
              // echo $likenototal;
            }

            $rowlike = mysqli_fetch_assoc($reslike); ?>
            <!-- rowlike에서 likecheck를 넘겨야하기때문에 스크립트태그와 붙여쓰지 않고 여기 위에 쓴다 -->
            <!-- 게시물정보, 게시물의저자정보(피 좋아요대상), 좋아요 누르는사람(세션) -->
            <div class="board-like" data-article_id=<?php echo $article_id ?> data-author=<?php echo $row['author'] ?> data-nickname = <?php echo $_SESSION['nickname'] ?> >
              <i class="fa fa-thumbs-o-up"></i>

            </div>
            <span class="badge"><?php echo $row['likes'] ?></span>



             <?php
            //만약 이글의 조회자가 이미 게시물에 좋아요를 눌렀다면
            if ($rowlike['likecheck'] != 0){ ?>
                <script type="text/javascript">
                  if(!$(".board-like").hasClass("focus")){
                    $(".board-like").addClass("focus");
                  }
                </script>

              <?php } ?>




        </div>


      </div>


      <?php
      $sql = "SELECT * FROM comment WHERE article_id=$article_id ORDER BY comment_id";
      $res = $conn->query($sql);
      if($res === false){
        echo mysqli_error($conn);
      }
      $total = mysqli_num_rows($res);
      ?>

      <div style="margin:0 auto ;width:60%">
        <div class="comment-number" style="color:#d19494">
          댓글 <?php echo $total ?> 개
        </div>
        <div class="bar">
          |
        </div>
        <div class="board-hit">
          <?php echo '조회 '.$row['hit'] ?>
        </div>

      </div>
      <div class="board-comments">
        <div class="post-element comments_area">
          <div id = "comments_area_html">
            <!--  -->
          </div>
          <hr>

          <?php
          while ($row=mysqli_fetch_assoc($res)){
            ?>
            <div class="comment-header">
              <div class="comment-user">
                <?php echo $row['author'] ?>
              </div>
              <div class="comment-date">
                <?php echo $row['wdate'] ?>

              </div>
              <div class="comment-remove">
                  <div class="remove2" style="cursor:pointer; display:block">
                    <button class="btn delete_comments" name="button"></button>
                  </div>
              </div>
            </div>
            <div class="mverdana comment-content">
              <?php echo $row['content'] ?>
            </div>
          <?php echo '<hr>'; } ?>










          <form action="comment_wip.php" name="emoticon" method="post">
            <input type="hidden" name="article_id" value="<?=$_GET['article_id']?>">
            <div id="comments_0">
              <button class="btn btn-red submit btn-default" style="color: #fff;height:64px;width:13.5%;float:right;margin-top:0px;padding:0px 0px;font-size:10pt;" value="0">입력</button>
            </div>
              <textarea name="comment_content" class="form-control" id="comments_text_0" style="height: 78px; width: 85%; display: inline-block; padding: 6px !important; resize: vertical; overflow-y: hidden;" onfocus="this.placeholder='따뜻한 댓글', document.getElementById('content_bottom_ad').style.display = 'none';" onblur="this.placeholder=''" placeholder=""></textarea>
          </form>


        </div>

      </div>
      <div class="etc_area">
        <?php
        $article_id = $_GET['article_id'];
        $sql = "SELECT title,content,author,likes,wdate,hit FROM board WHERE article_id = $article_id";
        $res = $conn->query($sql);
        if($res === false){
          echo mysqli_error($conn);
        }
        $total = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);
        ?>
        <?php if(isset($_SESSION['nickname'])) { //세션이 존재하고
          if (strcmp($_SESSION['nickname'],$row['author'])==0){ ?>
            <!-- 세션 닉네임과 작성자가 일치한다면 -->
          <form action="update.php?article_id=<?php echo $_GET['article_id'] ?>" method="post">
            <input type="hidden" name="old_title" value="<?php echo $row['title'] ?>">
            <?php
            // echo $row['content']
            ?>
            <?php
            // var_dump($row['content']);
            ?>
            <!-- 아래 히든태그가 풀렷던 이유. 밸류값을 "" 로 묶게 되면 로우컨텐트의 값인 "<p>로 시작하는 부분때문에 문자열이 중간에 끊기게 된다!!" 그래서 ''로 밸류를 묶어줘서 해결! -->
            <input type="hidden" name="old_content" value='<?php echo $row['content'] ?>'>
            <input type="submit" name="" value="후기 수정" class="btn btn-default referer">


          </form>
          <form action="delete_process.php" method="post">
            <input type="hidden" name="article_id" class="btn-default referer" value="<?php echo $_GET['article_id'] ?>">
            <!-- 반드시 submit type이어야 form태그가 올바르게 넘어간다 -->
            <input type="submit" name="" value="후기 삭제" class="btn btn-default referer">
          </form>
          <a class="btn btn-default referer" href="/board.php">목록 보기</a>

        <?php } else{ ?>
          <!-- 일치하지 않을 시 목록보기 -->
          <a class="btn btn-default referer" href="/board.php">목록 보기</a>
        <?php }} else { ?>
          <!-- 비회원일 시 목록보기 -->
          <a class="btn btn-default referer" href="/board.php">목록 보기</a>
        <?php } ?>




      </div>




      <?php function print_title(){
      if (isset($_GET['article_id'])){
        echo $_GET['article_id'];

      } else {
        echo '반가워요';
      }
      }
      function print_list(){
      $list = scandir("./article_data");
      // var_dump(count($list));
      for ($i=0;$i<count($list);$i++){
        if ($list[$i]!='.' && $list[$i]!='..'){
          echo "<li><a href =\"board.php?article_id=$list[$i]\">$list[$i]</a></li>\n";
        }
      }
      }
      function print_desc(){
      if(isset($_GET['article_id'])){
        // echo file_get_contents("./article_data/".$_GET['article_id']);
      } else {
        echo '여러분의 관람 후기를 나눠주세요';
      }
      }

      ?>



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

      <script src="statics/js/view.js"></script>

    </body>

    </html>
