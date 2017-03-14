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
            <a href="#">用户管理</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">用户详细信息</a>
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
                    <i class="fa fa-gift"></i> 用户详细信息
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


            <div class="portlet light">
                <div class="portlet-body">

                    <div class="row">
                        <div class="col-md-12">
                            <table id="user" class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td style="width:10%">
                                        用户账号
                                    </td>
                                    <td style="width:60%">
                                        <a href="javascript:;" id="username" data-type="text" data-pk="1"
                                           data-original-title="Enter username" class="editable editable-click">
                                            {{$user->account}} </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        用户名称
                                    </td>
                                    <td>
                                        <a href="javascript:;" id="firstname" data-type="text" data-pk="1"
                                           data-placement="right" data-placeholder="Required"
                                           data-original-title="Enter your firstname"
                                           class="editable editable-click editable-empty">{{$user->name}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        用户头像
                                    </td>
                                    <td style="height:100px;">
                                        <a class="editable editable-click editable-empty">{{$user->name}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        性别
                                    </td>
                                    <td>
                                        @if ($user->sex=='1')
                                            <a data-type="select" data-pk="1" data-value="5"
                                               data-source="/groups" data-original-title="Select group"
                                               class="editable editable-click">
                                                男 </a>
                                        @else
                                            <a data-type="select" data-pk="1" data-value="5"
                                               data-source="/groups" data-original-title="Select group"
                                               class="editable editable-click">
                                                女 </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        年龄
                                    </td>
                                    <td>
                                        <a data-type="select" data-pk="1" data-value="5"
                                           data-source="/groups" data-original-title="Select group"
                                           class="editable editable-click">
                                            {{$user->age}} </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        手机号
                                    </td>
                                    <td>
                                        <a data-type="select" data-pk="1" data-value="0"
                                           data-source="/status" data-original-title="Select status"
                                           class="editable editable-click">
                                            {{$user->phone}} </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        邮箱
                                    </td>
                                    <td>
                                        <a class="editable editable-click">{{$user->email}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        地址
                                    </td>
                                    <td>
                                        <a class="editable editable-click">{{$user->address}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        创建时间
                                    </td>
                                    <td>
                                        <a class="editable editable-click editable-empty">{{$user->time}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        可用状态
                                    </td>
                                    <td>
                                        @if ($user->sex=='y')
                                            <a class="editable editable-click">正常</a>
                                        @else
                                            <a class="editable editable-click">禁用</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        备注说明
                                    </td>
                                    <td style="height:120px;">
                                        <a>{{$user->remark}} </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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