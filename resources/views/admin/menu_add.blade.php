<link href="../../admin/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
      type="text/css">
<style>
    .col-md-9 {
        /*width: 75%;*/
        width: auto;
    }
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
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
            <a href="#1" onclick="func_action('{{$action}}')">菜单管理</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">添加菜单</a>
        </li>
    </ul>
</div>
<!-- BEGIN PAGE CONTENT-->
<div class="row" id="app">
    <div class="col-md-6" style="width: 100%">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box green ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 添加菜单
                </div>
                <div class="tools">
                    <a href="" class="collapse">
                    </a>
                    <a href="#portlet-config" data-toggle="modal" class="config">
                    </a>
                    <a href="" class="reload">
                    </a>
                    <a href="" class="remove">
                    </a>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单名称</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="mname"
                                       placeholder="菜单名称">
												<span class="help-inline" id="merror" style="color:red;display: none">填写菜单名称
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单路径</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="murl"
                                       placeholder="菜单路径">
												<span class="help-inline" id="murlerror"
                                                      style="color:red;display: none">填写菜单路径
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">父级菜单</label>

                            <div class="col-md-9">
                                <select class="form-control" id="fid" onchange="">
                                    <option value="0">顶级菜单</option>
                                    @foreach ($menus as $m)
                                        <option value="{{$m->menu_id}}">{{$m->menu_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group" id="ico">
                            <label class="col-md-3 control-label">图标选择</label>

                            <div class="col-md-9">
                                @include('admin.icon')
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单排序</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="msort"
                                       placeholder="菜单排序">
												<span class="help-inline" id="msorterror"
                                                      style="color:red;display: none">填写菜单顺序
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>

                            <div class="col-md-9">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadios1" id="status" value="y"
                                               checked> 可用 </label>'
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadios1" id="status" value="n"
                                               checked> 禁用 </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="button" class="btn green" v-on:click="sub">提交</button>
                                <button type="button" class="btn default" onclick="func_action('{{$action}}')">取消
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $("#fid").change(function () {
            if ($("#fid").val() == 0)
                $("#ico").show();
            else
                $("#ico").hide();
        });
    });
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
        data: '',
        methods: {
            sub: function (event) {
                var mname = $("#mname").val().trim();
                var murl = $("#murl").val().trim();
                var msort = $("#msort").val().trim();
                var fid = $("#fid").val().trim();
                var status = $("#status").val().trim();
                if (fid == 0) {
                    var icon = $("#checkico").attr("value");
                } else {
                    var icon = '';
                }
                if (mname == '') {
                    erro("merror", 1);
                } else {
                    erro("merror", 2);
                }
                if (murl == '') {
                    erro("murlerror", 1);
                } else {
                    erro("murlerror", 2);
                }
                if (msort == '') {
                    erro("msorterror", 1);
                } else {
                    erro("msorterror", 2);
                }
                senddata = {
                    mname: mname,
                    murl: murl,
                    fid: fid,
                    sort: msort,
                    status: status,
                    icon: icon
                };
                this.$http.post('/savemenu', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert2('操作成功', '/menu');
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            }
        }
    })
    function erro(id, type) {
        if (type == 1) {
            $("#" + id).css("display", "inline-block");
            return false;
        } else {
            $("#" + id).css("display", "none");
        }
    }
</script>