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

    .radio-inline {
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
       // Metronic.init();
        $("#bath_detail_img_table").freezeHeader({'height': '300px'});
        $("#bath_detail_img_table1").freezeHeader({'height': '300px'});
    });
</script>
<div class="row" id="batch_detail_img">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>批量编辑产品详情图片</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="bath_detail_img_table"
                       style="margin-top:0px;">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th>编号</th>
                        <th>产品标题</th>
                        <th>主图一</th>
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
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="portlet box grey" style="margin-bottom: 0px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> 批量编辑产品详情图片
                </div>
            </div>

            <div class="" style="width: 48%;float: left;margin-top: 5px;">
                <table class="table table-striped table-bordered table-hover" id="bath_detail_img_table1"
                       style="margin-top:0px;">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th>图片</th>
                        <th>使用次数</th>
                    </tr>
                    </thead>
                    <tbody style="">
                    <tr class="odd gradeX" v-for="list in imgs" style="height: 50px;line-height: 50px;cursor: pointer;"
                        id="@{{list.id}}" value="@{{list.ids}}|@{{list.url}}"
                        v-on:click="select(list.id)">
                        <td>
                            <p>
                                <img v-bind:src="list.url">
                            </p>
                        </td>
                        <td>@{{list.count}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class=" form" style="width: 48%;float: left;">
                <form role="form">
                    <div class="form-body" style="margin-left:10px; ">
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio2" id="radio2" value="option1">
                                    替换为另外一张图片 </label>
                                <button type="button" class="btn grey-cascade" v-on:click="bank">从图片银行选取</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio-list">
                                <label class="radio-inline">
                                    <input type="radio" name="radio3" id="radio3" value="option1"> 从所有产品中删除选中图片 </label>
                                <button type="button" class="btn grey-cascade" v-on:click="removeimg">删除</button>
                            </div>
                        </div>
                        <!--  <div class="form-group">
                              <div class="radio-list">
                                  <label class="radio-inline">
                                      <input type="radio" name="radio3" id="radio3" value="option1">
                                      使用型号自动匹配图片文件名称与产品型号相同的图片 </label>
                                  <button type="button" class="btn grey-cascade">选中图片文件夹</button>
                              </div>
                          </div> -->
                        <div class="form-group">
                            <div class="radio-list">
                                <input type="hidden" id="ids">
                                <input type="hidden" id="imgurl">
                                <input type="hidden" id="uploadimg">
                                <label class="radio-inline">
                                    <input type="radio" name="radio4" id="radio4" value="option1">插入图片 </label>
                                <span class="btn grey-cascade fileinput-button">
                                      <i class="fa fa-plus"></i>
                                      <span>所选图片之前</span>
                                      <input type="file" name="files" multiple="" id="file1">
                                </span>
                                <button type="button" class="btn grey-cascade" v-on:click="removeinsertimg(1)">删除插入
                                </button>
                                <span class="btn grey-cascade fileinput-button">
                                      <i class="fa fa-plus"></i>
                                      <span>所选图片之后</span>
                                      <input type="file" name="files[]" multiple="" id="file1">
                                </span>
                                <button type="button" class="btn grey-cascade" v-on:click="removeinsertimg(2)">删除插入
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="form-actions" style="text-align: right;margin-right: 20px;">
       <!--  <button type="button" v-on:click="" class="btn blue">保存</button> -->
        <button type="button" v-on:click="putbox()" class="btn blue">存入草稿箱</button>
        <button type="button" v-on:click="batchfabu()" class="btn blue">发布</button>
        <button type="button" class="btn default">返回</button>
    </div>
</div>
<script>
    var result = new Array();
    var len = 0;
    var i = 0;
    var up_type = 0;
    $(document).ready(function () {
        $("#file1").on("change", function () {
            result = new Array();
            i = 0;
            run(this, function (data) {
                index = data.indexOf(',');
                data = data.substring(index + 1);
                result.push(data);
                i++;
                if (i == len) {
                    var ids = $("#ids").val();
                    var imgurl = $("#imgurl").val();
                    senddata = {
                        data: result,
                        ids: ids,
                        checkimg: imgurl,
                        type: 1,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    var index = layer.msg('图片插入中...', {icon: 16, time: false});
                    $.post("/insertimg", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('插入成功');
                            vm8.imglist();
                            up_type = 1;
                            $("#uploadimg").val(eval(result).uploadimg);
                        }
                    });
                }
            });
        });
        $("#file2").on("change", function () {
            result = new Array();
            i = 0;
            run(this, function (data) {
                index = data.indexOf(',');
                data = data.substring(index + 1);
                result.push(data);
                i++;
                if (i == len) {
                    var ids = $("#ids").val();
                    var imgurl = $("#imgurl").val();
                    senddata = {
                        data: result,
                        ids: ids,
                        checkimg: imgurl,
                        type: 2,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    var index = layer.msg('图片插入中...', {icon: 16, time: false});
                    $.post("/insertimg", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('插入成功');
                            vm8.imglist();
                            up_type = 2;
                            $("#uploadimg").val(eval(result).uploadimg);
                        }
                    });
                }
            });
        });
    });
    var vm8 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#batch_detail_img',
        data: {
            lists: '',
            imgs: '',
            keys: ''
        },
        ready: function () {
            this.imglist();
        },
        methods: {
            list: function (ids) {
                senddata = {ids: ids};
                this.$http.get('/batchimglist', senddata, function (data) {
                    this.$set('lists', eval(data));
                })
            },
            imglist: function () {
                this.$http.get('/getbatchdetailimglist', function (data) {
                    this.$set('imgs', eval(data));
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
            bank: function (event) {
                layer.open({
                    title: '图片银行',
                    offset: ['100px', '300px'],
                    type: 2,
                    area: ['70%', '75%'],
                    fix: true, //不固定
                    maxmin: true,
                    content: '/batchimgbank'
                });
            },
            select: function (id) {
                $("#" + id).addClass("active").siblings().removeClass("active");
                var ids = $("#" + id).attr('value');
                arr = ids.split("|")
                this.list(arr[0]);
                $("#ids").val(arr[0]);
                $("#imgurl").val(arr[1]);
            },
            removeimg: function (id) {
                var ids = $("#ids").val();
                var imgurl = $("#imgurl").val();
                senddata = {
                    ids: ids,
                    checkimg: imgurl
                };
                var index = layer.msg('图片删除中...', {icon: 16, time: false});
                this.$http.get('/removedetailimg', senddata, function (data) {
                    if (eval(data).code) {
                        this.list(ids);
                        this.imglist();
                        layer.closeAll();
                        Alert1('删除成功');
                    }
                })
            },
            removeinsertimg: function (type) {
                if (type != up_type) {
                    Alert5('未进行相关操作');
                    return false;
                }
                var ids = $("#ids").val();
                var imgurl = $("#imgurl").val();
                var uploadimg = $("#uploadimg").val();
                senddata = {
                    ids: ids,
                    checkimg: imgurl,
                    delimg: uploadimg,
                    type: type
                };
                var index = layer.msg('图片删除中...', {icon: 16, time: false});
                this.$http.get('/removeinsertdetailimg', senddata, function (data) {
                    if (eval(data).code) {
                        this.imglist();
                        layer.closeAll();
                        Alert1('删除成功');
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
            batchfabu: function () {
                var index = layer.msg('编辑发布中...', {icon: 16, time: false});
                this.$http.get('/batchfabu', function (data) {
                    if (eval(data).code) {
                        layer.close(index);
                        Alert1('编辑发布成功');

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