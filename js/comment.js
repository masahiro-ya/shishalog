

  $(document).on('click','.comment_btn',function(e){
    e.stopPropagation();
    shopId = $('.shopId').val();
    userId = $('.userId').val();
    title = $('.title').val();
    star = $('.star').val();
    content = $('.content').val();
    $.ajax({
        type: 'POST',
        url: '../classes/ajax_comment.php',
        data: { shopId: shopId,
                userId: userId,
                title: title,
                star: star,
                content: content }
    }).done(function(data){
      console.log(data);
      $('#avg').html(data);
      getComment();
      $('.title').val('');
      $('.content').val('');
      $('.range-group>a').removeClass('on');
    }).fail(function(){
      console.log("XMLHttpRequest : " + XMLHttpRequest.status);
      console.log("textStatus     : " + textStatus);
      console.log("errorThrown    : " + errorThrown.message);
    });
  });



function getComment(){
  $.post("../public/detailshop.php", function(data){
    if (shopId === null){
      $("#send-comment-error").text("コメントの読み込みに失敗しました。リロードしてみて下さい。");
      return false;
    }else if (title === "")
      $("#comment").text("コメントがありません。");
    else{
      $("#newtitle").html(title);
      $("#newcomment").html(content);
    }
  });
}