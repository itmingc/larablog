<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>博客系统&nbsp;&nbsp;后台登录</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/login.css') }}">
    <script type="text/javascript" src="{{ asset('admin/js/jquery.js') }}"></script>
    <script type="text/javascript">var _control = '{{url("admin")}}'</script>
    <script type="text/javascript" src="{{ asset('admin/js/login.js') }}"></script>
</head>
<body>
    <div class="login-wrap">
        <p>博客系统 后台登录<span id="msg">@if($msg = session('msg')){{$msg}}@endif</span></p>
        <form id="login-form" action='' method="post">
            </label>
            <label class="row-uname">
                <input id="username" type="text" name="username" maxlength="50" placeholder="用户名" autocomplete="off" autofocus="on" />
            </label>
            <label class="row-pwd">
                <input id="password" type="password" name="password" maxlength="50" placeholder="密码" autocomplete="off" />
            </label>
            <label class="row-code">
                <input id="code" type="text" name="code" maxlength="10" placeholder="验证码" autocomplete="off" />
                <img id="img-code" src="{{ url('admin/captcha') }}" width="148" height="44" alt="验证码图像" title="看不清，点击换一张">
            </label>
            <label>
                {{csrf_field()}}
                <input id="login" type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录" />
            </label>
        </form>
    </div>
</body>
</html>
