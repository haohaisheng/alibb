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
            <a href="#">菜单编辑</a>
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
                    <i class="fa fa-gift"></i> 菜单编辑
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
                <form class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单名称</label>

                            <div class="col-md-9">
                                <input type="hidden" id="mid" value="{{$menu->menu_id}}">
                                <input type="text" class="form-control input-inline input-medium" id="mname"
                                       placeholder="菜单名称" value="{{$menu->menu_name}}">
												<span class="help-inline" id="merror" style="color:red;display: none">填写菜单名称
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单路径</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="murl"
                                       placeholder="菜单路径" value="{{$menu->menu_url}}">
												<span class="help-inline" id="murlerror"
                                                      style="color:red;display: none">填写菜单路径
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">父级菜单</label>

                            <div class="col-md-9">
                                <select class="form-control" id="fid">
                                    <option value="0">顶级菜单</option>
                                    @foreach ($menus as $m)
                                        @if ($m->menu_id == $menu->fid)
                                            <option value="{{$m->menu_id}}"
                                                    selected="selected">{{$m->menu_name}}</option>
                                        @else
                                            <option value="{{$m->menu_id}}">{{$m->menu_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">菜单排序</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="msort"
                                       placeholder="菜单排序" value="{{$menu->sort}}">
												<span class="help-inline" id="msorterror"
                                                      style="color:red;display: none">填写菜单顺序
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>

                            <div class="col-md-9">
                                <div class="radio-list">
                                    @if ($menu->status=='y')
                                        <label class="radio-inline">
                                            <input type="radio" name="optionsRadios1" id="status" value="y"
                                                   checked> 可用 </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optionsRadios1" id="status" value="n"> 禁用 </label>
                                    @else
                                        <label class="radio-inline">
                                            <input type="radio" name="optionsRadios1" id="status" value="y"> 可用 </label>
                                        '
                                        <label class="radio-inline">
                                            <input type="radio" name="optionsRadios1" id="status" value="n"
                                                   checked> 禁用 </label>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="button" class="btn green" v-on:click="sub">提交</button>
                                <button type="button" class="btn default" onclick="func_action('{{$action}}')">取消</button>
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
                var mid = $("#mid").val().trim();
                var status = '';
                var chk = document.getElementsByName("optionsRadios1");
                for (var i = 0; i < chk.length; i++) {
                    if (chk[i].checked) {
                        status = chk[i].value;
                    }
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
                    fid: fid,
                    mid: mid,
                    mname: mname,
                    murl: murl,
                    sort: msort,
                    status: status
                };
                this.$http.post('/editmenu', senddata, function (data) {
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