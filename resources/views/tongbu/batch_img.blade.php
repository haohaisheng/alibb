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

    .radio-inline{
        position: relative;
        display: inline-block;
       /* padding-left: 0px;*/
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;
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

<script>
    $(document).ready(function () {
        //Metronic.init();
        $("#img_table").freezeHeader({'height': '300px'});
    });
</script>
<div class="row" id="batch_img">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑产品图片</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="bath_img" width="100%"
                       style="margin-top:0px;">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th>编号</th>
                        <th>产品标题</th>
                        <th>主图一</th>
                        <th>主图二</th>
                        <th>主图三</th>
                        <th>主图四</th>
                        <th>主图五</th>
                        <th>主图六</th>
                    </tr>
                    </thead>
                    <tbody style="">
                    <tr class="odd gradeX" v-for="list in lists" style="height: 50px;line-height: 50px;">
                        <td>@{{list.id}}</td>
                        <td>@{{list.subject}}</td>

                        <td>
                            <p>
                                <img v-bind:src="list.img1">
                            </p>
                        </td>
                        <td>
                            <p>
                                <img v-bind:src="list.img2">
                            </p>
                        </td>
                        <td style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img3">
                            </p>
                        </td>
                        <td style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img4">
                            </p>
                        </td>
                        <td style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img5">
                            </p>
                        </td>
                        <td style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img6">
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑产品图片
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body" style="margin-left:10px; ">
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="1"> 主图一
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="2"> 主图二
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="3"> 主图三
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="4"> 主图四
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="5"> 主图五 </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="6"> 主图六
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="all"> 主图一至六
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio2" id="radio2" value="option1">
                                    选择多张不同图片匹配产品 </label>
                                <span class="btn grey-cascade fileinput-button">
                                      <i class="fa fa-plus"></i>
                                      <span>选择图片</span>
                                      <input type="file" name="files[]" multiple="" id="file1">
                                </span>
                                <button type="button" class="btn grey-cascade" v-on:click="bank">图片银行</button>
                                <select class="form-control input-medium" style="display: inline-block" id="selecttype">
                                    <option value="1">循环使用图片</option>
                                    <option value="2">随机使用图片</option>
                                </select>
                                <!-- <button type="button" class="btn default">添加边框</button>-->
                                <!--<button type="button" class="btn grey-cascade">打乱图片顺序</button>-->
                            </div>
                        </div>
                        <!--  <div class="form-group">
                              <div class="radio-list">
                                  <label class="radio-inline">
                                      <input type="radio" name="radio3" id="radio3" value="option1"> 自动匹配图片文件名称与 </label>
                                  <button type="button" class="btn grey-cascade">产品型号相同的图片</button>
                              </div>
                          </div> -->
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio4" id="radio4" value="option1">批量删除图片 </label>
                                <button type="button" class="btn grey-cascade" v-on:click="deleteimg('one')">删除选中图片
                                </button>
                                <button type="button" class="btn grey-cascade" v-on:click="deleteimg('all')">删除全部图片
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio5" id="radio5" value="option1">全部替换为 </label>
                                <span class="btn grey-cascade fileinput-button">
											<i class="fa fa-plus"></i>
											<span>选择图片</span>
											<input type="file" name="files[]" multiple="" id="file2">
                                    </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="form-actions" style="text-align: right">
            <button type="button" v-on:click="" class="btn blue">保存</button>
            <button type="button" v-on:click="putbox()" class="btn blue">存入草稿箱</button>
            <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
            <button type="button" class="btn default">返回</button>
        </div>
    </div>
</div>
<script>
    var result = new Array();
    var len = 0;
    var i = 0;
    $(document).ready(function () {
        $("#title_img").freezeHeader({'height': '300px'});
        //Metronic.init();
        // ComponentsFormTools.init();
        $("#file1").on("change", function () {
            result = new Array();
            i = 0;
            run(this, function (data) {
                index = data.indexOf(',');
                data = data.substring(index + 1);
                result.push(data);
                i++;
                if (i == len) {
                    var zhutu = $('input[name="imgradio1"]:checked').val();
                    selecttype = $("#selecttype").val();
                    senddata = {
                        data: result,
                        count: zhutu,
                        selecttype: selecttype,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    var index = layer.msg('图片更新中...', {icon: 16, time: false});
                    $.post("/checkimage", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            vm4.list(1);

                        }
                    });
                }
            });
        });
        $("#file2").on("change", function () {
            run(this, function (data) {
                result = new Array();
                i = 0;
                index = data.indexOf(',');
                data = data.substring(index + 1);
                result.push(data);
                i++;
                if (i == len) {
                    var zhutu = $('input[name="imgradio1"]:checked').val();
                    selecttype = $("#selecttype").val();
                    senddata = {
                        data: result,
                        count: zhutu,
                        selecttype: 1,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    var index = layer.msg('图片更新中...', {icon: 16, time: false});
                    $.post("/checkimage", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            vm4.list(1);

                        }
                    });
                }
            });
        });
    });
    var vm4 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_img',
        data: {
            lists: '',
            keys: ''
        },
        ready: function () {
            this.list();
        },
        methods: {
            list: function () {
                this.$http.get('/batchimglist', function (data) {
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
            deleteimg: function (type) {
                var count = $('input[name="imgradio1"]:checked').val();
                this.$http.get('/delimg/' + count + '/' + type, function (data) {
                    if (eval(data).code) {
                        Alert1('删除成功');
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
                    content: '/batchimgbank1'
                });
            },
            batchfabu: function () {
                var index = layer.msg('编辑发布中...', {icon: 16, time: false});
                this.$http.get('/batchfabu', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('编辑发布成功');
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