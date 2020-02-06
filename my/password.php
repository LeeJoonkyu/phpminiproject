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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



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


      <div class='post-element useredit'>
        <form class="" action="editpassword.php" method="post" onsubmit="return checkSubmit();">

                <div><i class='fa fa-user'>&nbsp;비밀번호 변경</i></div>
                <span>nickname :</span><input type='text' class='form-control nickname' value='<?php echo $_SESSION['nickname'] ?>' readonly=true>
                <!-- <span>password :</span><input type='password' class='form-control password' placeholder='password'> -->
                <span>new password :</span><input type='password' name='new-pass' class='form-control new-password' placeholder='new password'>
                <div class="check_pw_msg" style=""></div>
                <span>repeat new password :</span><input type='password' class='form-control re-new-password' placeholder='repeat new password'>
                <div class="check_pw2_msg" style=""></div>


                  <div class="formCheck">
                    <input type="hidden" name="pwCheck" class="pwCheck" />
                    <input type="hidden" name="pwCheck2" class="pwCheck2" />
                </div>

                <button class='btn btn-default submit'>수정</button>
                <div class='insert' style='margin-top:10px;'></div>

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

      <script type="text/javascript">

      var regexPw = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,16}$/;
      $(".new-password").blur(function(){

        var pwCheck = $('.pwCheck');

        var password = $(".new-password").val();
        if (password==""){
          $(".new-password").focus();
          $(".check_pw_msg").text("비밀번호를 입력하세요").css("color","red");
          return;
        }
        if (!regexPw.test(password)){
          $(".check_pw_msg").text("비밀번호는 영문,특문,숫자를 포함한 8-16자여야 합니다").css("color","red");
          pwCheck.val('0');
          console.log(pwCheck.val());


        } else{
          $(".check_pw_msg").text("사용 가능한 비밀번호 입니다").css("color","green");
          pwCheck.val('1');
          console.log(pwCheck.val());


        }


      })
      $(".re-new-password").blur(function(){

        var pwCheck2 = $('.pwCheck2');

        var password = $(".new-password").val();
        var passwordchk = $(".re-new-password").val();
        if (passwordchk==""){
          $(".re-new-password").focus();
          $(".check_pw2_msg").text("확인용 비밀번호를 입력하세요").css("color","red");
          return;
        }

          if (password != passwordchk){
            $(".check_pw2_msg").text("비밀번호가 일치하지 않습니다").css("color","red");
          } else {
            $(".check_pw2_msg").text("비밀번호가 일치합니다").css("color","green");
            pwCheck2.val('1');

          }




      })


      </script>
      <script type="text/javascript">
      function checkSubmit(){

      var pwCheck = $('.pwCheck');
      var pwCheck2 = $('.pwCheck2');
      var res = false;
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
          alert('비밀번호 폼을 정확히 채워 주세요.');
      }
      return res;
      }


      </script>





    </body>
    </html>
