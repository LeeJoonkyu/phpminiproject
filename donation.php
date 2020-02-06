<?php
echo '<link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
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

  <!-- <link rel="stylesheet" href="/bootstrap-4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/css/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" /> -->


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
          <?php
          if (isset($_COOKIE['kakao_tid'])){
            echo $_COOKIE['kakao_tid'];
            setcookie("kakao_tid","",time()-3600,'/');
          }
          if (isset($_COOKIE['kakao_order_id'])){
            echo $_COOKIE['kakao_order_id'];
            setcookie("kakao_order_id","",time()-3600,'/');
          }
          if (isset($_COOKIE['kakao_donate_to'])){
            echo $_COOKIE['kakao_donate_to'];
            setcookie("kakao_donate_to","",time()-3600,'/');
          }
          // echo $_COOKIE['kakao_tid'];
          // echo $_COOKIE['kakao_order_id'];
          // echo $_COOKIE['kakao_donate_to'];


          // //결제고유번호
           ?>
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

      <div class="post-element">
        <div class="board-header" style ="color:#000;font-size:18px; font-weight:700px;text-align:center">
          평이 좋은 후기 작성자들을 후원해주세요

        </div>
        <article class="boardArticle">

        <ul class="list-slide" style="">
          <?php
          if (mysqli_connect_error()){
            die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
          } else {
            $sql = "SELECT * FROM board ORDER BY likes DESC";

            $res = $conn->query($sql);
            if($res === false){
              echo mysqli_error($conn);
            }
          }
          while ($row = mysqli_fetch_assoc($res)){
            if($row['hit']!=0) {
           ?>
          <li class="lidon">
            <a class="link_slide" href="/content.php?article_id=<?php echo $row['article_id'] ?>">
            <div class="donation_con">
              <p class="donation_title"><?php echo $row['title'] ?></p>

              <span class="don">
                <i class="far fa-clock"><?php echo $row['wdate'] ?></i>
              </span>
              <br>
              <span class="don"><i class="fa fa-user"><?php echo $row['hit'] ?></i> </span>
              <span class="don"><i class="far fa-thumbs-up"><?php echo $row['likes'] ?></i></span>
              <br>
              <span class="donation_author">by <?php echo $row['author'] ?></span>

              <p class = "donation_content"><?php echo $row['content'] ?></p>

            </div>
            </a>
            <a href="#" class="donateto"><i class="fas fa-comments-dollar fa-lg">이 후기의 작성자를 후원하시겠어요?</i> </a>
      <!--
        결제정보셋팅
      -->

      <?php if (!isset($_SESSION['uid'])){ ?>

        <input type="submit"class="btn btn-default" value="카카오페이로 1,000원 후원" onclick=redirect();>

        <?php


      } else{ ?>
        <form method="post" action="CallPaymentKakaoPay.php">
        <input type="hidden" name="partner_order_id" value="<?=$row['article_id']?>">  <!-- 주문번호 -->
        <input type="hidden" name="partner_user_id" value="<?=$_SESSION['uid']?>">    <!-- 사이트 주문유저id -->
        <input type="hidden" name="item_name" value="<?=$row['author'].'님의 '.$row['title'].'게시글 후원'?>">                <!-- 상품명 -->
        <input type="hidden" name="quantity" value="<?=1?>">                  <!-- 수량 -->
        <input type="hidden" name="total_amount" value="<?=1000?>">          <!-- 상품총액 -->
        <input type="hidden" name="tax_free_amount" value="<?=0?>">    <!-- 비과세금액 -->
        <input type="hidden" name="kakao_donate_to" value="<?php echo $row['author'] ?>">

        <input type="submit" class="btn btn-default" value="카카오페이로 1,000원 후원">
  </form>

      <?php } ?>

      <?php if (!isset($_SESSION['uid'])){ ?>

        <input type="submit"class="btn btn-default" value="카카오페이로 5,000원 후원" onclick=redirect();>

        <?php


      } else{ ?>
        <form method="post" action="CallPaymentKakaoPay.php">
        <input type="hidden" name="partner_order_id" value="<?=$row['article_id']?>">  <!-- 주문번호 -->
        <input type="hidden" name="partner_user_id" value="<?=$_SESSION['uid']?>">    <!-- 사이트 주문유저id -->
        <input type="hidden" name="item_name" value="<?=$row['author'].'님의 '.$row['title'].'게시글 후원'?>">                <!-- 상품명 -->
        <input type="hidden" name="quantity" value="<?=1?>">                  <!-- 수량 -->
        <input type="hidden" name="total_amount" value="<?=5000?>">          <!-- 상품총액 -->
        <input type="hidden" name="tax_free_amount" value="<?=0?>">    <!-- 비과세금액 -->
        <input type="hidden" name="kakao_donate_to" value="<?php echo $row['author'] ?>">

        <input type="submit"class="btn btn-default" value="카카오페이로 5,000원 후원">
      </form>

      <?php } ?>
      <?php if (!isset($_SESSION['uid'])){ ?>

        <input type="submit" class="btn btn-default"value="카카오페이로 10,000원 후원" onclick=redirect();>

        <?php


      } else{ ?>
        <form method="post" action="CallPaymentKakaoPay.php">
        <input type="hidden" name="partner_order_id" value="<?=$row['article_id']?>">  <!-- 주문번호 -->
        <input type="hidden" name="partner_user_id" value="<?=$_SESSION['uid']?>">    <!-- 사이트 주문유저id -->
        <input type="hidden" name="item_name" value="<?=$row['author'].'님의 '.$row['title'].'게시글 후원'?>">                <!-- 상품명 -->
        <input type="hidden" name="quantity" value="<?=1?>">                  <!-- 수량 -->
        <input type="hidden" name="total_amount" value="<?=10000?>">          <!-- 상품총액 -->
        <input type="hidden" name="tax_free_amount" value="<?=0?>">    <!-- 비과세금액 -->
        <input type="hidden" name="kakao_donate_to" value="<?php echo $row['author'] ?>">

        <input type="submit" class="btn btn-default"value="카카오페이로 10,000원 후원">
      </form>

      <?php } ?>





          </li>
        <?php }} ?>

        </ul>


        </article>


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
