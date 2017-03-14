<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jqmeter.min.js" type="text/javascript"></script>
<link href="../../admin/assets/global/css/components.css" id="style_components"/>

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
<div class="row" id="func1">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>产品同步</div>
            </div>
            <div class="portlet-body">

                <div class="portlet-body form">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_tab_1_1">
                            <div class="skin skin-minimal">
                                <form role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                        <!-- <label style="font-weight: 600">类目</label>
                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label>
                                                        <select class="form-control" id="cateid" onchange=""
                                                                style="line-height: 30px;">
                                                            <option value="0">全部类目</option>
                                                            <option value="@{{g.groupid}}"
                                                                    v-for="g in groups">@{{g.name}}</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>-->

                                            <div class="form-group" style="width: 25%;float: left;">
                                                <label>一级分类</label>
                                                <select multiple class="form-control">
                                                    <option v-on:click="select()">选择一级分类</option>
                                                    <option value="@{{c.categoryID}}" v-for="c in cate1"
                                                            v-on:click="getcategory1(1,c.categoryID)">@{{c.enName}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="width: 25%;float: left">
                                                <label>二级分类</label>
                                                <select multiple class="form-control">
                                                    <option v-on:click="select()">选择二级分类</option>
                                                    <option value="@{{c.categoryID}}" v-for="c in cate2"
                                                            v-on:click="getcategory1(2,c.categoryID)">@{{c.enName}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="width: 25%;float: left">
                                                <label>三级分类</label>
                                                <select multiple class="form-control">
                                                    <option v-on:click="select()">选择三级分类</option>
                                                    <option value="@{{c.categoryID}}" v-for="c in cate3"
                                                            v-on:click="getcategory1(3,c.categoryID)">@{{c.enName}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="width: 25%;float: left">
                                                <label>四级分类</label>
                                                <select multiple class="form-control">
                                                    <option v-on:click="select()">选择四级分类</option>
                                                    <option value="@{{c.categoryID}}" v-for="c in cate4"
                                                            v-on:click="getcategory1(4,c.categoryID)">@{{c.enName}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: 600">基本信息</label>

                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label>
                                                        <input type="checkbox" id="shenhe" class="icheck"> 审核通过的产品
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: 600">详细信息</label>

                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label>
                                                        <input type="checkbox" id="detail" class="icheck"> 产品详细信息
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="font-weight: 600">图片信息</label>

                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label>
                                                        <input type="checkbox" id="pic" class="icheck"> 产品图片 </label>
                                                </div>
                                            </div>
                                        </div>
                                       <!-- <div class="form-group">
                                            <label style="font-weight: 600">橱窗产品</label>

                                            <div class="input-group">
                                                <div class="icheck-list">
                                                    <label>
                                                        <input type="checkbox" id="chuchuang" class="icheck"> 橱窗产品
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="form-actions">
                                            <input type="hidden" id="rid" value="123">
                                            {{--  <button type="button" v-on:click="save" class="btn green-haze">开始同步</button>--}}
                                            {{--  <a href="/tb">aaaaaa</a>--}}
                                            <button type="button" v-on:click="update" class="btn green-haze">开始同步
                                            </button>
                                            &nbsp;&nbsp;&nbsp;
                                            <button type="button" class="btn default" onclick="func_action('aa')">取消同步
                                            </button>
                                        </div>
                                        <!--<div class="form-group">
                                            <label>基本信息</label>
                                            <div class="input-group">
                                                <div class="icheck-inline">
                                                    <label>
                                                        <input type="checkbox" class="icheck"> 审核通过的产品 </label>
                                                    <label>
                                                        <input type="checkbox" checked class="icheck"> 审核通过的产品
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" class="icheck"> 审核通过的产品 </label>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--   <table class="table table-striped table-bordered table-hover" id="sample_1">
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
                    <!--  <div class="icheck-inline">
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
          </table>-->

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->


    </div>


</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var i = 0;
    jQuery(document).ready(function () {
        //Metronic.init(); // init metronic core components
        //FormiCheck.init(); // init page demo
    });
    var total = 0;
    var count = 0;
    var d;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#func1',
        data: {
            grous: '',
            pageno: 0,
            totalcount: '',
            totalpage: '',
            cate1: '',
            cate2: '',
            cate3: '',
            cate4: '',
            cateid: ''
        },
        ready: function () {
            this.getcategory();
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
            select: function () {
                this.$set('cateid', '');
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
            update1: function () {
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
                status = 2;
                if ($("#chuchuang").attr("checked") == 'checked') {
                    chuchuang = 1;
                } else {
                    chuchuang = 2;
                }
                cateid = $("#cateid").val();
                senddata = {
                    shenhe: shenhe,
                    detail: detail,
                    pic: pic,
                    status: status,
                    chuchuang: chuchuang,
                    cateid: cateid
                };
                // d = window.setInterval(this.ajaxlink, 500);
                var index = layer.msg('数据同步中...', {icon: 16, time: false});
                this.$http.get('/tb', senddata, function (data) {
                    if (eval(data).code == '101') {
                        layer.close(index);
                        Alert2('同步完成');
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            update: function () {
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
                status = 2;
                /*if ($("#chuchuang").attr("checked") == 'checked') {
                    chuchuang = 1;
                } else {
                    chuchuang = 2;
                } */
				chuchuang=2;
                senddata = {
                    shenhe: shenhe,
                    detail: detail,
                    pic: pic,
                    status: status,
                    chuchuang: chuchuang,
                    cateid: this.cateid,
                    pageno: this.pageno
                };
                if (this.pageno == 0) {
                    var index = layer.msg('数据同步中...', {icon: 16, time: false});
                }
                this.$http.get('/tb', senddata, function (data) {
                    if (eval(data).code == '101') {
                        if (this.pageno == 0) {
                            totalcount = eval(data).totalcount;
                            totalpage = eval(data).totalpage;
                            this.$set('totalcount', totalcount);
                            this.$set('totalpage', totalpage);
                        }
                        if (totalcount == 0) {
                            layer.close(index);
                            Alert2('没有要同步的产品');
                        } else {
                            count = eval(data).count;
                            pageno = eval(data).pageno;
                            this.$set('pageno', pageno);
                            msg = count + '/' + this.totalcount + ' 数据同步中...';
                            var index = layer.msg(msg, {icon: 16, time: false});
                            if (pageno > totalpage || count >= totalcount) {
                                layer.closeAll();
                                Alert2('同步完成');

                            } else {
                                this.update();
                            }

                            /* if (eval(data).count >= eval(data).totalcount) {
                             layer.closeAll();
                             Alert2('同步完成');
                             } else {
                             this.update();
                             } */
                        }

                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            grouplist: function () {
                this.$http.get('/getgrouplist', function (data) {
                    this.$set('groups', eval(data));
                })
            },
            getcategory: function () {
                this.$http.get('/getcategorylist/0', function (data) {
                    this.$set('cate1', eval(data));
                })
            },
            getcategory1: function (type, cateid) {
                this.$set('cateid', cateid);
                this.$http.get('/getcategorylist/' + cateid, function (data) {
                    if (type == 1) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate2', '');
                            this.$set('cate3', '');
                            this.$set('cate4', '');
                        } else {
                            this.$set('cate2', eval(data));
                        }
                    } else if (type == 2) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate3', '');
                        } else {
                            this.$set('cate3', eval(data));
                        }
                    } else if (type == 3) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate4', '');
                        } else {
                            this.$set('cate4', eval(data));
                        }
                    } else {
                        this.cateid = cateid;
                    }
                })
            },
        }
    })
</script>