<style>
    .actions {
        float: inherit;
        padding: 0px 0;
    }

    .radio-inline {
        position: relative;
        display: inline-block;
        padding-left: 0px;
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

<div class="row" id="batch">
    <div class="col-sm-12">
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑必填属性</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr style="display:block;background-color: red;" width="100%">
                        <th width="10%">编号</th>
                        <th width="10%">产品标题</th>
                        <th width="10%">主图一</th>
                        <th width="10%">主图二</th>
                        <th width="10%">主图三</th>
                        <th width="10%">主图四</th>
                        <th width="10%">主图五</th>
                        <th width="10%">主图六</th>
                        <th width="10%">新值</th>
                        <th width="10%">新值</th>
                    </tr>
                    </thead>
                    <tbody style="display:block;height: 200px;overflow: auto">
                    <tr class="odd gradeX" v-for="list in lists" style="height: 50px;line-height: 50px;">
                        <td width="10%">{{list.id}}</td>
                        <td width="10%">{{list.subject1}}</td>

                        <td width="10%">
                            <p>
                                <img v-bind:src="list.img1">
                            </p>
                        </td>
                        <td width="10%">
                            <p>
                                <img v-bind:src="list.img2">
                            </p>
                        </td>
                        <td width="10%" style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img3">
                            </p>
                        </td>
                        <td width="10%" style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img4">
                            </p>
                        </td>
                        <td width="10%" style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img5">
                            </p>
                        </td>
                        <td width="10%" style="vertical-align: middle;">
                            <p>
                                <img v-bind:src="list.img6">
                            </p>
                        </td>
                        <td width="10%" style="vertical-align: middle;">aa</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--批量编辑产品图片开始-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑产品图片
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="1"> 主图一 </label>
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
                                    <input type="radio" name="imgradio1" id="imgradio1" value="6"> 主图6
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="imgradio1" id="imgradio1" value="all"> 主图一至六
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio2" id="radio2" value="option1"> 选择多张不同图片匹配产品 </label>
                                <span class="btn default fileinput-button">
                                      <i class="fa fa-plus"></i>
                                      <span>选择图片</span>
                                      <input type="file" name="files[]" multiple="" id="file1">
                              </span>
                                <button type="button" class="btn default" v-on:click="bank">图片银行</button>
                                <select class="form-control input-medium" style="display: inline-block" id="selecttype">
                                    <option value="1">循环使用图片</option>
                                    <option value="2">数据使用图片</option>
                                    <option>默认</option>
                                </select>
                                <button type="button" class="btn default" v-on:click="generate">添加边框</button>
                                <button type="button" class="btn default" v-on:click="generate">打乱图片顺序</button>
                            </div>
                        </div>
                        <!--  <div class="form-group">
                              <div class="checkbox-list">
                                  <label class="checkbox-inline">
                                      <input type="checkbox" id="inlineCheckbox1" value="option1"> Checkbox 1 </label>
                                  <label class="checkbox-inline">
                                      <input type="checkbox" id="inlineCheckbox2" value="option2"> Checkbox 2 </label>
                              </div>
                          </div>-->
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio3" id="radio3" value="option1"> 自动匹配图片文件名称与 </label>
                                <button type="button" class="btn default" v-on:click="generate">产品型号相同的图片</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio4" id="radio4" value="option1">批量删除图片 </label>
                                <button type="button" class="btn default" v-on:click="deleteimg('none')">删除选中图片</button>
                                <button type="button" class="btn default" v-on:click="deleteimg('all')">删除全部图片</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio5" id="radio5" value="option1">全部替换为 </label>
                               <span class="btn default fileinput-button">
											<i class="fa fa-plus"></i>
											<span>选择图片</span>
											<input type="file" name="files[]" multiple="" id="file2">
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions" style="text-align: right">
                        <button type="button" v-on:click="deleteimg('all')" class="btn blue">保存</button>
                        <button type="button" class="btn blue">发布</button>
                        <button type="button" class="btn default">返回</button>
                    </div>
                </form>
            </div>
        </div>
        <!--批量编辑产品图片结束-->
    </div>
</div>

<script src="../../admin/assets/admin/pages/scripts/form-fileupload.js"></script>
<script src="../../admin/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script>
    var result = new Array();
    var len = 0;
    var i = 0;
    jQuery(document).ready(function () {
        $("#file1").on("change", function () {
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
                        selecttype: selecttype
                    };
                    var index = layer.msg('图片更新中...', {icon: 16, time: false});
                    $.post("/uploadimage", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            vm5.list(1);

                        }
                    });
                }
            });
        });
        $("#file2").on("change", function () {
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
                        selecttype: selecttype
                    };
                    var index = layer.msg('图片更新中...', {icon: 16, time: false});
                    $.post("/uploadimage", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            vm5.list(1);

                        }
                    });
                }
            });
        });
    });
    var vm5 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch',
        data: {
            lists: '',
            all: '',
            cur: 1,
            keys: ''
        },
        ready: function () {
            this.list(this.cur);
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
                senddata = {page: index, status: 1};
                this.$http.get('/gettempList', senddata, function (data) {
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
            deleteimg: function (type) {
                count = $("#radio1").val();
                this.$http.get('/deleteimages/' + count + '/' + type, function (data) {
                    if (eval(data).code) {
                        this.list(this.cur);
                    }
                })
            },
            upload: function (event) {

            },
            fabu: function () {
                this.$http.get('/fabu', function (data) {
                    if (eval(data).code) {
                        Alert('发布成功');
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