<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jqmeter.min.js" type="text/javascript"></script>
<style>
</style>
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
                <a href="#">系统管理</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#1" onclick="func_action('aa')">数据同步</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">产品同步</a>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row" id="func">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>产品同步</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th class="table-checkbox"
                            style="width:10%;text-align:center;padding-top: 10px;vertical-align: middle">
                            <div>同步基本信息
                                <span></span>
                            </div>
                        </th>
                        <th>
                            <!--垂直排列 <div class="icheck-list"> -->
                            <div class="icheck-inline">
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="shenhe"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    审核通过的产品
                                </label>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="table-checkbox"
                            style="width:10%;text-align:center;padding-top: 10px;vertical-align: middle">
                            <div>同步详细信息
                                <span></span>
                            </div>
                        </th>
                        <th>
                            <!--垂直排列 <div class="icheck-list"> -->
                            <div class="icheck-inline">
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="detail"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    产品详细信息
                                </label>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="table-checkbox"
                            style="width:10%;text-align:center;padding-top: 10px;vertical-align: middle">
                            <div>同步图片
                                <span></span>
                            </div>
                        </th>
                        <th>
                            <!--垂直排列 <div class="icheck-list"> -->
                            <div class="icheck-inline">
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="pic"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    产品图片
                                </label>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="table-checkbox"
                            style="width:10%;text-align:center;padding-top: 10px;vertical-align: middle">
                            <div>同步产品状态
                                <span></span>
                            </div>
                        </th>
                        <th>
                            <!--垂直排列 <div class="icheck-list"> -->
                          <!--  <div class="icheck-inline">
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="status"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    零效果产品
                                </label>
                            </div> -->
                            <div class="icheck-inline">
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="chuchuang"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    橱窗产品
                                </label>
                            </div>
                        </th>
                    </tr>
                    <tr style="height:40px;">
                        <td colspan="2">
                            <div id="proc"></div>
                        </td>
                    </tr>
                    </thead>
                </table>
                <div class="form-actions">
                    <input type="hidden" id="rid" value="123">
                    {{--  <button type="button" v-on:click="save" class="btn green-haze">开始同步</button>--}}
                    <a href="/tb">aaaaaa</a>
                    <button type="button" v-on:click="update" class="btn green-haze">开始同步</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn default" onclick="func_action('aa')">取消同步</button>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    $(function () {

    });
    var i = 0;
    /*jQuery(document).ready(function () {
     Metronic.init();
     });*/
    var total = 0;
    var count = 0;
    var d;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#func',
        data: {},
        ready: function () {

        },
        methods: {
            check: function (event) {
                var mid = event.target.id;
                if ($("#" + mid).attr("checked")) {
                    $("#" + mid).parents("div").addClass("checked");
                } else {
                    $("#" + mid).parents("div").removeClass("checked");
                }
            },
            ajaxlink: function () {
                this.$http.get('/tbcount', function (data) {
                    total = eval(data).total;
                    count = eval(data).count;
                    $('#proc').jQMeter({
                        goal: '$' + total,
                        raised: '$' + count,
                        width: '100%',
                        barColor: '#6699cc',
                        // displayTotal: true,
                        animationSpeed: 0,
                        counterSpeed: 0
                    });
                    if (count = total) {
                        window.clearInterval(d);
                    }
                })
            },
            update: function () {
                /*$("input[name='chk']").each(function () {
                 if ($(this).attr("checked")) {
                 mid += $(this).attr("id") + "-";
                 }
                 })
                 mid = mid.substring(0, mid.length - 1);*/
                if ($("#shenhe").attr("checked") == 'checked') {
                    shenhe = 1;
                } else {
                    shenhe = 2;
                }
                if ($("#detail").attr("checked") == 'checked') {
                    detail = 1;
                } else {
                    detail = 2;
                }
                if ($("#pic").attr("checked") == 'checked') {
                    pic = 1;
                } else {
                    pic = 2;
                }
                /*if ($("#status").attr("checked") == 'checked') {
                    status = 1;
                } else {
                    status = 2;
                }*/
                status = 2;
                if ($("#chuchuang").attr("checked") == 'checked') {
                    chuchuang = 1;
                } else {
                    chuchuang = 2;
                }
                senddata = {
                    shenhe: shenhe,
                    detail: detail,
                    pic: pic,
                    status: status,
                    chuchuang: chuchuang
                };
                d = window.setInterval(this.ajaxlink, 500);
                this.$http.get('/tb', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert2('更新完成');
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            }
        }
    })
</script>