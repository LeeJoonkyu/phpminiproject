<?php
require_once('lib/sess_start.php');
sess_start();
require_once('lib/dbconnect.php');

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $article_id=$_POST['article_id'];
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $last_modified = date('Y-m-d H:i:s');
  $ipaddr = $_SERVER['REMOTE_ADDR'];

  $sql = "UPDATE board SET title='{$title}',content='{$desc}',last_modified='{$last_modified}',ip_addr='{$ipaddr}' WHERE article_id=$article_id";
  $res = mysqli_query($conn,$sql);

  if($res === false){
    echo mysqli_error($conn);
  } else { ?>
    <script type="text/javascript">
      alert("<?php echo '글이 수정되었습니다' ?>");
      location.replace("<?php echo '/content.php?article_id='.$article_id ?>");
    </script>
    <?php
  }

}



// rename('article_data/'.$_POST['old_title'], 'article_data/'.$_POST['title']);
// file_put_contents('article_data/'.$_POST['title'], $_POST['description']);


?>
