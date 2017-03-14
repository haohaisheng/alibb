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
            <li><a href="#">草稿箱</a></li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row" id="app_2">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>发布草稿箱</div>
                <div class="actions">
                    <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label><input style="height: 27px;width:200px;" id="keyword" aria-controls="sample_1"
                                      placeholder="输入关键词查询"
                                      class="form-control  input-inline" type="search"></label>
                    </div>
                    <button v-on:click="search(1,'search')" class="btn btn-sm yellow filter-submit margin-bottom"><i
                                class="fa fa-search"></i> 搜索
                    </button>
                    <a v-on:click="fabu()" class="btn blue"><i class="fa fa-pencil"></i> 全部发布</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <!--  <th class="table-checkbox" style="width1:8px;">
                              <div class="checker"><span>
                              <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"
                                     v-on:click="chk"/></span>
                              </div>
                          </th> -->
                        <th width="20%">商品标题</th>
                        <th>商品型号</th>
                        <th>商品状态</th>
                        <th>关键词</th>
                        <th>发布日期</th>
                        <th>更新日期</th>
                        <th>所属分组</th>
                        <th>商品类目</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <!-- <td>
                             <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"
                                                               v-on:click="chk"/></span></div>
                         </td> -->
                        <td>@{{list.subject}}</td>
                        <td>@{{list.xinghao}}</td>
                        <td>
                            <span v-if="list.status=='auditing'" class="label label-sm label-success">审核中</span>
                            <span v-if="list.status=='online'" class="label label-sm label-success">已上网</span>
                            <span v-if="list.status=='FailAudited'" class="label label-sm label-success">审核未通过</span>
                            <span v-if="list.status=='published'" class="label label-sm label-success">已发布</span>
                            <span v-if="list.status=='delete'" class="label label-sm label-success">审核删除</span>
                            <span v-if="list.status=='member delete(d)'"
                                  class="label label-sm label-success">用户删除</span>
                            <span class="label label-sm label-success">待发布</span>
                        </td>
                        <td>@{{list.status}}</td>
                        <td>@{{list.createTime}}</td>
                        <td>@{{list.lastUpdateTime}}</td>
                        <td>@{{list.groupname}}</td>
                        <td>@{{list.catename}}</td>
                        <td>
                            <a v-on:click="fabu_one(list.productID)" class="btn default btn-xs blue"><i
                                        class="fa fa-history"></i>
                                发布</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a v-on:click="remove(list.productID)" class="btn default btn-xs blue"><i
                                        class="fa fa-trash-o"></i>
                                删除</a>
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
    var count = '';
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app_2',
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
            list: function (index) {
                this.cur = index;
                status = 'fabu';
                senddata = {page: index, status: status};
                this.$http.get('/draftboxlist', senddata, function (data) {
                    if (data == '') {
                        count = 0;
                    } else {
                        this.$set('lists', eval(JSON.stringify(data.data)));
                        this.$set('all', eval(JSON.stringify(data.last_page)));
                    }
                })
            },
            search: function () {
                key = $("#key").val();
                status = 'fabu';
                senddata = {page: 1, key: key, status: status};
                this.$http.get('/searchbox', senddata, function (data) {
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
            fabu_one: function (id) {
                senddata = {productid: id};
                var index = layer.msg('数据更新中...', {icon: 16, time: false});
                this.$http.get('/fabu_one', senddata, function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('发布成功');
                    }
                })
            },
            fabu: function () {
                if (count == 0) {
                    Alert5('没有可编辑发布的产品');
                    return false;
                }
                var index = layer.msg('发布中...', {icon: 16, time: false});
                this.$http.get('/fabu', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('发布成功');
                    }
                })
            },
            remove: function (id) {
                var index = layer.msg('数据更新中...', {icon: 16, time: false});
                this.$http.get('/removefabu/' + id, function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        this.list(1);
                        Alert1('删除成功');
                    }
                })
            },
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