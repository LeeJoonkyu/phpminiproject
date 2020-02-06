<?php
require('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{

  $nickname = $_GET['user_nickname'];

  $sql = "SELECT * FROM userlist WHERE nickname = '{$nickname}'";
  $res = $conn->query($sql);

  if($res->num_rows >= 1){
    echo json_encode(array("result"=>1));
  } else {
    echo json_encode(array("result"=>0));
  }



}


?>
