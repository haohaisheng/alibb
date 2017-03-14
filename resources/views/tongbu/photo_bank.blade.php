<link href="../../admin/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css"
      rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
<link href="../../admin/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
<style type="text/css">
    ul img {
        width: 70px;
        height: 70px;
    }

    li {
        list-style-type: none
    }
</style>
<div class="row">
    <div class="col-md-12">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">主目录</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">系统管理</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li><a href="#">图片银行</a></li>
        </ul>
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row" id="app">
    <div class="col-sm-12">
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>图片银行</div>
                <div class="actions">

                    <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label>
                            <select class="form-control" id="groupid" v-on:change="list1(1)"
                                    style="height:27px;width:150px;line-height: 27px;padding:0 12px;">
                                <option value="">全部类目</option>
                                <option value="@{{g.albumID}}" v-for="g in group"
                                >@{{g.name}}</option>
                            </select>
                        </label>
                    </div>
                    <span class="btn blue fileinput-button">
                                      <i class="fa fa-plus"></i>
                                      <span>上传图片</span>
                                      <input type="file" name="files[]" multiple="" id="file1">
                    </span>
                    <a v-on:click="tongbu()" class="btn blue"><i class="fa  fa-download"></i> 图片同步</a>
                    <a v-on:click="deleteimage()" class="btn red"><i class="fa fa-trash-o"></i> 删除图片</a>

                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="fa fa-cogs"></i> 更多操作
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <!--   <ul class="dropdown-menu pull-right">
                               <li><a><i class="fa fa-trash-o"></i> 删除</a></li>
                               <li><a><i class="fa fa-ban"></i> 禁用</a></li>
                           </ul> -->
                    </div>
                </div>
            </div>
            <div class="portlet-body" style="height:600px;">
                <ul id="ul" style="width:100%">
                    <li>
                        <div v-for="list in lists">
                            <div style="float: left;margin:0 10px 10px 0;border: #ddd solid 1px;padding: 5px;">
                                <label style="cursor: pointer">
                                    <input type="checkbox" name="chk" value="@{{list.url}}" id="@{{ list.albumID}}"
                                           v-on:click="chk(list.id)">
                                    <img v-bind:src="list.url">
                                </label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="dataTables_paginate paging_bootstrap">
                    <ul class="pagination" style="visibility: visible;">
                        <li class="prev disabled"><a href="#" title="Previous"><i class="fa fa-angle-left"></i></a>
                        </li>
                        <li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                            <a v-on:click="list(index,'defa')">@{{ index }}</a>
                        </li>
                        <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"></i></a></li>
                        <li><a>共<i>@{{all}}</i>页</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<script src="../../admin/assets/admin/pages/scripts/form-fileupload.js"></script>
<script src="../../admin/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var len = 0;
    jQuery(document).ready(function () {
        $("#file1").on("change", function () {
            var i = 0;
            var result = new Array();
            run(this, function (data) {
                index = data.indexOf(',');
                data = data.substring(index + 1);
                result.push(data);
                i++;
                if (i == len) {
                    var groupid = $("#groupid").val();
                    if (groupid == '') {
                        groupid = 'all';
                    }
                    senddata = {
                        data: result,
                        gid: groupid,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    var index = layer.msg('图片上传中...', {icon: 16, time: false});
                    $.post("/photoupload", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('上传成功');
                            vm.list(1, groupid);
                        }
                    });
                }
            });
        });
    });

    var type = 'online';
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
        data: {
            lists: '',
            all: '',
            cur: 1,
            chks: '',
            group: '',
            groupid: ''
        },
        ready: function () {
            this.listgroup();
            this.list(this.cur, 'all');
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
            list: function (index, gid) {
                this.cur = index;
                if (gid == 'defa') {
                    gid = this.groupid;
                } else {
                    this.$set('groupid', gid);
                }
                this.$http.get('/getimagelist/' + this.cur + '/' + gid, function (data) {
                    this.$set('lists', eval(data).data);
                    this.$set('all', eval(data).totalPage);
                })
            },
            list1: function (index) {
                var groupid = $("#groupid").val();
                this.$set('groupid', groupid);
                this.list(index, groupid);
            },
            listgroup: function (index, gid) {
                this.$http.get('/getimagegroup', function (data) {
                    this.$set('group', eval(data).data);
                })
            },
            deleteimage: function () {
                if (this.chks == '') {
                    Alert5('先选择要删除的图片');
                    return false;
                }
                layer.confirm('确定要删除吗？', {
                    btn: ['确定', '取消'] //按钮
                }, function () {
                    var index = layer.msg('图片删除中...', {icon: 16, time: false});
                    senddata = {
                        ids: vm.chks,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    $.post("/deleteimage", senddata, function (result) {
                        if (eval(result).code) {
                            layer.close(index);
                            Alert1('删除成功');
                            vm.list(1);
                        }
                    });
                }, function () {
                    return false;
                });
                /* senddata = {
                 ids: this.chks
                 };
                 this.$http.post('/deleteimage', senddata, function (data) {
                 layer.closeAll();
                 alert(eval(data).code);
                 if (eval(data).code == 101) {
                 Alert1('删除成功');
                 this.list(this.cur);
                 }
                 }) */

            },
            chk: function (id) {
                var chk_value = [];
                $('input[name="chk"]:checked').each(function () {
                    chk_value.push(id);
                });
                this.$set('chks', chk_value);
            },
            tongbu: function () {
                Alert1('同步完成');
            },
            cancel: function () {
                var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                parent.layer.close(index);
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