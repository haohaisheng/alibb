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
            <li><a href="#">今日操作</a></li>
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
                <div class="caption"><i class="fa fa-user"></i>今日操作</div>
                <div class="actions">
                    <!-- <div class="icheck-list" style="float:left;margin-right: 8px;">
                         <label>
                             <select class="form-control" id="cateid" onchange=""
                                     style="height:27px;width:150px;line-height: 27px;padding:0 12px;">
                                 <option value="">全部类目</option>
                                 <option value="134334">食品</option>
                                 <option value="223124">衣服鞋帽</option>
                                 <option value="100372">电子器材</option>
                             </select>
                         </label>
                     </div> -->
                    <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label><input style="height: 27px;width:200px;" id="key" aria-controls="sample_1"
                                      placeholder="输入关键词查询"
                                      class="form-control  input-inline" type="search"></label>
                    </div>
                    <button v-on:click="search(1,'search')" class="btn btn-sm yellow filter-submit margin-bottom"><i
                                class="fa fa-search"></i> 搜索
                    </button>
                    <a v-on:click="list(1,'create')" class="btn blue"><i class="fa fa-pencil"></i> 今日发布</a>
                    <a v-on:click="list(1,'update')" class="btn blue"><i class="fa fa-pencil"></i> 今日修改</a>
                    <a v-on:click="list(1,'flash')" class="btn blue"><i class="fa fa-pencil"></i> 今日刷新</a>

                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i> 更多操作
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <!-- <ul class="dropdown-menu pull-right">
                             <li><a><i class="fa fa-pencil"></i> 编辑</a></li>
                             <li><a><i class="fa fa-trash-o"></i> 删除</a></li>
                             <li><a><i class="fa fa-ban"></i> 禁用</a></li>
                         </ul> -->
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
                                   v-on:click="chk"/></span>
                            </div>
                        </th>
                        <th width="20%">商品标题</th>
                        <th>商品型号</th>
                        <th>商品状态</th>
                        <th>发布日期</th>
                        <th>更新日期</th>
                        <th>所属分组</th>
                        <th>商品类目</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"
                                                              v-on:click="chk"/></span></div>
                        </td>
                        <td>@{{list.subject}}</td>
                        <td>@{{list.xinghao}}</td>
                        <td>
                            <span v-if="list.status=='auditing'" class="label label-sm label-success">审核中</span>
                            <span v-if="list.status=='online'" class="label label-sm label-success">已上网</span>
                            <span v-if="list.status=='FailAudited'" class="label label-sm label-success">审核未通过</span>
                            <span v-if="list.status=='published'" class="label label-sm label-success">已发布</span>
                            <span v-if="list.status=='delete'" class="label label-sm label-success">审核删除</span>
                            <span v-if="list.status=='approved'" class="label label-sm label-success">审核通过</span>
                            <span v-if="list.status=='member delete(d)'"
                                  class="label label-sm label-success">用户删除</span>
                        </td>
                        <td>@{{list.createTime}}</td>
                        <td>@{{list.lastUpdateTime}}</td>
                        <td>@{{list.groupname}}</td>
                        <td>@{{list.catename}}</td>
                        <td>
                            <a v-on:click="reset(list.productID)" class="btn default btn-xs blue"><i
                                        class="fa fa-history"></i>
                                同步</a>
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
    var type = 'edit';
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
        },
        ready: function () {
            this.list(this.cur, 'today');
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
            /*list: function (index, status) {
             this.cur = index;
             if (status == 'defa') {
             status = type;
             }
             type = status;
             if (status == 'search') {
             key = $("#key").val();
             cateid = $("#cateid").val();
             senddata = {page: index, key: key, cateid: cateid};
             this.$http.get('/search_today', senddata, function (data) {
             this.$set('lists', eval(JSON.stringify(data.data)));
             this.$set('all', eval(JSON.stringify(data.last_page)));
             })
             } else {
             senddata = {page: index, status: status};
             this.$http.get('/todayproduct', senddata, function (data) {
             this.$set('lists', eval(JSON.stringify(data.data)));
             this.$set('all', eval(JSON.stringify(data.last_page)));
             })
             }
             }, */
            list: function (index, status) {
                this.cur = index;
                if (status == 'defa') {
                    status = type;
                }
                type = status;
                senddata = {page: index, status: status};
                this.$http.get('/todayproduct', senddata, function (data) {
                    this.$set('lists', eval(JSON.stringify(data.data)));
                    this.$set('all', eval(JSON.stringify(data.last_page)));
                })
            },
            search: function (index, status) {
                key = $("#key").val();
                cateid = $("#cateid").val();
                senddata = {page: index, key: key, cateid: cateid};
                this.$http.get('/search_today', senddata, function (data) {
                    this.$set('lists', eval(JSON.stringify(data.data)));
                    this.$set('all', eval(JSON.stringify(data.last_page)));
                })
            },
            chk: function (event) {
                if (event.target.checked) {
                    event.target.parentNode.className = "checked";
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                } else {
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd ";
                    event.target.parentNode.className = ""
                }
            },
            add: function () {
                func_action('/usercreate');
            },
            edit: function (uid) {
                func_action('/usereditcreate/' + uid);
            },
            reset: function (proid) {
                layer.msg('确定要同步吗？', {
                    icon: 6,
                    time: 0,
                    btn: ['确定', '取消'],
                    yes: function (index) {
                        layer.close(index);
                        senddata = {productid: proid};
                        var index = layer.msg('数据更新中...', {icon: 16});
                        vm.$http.get('/updateProduct', senddata, function (data) {
                            if (eval(data).code == '101') {
                                layer.close(index);
                                Alert1('更新成功');
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