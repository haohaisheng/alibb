<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    @include('admin.common.head.bak')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <a class="navbar-brand" href="index.html">
            <img src="admin/assets/img/logo.png" alt="logo" class="img-responsive"/>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <img src="admin/assets/img/menu-toggler.png" alt=""/>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->


        <div class="theme-panel hidden-xs hidden-sm">
            <div class="toggler"></div>
            <div class="toggler-close"></div>
            <div class="theme-options">
                <div class="theme-option theme-colors clearfix">
                    <span>THEME COLOR</span>
                    <ul>
                        <li class="color-black current color-default" data-style="default"></li>
                        <li class="color-blue" data-style="blue"></li>
                        <li class="color-brown" data-style="brown"></li>
                        <li class="color-purple" data-style="purple"></li>
                        <li class="color-grey" data-style="grey"></li>
                        <li class="color-white color-light" data-style="light"></li>
                    </ul>
                </div>
                <div class="theme-option">
                    <span>Layout</span>
                    <select class="layout-option form-control input-small">
                        <option value="fluid" selected="selected">Fluid</option>
                        <option value="boxed">Boxed</option>
                    </select>
                </div>
                <div class="theme-option">
                    <span>Header</span>
                    <select class="header-option form-control input-small">
                        <option value="fixed" selected="selected">Fixed</option>
                        <option value="default">Default</option>
                    </select>
                </div>
                <div class="theme-option">
                    <span>Sidebar</span>
                    <select class="sidebar-option form-control input-small">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="selected">Default</option>
                    </select>
                </div>
                <div class="theme-option">
                    <span>Footer</span>
                    <select class="footer-option form-control input-small">
                        <option value="fixed">Fixed</option>
                        <option value="default" selected="selected">Default</option>
                    </select>
                </div>
            </div>
        </div>
        <ul class="nav navbar-nav pull-right">
            <!-- END NOTIFICATION DROPDOWN -->
            <!-- BEGIN INBOX DROPDOWN -->
            <li class="dropdown" id="header_inbox_bar">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <i class="fa fa-envelope"></i>
                    <span class="badge">5</span>
                </a>
                <ul class="dropdown-menu extended inbox">
                    <li>
                        <p>你有1条消息</p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list scroller" style="height: 250px;">
                            <li>
                                <a href="inbox.html?a=view">
                                    <span class="photo"><img src="admin/assets/img/avatar2.jpg" alt=""/></span>
									<span class="subject">
									<span class="from">Lisa Wong</span>
									<span class="time">Just Now</span>
									</span>
									<span class="message">
									Vivamus sed auctor nibh congue nibh. auctor nibh
									auctor nibh...
									</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="external">
                        <a href="inbox.html">See all messages <i class="m-icon-swapright"></i></a>
                    </li>
                </ul>
            </li>
            <!-- END INBOX DROPDOWN -->
            <!-- END TODO DROPDOWN -->
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                   data-close-others="true">
                    <img alt="" src="admin/assets/img/avatar1_small.jpg"/>
                    <span class="username">Bob Nilson</span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="extra_profile.html"><i class="fa fa-user"></i> My Profile</a></li>
                    <li><a href="#"><i class="fa fa-tasks"></i> My Tasks <span class="badge badge-success">7</span></a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a></li>
                    <li><a href="extra_lock.html"><i class="fa fa-lock"></i> Lock Screen</a></li>
                    <li><a href="login.html"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container" id="mem">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" id="memuch">
            <li>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler hidden-phone"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li>
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <form class="sidebar-search" action="extra_search.html" method="POST">
                    <div class="form-container">
                        <div class="input-box">
                            <a href="javascript:;" class="remove"></a>
                            <input type="text" placeholder="Search..."/>
                            <input type="button" class="submit" value=" "/>
                        </div>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <li class="start active ">
                <a href="index.html">
                    <i class="fa fa-home"></i>
                    <span class="title">系统总览</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="">
                <a href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span class="title">系统管理</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li v-on:click="cstyle">
                        <a onclick="jump('/user')">
                            <span class="badge badge-roundless badge-warning">new</span>用户管理</a>
                    </li>
                    <li>
                        <a onclick="jump('/usercreate')">
                            <span class="badge badge-roundless badge-important">new</span>菜单管理</a>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span class="title">表格样式</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="table_basic.html">
                            Basic Datatables</a>
                    </li>
                    <li>
                        <a href="table_ajax.html">
                            Ajax Datatables</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!---原来设置皮肤的位置-->
        <!--设置内容页面开始-->
        @include('admin.user_list.bak')
                <!--设置内容页面结束-->
    </div>
</div>
@include('admin.common.footer.bak')

<script>
    jQuery(document).ready(function () {
        App.init(); // initlayout and core plugins
        Index.init();
        Index.initDashboardDaterange();
        Index.initIntro();
        Tasks.initDashboardWidget();
        $("#memuch").on('click', "li", function () {
            $(this).addClass("active open").siblings().removeClass("active ");
        });
    });

    function jump(action) {
        $(".page-content").load(action, function () {
                    $(".page-content").fadeIn(100);
                }
        );
    }

    var vm = new Vue({
        el: '#mem',
        data: {
            lists: '',
            all: '',
            cur: 1,
        },
        ready: function () {
            this.btnClick(this.cur);
        },
        methods: {
            cstyle: function (event) {
               // event.target.className = "active";
            },
            btnClick: function (index) {
                this.cur = index;
                /* senddata = {page: index};
                 this.$http.get('/getuser', senddata, function (data) {
                 this.$set('lists', eval(JSON.stringify(data.data)));
                 this.$set('all', eval(JSON.stringify(data.last_page)));
                 }).error(function (data, status, request) {
                 console.log('fail' + status + "," + request);
                 })*/
            }
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        }
    })
</script>
<!-- END JAVASCRIPTS -->
</body>
</html>
