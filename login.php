<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">
';
require_once('lib/sess_start.php');
sess_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>로그인</title>
  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css"> -->

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


      <div class="container" style="margin:0 auto; text-align:center">
        <h2 class="title_center" style="margin-top:10px">반가워요</h2>
        <form action="login_process.php" method="post" style="margin-top:10px;">
          <p><input type="text" placeholder="아이디(이메일 형식)" name="email" value=""style="margin-top:10px;"></p>
          <p><input type="password" placeholder="비밀번호" name="password" value=""style="margin-top:10px;"></p>
          <p><input class= "btn btn-default"type="submit" name="" value="로그인"style="margin-top:10px; color:#fff"></p>
        </form>

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
