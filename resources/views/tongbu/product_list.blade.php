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
            <li><a href="#">产品管理</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row" id="app">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>产品管理</div>
                <div class="actions">
                <!--  <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label>
                            <select class="form-control" id="cateid" onchange=""
                                    style="height:27px;width:150px;line-height: 27px;padding:0 12px;">
                                <option value="">全部类目</option>
                                <option value="@{{g.groupid}}" v-for="g in groups">@{{g.groupid}}</option>
                            </select>
                        </label>
                    </div> -->
                    <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label><input style="height: 27px;width:200px;" id="key" aria-controls="sample_1"
                                      placeholder="输入关键词查询"
                                      class="form-control  input-inline" type="search"></label>
                    </div>
                    <button v-on:click="list(1,'search')" class="btn btn-sm yellow filter-submit margin-bottom"><i
                                class="fa fa-search"></i> 搜索
                    </button>
                    <a v-on:click="add()" class="btn blue"><i class="fa fa-pencil"></i> 复制发布</a>
                    <a v-on:click="batch()" class="btn blue"><i class="fa fa-pencil"></i> 批量编辑</a>
                    <a v-on:click="updategroup()" class="btn yellow"><i class="fa fa-pencil"></i> 更新分组</a>
                    <a v-on:click="list(1,'approved')" class="btn blue"><i class="fa fa-pencil"></i> 通过审核</a>
                    <a v-on:click="list(1,'auditing')" class="btn blue"><i class="fa fa-pencil"></i> 审核中</a>

                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i> 更多操作
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <!-- <li><a><i class="fa fa-pencil"></i> 编辑</a></li>  -->
                            <li v-on:click="deletePro"><a><i class="fa fa-trash-o"></i> 删除</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th class="table-checkbox" style="width1:8px;">
                            <div class="checker"><span>
                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"
                                   v-on:click="chkall"/></span>
                            </div>
                        </th>
                        <th width="20%">商品标题</th>
                        <th>商品型号</th>
                        <th>商品状态</th>
                        <th>发布日期</th>
                        <th>修改日期</th>
                        <th>所属分组</th>
                        <th>商品类目</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1" name="chk"
                                                              style="cursor:pointer"
                                                              id="@{{list.productID}}"
                                                              v-on:click="chk"/></span></div>
                        </td>
                        <td>@{{list.subject}}</td>
                        <td>@{{list.xinghao}}</td>
                        <td>
                            <span v-if="list.status=='auditing'" class="label label-sm label-success">审核中</span>
                            <span v-if="list.status=='online'" class="label label-sm label-success">已上网</span>
                            <span v-if="list.status=='FailAudited'" class="label label-sm label-danger">审核未通过</span>
                            <span v-if="list.status=='published'" class="label label-sm label-success">已发布</span>
                            <span v-if="list.status=='delete'" class="label label-sm label-success">审核删除</span>
                            <span v-if="list.status=='approved'" class="label label-sm label-success">审核通过</span>
                            <span v-if="list.status=='modified'" class="label label-sm label-warning">修改待审核</span>
                            <span v-if="list.status=='member delete(d)'"
                                  class="label label-sm label-success">用户删除</span>
                            {{--<span v-else class="label label-sm label-default">禁用</span>--}}
                        </td>
                        <td>@{{list.createTime}}</td>
                        <td>@{{list.lastUpdateTime}}</td>
                        <td>@{{list.groupname}}</td>
                        <td>@{{list.catename}}</td>
                        <td>
                            <a v-on:click="reset(list.productID,list.lastUpdateTime)" class="btn default btn-xs blue"><i
                                        class="fa fa-history"></i>
                                同步</a>&nbsp;&nbsp;&nbsp;
                            <!--  <a v-on:click="info(list.productID)" class="btn default btn-xs blue"><i
                                          class="fa fa-share"></i> 详情</a>&nbsp;&nbsp;&nbsp; -->
                            <a v-on:click="batchone(list.productID)" class="btn default btn-xs purple"><i
                                        class="fa fa-edit"></i>
                                编辑</a>&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="dataTables_paginate paging_bootstrap">
                    <ul class="pagination" style="visibility: visible;">
                        <li class="prev disabled"><a href="#" title="Previous"><i class="fa fa-angle-left"></i></a>
                        </li>
                        <li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                            <a v-on:click="list(index,'defa')">@{{ index }}</a>
                        </li>
                        <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                        <li><a>共<i>@{{all}}</i>页</a></li>
                        <!--  <li><a><i><input style="height: 17px;width:50px;" id="tiao" type="text"></i></a></li>
                          <li><a v-on:click="go()"><i>GO</i></a></li> -->
                    </ul>
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
    var type = 'online';
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
        data: {
            lists: '',
            all: '',
            cur: 1,
            grous: ''
        },
        ready: function () {
            this.list(this.cur, 'all');
        },
        computed: {
            indexs: pageinit,
            showLast: function () {
                if (this.cur == this.all) {
                    return false
                }
                return true
            },
            showFirst: function () {
                if (this.cur == 1) {
                    return false
                }
                return true
            }
        },
        methods: {
            disab: function (event) {
                senddata = {
                    uid: event.target.id.split('|')[0],
                    status: event.target.id.split('|')[1]
                };
                this.$http.post('/updatestatus', senddata, function (data) {
                    if (eval(data).code) {
                        Alert1('操作成功');
                        this.list(this.cur);
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            list: function (index, status) {
                this.cur = index;
                if (status == 'defa') {
                    status = type;
                }
                type = status;
                if (status == 'search') {
                    key = $("#key").val();
                    cateid = $("#cateid").val();
                    senddata = {page: index, key: key, cateid: cateid};
                    this.$http.get('/search', senddata, function (data) {
                        this.$set('lists', eval(JSON.stringify(data.data)));
                        this.$set('all', eval(JSON.stringify(data.last_page)));
                    }).error(function (data, status, request) {
                        console.log('fail' + status + "," + request);
                    })
                } else {
                    senddata = {page: index, status: status};
                    this.$http.get('/getproduct', senddata, function (data) {
                        this.$set('lists', eval(JSON.stringify(data.data)));
                        this.$set('all', eval(JSON.stringify(data.last_page)));
                    }).error(function (data, status, request) {
                        console.log('fail' + status + "," + request);
                    })
                }
            },
            go: function () {
                var tiao = $("#tiao").val();
                this.list(tiao, type);
            },
            chk: function (event) {
                var checkid = event.target.id;
                if (event.target.checked) {
                    event.target.parentNode.className = "checked";
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                    $("#" + checkid).attr("checked", true);
                } else {
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd ";
                    event.target.parentNode.className = "";
                    $("#" + checkid).attr("checked", false);
                }
            },
            chkall: function (event) {
                if (event.target.checked) {
                    event.target.parentNode.className = "checked"
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                    $("input[name='chk']").each(function (i) {
                        id = $(this).attr("id");
                        $("#" + id).attr("checked", true);
                        document.getElementById(id).parentNode.className = "checked";
                        document.getElementById(id).parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                    })
                } else {
                    event.target.parentNode.className = ""
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd ";
                    $("input[name='chk']").each(function (i) {
                        id = $(this).attr("id");
                        $("#" + id).attr("checked", false);
                        document.getElementById(id).parentNode.className = "";
                        document.getElementById(id).parentNode.parentNode.parentNode.parentNode.className = "gradeX odd";
                    })
                }
            },
            add: function () {
                id = '';
                if ($("input[name='chk']:checked").length > 1) {
                    Alert5('只能选择一个产品复制');
                    return false;
                }
                if ($("input[name='chk']:checked").length < 1) {
                    Alert5('先选择一个产品');
                    return false;
                }
                if ($("input[name='chk']:checked").length == 1) {
                    var index = layer.msg('正在处理...', {icon: 16, time: 1000});
                    $("input[name='chk']").each(function (i) {
                        id = $(this).attr("id");
                    })
                    func_action('/fabu_count/' + id);
                }
            },
            edit: function (uid) {
                func_action('/usereditcreate/' + uid);
            },
            reset: function (proid, lastUpdateTime) {
                layer.msg('确定要同步吗？', {
                    icon: 6,
                    time: 0,
                    btn: ['确定', '取消'],
                    yes: function (index) {
                        layer.close(index);
                        senddata = {productid: proid, lastupdatetime: lastUpdateTime};
                        var index = layer.msg('数据更新中...', {icon: 16, time: false});
                        vm.$http.get('/updateProduct', senddata, function (data) {
                            if (eval(data).code == 101) {
                                layer.close(index);
                                this.list(this.cur, 'all');
                                Alert1('更新成功');
                            } else if (eval(data).code == 102) {
                                layer.close(index);
                                Alert1('无此产品信息');
                            } else if (eval(data).code == 103) {
                                layer.close(index);
                                Alert1('该产品无更新');
                            }
                        }).error(function (data, status, request) {
                            console.log('fail' + status + "," + request);
                        })
                    }
                });
            },
            info: function (uid) {
                func_action('/userinfo/' + uid);
            },
            func: function (uid) {
                layer.open({
                    type: 2,
                    area: ['500px', '350px'],
                    fix: false, //不固定
                    maxmin: true,
                    content: '/userfunc/' + uid
                });
            },
            grouplist: function () {
                this.$http.get('/getgrouplist', function (data) {
                    this.$set('groups', eval(data));
                })
            },
            batch: function () {
                var ids = new Array();
                $("input[name='chk']").each(function (i) {
                    if ($(this).attr("checked")) {
                        ids.push($(this).attr("id"));
                    }
                });
                if (ids.length < 1) {
                    Alert5('至少选择一个产品');
                    return false;
                }
                var index = layer.msg('正在处理...', {icon: 16, time: 1000});
                senddata = {ids: ids, _token: document.getElementsByTagName('meta')['_token'].content};
                func_action_data('/batch', senddata);
            },
            batchone: function (id) {
                var ids = new Array();
                ids.push(id);
                var index = layer.msg('数据处理中...', {icon: 16, time: 1000});
                senddata = {ids: ids, _token: document.getElementsByTagName('meta')['_token'].content};
                func_action_data('/batch', senddata);
            },
            deletePro: function () {
                var ids = new Array();
                $("input[name='chk']").each(function (i) {
                    if ($(this).attr("checked")) {
                        ids.push($(this).attr("id"));
                    }
                });
                if (ids.length < 1) {
                    Alert5('至少选择一个产品');
                    return false;
                }
                layer.confirm('将同步删除国际站产品,确认删除吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    var index = layer.msg('数据处理中...', {icon: 16, time: false});
                    senddata = {ids: ids};
                    $.get("/deleteproduct", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('删除成功');
                            this.list(this.cur, 'all');
                        }
                    });
                }, function () {
                    return false;
                });
            },
            updategroup: function () {
                var index = layer.msg('分组信息更新中...', {icon: 16, time: false});
                $.get("/getgroup1/-1", function (result) {
                    if (eval(result).code == 101) {
                        layer.close(index);
                        Alert1('更新成功');
                        this.list(this.cur, 'all');
                    }
                });
            }
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        }
    })
    Vue.filter('reverse', function (value) {
        if (value == 1) {
            return '男';
        } else {
            return '女';
        }
    })
</script>