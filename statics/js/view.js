
$(document).ready(function() {

    $('#report_content').click(function(e) {
    	e.preventDefault();
    	var c = confirm("신고 하시겠습니까?");
        if(c){
			$.ajax({
				type:"POST",
				url :"/report/content/" + board_no,
			}).done(function(e) {
				if (e.type == false) {
					alert(e.msg);
				} else {
					alert('감사합니다. 곧 운영자가 확인할 예정입니다.');
				}
			});
        }

//        e.preventDefault();
//        $.ajax({
//            type:"POST",
//            url :"/report/content/" + board_no,
//        }).done(function(e) {
//            if (e.type == false) {
//                alert(e.msg);
//            } else {
//                alert('냉동신청 되었습니다. 냉동이 5개 누적되면 해당 글은 블라인드 처리됩니다.');
//            }
//
//        });
    });

    $('#report_content2').click(function(e) {
        e.preventDefault();
        var c = confirm("신고 하시겠습니까?");
        if(c){
            $.ajax({
                type:"POST",
                url :"/report/content/" + board_no,
            }).done(function(e) {
                if (e.type == false) {
                    alert(e.msg);
                } else {
                    alert('감사합니다. 곧 운영자가 확인할 예정입니다.');
                }
            });
        }

//        e.preventDefault();
//        $.ajax({
//            type:"POST",
//            url :"/report/content/" + board_no,
//        }).done(function(e) {
//            if (e.type == false) {
//                alert(e.msg);
//            } else {
//                alert('냉동신청 되었습니다. 냉동이 5개 누적되면 해당 글은 블라인드 처리됩니다.');
//            }
//
//        });
    });
    $('#scrap').click(function(e) {
        e.preventDefault();
        $.ajax({
            type:"POST",
            url :"/scrap/" + board_no,
        }).done(function(e) {
            if (e.type == false) {
                alert(e.msg);
            } else {
                alert('스크랩 되었습니다. 내 페이지에서 확인 가능합니다.');
                window.location.reload();

            }

        });

    });

    $('#scrap_cancel').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/scrap_cancel/" + board_no,
        }).done(function (e) {
            if (e.type == false) {
                alert(e.msg);
            } else {
                alert('스크랩 취소 되었습니다.');
                window.location.reload();
            }

        });
    });
    $('#scrap2').click(function(e) {
        e.preventDefault();
        $.ajax({
            type:"POST",
            url :"/scrap/" + board_no,
        }).done(function(e) {
            if (e.type == false) {
                alert(e.msg);
            } else {
                alert('스크랩 되었습니다. 내 페이지에서 확인 가능합니다.');
                window.location.reload();

            }

        });

    });

    $('#scrap_cancel2').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/scrap_cancel/" + board_no,
        }).done(function (e) {
            if (e.type == false) {
                alert(e.msg);
            } else {
                alert('스크랩 취소 되었습니다.');
                window.location.reload();
            }

        });
    });
    $('#input-comment, .comment-content').on( 'keyup', 'textarea', function (e){
        var scroll = $(document).scrollTop();
        $(this).css('height','auto');
        $(this).height( this.scrollHeight );
        $(document).scrollTop(scroll);
    });
    $('#input-comment, .comment-content').find( 'textarea' ).keyup();

    $(document).on('click', '.remove1', function() {
        $(".remove1").css("display","block");
        $(".remove2").css("display","none");
        $(this).css("display","none");
        $(this).parent().children('.remove2').css("display","block");
    });
    $(document).on('click', '.remove_cancel', function() {
        $(this).parent().css("display","none");
        $(this).parent().parent().children('.remove1').css("display","block");
        $(".reply_comments").css("display","none");
    });
    $(document).on('click', '.reply_comment', function() {
        var button_val = $(this).val();
        $(".reply_comments").css("display","none");
        $("#reply_comments_"+button_val).css("display","block");
    });

    $(".submit").click(function() {
        var obj = $(this);
        obj.attr("disabled",true);
        var button_val = $(this).val();
       // alert( $(this).val());
        $.ajax({
            type:"POST",
            url :"/comment",
            data:{
                content_id:board_no,
            content:$("#comments_text_"+button_val+"").val(),
            comments_no:button_val,
            comments_id:$("#comments_"+$(this).val()+" > input[name='comments_num']").val(),
            comments_depth:$("#comments_"+$(this).val()+" > input[name='comments_depth']").val(),
            time_now:$("#time_now").val()
            }
        }).done(function(e) {
        $(".form-control").val('');
            if (e.type == false)
            {
             //   $(".insert").html("").append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>"+e.msg+"</div>");
            }
            else
            {
//alert(e.comments_num);
                   $("#time_now").val(e.time_now);
                   $("#comments_area_html").html(e.send_msg);
                window.location.reload();

                //location.reload();
            }

            obj.attr("disabled",false);
        });
    });
    $(document).on('click', '.delete_comments', function() {
        var result = confirm('삭제 하시겠습니까?');
        if (result) {
        var obj = $(this);
        obj.attr("disabled",true);
        var button_val = $(this).val();
       // alert( $(this).val());

        $.ajax({
            type:"POST",
            url :"/comment/"+button_val,
            data:{
                no:board_no,
            comments_no:button_val,
            board_type:board_type,
            time_now:$("#time_now").val()
            }
        }).done(function(e) {
            if (e.type == false) {
                $(".insert").html("").append("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + e.msg + "</div>");
            }
            else
            {
//alert(e.comments_num);
                    $("#time_now").val(e.time_now);
                   $("#comments_area_html").html(e.send_msg);
                    window.location.reload();
            }

            obj.attr("disabled",false);
        });
    }});
    $(".checkid").click(function(){
      var idCheck = $('.idCheck');


      var user_id = $("#email").val();
      if (user_id==""){
        $("#email").focus();
        $(".check_id_msg").text("아이디를 입력하세요").css("color","red");
        return;
      }
      $.ajax({
        type:'get',
        url:"/check_id.php",
        data:{user_id:user_id,},
        dataType:'JSON',
        success:function(data){
          console.log(data);
          if (data.result==1){
            console.log(data.result);

            $(".check_id_msg").text("이미 존재하는 아이디입니다").css("color","red");
          } else{
            console.log(data.result);
            var regexId = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
            if (!regexId.test(user_id)){
              $(".check_id_msg").text("유효하지 않은 아이디입니다").css("color","red");

            } else{

              $(".check_id_msg").text("사용 가능한 아이디입니다").css("color","green");
              idCheck.val('1');


            }




          }
        },
        error:function(){
          console.log("fail");
        }




      })

    })
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
            var regexNick = /^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|\*]{2,10}$/;
            console.log(user_nickname);
            if (!regexNick.test(user_nickname)){
              $(".check_nickname_msg").text("유효하지 않은 닉네임입니다").css("color","red");

            } else{
              console.log(user_nickname);

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

    var regexPw = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,16}$/;
    $("#password").blur(function(){

      var pwCheck = $('.pwCheck');

      var password = $("#password").val();
      if (password==""){
        $("#password").focus();
        $(".check_pw_msg").text("비밀번호를 입력하세요").css("color","red");
        return;
      }
      if (!regexPw.test(password)){
        $(".check_pw_msg").text("유효하지 않은 비밀번호입니다").css("color","red");
        pwCheck.val('0');
        console.log(pwCheck.val());


      } else{
        $(".check_pw_msg").text("사용 가능한 비밀번호 입니다").css("color","green");
        pwCheck.val('1');
        console.log(pwCheck.val());


      }


    })
    $("#passwordchk").blur(function(){

      var pwCheck2 = $('.pwCheck2');

      var password = $("#password").val();
      var passwordchk = $("#passwordchk").val();
      if (passwordchk==""){
        $("#passwordchk").focus();
        $(".check_pw2_msg").text("확인용 비밀번호를 입력하세요").css("color","red");
        return;
      }

        if (password != passwordchk){
          $(".check_pw2_msg").text("비밀번호가 일치하지 않습니다").css("color","red");
        } else {
          $(".check_pw2_msg").text("비밀번호가 일치합니다").css("color","green");
          pwCheck2.val('1');

        }




    })

    var isclicked = false;
    $(".board-like").click(function() {
        var obj = $(this);
        var article_id=$(this).data('article_id');
        var author = $(this).data('author');
        var nickname = $(this).data('nickname');
        console.log(obj);
        console.log(article_id);
        //여기가 지금 undefined 처리되어서 첫 조회시 에러가 뜬다.
        console.log(author);
        console.log(nickname);

        //만약 이미 isclicked =true 되어있는지 확인을 해야하는데..
        //그리고 최초에 조회시에 버튼클릭해도 반영이 안되는 문제.
        if (!$(".board-like").hasClass("focus")){
          //이미 눌린게 아니라면,
          //로그에 false가 찍히고, 추천수 +1된다.
          isclicked = false;
          console.log('false');

        }
        else{
          isclicked = true;
          console.log('true');
        }



        // obj.attr("disabled",true);ss
        $.ajax({
            type:"POST",
            url:"/boardlike.php",
            data:{article_id:article_id,author:author,nickname:nickname,isclicked:isclicked,},
            //이게 데이터타입을 넘길때 json으로 넘어가서, "true","false" 이런식으로 넘어간다.
            //is clicked = false
            // dataType:'JSON',
            error : function(error) {
              console.log(error);
            },

            success:function(data){

              if (!$(".board-like").hasClass("focus")){
                $(".board-like").addClass("focus").parent().find(".badge").text(parseInt($(".badge:eq(0)").text())+1);
                // badge:eq(0)은 뱃지라는 선택자중 0번째 것을 가져오겟다는 것.
                // 이제 디비 단 처리를 해줘보자.
              }
              else{
                $(".board-like.focus").removeClass("focus").parent().find(".badge").text(parseInt($(".badge:eq(0)").text())-1);

              }
            }
        }).done(function(e) {
          //위의 클릭 작업 이후에 isclicked 플래그 변수를 바꿈(토글식)

            if (isclicked == false){
              isclicked = true;
              //url post 당시 isclicked는 트루로 넘어감.
            } else {
              isclicked = false;
            }

            obj.attr("disabled",false);
        });
    });

    $(".board-dislike").click(function() {
        var obj = $(this);
        obj.attr("disabled",true);
        $.ajax({
            type:"POST",
            url:"/dislike/" + board_no,
        }).done(function(e) {
            if (e.type == true){
                if ($(".board-like").hasClass("focus"))
            $(".board-like").removeClass("focus").parent().find(".badge").text(parseInt($(".badge:eq(0)").text())-1);
        if (!$(".board-dislike").hasClass("focus"))
            $(".board-dislike").addClass("focus").parent().find(".badge").text(parseInt($(".badge:eq(1)").text())+1);
        else
            $(".board-dislike").removeClass("focus").parent().find(".badge").text(parseInt($(".badge:eq(1)").text())-1);
            obj.attr("disabled",false);
            }
            else {
                alert(e.msg);
            }
        });
    });
    $(".comment-edit > a").click(function(e) {
        e.preventDefault();
        var obj = $(this).parent().parent().parent();
      //  var html = obj.find(".comment-content").html().replace(/<br>/g,"\n");
        obj.find(".comment-content").css({"display":"block", "height":"auto"}).html("");
        obj.find(".comment-content").append("<textarea class='form-control' style='display:block;width:100%;resize:none'>"+html+"</textarea>");
    });

  //  alert($("#time_now").val());
/*    var tid = setInterval(repeatcomments, 3000);
    function repeatcomments() {
    var time_ = $("#time_now").val();
       $.ajax({
            type:"POST",
            url :"/getComment/"+board_no,
            data:{
                no:board_no,
                upload_date:time_,
            }
        }).done(function(e) {
            if (e.type == true)
            {

           $("#time_now").val(e.time_now);
            time_ = e.time_now;
                $("#comments_area_html").append(e.send_msg);
            }
        });
    }*/

    });

function report_comment(comment_id) {
//	console.log(comment_id);.ㅁ
	var c = confirm("허위 냉동시 불이익을 받을 수 있습니다. 냉동 신청 하시겠습니까?");
    if(c) {
	    $.ajax({
	        type:"POST",
	        url :"/report/comment/" + comment_id,
	    }).done(function(e) {
	        if (e.type == false) {
	            alert(e.msg);
	        } else {
	            alert('접수완료');
	        }

	    });
    }
};
