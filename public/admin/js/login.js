$(function(){

	//提交表单
	$('#login-form').submit(function(){
		if($('input[name="code"]').val().trim() == ''){
			showMsg('请输入验证码！');
			return false;
		}
		else if($('input[name="password"]').val().trim() == ''){
			showMsg('请输入密码！');
			return false;
		}
		else if($('input[name="username"]').val().trim() == ''){
			showMsg('请输入用户名！');
			return false;
		}
		return true;
	});

	// 刷新验证码
	$('#img-code').click(function(){
		$(this).attr('src', _control + '/captcha?' + Math.random());
	}).css('cursor', 'pointer');
});

function showMsg(msg){
	$('#msg').html(msg);
}