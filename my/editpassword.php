<?php
require_once('../lib/sess_start.php');
sess_start();
require_once('../lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $new_pass=$_POST['new-pass'];
  $new_pass = md5($new_pass);

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

  $sql = "UPDATE userlist SET password='{$new_pass}' WHERE nickname='{$_SESSION['nickname']}'";
  $res = mysqli_query($conn,$sql);
  if ($res===false){
    echo mysqli_error($conn);
  } else { ?>
    <script type="text/javascript">
      alert('비밀번호가 성공적으로 변경되었습니다');
      location.replace("<?=
      '/'
      ?>");
    </script>
    <?php


  }

}

?>
