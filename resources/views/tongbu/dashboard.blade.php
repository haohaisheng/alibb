<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">主目录</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">系统概述</a>
                <i class="fa fa-angle-right"></i>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light blue-soft" href="javascript: func_action('/product');">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{$totalcount}}
                </div>
                <div class="desc">
                    产品总数
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light red-soft" href="javascript:func_action('/today');">
            <div class="visual">
                <i class="fa fa-trophy"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{$todaycreate}}
                </div>
                <div class="desc">
                    今日新增
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light green-soft" href="javascript:func_action('/today');">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    {{$todayupdate}}
                </div>
                <div class="desc">
                    今日修改
                </div>
            </div>
        </a>
    </div>
  <!--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-light purple-soft" href="javascript:;">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="number">
                    45
                </div>
                <div class="desc">
                    今日订单
                </div>
            </div>
        </a>
    </div>-->
</div>