<?php
echo '<link rel="stylesheet" type="text/css" href="/css/main.css">

<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

<link href="../summernote/summernote.css" rel="stylesheet">
<script src="../summernote/summernote.js"></script>';
require_once('lib/sess_start.php');
sess_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>후기 작성</title>
  <!-- <link rel="stylesheet" type="text/css" href="/css/main.css"> -->

  <!-- include libraries(jQuery, bootstrap) -->
  <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet"> -->
  <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> -->
  <!-- <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> -->

  <!-- include summernote css/js -->
  <!-- <link href="../summernote/summernote.css" rel="stylesheet"> -->
  <!-- <script src="../summernote/summernote.js"></script> -->
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



      <script type="text/javascript" src="../se2/demo/js/service/HuskyEZCreator.js?" charset="utf-8"></script>

<?php
// print_r($_POST['old_content']);
// var_dump($_POST['old_content']);
 ?>
      <main class="container" style="margin:0 auto">
        <form action="update_process.php" method="post">
              <input type="hidden" name="article_id" value="<?php echo $_GET['article_id'] ?>">
              <p style="text-align:center">
                <input type="text" style="width:70%; margin-top:20px;margin-bottom:10px" name="title" placeholder="제목을 입력하세요" value="<?php echo $_POST['old_title'] ?>">
              </p>
              <div style="text-align:center; padding-left:15% ;padding-right:15%">
                  <textarea id="summernote"name="description"><?php echo $_POST['old_content'] ?></textarea>
              </div>

              <p style="text-align:center">
                <input type="submit" style="width:70%;color:#d19494;margin:0 20px;" name="" value="수정하기">
              </p>
            </form>

      </main>








<script type="text/javascript">
$(document).ready(function() {
$('#summernote').summernote({
  height:200,
  width:$('main.container').width()*0.7,
  disableResizeEditor:true,

});
});
</script>




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
      <!-- include js -->

    </body>
    </html>
