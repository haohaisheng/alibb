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
<style>
    .actions {
        float: inherit;
        /* display: inline-block; */
        padding: 0px 0;
    }
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
<div class="row" id="batch_price">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量设置产品价格</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="price_table">
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
                        <td>@{{list.subject}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑FOB价格_FOB价格
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" style="width:60%">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">货币种类</label>

                            <div class="col-md-9">
                                <select class="form-control" id="fobUnitType">
                                    <option value="">货币种类</option>
                                    <option value="USD">USD</option>
                                    <option value="GBP">GBP</option>
                                    <option value="RMB">RMB</option>
                                    <option value="AUD">AUD</option>
                                    <option value="CAD">CAD</option>
                                    <option value="CHF">CHF</option>
                                    <option value="JPY">JPY</option>
                                    <option value="HKD">HKD</option>
                                    <option value="NZD">NZD</option>
                                    <option value="SGD">SGD</option>
                                    <option value="NTD">NTD</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最小价格</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="fobMinPrice">
                                <select id="fobMinPrice_count">
                                    <option value="2">保留二位小数</option>
                                    <option value="3">保留三位小数</option>
                                    <option value="4">保留四位小数</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">最高价格</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control input-inline input-medium" id="fobMaxPrice">
                                <select id="fobMaxPrice_count">
                                    <option value="2">保留二位小数</option>
                                    <option value="3">保留三位小数</option>
                                    <option value="4">保留四位小数</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">per</label>
                            <div class="col-md-9">
                                <select class="form-control" id="minOrderUnitType">
                                    <option value="">计量单位</option>
                                    <option v-for="unit in units" value="@{{unit.name}}">@{{unit.name}}</option>
                                </select>
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
    $(document).ready(function () {
        //Metronic.init();
        $("#price_table").freezeHeader({'height': '300px'});
    });
    var vm5 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_price',
        data: {
            lists: '',
            units: '',
            keys: ''
        },
        ready: function () {
            this.list();
            this.unitlist();
        },
        methods: {
            list: function () {
                this.$http.get('/getbatchList', function (data) {
                    this.$set('lists', eval(data));
                })
            },
            unitlist: function () {
                this.$http.get('/getunitlist', function (data) {
                    this.$set('units', eval(data));
                })
            },
            save: function () {
                fobUnitType = $("#fobUnitType").val();
                fobMinPrice = $("#fobMinPrice").val();
                fobMaxPrice = $("#fobMaxPrice").val();
                minOrderUnitType = $("#minOrderUnitType").val();
                fobMinPrice_count = $("#fobMinPrice_count").val();
                fobMaxPrice_count = $("#fobMaxPrice_count").val();
                senddata = {
                    fobUnitType: fobUnitType,
                    fobMinPrice: fobMinPrice,
                    fobMaxPrice: fobMaxPrice,
                    minOrderUnitType: minOrderUnitType,
                    fobMinPrice_count: fobMinPrice_count,
                    fobMaxPrice_count: fobMaxPrice_count
                };
                var index = layer.msg('数据保存中...', {icon: 16, time: false});
                this.$http.post('/savebatchfobprice', senddata, function (data) {
                    if (eval(data).code) {
                        this.list();
                        Alert1('保存成功');
                        layer.close(index);
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
        },
        watch: {
            cur: function (oldValue, newValue) {
                console.log(arguments)
            }
        }
    })
</script>