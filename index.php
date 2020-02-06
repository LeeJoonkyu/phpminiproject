<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">';
require_once('lib/sess_start.php');
sess_start();
require_once('lib/simple_html_dom.php');
?>
<!DOCTYPE html>
<html lang="ko" dir="">
<head>
  <meta charset="utf-8">
  <title>With Your Theater</title>
  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css"> -->
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

function popup() {
    winopen=window.open('popup.php','winopen','width=270 ,height=730, left=10, top=10,  넓이,scrollbars=yes');
 }

  </script>


</head>

    <body>
      <?php
      if(!isset($_COOKIE['eventpop']))  {
        ?>
        <script type="text/javascript">
          popup();
        </script>
        <?php
         }

       ?>

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
                  <li class="menu5"><a href="http://localhost:3000">채팅 하기</a></li>
                  <!-- <li class="menu4"><a href="/dummy_board.php">더미 만들기</a></li> -->
                  <?php  ?>
                </ul>

              </div>
          </nav>
        </div>
        <!-- 웹용 header -->
      </header>
      <?php


      $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
      $context = stream_context_create($opts);
      $html = file_get_html('http://ticket.interpark.com/contents/Ranking/RankList?pKind=01009&pCate=RK411&pType=D',false,$context);

      ?>

      <div class="showlist">
        <?php
        foreach ($html->find("a.prdImg") as $element) {
          echo $element;
        } ?>
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
