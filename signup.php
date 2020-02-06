<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
';
require_once('lib/sess_start.php');
sess_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>회원가입</title>
  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

</head>
<body>


  <header>
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
        <h2 class="title_center" style="margin-top:10px">회원가입</h2>
          <!-- E-mail Start -->
          <form class="" action="signup_process.php" method="post" onsubmit="return checkSubmit();">


          <!-- <p id="error_email_format" class="error_message " style="display: none">이메일 형식이 올바르지 않습니다.</p>
          <p id="error_email_con" class="error_message " style="display: none">앗! '.con'이라니. 이메일 주소를 확인해주세요.</p> -->

          <div class="" style="display:inline">
            <input id="email" style="margin-top:10px;"name="email" type="email" placeholder="이메일 (로그인 아이디로 사용)" maxlength="100" class="input_default" value="" required>
          </div>
            <input class="checkid btn btn-default" onclick="" type="button" name="" value="아이디 중복검사" style="margin-left:6px;margin-top:10px;font-size:12px; color:#fff; display:inline">
            <div class="check_id_msg" style="">

            </div>



          <!-- E-mail End -->
          <!-- User Name Start -->
          <!-- <p id="error_name_len" class="error_message " style="display: none">2글자 이상 입력해주세요.</p> -->
          <div class="">
            <input id="nickname" style="margin-top:10px;"name="nickname" type="text" placeholder="닉네임" maxlength="20" class="input_default" value="" required>
            <span class="tooltiptext">특수문자 불가능 2-10자</span>
          </div>
          <div class="check_nickname_msg" style="">

          </div>
          <!-- User Name End -->
          <!-- Password start -->
          <!-- <p id="error_password_len" class="error_message " style="display: none">비밀번호를 6자 이상 입력해주세요.</p> -->
          <div class="">
            <input id="password" style="margin-top:10px;"name="password" type="password" placeholder="비밀번호" maxlength="30" class="input_default" value="" required>
            <span class="tooltiptext" style="margin-left:2px;">영문/숫자/특문 8-16자</span>
          </div>
          <div class="check_pw_msg" style="">

          </div>
          <div class="">
            <input id="passwordchk" style="margin-top:10px;"name="passwordchk" type="password" placeholder="비밀번호 확인" maxlength="30" class="input_default" value="" required>
            <span class="tooltiptext" style="margin-left:7px;">한번 더 확인해주세요</span>
          </div>
          <div class="check_pw2_msg" style=""></div>
          <div class="formCheck">
            <input type="hidden" name="idCheck" class="idCheck" />
            <input type="hidden" name="nicknameCheck" class="nicknameCheck" />
            <input type="hidden" name="pwCheck" class="pwCheck" />
            <input type="hidden" name="pwCheck2" class="pwCheck2" />
        </div>


          <input class="btn btn-default" type="submit" name="" value="회원가입"style="margin-top:10px; color:#fff">





        </form>










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
      <script type="text/javascript">

      function checkSubmit(){
      var idCheck = $('.idCheck');
      var nicknameCheck = $('.nicknameCheck');

      var pwCheck = $('.pwCheck');
      var pwCheck2 = $('.pwCheck2');
      var res = false;

      if(idCheck.val() == '1'){
          res = true;
      }else{
          res = false;
      }

      if(nicknameCheck.val() == '1'){
          res = true;
      }else{
          res = false;
      }
      if(pwCheck.val() == '1'){
          res = true;
      }else{
          res = false;
      }
      if(pwCheck2.val() == '1'){
          res = true;
      }else{
          res = false;
      }

      if(res == false){
          alert('회원가입 폼을 정확히 채워 주세요.');
      }
      return res;
      }

      </script>



    </body>
    </html>
