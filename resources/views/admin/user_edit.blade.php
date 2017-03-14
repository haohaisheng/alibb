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
            <a href="#1" onclick="func_action('{{$action}}')">用户管理</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">用户编辑</a>
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
                    <i class="fa fa-gift"></i> 用户编辑
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
                            <label class="col-md-3 control-label">登录账号</label>

                            <div class="col-md-9">
                                <input type="hidden" id="uid" value="{{$user->id}}">
                                <input type="text" class="form-control input-inline input-medium" id="uacc"
                                       value="{{$user->account}}" disabled
                                       placeholder="登录账号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">用户名称</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="unme"
                                       value="{{$user->name}}"
                                       placeholder="用户名称"><span style="color: red">*</span>
												<span class="help-inline" style="color:red;display: none"
                                                      id="unmeerror">用户名不能为空
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">手机号</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="phone"
                                       value="{{$user->phone}}"
                                       placeholder="手机号"><span style="color: red">*</span>
												<span class="help-inline" style="color:red;display: none"
                                                      id="phoneerror">手机号不能为空
												</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">年龄</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="age"
                                       value="{{$user->age}}"
                                       placeholder="年龄">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">邮箱地址</label>

                            <div class="col-md-9">
                                <div class="input-group">
													<span class="input-group-addon">
													<i class="fa fa-envelope"></i>
													</span>
                                    <input type="email" class="form-control" placeholder="邮箱地址" id="uem"
                                           value="{{$user->email}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">地址</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="address"
                                       value="{{$user->address}}"
                                       placeholder="地址">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile" class="col-md-3 control-label">上传头像</label>

                            <div class="col-md-9">
                                <input type="file" id="upic">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">性别</label>

                            <div class="col-md-9">
                                <div class="radio-list">
                                    @if ($user->sex==1)
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="sex" value="1"
                                                   checked> 男 </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="sex" value="2"> 女 </label>
                                    @else
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="sex" value="1"> 男 </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="sex" value="2"
                                                   checked> 女 </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">状态</label>

                            <div class="col-md-9">
                                <div class="radio-list">
                                    @if ($user->status=='y')
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="y"
                                                   checked> 可用 </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="n"> 禁用 </label>
                                    @else
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="y"> 可用 </label>
                                        '
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="n"
                                                   checked> 禁用 </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">说明</label>

                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="备注说明......"
                                          id="remark">{{$user->remark}}</textarea>
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
            sub: function () {
                var uid = $("#uid").val().trim();
                var unme = $("#unme").val().trim();
                var uacc = $("#uacc").val().trim();
                var phone = $("#phone").val().trim();
                var age = $("#age").val().trim();
                var uem = $("#uem").val().trim();
                var address = $("#address").val().trim();
                var remark = $("#remark").val().trim();
                var status, sex = '';
                var sexck = document.getElementsByName("sex");
                for (var i = 0; i < sexck.length; i++) {
                    if (sexck[i].checked) {
                        sex = sexck[i].value;
                    }
                }
                var statusck = document.getElementsByName("status");
                for (var i = 0; i < statusck.length; i++) {
                    if (statusck[i].checked) {
                        status = statusck[i].value;
                    }
                }
                if (uacc == '') {
                    erro("uaccerror", 1);
                } else {
                    erro("uaccerror", 2);
                }
                if (unme == '') {
                    erro("unmeerror", 1);
                } else {
                    erro("unmeerror", 2);
                }
                if (phone == '') {
                    erro("phoneerror", 1);
                } else {
                    erro("phoneerror", 2);
                }
                senddata = {
                    uid: uid,
                    uacc: uacc,
                    unme: unme,
                    uem: uem,
                    sex: sex,
                    phone: phone,
                    age: age,
                    address: address,
                    status: status,
                    remark: remark
                };
                this.$http.post('/edituser', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert2('操作成功', '/user');
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