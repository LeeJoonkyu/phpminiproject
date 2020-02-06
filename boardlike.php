<?php
require_once('lib/sess_start.php');
sess_start();
require_once('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else {
  $article_id = $_POST['article_id'];
  //누구에게 눌럿는지df
  $author = $_POST['author'];
  //누가 눌럿는지
  $nickname = $_POST['nickname'];
  $isclicked = $_POST['isclicked'];

//여기가 안걸린다.
//false 불리언으로 넘어오는 게 아니라, 스트링으로 넘어온다
  if (strcmp($isclicked,"false")==0){

    // 게시물 좋아요 올리기
    $sql = "UPDATE board SET likes =likes + 1 WHERE article_id='{$article_id}'" ;
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }

    $sql = "UPDATE liketo SET likecheck = likecheck+1 WHERE article_id='{$article_id}' AND nickname='{$nickname}'";
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }

    $sql = "UPDATE userlist SET likes_collected = likes_collected+1 WHERE nickname='{$author}'";
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }
    echo json_encode(array("result"=>0));

  } else {

    $sql = "UPDATE board SET likes =likes - 1 WHERE article_id='{$article_id}'" ;
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }

    $sql = "UPDATE liketo SET likecheck = 0 WHERE article_id='{$article_id}' AND nickname='{$nickname}'";
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }

    $sql = "UPDATE userlist SET likes_collected = likes_collected - 1 WHERE nickname='{$author}'";
    $res = $conn ->query($sql);
    if($res === false){
      echo mysqli_error($conn);
    }
    echo json_encode(array("result"=>1));


  }



}

?>
