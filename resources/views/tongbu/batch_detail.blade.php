<style>
    .radio-inline1 {
        position: relative;
        display: inline-block;
        /* padding-left: 0px;*/
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;
    }

</style>

<script>
</script>
<div class="row" id="batch_detail">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑产品详情</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="title_table">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th width="5%">序号</th>
                        <th>信息标题</th>
                        <th>旧值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>@{{list.id}}</td>
                        <td>@{{list.subject}}</td>
                        <td>共@{{list.str}}个字符
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑产品详情
                </div>
            </div>
            <div class="portlet-body form">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 30px;">
                        <div class="input-group">
                            <input type="text" id="findkey" class="form-control">
                            <span class="input-group-btn">
												<button class="btn blue" v-on:click="find()" type="button">查找</button>
												</span>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 30px;">
                        <div class="input-group">
                            <span>查找结果：</span><span style="color: red" id="tishi1"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="margin-top: 30px;">
                        <div class="input-group">
                            <input type="text" id="replacekey" class="form-control">
                            <span class="input-group-btn">
												<button class="btn blue" v-on:click="replace()"
                                                        type="button">替换
                                                </button>
												</span>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 30px;">
                        <div class="input-group">
                            <span>替换结果：</span><span style="color: red" id="tishi2"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-actions" style="text-align: right;margin-right: 20px;">
        <button type="button" v-on:click="batchsave()" class="btn blue">保存</button>
        <button type="button" v-on:click="putbox()" class="btn blue">存入草稿箱</button>
        <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
        <button type="button" class="btn default">返回</button>
    </div>
</div>
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>

<script>
    var ids = '';
    var count = 0;
    $(document).ready(function () {
        $("#detail_table").freezeHeader({'height': '300px'});
        //Metronic.init();
    });
    var vm8 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_detail',
        data: {
            lists: '',
            keys: ''
        },
        ready: function () {
            this.list();
        },
        methods: {
            list: function () {
                this.$http.get('/getbatchdetaillist', function (data) {
                    this.$set('lists', eval(data));
                })
            },
            find: function () {
                findkey = $("#findkey").val();
                replacekey = $("#replacekey").val();
                if (findkey == '') {
                    Alert5('请输入查找内容');
                    return false;
                }
                senddata = {
                    findkey: findkey,
                    replacekey: replacekey,
                    type: 'find'
                };
                this.$http.post('/editbatchproductdetail', senddata, function (data) {
                    if (eval(data).code) {
                        count = eval(data).count;
                        msg = '从产品详情中匹配到' + eval(data).count + '处结果';
                        $("#tishi1").text(msg);
                        this.list();
                    }
                })
            },
            replace: function () {
                findkey = $("#findkey").val();
                replacekey = $("#replacekey").val();
                if (replacekey == '') {
                    Alert5('请输入替换内容');
                    return false;
                }
                senddata = {
                    findkey: findkey,
                    replacekey: replacekey,
                    type: 'replace'
                };
                this.$http.post('/editbatchproductdetail', senddata, function (data) {
                    if (eval(data).code) {
                        msg = '从产品详情中替换掉' + count + '处结果';
                        $("#tishi2").text(msg);
                        this.list();
                    }
                })
            },
            batchsave: function () {
                this.$http.post('/getbatchdetaillist', function (data) {
                    if (eval(data).code) {
                        Alert('操作成功');
                        this.list();
                    }
                })
            },
            fabu: function () {
                this.$http.get('/batchfabu', function (data) {
                    if (eval(data).code) {
                        Alert('发布成功');
                        this.list();
                    }
                })
            },
            batchfabu: function () {
                var index = layer.msg('编辑发布中...', {icon: 16, time: false});
                this.$http.get('/batchfabu', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('编辑发布成功');

                    }
                })
            },
            putbox: function () {
                layer.confirm('放入草稿箱后,产品将不会在这里出现,确定放入吗 ？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    var index = layer.msg('数据处理中...', {icon: 16, time: false});
                    $.get("/putdraftbox", function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('放入成功');
                            func_action('/box');
                        }
                    });
                }, function () {
                    return false;
                });
            },
        }
    })
</script>