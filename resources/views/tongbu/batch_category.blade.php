<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<div class="row" id="batch_cate">
    <div class="col-sm-12">

        <div class="col-md-2">
            <ul class="ver-inline-menu tabbable margin-bottom-10">
                <li class="active">
                    <a data-toggle="tab" href="#tab_c1">
                        <i class="fa fa-briefcase"></i> 原产地 </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_c2">
                        <i class="fa fa-group"></i> 品牌 </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_c3">
                        <i class="fa fa-leaf"></i> 型号</a>
                </li>
                <li>
                    <a data-toggle="tab" href="#tab_c4">
                        <i class="fa fa-plus"></i> 自定义属性 </a>
                </li>
                <!-- <li>
                     <a data-toggle="tab" href="#tab_c5">
                         <i class="fa fa-tint"></i> 其它属性 </a>
                 </li> -->
                <li>
                    <a data-toggle="tab" href="#tab_c6">
                        <i class="fa fa-info-circle"></i> 产品类目 </a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div id="tab_c1" class="tab-pane active">
                    <div id="accordion2" class="panel-group">
                        <table class="table table-striped table-bordered table-hover" id="c1">
                            <thead>
                            <tr style="background-color: #EEEEEE">
                                <th width="5%">产品编号</th>
                                <th>信息标题</th>
                                <th>产地</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="list in lists">
                                <td>@{{list.productID}}</td>
                                <td>@{{list.subject}}</td>
                                <td>@{{list.chandi}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="portlet box grey" style="margin-bottom: 0px;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> 批量编辑原产地
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">原产地</label>

                                        <div class="col-md-6">
                                            <select class="form-control" id="country">
                                                <option value="">请选择国家地区</option>
                                                <option value="@{{c.name}}"
                                                        v-for="c in countrys">@{{c.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--操作按钮-->
                    <div class="form-actions" style="text-align: right;margin-top: 60px;">
                        <button type="button" v-on:click="chandi()" class="btn blue">保存</button>
                        <button type="button" class="btn blue" v-on:click="batchfabu()">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </div>
                <div id="tab_c2" class="tab-pane">
                    <div id="accordion1" class="panel-group">
                        <table class="table table-striped table-bordered table-hover" id="c2">
                            <thead>
                            <tr style="background-color: #EEEEEE">
                                <th width="5%">产品编号</th>
                                <th>信息标题</th>
                                <th>品牌</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="list in lists">
                                <td>@{{list.productID}}</td>
                                <td>@{{list.subject}}</td>
                                <td>@{{list.pinpai}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="portlet box grey" style="margin-bottom: 0px;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> 批量编辑品牌
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">品牌</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control input-inline input-medium"
                                                   id="pinpai">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--操作按钮-->
                    <div class="form-actions" style="text-align: right;margin-top: 60px;">
                        <button type="button" v-on:click="pinpai()" class="btn blue">保存</button>
                        <button type="button" class="btn blue" v-on:click="batchfabu()">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </div>
                <div id="tab_c3" class="tab-pane">
                    <div id="accordion3" class="panel-group">
                        <table class="table table-striped table-bordered table-hover" id="c3">
                            <thead>
                            <tr style="background-color: #EEEEEE">
                                <th width="5%">产品编号</th>
                                <th>信息标题</th>
                                <th>型号</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="list in lists">
                                <td>@{{list.productID}}</td>
                                <td>@{{list.subject}}</td>
                                <td>@{{list.xinghao}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="portlet box grey" style="margin-bottom: 0px;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> 批量编辑型号
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form role="form">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <input type="radio" name="radio_xinghao" value="radio1" id="radio1"
                                                       v-on:click="check()"> 全部替换为
                                            </label>
                                            <input type="text" class="form-control input-inline input-medium"
                                                   id="replace">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio-list">
                                            <label class="radio-inline">
                                                <input type="radio" name="radio_xinghao" value="radio2" id="radio1"
                                                       v-on:click="check()">
                                                按输入的型号自动生成 </label>
                                            <input type="text" class="form-control input-inline input-medium"
                                                   id="xinghao" disabled>
                                            <button type="button" class="btn grey-cascade" id="button2"
                                                    v-on:click="shunxushengcheng()" disabled>按顺序生成
                                            </button>
                                        </div>
                                    </div>
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input type="radio" name="radio_xinghao" id="radio1" value="radio3"
                                                   v-on:click="check()">
                                            导入文本文件设置型号 </label>
                                        <form action="/savefilexinghao" method="post" enctype="multipart/form-data"
                                              id="fileform">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <span class="btn grey-cascade fileinput-button">
                                                <i class="fa fa-plus"></i>
                                                  <span>导入型号</span>
                                                 <input type="file" name="filexinghao" multiple="" id="filexinghao"
                                                        disabled>
                                             </span>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--操作按钮-->
                    <div class="form-actions" style="text-align: right;margin-top: 60px;">
                        <button type="button" v-on:click="xinghao()" class="btn blue">保存</button>
                        <button type="button" class="btn blue" v-on:click="batchfabu()">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </div>
                <div id="tab_c4" class="tab-pane">
                    <div id="accordion4" class="panel-group">
                        <table class="table table-striped table-bordered table-hover" id="c4">
                            <thead>
                            <tr style="background-color: #EEEEEE">
                                <th width="5%">产品编号</th>
                                <th>信息标题</th>
                                <th>旧值</th>
                                <th>新值</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="list in lists">
                                <td>@{{list.productID}}</td>
                                <td>@{{list.subject}}</td>
                                <td>@{{list.subject}}
                                </td>
                                <td><input type="text" class="form-control form-filter input-sm"
                                           value="@{{list.subject1}}">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="portlet box grey" style="margin-bottom: 0px;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> 批量编辑自定义属性
                            </div>
                        </div>
                    </div>
                    <div class="row" style="width:40%;margin-top: 10px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性名</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="param0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性值</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="val0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="width:40%">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性名</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="param1">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性值</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="val1">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row" style="width:40%">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性名</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="param2">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性值</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="val2">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row" style="width:40%">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性名</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="param3">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-3">属性值</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="val3">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--操作按钮-->
                    <div class="form-actions" style="text-align: right;margin-top: 60px;">
                        <button type="button" v-on:click="custom()" class="btn blue">保存</button>
                        <button type="button" class="btn blue" v-on:click="batchfabu()">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </div>
                <!-- <div id="tab_c5" class="tab-pane">
                     <div id="accordion5" class="panel-group">
                         tab_c5
                     </div>
                 </div>-->
                <div id="tab_c6" class="tab-pane">
                    <div id="accordion6" class="panel-group">
                        <table class="table table-striped table-bordered table-hover" id="c6">
                            <thead>
                            <tr style="background-color: #EEEEEE">
                                <th width="5%">产品编号</th>
                                <th>信息标题</th>
                                <th>类目</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="list in lists">
                                <td>@{{list.productID}}</td>
                                <td>@{{list.subject}}</td>
                                <td>@{{list.catename}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="portlet box grey" style="margin-bottom: 0px;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i> 批量编辑自定义属性
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="width: 25%;float: left;">
                        <label>一级分类</label>
                        <select multiple class="form-control">
                            <option>选择一级分类</option>
                            <option value="@{{c.categoryID}}" v-for="c in cate1"
                                    v-on:click="getcategory1(1,c.categoryID)">@{{c.enName}}</option>
                        </select>
                    </div>
                    <div class="form-group" style="width: 25%;float: left">
                        <label>二级分类</label>
                        <select multiple class="form-control">
                            <option>选择二级分类</option>
                            <option value="@{{c.categoryID}}" v-for="c in cate2"
                                    v-on:click="getcategory1(2,c.categoryID)">@{{c.enName}}</option>
                        </select>
                    </div>
                    <div class="form-group" style="width: 25%;float: left">
                        <label>三级分类</label>
                        <select multiple class="form-control">
                            <option>选择三级分类</option>
                            <option value="@{{c.categoryID}}" v-for="c in cate3"
                                    v-on:click="getcategory1(3,c.categoryID)">@{{c.enName}}</option>
                        </select>
                    </div>
                    <div class="form-group" style="width: 25%;float: left">
                        <label>四级分类</label>
                        <select multiple class="form-control">
                            <option>选择四级分类</option>
                            <option value="@{{c.categoryID}}" v-for="c in cate4"
                                    v-on:click="getcategory1(4,c.categoryID)">@{{c.enName}}</option>
                        </select>
                    </div>
                    <div class="form-actions" style="text-align: right;margin-top: 60px;">
                        <button type="button" v-on:click="cate()" class="btn blue">保存</button>
                        <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var type = '';
    $(document).ready(function () {
        //Metronic.init();
        $("#c1").freezeHeader({'height': '300px'});
        $("#c2").freezeHeader({'height': '300px'});
        $("#c3").freezeHeader({'height': '300px'});
        $("#c4").freezeHeader({'height': '300px'});
        $("#c6").freezeHeader({'height': '300px'});

        $("#fileform").on("change", function () {
            //$(selector).submit();
        });

    });
    var vm2 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_cate',
        data: {
            lists: '',
            countrys: '',
            cate1: '',
            cate2: '',
            cate3: '',
            cate4: '',
            cateid: ''
        },
        ready: function () {
            this.list(this.cur);
            this.getcountry();
            this.getcategory();
        },
        methods: {
            list: function () {
                var index = layer.msg('数据加载中...', {icon: 16, time: false});
                this.$http.get('/getbatchcatetorylist', function (data) {
                    layer.close(index);
                    this.$set('lists', eval(data));
                })
            },
            getcountry: function () {
                this.$http.get('/getcountrylist', function (data) {
                    this.$set('countrys', eval(data));
                })
            },
            getcategory: function () {
                this.$http.get('/getcategorylist/0', function (data) {
                    this.$set('cate1', eval(data));
                })
            },
            getcategory1: function (type, cateid) {
                this.$http.get('/getcategorylist/' + cateid, function (data) {
                    if (type == 1) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate2', '');
                            this.$set('cate3', '');
                            this.$set('cate4', '');
                        } else {
                            this.$set('cate2', eval(data));
                        }
                    } else if (type == 2) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate3', '');
                        } else {
                            this.$set('cate3', eval(data));
                        }
                    } else if (type == 3) {
                        if (eval(data) == '') {
                            this.cateid = cateid;
                            this.$set('cate4', '');
                        } else {
                            this.$set('cate4', eval(data));
                        }
                    } else {
                        this.cateid = cateid;
                    }
                })
            },
            chandi: function () {
                senddata = {
                    country: $("#country").val()
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savechandi', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            pinpai: function () {
                senddata = {
                    pinpai: $("#pinpai").val()
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savepinpai', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            xinghao: function () {
                var type = $("input[name='radio_xinghao']:checked").val();
                var replace = $("#replace").val();
                if (replace == '') {
                    Alert5('请输入要替换的型号');
                    return false;
                }
                senddata = {
                    type: type,
                    replace: replace
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savexinghao', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            shunxushengcheng: function () {
                var type = $("input[name='radio_xinghao']:checked").val();
                var replace = $("#xinghao").val();
                if (replace == '') {
                    Alert5('请输入型号');
                    return false;
                }
                senddata = {
                    type: type,
                    replace: replace
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savexinghao', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            check: function (event) {
                type = $("input[name='radio_xinghao']:checked").attr('value');
                if (type == 'radio2') {
                    $("#replace").attr("disabled", true);
                    $("#xinghao").attr("disabled", false);
                    $("#button2").attr("disabled", false);
                    $("#filexinghao").attr("disabled", true);
                } else if (type == 'radio3') {
                    $("#filexinghao").attr("disabled", false);
                    $("#xinghao").attr("disabled", true);
                    $("#button2").attr("disabled", true);
                    $("#replace").attr("disabled", true);
                } else {
                    $("#replace").attr("disabled", false);
                    $("#xinghao").attr("disabled", true);
                    $("#button2").attr("disabled", true);
                    $("#filexinghao").attr("disabled", true);
                }
            },
            set: function (type) {
                if (type == 'radio1') {
                    senddata = {
                        replace: $("#replace").val(),
                        type: type
                    };
                } else if (type == 'radio2') {
                    senddata = {
                        replace: $("#replace").val(),
                        type: type
                    };
                } else {
                    senddata = {
                        replace: $("#replace").val(),
                        type: type
                    };
                }
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savexinghao', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            custom: function () {
                var custom = [];
                for (i = 0; i < 4; i++) {
                    if ($("#param" + i).val() != '' && $("#val" + i).val() != '') {
                        var row = $("#param" + i).val() + '|' + $("#val" + i).val();
                        custom.push(row);
                    }
                }
                if (custom.length < 1) {
                    Alert5('请输入自定义属性');
                    return false;
                }
                senddata = {
                    custom: custom
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/batchcustomcategory', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
                    }
                })
            },
            cate: function () {
                senddata = {
                    cateid: this.cateid
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savecategory', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        layer.close(index);
                        Alert1('保存成功');

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