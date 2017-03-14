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
            <a href="#1" onclick="func_action('{{$action}}')">角色管理</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">添加角色</a>
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
                    <i class="fa fa-gift"></i> 添加角色
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
                            <label class="col-md-3 control-label">角色名称</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="rname"
                                       placeholder="菜单名称">
												<span class="help-inline" id="rerror" style="color:red;display: none">填写角色名称
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
                var rname = $("#rname").val().trim();
                var status = $("#status").val().trim();
                if (rname == '') {
                    erro("rerror", 1);
                } else {
                    erro("rerror", 2);
                }
                senddata = {
                    rname: rname,
                    status: status
                };
                this.$http.post('/saverole', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert2('操作成功', '/role');
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