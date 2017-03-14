<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    @include('admin.common.head')
</head>
<body class="page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed-mobile page-footer-fixed1">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img src="../../admin/assets/admin/layout2/img/logo-default.png" alt="logo" class="logo-default"/>
            </a>

            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!--皮肤设置-->
                @include('admin.common.skin_set')
                <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                         <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                            data-close-others="true">
                             <i class="icon-envelope-open"></i>
                         <span class="badge badge-default">
                         4 </span>
                         </a>
                         <ul class="dropdown-menu">
                             <li class="external">
                                 <h3>You have <span class="bold">7 New</span> Messages</h3>
                                 <a href="page_inbox.html">view all</a>
                             </li>
                             <li>
                                 <ul class="dropdown-menu-list scroller" style="height: 275px;"
                                     data-handle-color="#637283">
                                     <li>
                                         <a href="inbox.html?a=view">
                                         <span class="photo">
                                         <img src="../../admin/assets/admin/layout3/img/avatar2.jpg" class="img-circle"
                                              alt="">
                                         </span>
                                         <span class="subject">
                                         <span class="from">
                                         Lisa Wong </span>
                                         <span class="time">Just Now </span>
                                         </span>
                                         <span class="message">
                                         Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                         </a>
                                     </li>
                                 </ul>
                             </li>
                         </ul>
                     </li> -->
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle"
                                 src="../../admin/assets/admin/layout2/img/avatar3_small.jpg"/>
                            <span class="username username-hide-on-mobile">
						{{$uname}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <!-- <li>
                                 <a href="extra_lock.html">
                                     <i class="icon-lock"></i> 锁 屏 </a>
                             </li>-->
                            <li>
                                <a href="/logout">
                                    <i class="icon-key"></i> 退 出 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!--左边菜单开始位置-->
            @include('admin.common.left_menu', array('topmenu'=>$topmenu,'menus'=>$menus,'initaction'=>$initaction))
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
        </div>
    </div>
</div>
<!-- END CONTAINER -->
<!-- 页面底部开始 -->
@include('admin.common.footer')
<!-- 页面底部结束 -->
<!-- bottom--javascript--start -->
@include('admin.common.footer_js')
<!-- bottom--javascript--end -->
<script>
    //javascript:window.history.forward(1);
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Demo.init(); // init demo features
        $("#memuch").on('click', "li", function () {
            $(this).addClass("active open").siblings().removeClass("active open");
        });
        $(".sub-menu").on('click', "li", function () {
            $(this).addClass("active").siblings().removeClass("active");
        });
        //var action = getCookie('action1');
        var action = '{{$initaction}}';
        if (action != '') {
            $(".page-content").load(action, function () {
                        $(".page-content").fadeIn(100);
                    }
            );
        }
    });

</script>
</body>
</html>