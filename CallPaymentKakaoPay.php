<?php
$orderArr['order_id']=$_POST['partner_order_id'];
$orderArr['user_id']=$_POST['partner_user_id'];
$orderArr['order_prd_nm']=$_POST['item_name'];
$orderArr['ord_row']=$_POST['quantity'];
$orderArr['total_price']=$_POST['quantity']*$_POST['total_amount'];
CallPaymentKakaoPay($orderArr);



function CallPaymentKakaoPay($orderArr) {


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

        // $approval_url   = "https://".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPaySuccess";
        // $cancel_url     = "https://".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPayCancle";
        // $fail_url       = "https://".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPayCancle";

        $approval_url   = "http://localhost/CallPaymentKakaoPaySuccess.php";
        $cancel_url     = "http://localhost/CallPaymentKakaoPayCancel.php";
        $fail_url       = "http://localhost/CallPaymentKakaoPayCancel.php";
        $pay_url = "https://kapi.kakao.com/v1/payment/ready";

        $kakao_params = array(
            'cid'               => $cid,                                    // 가맹점코드 10자
            'partner_order_id'  => $orderArr['order_id'],                   // 주문번호
            // 'partner_user_id'   => get_cookie('user_id'),                   // 유저 id
            'partner_user_id'   => $orderArr['user_id'],                   // 유저 id

            'item_name'         => $orderArr['order_prd_nm'],               // 상품명
            'quantity'          => $orderArr['ord_row'],                    // 상품 수량
            'total_amount'      => $orderArr['total_price'],                // 상품 총액
            'tax_free_amount'   => 0,                                     // 상품 비과세 금액
            'approval_url'      => $approval_url,                           // 결제성공시 콜백url 최대 255자
            'cancel_url'        => $cancel_url,
            'fail_url'          => $fail_url,
        );

        //pre($kakao_params);

        $strArrResult = request_curl('https://kapi.kakao.com/v1/payment/ready', 1, http_build_query($kakao_params), $kakao_header);

        //pre($strArrResult);

        if( $strArrResult[3] != '200' ) {
                 var_dump($strArrResult);
                 echo "<script>";
                 echo "alert('에러입니다. 관리자에게 문의하세요.');";
                 echo "</script>";
                 return;
        }

        $strArrResult = json_decode($strArrResult[0]);

        // setcookie('content?article_id_'.$article_id, TRUE, time() + (60 * 60 * 24), '/');

        setcookie("kakao_tid", $strArrResult->tid, time()+60*5,'/');
        //결제고유번호
        setcookie("kakao_order_id", $orderArr['order_id'], time()+60*5,'/');
        setcookie("kakao_donate_to",$_POST['kakao_donate_to'],time()+60*5,'/');


        // echo $_COOKIE["kakao_tid"];
        // echo "/n";
        // //결제고유번호
        // echo $_COOKIE["kakao_order_id"];
        // echo "/n";
        // echo $_COOKIE["kakao_donate_to"];


        echo "<script>";
        echo "var win = window.open('','','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=540,height=700,left=100,top=100');";
        echo "win.document.write('<iframe width=100%, height=650 src=".$strArrResult->next_redirect_pc_url." frameborder=0 allowfullscreen></iframe>')";
        echo "</script>";
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
