<?php
require_once('../lib/sess_start.php');
sess_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>With Your Theater</title>
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  <script type="text/javascript">
  function Go(strGoodsCode, bBookable, strGoUrl) {
  if (strGoUrl.length > 1) {
      window.location.href = strGoUrl;
  }
  else {
      if ("Y" == bBookable) {
          window.location.href = "http://ticket.interpark.com/Tiki/Main/TiKiGoodsinfo.asp?GoodsCode=" + strGoodsCode;
      }
      else {
          window.location.href = "http://ticket.interpark.com/Tiki/Main/TiKiGoodsinfoViewer.asp?GoodsCode=" + strGoodsCode;
      }
  }
}
  </script>


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

<div class="" style="margin:10px auto; text-align:center">
  <h3>성공적으로 후원하였습니다.<br> 감사합니다.</h3>
  <?php
  setcookie("kakao_tid","",time()-60*5,'/');
  setcookie("kakao_order_id","",time()-60*5,'/');
  setcookie("kakao_donate_to","",time()-60*5,'/');

   ?>

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
