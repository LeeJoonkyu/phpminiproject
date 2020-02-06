<?php
require_once('lib/sess_start.php');
sess_start();
echo $_COOKIE['kakao_tid'];
echo "/n";
//결제고유번호
echo $_COOKIE['kakao_order_id'];
echo "/n";
echo $_COOKIE['kakao_donate_to'];

  CallPaymentKakaoPaySuccess();

    function CallPaymentKakaoPaySuccess() {

      $adminkey             ="69e685fe79857178da1a832c8dbc007c";       // admin 키
      /*if( $this->config->item('kakaopay_mode') == 'service' ) {
          // $cid            = $this->strkakaopayCID;            // cid
      } else if( $this->config->item('kakaopay_mode') == 'test' ) {
          $cid            = 'TC0ONETIME';
      }*/
      $cid = "TC0ONETIME";

      $req_auth   = 'Authorization: KakaoAK '.$adminkey;
      $req_cont   = 'Content-type: application/x-www-form-urlencoded;charset=utf-8';

      $kakao_header = array( $req_auth, $req_cont );

        $kakao_params = array(
            'cid'               => $cid,                            // 가맹점코드 10자
            'tid'               => $_COOKIE['kakao_tid'],         // 결제 고유번호. 결제준비 API의 응답에서 얻을 수 있음
            'partner_order_id'  => $_COOKIE['kakao_order_id'],    // 여기선 게시글 후원대상 게시글 아이디. 가맹점 주문번호. 결제준비 API에서 요청한 값과 일치해야 함
            'partner_user_id'   => $_SESSION['uid'],           // 가맹점 회원 id. 결제준비 API에서 요청한 값과 일치해야 함
            'pg_token'          => $_GET['pg_token'],    // 결제승인 요청을 인증하는 토큰. 사용자가 결제수단 선택 완료시 approval_url로 redirection해줄 때 pg_token을 query string으로 넘겨줌
            //'payload'           => ,                              // 해당 Request와 매핑해서 저장하고 싶은 값. 최대 200자
        );

        $strArrResult = request_curl('https://kapi.kakao.com/v1/payment/approve', 1, http_build_query($kakao_params), $kakao_header);

        $IS_PAYMENT_SUCCESS = false;

        if( $strArrResult[3] != '200' ) {
            var_dump($strArrResult);
            // var_dump($strArrResult[0]);
            echo "<script>";
            echo "alert('에러입니다. 관리자에게 문의하세요.');";
            echo "window.parent.close();";
            echo "</script>";
            return;
        }

        $strArrResult = json_decode($strArrResult[0]);

        // LGD 로 쓰는 이유는 기존 table를 활용해서 같이쓰기위함.
        $paymentResultArr = Array (
             'LGD_TID'                => $strArrResult->tid,                     // kakao 거래 고유 번호
             'LGD_MID'                => $strArrResult->cid,                     // 상점아이디
             'LGD_OID'                => $strArrResult->partner_order_id,        // 상점주문번호
             'LGD_AMOUNT'             => $strArrResult->amount->total,           // 결제금액

             'LGD_RESPCODE'           => '0000',                                 // 결과코드
             'LGD_RESPMSG'            => '결제성공',                                       // 결과메세지

             // 'LGD_FINANCENAME'        => $strArrResult->card_info->purchase_corp,         // 은행명
             // 'LGD_FINANCECODE'        => $strArrResult->card_info->purchase_corp_code,    // 은행코드

             'LGD_PAYTYPE'            => $strArrResult->payment_method_type,              // 결제 방법 ( CARD, MONEY )

             'LGD_PAYDATE'            => $strArrResult->approved_at,                      // 승인시간 (모든 결제 수단 공통)
             // 'LGD_FINANCEAUTHNUM'     => $strArrResult->card_info->approved_id,           // 신용카드 승인번호
             // 'LGD_CARDNOINTYN'        => $strArrResult->card_info->interest_free_install, // 신용카드 무이자 여부 ( Y: 무이자,  N : 일반)
             // 'LGD_CARDINSTALLMONTH'   => $strArrResult->card_info->install_month,         // 신용카드 할부개월

        );

        /*

        // 트랜잭션 시작
        $this->db->trans_begin();

        //결재 정보 갱신
        $this->AfterPaymentSuccess( $paymentResultArr );

        if ($this->db->trans_status() == FALSE) {
             $this->db->trans_rollback();
        } else {
             $IS_PAYMENT_SUCCESS = true;
             $this->db->trans_commit();
        } */

        //db insertion
        $IS_PAYMENT_SUCCESS = true;

        if( $IS_PAYMENT_SUCCESS ) {

            /**
             * TODO
             * 주문 SMS 발송
             */
            // $this->ordersms( get_cookie('kakao_order_id') );

            // $replace_url = HTTP_GURL . "/order/orderSuccess/".get_cookie('kakao_order_id');
            $replace_url = "/donation/success.php";

?>

<?php
require_once('lib/dbconnect.php');
if (mysqli_connect_error()){
  die('connect Error('.mysqli_connect_errono().')'.mysqli_connect_error());
} else{

  $sql = "INSERT INTO donationkakaopay (kakao_tid,kakao_mid,kakao_oid,kakao_amount,kakao_to,kakao_respcode,kakao_respmsg,kakao_paytype,kakao_paydate)";
  $sql .= " VALUES ('{$paymentResultArr['LGD_TID']}','{$paymentResultArr['LGD_MID']}','{$paymentResultArr['LGD_OID']}','{$paymentResultArr['LGD_AMOUNT']}','{$_COOKIE['kakao_donate_to']}','{$paymentResultArr['LGD_RESPCODE']}','{$paymentResultArr['LGD_RESPMSG']}','{$paymentResultArr['LGD_PAYTYPE']}','{$paymentResultArr['LGD_PAYDATE']}')";
  $res = $conn->query($sql);
  if ( false===$res ) {
    printf("error: %s\n", mysqli_error($conn));
    ?>
    <script language='javascript'>
         var childWindow = window.parent;
         var parentWindow = childWindow.opener;
         // childWindow.document("error: $s\n, <?= mysqli_error($conn); ?>");
         childWindow.close();
    </script>


    <?php
  }
  else {?>
    <script language='javascript'>
         var childWindow = window.parent;
         var parentWindow = childWindow.opener;
         // childWindow.document("결제 성공");

         childWindow.close();
    </script>


    <?php
    echo '트랜젝션 성공';
  }


}


 ?>

            <script language='javascript'>
                 var childWindow = window.parent;
                 var parentWindow = childWindow.opener;
                 parentWindow.parent.location.replace("<?=
                 $replace_url
                 ?>");
                 // 여길 php echo로 고치니까 해결됏다고..? 뭐지?
                 childWindow.close();
            </script>
<?php
        }

    }
    /**
 * @param $url  값을 던질 url
 * @param int $is_post   post 통신이면 1, get 이면0
 * @param array $data    전달할 값
 * @param null $custom_header    header를 같이 전송할경우
 * @return mixed
 */
function request_curl($url, $is_post=0, $data=array(), $custom_header=null) {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_SSLVERSION,1);
        curl_setopt ($ch, CURLOPT_POST, $is_post);
        if($is_post) {
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt ($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt ($ch, CURLOPT_HEADER, true);

        if($custom_header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_header);
        }
        $result[0] = curl_exec ($ch);
        $result[1] = curl_errno($ch);
        $result[2] = curl_error($ch);
        $result[3] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        return $result;
}



?>
