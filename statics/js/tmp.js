$("#nickname").blur(function(){

  var nicknameCheck = $('.nicknameCheck');

  var user_nickname = $("#nickname").val();
  if (user_nickname==""){
    $("#nickname").focus();
    $(".check_nickname_msg").text("닉네임을 입력하세요").css("color","red");
    return;
  }
  $.ajax({
    type:'get',
    url:"/check_nickname.php",
    data:{user_nickname:user_nickname,},
    dataType:'JSON',
    success:function(data){
      console.log(data);
      if (data.result==1){
        console.log(data.result);

        $(".check_nickname_msg").text("이미 존재하는 닉네임입니다").css("color","red");
      } else{
        var regexNick = /[ \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi;
        var regexNick2 = /^{2,10}/;
        if(regexNick.test(user_nickname) || !regexNick2.text(user_nickname){
          $(".check_nickname_msg").text("유효하지 않은 닉네임입니다").css("color","red");
        } else {
          $(".check_nickname_msg").text("사용 가능한 닉네임입니다").css("color","green");
          nicknameCheck.val('1');

        }



      }
    },
    error:function(){
      console.log("fail");
    }




  })

})
