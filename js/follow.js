  $(document).on('click','.follow_btn',function(e){
    e.stopPropagation();
    var $this = $(this),
    current_user_id = $('.current_user_id').val();
    user_id = $this.prev().val();
    console.log(current_user_id,user_id);
    $.ajax({
        type: 'POST',
        url: '../classes/ajax_follow_process.php',
        data: { current_user_id: current_user_id,
                user_id: user_id }
    }).done(function(data){
      console.log(data);
        $('.count a').html(data);
        if($("button").hasClass("follow")){
           $(".follow_btn").removeClass("follow");
           $(".follow_btn").addClass("nofollow");
           $(".follow_btn").css({color:"#000", background:"#fff"});
           $(".follow_btn").text("フォロー");
        }else if($("button").hasClass("nofollow")){
           $(".follow_btn").removeClass("nofollow");
           $(".follow_btn").addClass("follow");
           $(".follow_btn").css({color:"#fff", background:"#007bff"});
           $(".follow_btn").text("フォロー中");
        }
    }).fail(function(){
      console.log("XMLHttpRequest : " + XMLHttpRequest.status);
      console.log("textStatus     : " + textStatus);
      console.log("errorThrown    : " + errorThrown.message);
    });
  });
