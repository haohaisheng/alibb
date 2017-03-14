<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>系统 | 登录</title>
    @include('admin.common.head')
    <link href="../../admin/assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="#">
       <img src="../../admin/assets/admin/layout2/img/logo-big.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{URL::route('auth.checklogin')}}" method="post" id="login">
        <h3 class="form-title">登 录</h3>

        <div class="alert alert-danger display-hide" id="error">
            <button class="close" data-close="alert"></button>
			<span>
			账号或密码错误. </span>
        </div>
        @if (session('error'))
            <div class="alert alert-danger" id="error1">
                <button class="close" data-close="alert"></button>
			<span>{{ session('error') }}
			 </span>
            </div>
        @endif
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">登录账号</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                   placeholder="账号" name="username" id="username"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">登录密码</label>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="密码" name="password" id="password"/>
        </div>
        <div class="form-actions">
            <button type="button" v-on:click="login" class="btn btn-success uppercase">登 录</button>
            {{-- <label class="rememberme check">
                 <input type="checkbox" name="remember" value="1"/>记住密码 </label>--}}
            <a href="javascript:;" id="forget-password" class="forget-password">忘记密码 ?</a>
        </div>
        <div class="login-options">
           <!-- <h4>或使用其他账号</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                </li>
            </ul>-->
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="index.html" method="post">
        <h3>忘记密码 ?</h3>

        <p>
            输入你的邮箱地址以便重置密码.
        </p>

        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                   name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">返回</button>
            <button type="submit" class="btn btn-success uppercase pull-right">提交</button>
        </div>
    </form>
</div>
<div class="copyright">
    2015 © Admin Dashboard Template.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../admin/assets/global/plugins/respond.min.js"></script>
<script src="../../admin/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../admin/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../admin/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="../../admin/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="../../admin/assets/admin/pages/scripts/login.js" type="text/javascript"></script>

<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
        Demo.init();
    });
    var vm = new Vue({
        el: '#login',
        methods: {
            login: function () {
                var username = $("#username").val().trim();
                var password = $("#password").val().trim();
                if (username == '' || password == '') {
                    $("#error").show();
                    return false;
                } else {
                    $("#error").hide();
                }
                $("#login").submit();
            }
        }
    })
</script>

</body>
</html>