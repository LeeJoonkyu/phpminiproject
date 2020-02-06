<?php
  CallPaymentKakaoPayCancel();

    function CallPaymentKakaoPayCancel() {

?>
        <script language='javascript'>
            var childWindow = window.parent;
            var parentWindow = childWindow.opener;
            alert('결제가 취소/실패 하였습니다.\n\n다시시도해주세요!');
            parentWindow.parent.location.replace("<?="/donation/fail.php"?>");
            childWindow.close();
        </script>
<?php


    }
?>
