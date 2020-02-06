<?php
function sess_start(){
  // $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  session_start();
  if (!isset($_SESSION['uid'])){
    echo '<div class="hello">반가워요</div>';
    echo '<div class="hello"><a href=\'/login.php\'>로그인</a></div>';
    echo '<div class="hello"><a href=\'/signup.php\'>회원가입</a></div>';

  }
  // else if (strpos($url,'mypage.php')!==false){
    // $uid = $_SESSION['uid'];
    // $nickname = $_SESSION['nickname'];
    // $is_logged = $_SESSION['is_logged'];
  // } 
  else {
      $uid = $_SESSION['uid'];
      $nickname = $_SESSION['nickname'];
      $is_logged = $_SESSION['is_logged'];

      echo '<div class="hello">'.$nickname.'님, 반가워요</div>';
      echo '<div class="hello"><a href=\'/logout.php\'>로그아웃</a></div>';
      echo '<div class="hello"><a href=\'/mypage.php\'>마이페이지</a></div>';
    }
}
 ?>
