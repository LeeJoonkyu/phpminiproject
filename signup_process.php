<?php
require('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $uid = $_POST['email'];
  $nickname = $_POST['nickname'];
  $password = $_POST['password'];
  $passwordchk = $_POST['passwordchk'];
  $date = date('Y-m-d H:i:s');


  //아이디 중복검사.
  $sql = "SELECT * FROM userlist WHERE uid = '{$uid}'";
  $res = $conn->query($sql);

  if($res->num_rows >= 1){
      echo '이미 존재하는 아이디가 있습니다.';
      exit;
  }
  $nickname = $_POST['nickname'];

  $sql = "SELECT * FROM userlist WHERE nickname = '{$nickname}'";
  $res = $conn->query($sql);

  if($res->num_rows >= 1){
      echo '이미 존재하는 닉네임이 있습니다.';
      exit;
  }

  //비밀번호 일치하는지 확인
  if($password != $passwordchk){
      echo '비밀번호가 일치하지 않습니다.';
      exit;
  }else{
      //비밀번호를 암호화 처리.
      $password = md5($password);
  }

  //이제부터 넣기 시작
  $sql = "INSERT INTO userlist (uid,nickname,password,signup_date) VALUES ('{$uid}','{$nickname}','{$password}','{$date}')";

  $res = $conn->query($sql);
  if ( false===$res ) {
    printf("error: %s\n", mysqli_error($conn));
  }
  else {
    echo '회원가입 성공';
  }



}




file_put_contents('users/'.$_POST['email'], $_POST['password'].' '.$_POST['nickname']);
header('Location: /');
?>
