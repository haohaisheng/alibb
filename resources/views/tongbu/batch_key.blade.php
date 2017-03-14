<style>
</style>
<div class="row" id="batch_key">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑关键词</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="key_table">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th width="5%">序号</th>
                        <th>信息标题</th>
                        <th>关键词1旧</th>
                        <th>关键词1新</th>
                        <th>关键词2旧</th>
                        <th>关键词2新</th>
                        <th>关键词3旧</th>
                        <th>关键词3新</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>@{{list.id}}</td>
                        <td>@{{list.subject}}</td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑关键词
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body" style="margin-left:10px; ">
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="find" id="find" value="1"> 自动修改次关键词
                                </label>
                                <button type="button" class="btn grey-cascade" v-on:click="bank">修改</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="find" id="find" value="1"> 手动修改
                                </label>
                                <label class="radio-inline">
                                    <input type="text" name="findkey" id="findkey" style="width:300px;"
                                           placeholder="填写与标题匹配的主关键词">
                                </label>
                                <button type="button" class="btn grey-cascade" v-on:click="bank">修改</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="form-actions" style="text-align: right">
            <button type="button" v-on:click="deleteimg('all')" class="btn blue">保存</button>
            <button type="button" v-on:click="putbox()" class="btn blue">存入草稿箱</button>
            <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
            <button type="button" class="btn default">返回</button>
        </div>
    </div>
</div>
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<script>
    var ids = '';
    $(document).ready(function () {
        $("#key_table").freezeHeader({'height': '300px'});
       // Metronic.init();
    });
    var vm2 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_key',
        data: {
            lists: '',
            keys: ''
        },
        ready: function () {
            this.list();
        },
        methods: {
            list: function () {
                this.$http.get('/getbatchList', function (data) {
                    this.$set('lists', eval(data));
                })
            },
            next: function () {
                $('#tab6').click();
                $("#tab_61").load('/tobatch', function () {
                            $("#tab_61").fadeIn(100);
                        }
                );
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