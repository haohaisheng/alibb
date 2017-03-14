<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/plugins/jqmeter.min.js" type="text/javascript"></script>
<link href="../../admin/assets/global/css/components.css" id="style_components"/>

<link href="../../admin/assets/mall/css/hhs.css" rel="stylesheet" type="text/css"/>
{{--<link href="../../admin/assets/mall/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="../../admin/assets/mall/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="../../admin/assets/mall/lib/icheck/icheck.css" rel="stylesheet" type="text/css" />
<link href="../../admin/assets/mall/lib/Hui-iconfont/1.0.1/iconfont.css" rel="stylesheet" type="text/css" />--}}
<style>
    .actions {
        float: inherit;
        padding: 0px 0;
    }

    .radio-inline {
        position: relative;
        display: inline-block;
        /*padding-left: 0px;*/
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;

    }

    table {
        margin: auto
    }

    table td, table th {
        text-align: center;
        /* vertical-align: middle;*/
    }

    tbody td {
        text-align: center;
        vertical-align: middle;
    }

    li {
        list-style-type: none;
    }

    p img {
        width: 50px;
        height: 50px
    }

    p {
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>
<link href="../../admin/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css"
      rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#bath_table").freezeHeader({'height': '300px'});
        // $("#hdbath_table").css({"margin-top":"0","propertyname":"value"});//隐藏，等同于hide()方法
        //  $("#hdbath_table").css({"":"0"});//隐藏，等同于hide()方法
    });
</script>

<div class="row" id="yfmb">
    <div class="col-sm-12">
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量物流信息</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="bath_table" width="100%"
                       style="margin-top:0px;">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th>编号</th>
                        <th>产品标题</th>
                    </tr>
                    </thead>
                    <tbody style="">
                    <tr class="odd gradeX" v-for="list in lists" style="height: 50px;line-height: 50px;">
                        <td>@{{list.id}}</td>
                        <td>@{{list.subject}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--批量编辑物流信息开始-->
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑物流信息
                </div>
            </div>
            <div class="portlet-body form">
                <div class="pd-20">
                    <form action="" method="post" class="form form-horizontal" id="form-article-add">
                        <div class="row cl">
                            <label class="form-label col-2"><span class="c-red">*</span>选择运费模板：</label>
                            <div class="formControls col-2">
                                <span class="select-box">
                                    <select name="" class="select">
                                        <option value="0">全部栏目</option>
                                        <option value="@{{c.id}}" v-for="c in yfmb">@{{c.name}}</option>
                                    </select>
				                </span>
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2"><span class="c-red">*</span>单位重量：</label>
                            <div class="formControls col-2">
                                <input type="text" class="input-text" value="" placeholder="" id="" name="">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2"><span class="c-red">*</span>尺寸：</label>
                            <div class="formControls col-2">
                                <input type="text" class="input-text" value="" placeholder="" id="" name="">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2"><span class="c-red">*</span>体积：</label>
                            <div class="formControls col-2">
                                <input type="text" class="input-text" value="" placeholder="" id="" name="">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2"><span class="c-red">*</span>备货期：</label>
                            <div class="formControls col-2">
                                <input type="text" class="input-text" value="" placeholder="" id="" name="">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-2">简略标题：</label>
                            <div class="formControls col-10">
                                <input type="text" class="input-text" value="" placeholder="" id="" name="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--批量编辑物流信息结束-->
        <div class="form-actions" style="text-align: right">
            <button type="button" class="btn blue" v-on:click="next">下一步</button>
            <button type="button" class="btn default">返回</button>
        </div>
    </div>
</div>
<script src="../../admin/assets/admin/pages/scripts/form-fileupload.js"></script>
<script src="../../admin/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>

<script charset="utf-8" src="{{ URL::asset('assets/plugins/layer/layer.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var result = new Array();
    var len = 0;
    var i = 0;
    jQuery(document).ready(function () {

    });
    var vm8 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#yfmb',
        data: {
            lists: '',
            keys: '',
            yfmb: ''
        },
        ready: function () {
            this.list();
            this.yfmblist();
        },
        methods: {
            list: function () {
                senddata = {status: 1};
                this.$http.get('/gettempList', senddata, function (data) {
                    this.$set('lists', eval(JSON.stringify(data.data)));
                })
            },
            yfmblist: function () {
                this.$http.get('/yfmblist', function (data) {
                    this.$set('yfmb', eval(data.data));
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
            deleteimg: function (type) {
                count = $("#imgradio1").val();
                this.$http.get('/deleteimages/' + count + '/' + type, function (data) {
                    if (eval(data).code) {
                        this.list();
                    }
                })
            },
            upload: function (event) {

            },
            fabu: function () {
                var index = layer.msg('产品发布中...', {icon: 16, time: false});
                this.$http.get('/fabu', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('发布成功');
                    }
                })
            },
            randimage: function () {
                var index = layer.msg('数据处理中...', {icon: 16, time: false});
                this.$http.get('/randimage', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        this.list();
                    }
                })
            },
            bank: function (event) {
                layer.open({
                    title: '图片银行',
                    offset: ['100px', '300px'],
                    type: 2,
                    area: ['70%', '75%'],
                    fix: true, //不固定
                    maxmin: true,
                    content: '/imagebank'
                });
            },
            keyslist: function () {
                this.$http.get('/getKeys/2', function (data) {
                    this.$set('keys', eval(JSON.stringify(data)));
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
                $('#tab7').click();
                $("#tab_71").load('/tobatch', function () {
                            $("#tab_71").fadeIn(100);
                        }
                );
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

    function run(input_file, get_data) {
        var tm = '';
        /*input_file：文件按钮对象,get_data: 转换成功后执行的方法*/
        if (typeof (FileReader) === 'undefined') {
            alert("抱歉，你的浏览器不支持 FileReader，不能将图片转换为Base64，请使用现代浏览器操作！");
        } else {
            try {
                len = input_file.files.length;
                for (var i = 0; i < len; i++) {
                    var file = input_file.files[i];
                    if (!/image\/\w+/.test(file.type)) {
                        alert("请确保文件为图像类型");
                        return false;
                    }
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        get_data(this.result);
                    }
                }
            } catch (e) {
                alert('图片转Base64出错啦！' + e.toString());
            }
        }
    }
</script>