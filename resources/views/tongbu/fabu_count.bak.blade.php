<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jqmeter.min.js" type="text/javascript"></script>
<link href="../../admin/assets/global/css/components.css" id="style_components"/>

<link rel="stylesheet" href="{{ URL::asset('assets/plugins/kindeditor-4.1.7/themes/default/default.css') }}"/>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/kindeditor-min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/lang/zh_CN.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/plugins/code/prettify.js') }}"></script>

<script>
    var editor;
    function kedit(kedit) {
        editor = KindEditor.create(kedit, {
            cssPath: '{{ URL::asset('assets/plugins/kindeditor-4.1.7/plugins/code/prettify.css') }}',
            uploadJson: '{{ URL::route('upload.uploadimage1',['_token'=>''])}}' + "{{csrf_token()}}",
            allowImageUpload: true,
            resizeType: 1,
            readonlyMode: false,
            resizeMode: 0,
            allowFileManager: true,
            allowPreviewEmoticons: false,
            afterCreate: function () {
            },
            afterChange: function () {
                this.sync();
            },
            afterBlur: function () {
                this.sync();
            },
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', '|', 'image', 'link']
        });
    }
    $(function () {
        kedit('textarea[name="content"]');
    })
</script>
<!--<div class="row">
    <div class="col-md-12">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">主目录</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">产品管理</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#1" onclick="func_action('aa')">复制发布</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">复制发布</a>
            </li>
        </ul>
    </div>
</div>-->

<div class="row" id="app">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom tabbable-noborder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="tab1" href="#tab_1" data-toggle="tab">
                        设置数量 </a>
                </li>
                <li>
                    <a id="tab2" href="#tab_2" data-toggle="tab">
                        设置产品详情模板 </a>
                </li>
                <li>
                    <a id="tab3" href="#tab_3" data-toggle="tab">
                        设置生成参数 </a>
                </li>
                <li>
                    <a id="tab4" href="#tab_4" data-toggle="tab">
                        设置关键词 </a>
                </li>
                <li>
                    <a id="tab5" href="#tab_5" data-toggle="tab">
                        生成标题 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_6" data-toggle="tab">
                        批量编辑 </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="margin-top-10">
                        <ul class="mix-filter">
                            <label class="control-label col-md-1" style="line-height: 34px;">复制数量</label>
                            <input type="hidden" id="productid" value="{{$productid}}">

                            <div id="spinner4">
                                <div class="input-group" style="width:150px;">
                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-up blue">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <input id="count" type="text" class="spinner-input form-control" maxlength="3">

                                    <div class="spinner-buttons input-group-btn">
                                        <button type="button" class="btn spinner-down red">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <label class="control-label"></label>

                            <div class="form-actions" style="text-align: right">
                                <button type="button" v-on:click="fabu" class="btn blue">下一步</button>
                                <button type="button" class="btn default">返回</button>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="filter-v1 margin-top-10">

                    </div>
                </div>
                <div class="tab-pane" id="tab_3">
                    <div class="filter-v1 margin-top-10">
                        @include('tongbu.fabu_set_param')
                    </div>
                </div>
                <div class="tab-pane" id="tab_4">
                    <div class="filter-v1 margin-top-10">
                        @include('tongbu.fabu_set_key')
                    </div>
                </div>
                <div class="tab-pane" id="tab_5">
                    <div class="filter-v1 margin-top-10">
                        @include('tongbu.fabu_set_title')
                    </div>
                </div>
                <div class="tab-pane" id="tab_6">
                    <div class="filter-v1 margin-top-10">
                        @include('tongbu.fabu_batchedit')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>

<script type="text/javascript" src="../../admin/assets/global/plugins/fuelux/js/spinner.min.js"></script>
<script type="text/javascript"
        src="../../admin/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script type="text/javascript"
        src="../../admin/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript"
        src="../../admin/assets/global/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
<script src="../../admin/assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js"
        type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js"
        type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"
        type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js"
        type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

<script src="../../admin/assets/admin/pages/scripts/components-form-tools.js"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/layer/layer.js') }}"></script>

<script>
    var i = 0;
    jQuery(document).ready(function () {
        Metronic.init();
        ComponentsFormTools.init();
    });
    var total = 0;
    var count = 0;
    var d = 0;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
        data: {
            productid: ''
        },
        ready: function () {
        },
        methods: {
            fabu: function () {
                count = $("#count").val();
                productid = $("#productid").val();
                if (count == 0) {
                    Alert5('请输入复制数量');
                    return false;
                }
                this.$set('productid', productid);
                var index = layer.msg('产品复制中...', {icon: 16, time: false});
                vm.$http.get('/fuzhi/' + productid + '/' + count, function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        vm.initinfo(productid);
                        //$('#tab_4').listview('refresh');
                        $('#tab2').click();
                    }
                })
            },
            initinfo: function (productid) {
                vm.$http.get('/getproductinfo/' + productid, function (data) {
                    if (eval(data).code) {
                        result = eval(data).data;
                        editor.html(result.description);
                    }
                })
            },
            next: function () {
                var content = editor.html();
                senddata = {
                    content: content
                };
                var index = layer.msg('正在处理...', {icon: 16, time: false});
                this.$http.post('/updatedesc', senddata, function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        $('#tab3').click();
                        $("#tab_31").load('/todetail/' + productid, function () {
                                    $("#tab_31").fadeIn(100);
                                }
                        );
                    }
                })
            }
        }
    })
</script>