$(function(){
    var $good = $('.btn-good'), //いいねボタンセレクタ
                goodPostId; //投稿ID
    $good.on('click',function(e){
        e.stopPropagation();
        var $this = $(this);
        //カスタム属性（postid）に格納された投稿ID取得
        goodPostId = $this.parents('.post').data('postid');
        $.ajax({
            type: 'POST',
            url: '../classes/ajaxFavorite.php', //post送信を受けとるphpファイル
            data: { postId: goodPostId} //{キー:投稿ID}
        }).done(function(data){
            console.log(data);
            // いいねの総数を表示
            $this.children('span').html(data);
            // いいね取り消しのスタイル
            // $this.children('i').toggleClass('far'); //空洞ハート
            // いいね押した時のスタイル
            // $this.children('i').toggleClass('fas'); //塗りつぶしハート
            // $this.children('i').toggleClass('active');
            // $this.toggleClass('active');

            // いいねしていない時
            if($this.children('i').hasClass('active')){
               $this.children('i').removeClass('fas');
               $this.children('i').addClass('far');
               $this.children('i').removeClass('active');
               $this.removeClass('active');
            // いいねしている時
            }else if(!$this.children('i').hasClass('active')){
               $this.children('i').removeClass('far');
               $this.children('i').addClass('active');
               $this.children('i').addClass('fas');
               $this.addClass('active');
            }
        }).fail(function(msg) {
            console.log('Ajax Error');
        });
    });
});
