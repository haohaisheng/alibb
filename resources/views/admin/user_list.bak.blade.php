<meta name="_token" content="{{csrf_token()}}"/>
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
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">Data Tables</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li><a href="#">Managed Datatables</a></li>
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
                <div class="caption"><i class="fa fa-user"></i>Table</div>
                <div class="actions">
                    <a href="#" class="btn blue"><i class="fa fa-pencil"></i> 添加</a>

                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i> 更多操作
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#"><i class="fa fa-pencil"></i> 编辑</a></li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> 删除</a></li>
                            <li><a href="#"><i class="fa fa-ban"></i> 禁用</a></li>
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
                                   v-on:click="cstyle"/></span>
                            </div>
                        </th>
                        <th>姓名</th>
                        <th>账号</th>
                        <th>性别</th>
                        <th>年龄</th>
                        <th>phone</th>
                        <th>地址</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"
                                                              v-on:click="cstyle"/></span></div>
                        </td>
                        <td>@{{list.name}}</td>
                        <td>@{{list.account}}</td>
                        <td>@{{list.sex|reverse}}</td>
                        <td>@{{list.age}}</td>
                        <td>@{{list.phone}}</td>
                        <td>@{{list.address}}</td>
                        <td>
                            <span v-if="list.status=='y'" class="label label-sm label-success">正常</span>
                            <span v-else class="label label-sm label-default">禁用</span>
                        </td>
                        <td>@{{list.time}}</td>
                        <td>
                            <a href="#" class="btn default btn-xs blue"><i class="fa fa-share"></i> 详情</a>&nbsp;&nbsp;&nbsp;
                            <a href="#" class="btn default btn-xs purple"><i class="fa fa-edit"></i> 编辑</a>&nbsp;&nbsp;&nbsp;
                            <a href="#" class="btn default btn-xs green"><i class="fa fa-edit"></i> 权限</a>&nbsp;&nbsp;&nbsp;
                            <a href="#1" v-if="list.status=='y'" v-on:click="disab" id="@{{list.id}}|n"
                               class="btn default btn-xs black"><i
                                        class="fa fa-trash-o"></i> 禁用</a>
                            <a href="#1" v-else v-on:click="disab" id="@{{list.id}}|y" class="btn default btn-xs black"><i
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
                            <a v-on:click="btnClick(index)">@{{ index }}</a>
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
    //Vue.http.options.emulateJSON = true;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
        },
        el: '#app',
        data: {
            lists: '',
            all: '',
            cur: 1,
        },
        ready: function () {
            this.btnClick(this.cur);
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
                        this.btnClick(this.cur);
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            btnClick: function (index) {
                this.cur = index;
                senddata = {page: index};
                this.$http.get('/getuser', senddata, function (data) {
                    /* if (this.cur == 1) {
                     this.$set('lists', eval(JSON.stringify(data.data)));
                     } else {
                     var aa = eval(JSON.stringify(this.lists));
                     var bb = eval(JSON.stringify(data.data));
                     var cc = aa.concat(bb);
                     this.$set('lists', cc);
                     }*/
                    this.$set('lists', eval(JSON.stringify(data.data)));
                    this.$set('all', eval(JSON.stringify(data.last_page)));
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            cstyle: function (event) {
                if (event.target.checked) {
                    event.target.parentNode.className = "checked";
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                } else {
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd ";
                    event.target.parentNode.className = ""
                }
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