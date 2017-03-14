<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                Widget settings form goes here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn blue">Save changes</button>
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
            <li><a href="#1">菜单管理</a></li>
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
                <div class="caption"><i class="fa fa-user"></i>菜单管理</div>
                <div class="actions">
                    <a href="#" class="btn blue" onclick="func_action('/menucreate')"><i class="fa fa-pencil"></i> 添加</a>

                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i> 更多操作
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a v-on:click="del"><i class="fa fa-trash-o"></i> 删除</a></li>
                            <li><a><i class="fa fa-ban"></i> 禁用</a></li>
                            <!-- <li class="divider"></li>
                            <li><a href="#"><i class="i"></i> Make admin</a></li> -->
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
                                   v-on:click="checkall"/></span>
                            </div>
                        </th>
                        <th>菜单名称</th>
                        <th>菜单路径</th>
                        <th>父级菜单</th>
                        <th>排序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes"
                                                              id="@{{list.menu_id}}" name="chk"
                                                              v-on:click="check(list.menu_id)"/></span></div>
                        </td>
                        <td>@{{list.menu_name}}</td>
                        <td>@{{list.menu_url}}</td>
                        <td>@{{list.fname}}</td>
                        <td>@{{list.sort}}</td>
                        <td>
                            <span v-if="list.status=='y'" class="label label-sm label-success">正常</span>
                            <span v-else class="label label-sm label-default">禁用</span>
                        </td>
                        <td>
                            <a v-on:click="edit(list.menu_id)" class="btn default btn-xs purple"><i
                                        class="fa fa-edit"></i> 编辑</a>&nbsp;&nbsp;&nbsp;
                            <a v-if="list.status=='y'" v-on:click="disab" id="@{{list.menu_id}}|n"
                               class="btn default btn-xs black"><i
                                        class="fa fa-trash-o"></i> 禁用</a>
                            <a v-else v-on:click="disab" id="@{{list.menu_id}}|y"
                               class="btn default btn-xs black"><i
                                        class="fa fa-trash-o"></i> 启用</a>
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
                            <a v-on:click="list(index)">@{{ index }}</a>
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
    //var menuid = '';
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
            this.list(this.cur);
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
                this.$http.post('/menustatus', senddata, function (data) {
                    if (eval(data).code) {
                        Alert1('操作成功');
                        this.list(this.cur);
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            list: function (index) {
                this.cur = index;
                senddata = {page: index};
                this.$http.get('/getmenus', senddata, function (data) {
                    this.$set('lists', eval(JSON.stringify(data.data)));
                    this.$set('all', eval(JSON.stringify(data.last_page)));
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            checkall: function (event) {
                if (event.target.checked) {
                    event.target.parentNode.className = "checked";
                    var flag = true;
                } else {
                    event.target.parentNode.className = ""
                    var flag = false;
                }
                $("input[name='chk']").each(function () {
                    $(this).attr("checked", flag);
                    vm.check($(this).attr("id"));
                })
            },
            del: function (index) {
                var menuid = '';
                $("input[name='chk']").each(function () {
                    if ($(this).attr("checked")) {
                        menuid += $(this).attr("id") + ",";
                    }
                })
                menuid = menuid.substring(0, menuid.length - 1);
                senddata = {mid: menuid};
                /* alert(menuid);
                 return false;*/
                this.$http.post('/delmenu', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert1('操作成功');
                        this.list(this.cur);
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            check: function (mid) {
                if ($("#" + mid).attr("checked")) {
                    $("#" + mid).parents("span").attr("class", "checked");
                    $("#" + mid).parents("tr").attr("class", "gradeX odd active");
                } else {
                    $("#" + mid).parents("span").attr("class", "");
                    $("#" + mid).parents("tr").attr("class", "gradeX odd");
                }
            },
            edit: function (mid) {
                func_action('/menueditcreate/' + mid);
            },
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        }
    })
</script>