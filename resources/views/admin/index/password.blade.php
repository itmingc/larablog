@extends('layouts.admin')

@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 修改密码
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改密码</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form method="post" action="" id="password-form">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>原密码：</th>
                <td>
                    <input type="password" name="password_o"><span style="color: red;"></span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>新密码：</th>
                <td>
                    <input type="password" name="password"><span style="color: red;"></span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>确认密码：</th>
                <td>
                    <input type="password" name="password_confirmation"><span style="color: red;"></span>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script type="text/javascript" charset="utf-8">
    $(function (){

        $('#password-form').submit(function(){
            var
                $pwd_o = $('input[name="password_o"]'),
                $pwd = $('input[name="password"]'),
                $pwd_c = $('input[name="password_confirmation"]');

            if($pwd_o.val().trim() == ''){
                $pwd_o.next().html('请输入原密码！');
                return false;
            }
            else if($pwd.val().trim() == ''){
                $pwd.next().html('请输入新密码！');
                return false;
            }
            // else if(!/^[a-zA-Z_]\w{4,19}$/g.test($pwd.val().trim())){
            //     $pwd.next().html('密码由字母或下划线开始，5-20位！');
            //     return false;
            // }
            else if($pwd_c.val().trim() == ''){
                $pwd_c.next().html('请确认新密码！');
                return false;
            }
            else if($pwd.val().trim() != $pwd_c.val().trim()){
                $pwd_c.next().html('两次密码不一致！');
                return false;
            }
            else if($pwd.val().trim() == $pwd_o.val().trim()){
                $pwd.next().html('您的密码没有改变！');
                return false;
            }

            return true;

        });
    });
</script>
@endsection
