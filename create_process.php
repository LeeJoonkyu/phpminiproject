<?php
require_once('lib/sess_start.php');
sess_start();

// db conn
$host = "localhost";
$dbUsername = "root";
$dbPassword = "asdf2262";
$dbname = "withyourtheater";
//create connection
$conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{
  $uid = $_SESSION['uid'];
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $author = $_SESSION['nickname'];
  $likes = 0;
  $date = date('Y-m-d H:i:s');
  $hit = 0;
  $ipaddr = $_SERVER['REMOTE_ADDR'];

  $sql = "INSERT INTO board (uid,title,content,author,wdate,ip_addr) VALUES('{$uid}','{$title}','{$desc}','{$author}','{$date}','{$ipaddr}')";
  $res = mysqli_query($conn,$sql);

  if($res === false){
    echo mysqli_error($conn);
  } else { ?>
    <script type="text/javascript">
      alert("<?php echo '글이 등록되었습니다' ?>");
      location.replace("<?php echo '/board.php'?>");
    </script>
    <?php
  }

}




file_put_contents('article_data/'.$_POST['title'], $_POST['description']);
// header('Location: /board.php?article_id='.$_POST['title']);
//지금 방식대로는 id가 겹치면 원글이 수정되어버리는 작성 방식
// 세션을 활용하여 닉네임 누구누구의 후기 같은 식으로 앞에 닉네임을 붙여줄 것


?>
