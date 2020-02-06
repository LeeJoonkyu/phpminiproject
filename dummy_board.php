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
  // $title = $_POST['title'];
  // $desc = $_POST['description'];
  $author = $_SESSION['nickname'];
  $likes = 0;
  $date = date('Y-m-d H:i:s');
  $hit = 0;
  $ipaddr = $_SERVER['REMOTE_ADDR'];

  $arr = array("대학로 킬롤로지 후기","세종아트센터 미저리 후기","대학로 늘근도둑이야기 후기","세종아트센터 엘리펀트송 후기","대학로 작업의정석 후기","대학로 오펀스 후기");
  $lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

  for ($j=0;$j<5;$j++){
    for ($i=0;$i<6;$i++){
      $sql = "INSERT INTO board (uid,title,content,author,wdate,ip_addr) VALUES('{$uid}','{$arr[$i]}','{$lorem}','{$author}','{$date}','{$ipaddr}')";
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

  }




}




file_put_contents('article_data/'.$_POST['title'], $_POST['description']);
// header('Location: /board.php?article_id='.$_POST['title']);
//지금 방식대로는 id가 겹치면 원글이 수정되어버리는 작성 방식
// 세션을 활용하여 닉네임 누구누구의 후기 같은 식으로 앞에 닉네임을 붙여줄 것


?>
