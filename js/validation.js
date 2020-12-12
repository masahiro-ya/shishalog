$(function(){
	$('.comment_btn').click(function(){
		if(!input_check()){
			return false;
		}
	});
});

// 入力内容チェックのための関数
function input_check(){
	var result = true;

	// エラー用装飾のためのクラスリセット
	$('.userId').removeClass("inp_error");
	$('.title').removeClass("inp_error");
	$('.content').removeClass("inp_error");
	// $('.content').removeClass("inp_error");

	// 入力エラー文をリセット
	$("#title_error").empty();

	// 入力内容セット
	var userId   = $(".userId").val();
	var title   = $(".title").val();
	var content = $(".content").val();



	// 入力内容チェック

	// お名前
	if(userId == null){
		$("#name_error").html("ログインしてください。");
		$("#name").addClass("inp_error");
		result = false;
	}
	// フリガナ
	if(title == ""){
		$("#title_error").html("タイトルを記入してください。");
		$("#title").addClass("inp_error");
		result = false;
	}else if(title.length > 10){
		$("#title_error").html("タイトルは10文字以内入力してください。");
		$("#title").addClass("inp_error");
		result = false;
	}
	if(content == ""){
		$("#content_error").html(" 本文は必須です。");
		$("#content").addClass("inp_error");
		result = false;
	}else if(content.length > 100){
		$("#content_error").html(" 本文は100文字以内入力してください。");
		$("#content").addClass("inp_error");
		result = false;
	}
	return result;
}