<?php
require('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $uid = $_GET['user_id'];

  //아이디 중복검사.
  $sql = "SELECT * FROM userlist WHERE uid = '{$uid}'";
  $res = $conn->query($sql);

  if($res->num_rows >= 1){
    //중복이면 1 아니면0  리턴
    echo json_encode(array("result"=>1));
  } else {
    echo json_encode(array("result"=>0));
  }


}


?>
