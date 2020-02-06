<?php
require_once('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $article_id = $_POST['article_id'];

  $sql = "DELETE FROM board WHERE article_id=$article_id";
  $res = mysqli_query($conn,$sql);

  if($res === false){
    echo mysqli_error($conn);
  } else { ?>
    <script type="text/javascript">
      alert("<?php echo '글이 삭제되었습니다' ?>");
      location.replace("<?php echo '/board.php'?>");
    </script>
    <?php
  }

}


unlink('article_data/'.$_POST['article_id']);
// header('Location: /board.php');
 ?>
