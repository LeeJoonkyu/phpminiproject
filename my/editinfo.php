<?php
require_once('../lib/sess_start.php');
sess_start();
require_once('../lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $nickname = $_POST['nickname'];

/*
  $sql = "UPDATE userlist SET nickname='{$nickname}' WHERE nickname='{$_SESSION['nickname']}'";
  $res = mysqli_query($conn,$sql);
  if($res === false){
    // echo mysqli_error($conn);
    echo json_encode(array("result"=>0));
  } else {
    $_SESSION['nickname'] = $nickname;
    echo json_encode(array("result"=>1));
}
*/

  $sql = "SELECT * FROM userlist WHERE nickname = '{$nickname}'";
  $res = $conn->query($sql);
  if($res->num_rows >= 1){
    echo json_encode(array("result"=>0));
  } else {
    $sql = "UPDATE userlist SET nickname='{$nickname}' WHERE nickname='{$_SESSION['nickname']}'";
    $res = mysqli_query($conn,$sql);
    if($res === false){
      // echo mysqli_error($conn);
      echo json_encode(array("result"=>2));

    } else {
      echo json_encode(array("result"=>1));
      $_SESSION['nickname'] = $nickname;
  }

  }


}
?>
