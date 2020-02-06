<?php
require_once('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $uid = $_POST['email'];
  $password = $_POST['password'];

  //아이디 존재확인
  $sql = "SELECT * FROM userlist WHERE uid = '$uid'";
  $res = $conn->query($sql);
  $row = mysqli_fetch_array($res);

  //아이디 존재확인
  if($res->num_rows >= 1){
    $password = md5($password);
    //비밀번호 확인
    // print_r($row);
    // echo '<br>'.$row['password'].'<br>'.$password;
    // echo strcmp($row['password'], $password);

    if (strcmp($row['password'], $password) == 0 ){
      //로그인 성공
      session_start();
      $_SESSION['uid'] = $_POST['email'];
      // $sql = "SELECT nickname FROM userlist WHERE uid = '$uid'";
      // $res = $conn->query($sql);
      // $_SESSION['nickname'] = mysqli_fetch_array($res)['nickname'];
      $_SESSION['nickname'] = $row['nickname'];
      // $_SESSION['nickname'] = mysqli_fetch_array($res)[0];
      $_SESSION['is_logged'] = true;

      ?>
      <script type="text/javascript">
        // alert('로그인 성공');
        location.href='/';
      </script>

      <?php


    } else{
      ?>
      <script type="text/javascript">
        alert('비밀번호를 다시 확인해주세요');
        location.href='/login.php';
      </script>

      <?php

    }
  }else{
    ?>
    <script type="text/javascript">
      alert('존재하지 않는 아이디입니다');
      location.href='/login.php';
    </script>

    <?php
  }

}

?>
