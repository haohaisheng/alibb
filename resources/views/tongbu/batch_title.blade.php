<!--<script src="../../admin/assets/global/plugins/jquery.ui.widget.js"></script>
<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jqmeter.min.js" type="text/javascript"></script>
<link href="../../admin/assets/global/css/components.css" id="style_components"/>
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<script src="../../admin/assets/admin/pages/scripts/form-fileupload.js"></script>
<script src="../../admin/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>

<link href="../../admin/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css"
      rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
-->
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<style>
    .actions {
        float: inherit;
        /* display: inline-block; */
        padding: 0px 0;
    }

    .radio-inline {
        position: relative;
        display: inline-block;
        /* padding-left: 0px;*/
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;
    }
</style>

<script>
    $(document).ready(function () {
        $("#title_table").freezeHeader({'height': '400px'});
    });
</script>
<div class="row" id="batch_title">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑标题</div>
            </div>
            <div class="portlet-body">

                <table class="table table-striped table-bordered table-hover" id="title_table">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th width="5%">产品编号</th>
                        <th>信息标题</th>
                        <th>新值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>@{{list.productID}}</td>
                        <td>@{{list.subject}}</td>
                        <td>@{{list.subject2}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑产品标题
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body" style="margin-left:10px; ">
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" checked="true" name="type" id="type" value="1"> 查找并替换
                                </label>
                                <label class="radio-inline">
                                    查找 <input type="text" name="findwrod" id="findwrod">
                                </label>
                                <label class="radio-inline">
                                    替换 <input type="text" name="replacewrod" id="replacewrod">
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="isbig" id="isbig" value="1"> 区分大小写
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" checked="true" name="isbig" id="isbig" value="2"> 忽略大小写
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="type" id="type" value="2">
                                    全部更换为 </label>
                                <label class="radio-inline">
                                    新值 <input type="text" name="allword" id="allword">
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="checkbox" name="isupdate" id="isupdate">自动更新简要描述和详情信息中的标题
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="form-actions" style="text-align: right">
            <button type="button" v-on:click="save()" class="btn blue">保存</button>
            <button type="button" v-on:click="putbox()" class="btn blue">存入草稿箱</button>
            <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
            <button type="button" class="btn default">返回</button>
        </div>
    </div>
</div>
<script>
    var ids = "";
    $(document).ready(function () {
        //Metronic.init();
    });
    var vm2 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_title',
        data: {
            lists: '',
            keys: ''
        },
        ready: function () {
            this.list();
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
            list: function () {
                var index = layer.msg('数据加载中...', {icon: 16, time: false});
                this.$http.get('/getbatchList', function (data) {
                    layer.close(index);
                    this.$set('lists', eval(data));
                })
            },
            func: function (uid) {
                layer.open({
                    type: 2,
                    area: ['600px', '350px'],
                    fix: false, //不固定
                    maxmin: true,
                    content: '/keyseting'
                });
            },
            next: function () {
                $('#tab6').click();
                $("#tab_61").load('/tobatch', function () {
                            $("#tab_61").fadeIn(100);
                        }
                );
            },
            save: function () {
                var type = $("input[name='type']:checked").val();
                var findwrod = $("#findwrod").val();
                var replacewrod = $("#replacewrod").val();
                var allword = $("#allword").val();
                var isbig = $("input[name='isbig']:checked").val();
                var isupdate = $("#isupdate").val();
                var index = layer.msg('数据加载中...', {icon: 16, time: false});
                if ($('#isupdate').attr('checked')) {
                    isupdate = 1;
                } else {
                    isupdate = 0;
                }
                senddata = {
                    type: type,
                    findwrod: findwrod,
                    replacewrod: replacewrod,
                    isbig: isbig,
                    allword: allword,
                    isupdate: isupdate
                };
                this.$http.post('/titlereplace', senddata, function (data) {
                    layer.close(index);
                    if (eval(data).code) {
                        this.list();
                        Alert1('保持成功');
                    }
                    this.$set('lists', eval(data));
                })
            },
            fabu: function () {
                var type = $("input[name='type']:checked").val();
                var index = layer.msg('发布中...', {icon: 16, time: false});
                senddata = {
                    type: type
                };
                this.$http.get('/batchFabu', senddata, function (data) {
                    layer.close(index);
                    if (eval(data).code) {
                        Alert1('编辑发布成功');
                    }
                })
            },
            batchfabu: function () {
                var index = layer.msg('编辑发布中...', {icon: 16, time: false});
                this.$http.get('/batchfabu', function (data) {
                    if (eval(data).code == 101) {
                        layer.close(index);
                        Alert1('编辑发布成功');
                    } else if (eval(data).code == 102) {
                        layer.close(index);
                        Alert5(eval(data).message);
                    } else {
                        layer.close(index);
                        Alert5(eval(data).message);
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