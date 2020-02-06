<?php
require_once('lib/sess_start.php');
sess_start();
// db conn
require_once('lib/dbconnect.php');
// db conn

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $article_id = $_POST['article_id'];
  $uid = $_SESSION['uid'];
  $author = $_SESSION['nickname'];
  $content = $_POST['comment_content'];

  $date = date('Y-m-d H:i:s');
  $ipaddr = $_SERVER['REMOTE_ADDR'];

  $sql = "INSERT INTO comment (article_id,uid,author,content,wdate,ip_addr) VALUES('{$article_id}','{$uid}','{$author}','{$content}','{$date}','{$ipaddr}')";
  $res = mysqli_query($conn,$sql);

  if($res === false){
    echo mysqli_error($conn);
  } else { ?>
    <script type="text/javascript">
      alert("<?php echo '댓글이 등록되었습니다' ?>");
      // 댓글 등록 후 해당 글로 이동
      location.replace("<?php echo '/content.php?article_id='.$article_id ?>");

    </script>
    <?php
  }

}




?>
