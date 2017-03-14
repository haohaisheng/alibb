<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<div id="param">
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="actions">
                        <a href="javascript:;" v-on:click="fadd(0)" class="btn btn-circle btn-default">
                            <i class="fa fa-plus"></i> 添加 </a>
                        <a href="javascript:;" v-on:click="editKey(0)" class="btn btn-circle btn-default">
                            <i class="fa fa-pencil"></i> 修改 </a>
                        <a href="javascript:;" v-on:click="fudelKey()" class="btn btn-circle btn-default">
                            <i class="fa fa-pencil"></i> 删除 </a>

                        <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow"
                         data-handle-color="#a1b2bd">
                        <select class="form-control" name="select_multi" id="fu" multiple
                                style="height: 200px;margin-bottom: 10px;">
                            <option v-on:click="childlist(list.id,list.status)" value="@{{list.id}}"
                                    v-for="list in lists" track-by="$index">@{{list.title_key}}</option>
                        </select>

                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>

        <div class="col-md-6">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="actions">
                        <a href="javascript:;" v-on:click="fadd(2)" class="btn btn-circle btn-default">
                            <i class="fa fa-plus"></i> 添加 </a>
                        <a href="javascript:;" v-on:click="childdelKey()" class="btn btn-circle btn-default">
                            <i class="fa fa-pencil"></i> 修改 </a>
                        <a href="javascript:;" v-on:click="childdelKey()" class="btn btn-circle btn-default">
                            <i class="fa fa-pencil"></i> 删除 </a>

                        <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen"></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow"
                         data-handle-color="#a1b2bd">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                            <tr>
                                <th width="70%">关键词</th>
                                <th class="table-checkbox" style="width1:8px;">选择
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="odd gradeX" v-for="c in childs">
                                <td>@{{c.title_key}}</td>
                                <td>
                                    <div class="checker"><span><input type="checkbox" class="checkboxes"
                                                                      value="@{{c.id}}"
                                                                      v-on:click="chk"/></span></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
        </div>
    </div>

    <div class="form-group" style="margin-top: 30px;">
        <label>设置标题生成格式</label>
        <select class="form-control input-xlarge">
            <option v-for="t in titles">@{{t.title}}</option>
        </select>
    </div>
    <span class="help-block">设置产品标题生成格式,将按这里的格式生成每个产品的标题，例如：{前缀}{主关键词}{后缀} </span>

    <div class="form-actions" style="text-align: right">
        <button type="button" class="btn blue" v-on:click="next">下一步</button>
        <button type="button" class="btn default">返回</button>
    </div>
</div>

<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    jQuery(document).ready(function () {
        $("#sample_1").freezeHeader({'height': '200px'});
    });
    var vm1 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#param',
        data: {
            lists: '',
            childs: '',
            fid: '',
            ftype: '',
            id: '',
            titles: ''
        },
        ready: function () {
            this.list();
            this.titleFormat();
        },
        methods: {
            list: function () {
                this.$http.get('/getkeylist/0', function (data) {
                    this.$set('lists', eval(JSON.stringify(data)));
                    var da = eval(JSON.stringify(data));
                    this.childlist(da[0].id, da[0].status);
                })
            },
            chk: function (event) {
                if (event.target.checked) {
                    event.target.parentNode.className = "checked";
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd active";
                    this.$set('id', event.target.value);
                    senddata = {
                        ids: event.target.value,
                        fid: vm1.fid,
                        ftype: vm1.ftype,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    $.post("/savetempkey", senddata, function (result) {
                    });
                } else {
                    event.target.parentNode.parentNode.parentNode.parentNode.className = "gradeX odd ";
                    event.target.parentNode.className = "";
                    this.$set('id', event.target.value);
                    senddata = {
                        ids: event.target.value,
                        fid: this.fid,
                        ftype: this.ftype,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    $.post("/deltempkey", senddata, function (result) {
                    });
                }
            },
            fabu: function () {
                $("#aa").click()
                return false;
            },
            childlist: function (fid, ftype) {
                this.$set('fid', fid);
                this.$set('ftype', ftype);
                this.$http.get('/getkeylist/' + fid, function (data) {
                    this.$set('childs', eval(JSON.stringify(data)));
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            },
            fadd: function (type) {
                if (type == 0) {
                    fuid = 0;
                } else {
                    fuid = this.fid
                }
                layer.prompt({
                    title: '输入标题词语',
                    formType: 0 //prompt风格，支持0-2
                }, function (key) {
                    senddata = {
                        key: key,
                        fid: fuid,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    $.post("/saveKeys", senddata, function (result) {
                        if (eval(result).code) {
                            layer.closeAll();
                            if (type == 0) {
                                vm1.list();
                            } else {
                                vm1.childlist(fuid, vm1.ftype);
                            }
                        }
                    });
                });
            },
            editKey: function (type) {
                fid = this.fid;
                id = this.fid;
                layer.prompt({
                    title: '输入标题词语',
                    formType: 0 //prompt风格，支持0-2
                }, function (key) {
                    if (type != 0) {
                        id = vm1.id;
                    }
                    senddata = {
                        key: key,
                        id: id,
                        _token: document.getElementsByTagName('meta')['_token'].content
                    };
                    $.post("/editKey", senddata, function (result) {
                        if (eval(result).code) {
                            layer.closeAll();
                            if (type == 0) {
                                vm1.list();
                            } else {
                                vm1.childlist(fid, vm1.ftype);
                            }
                        }
                    });
                });
            },
            childdelKey: function () {
                senddata = {
                    id: $("#childs").val(),
                    _token: document.getElementsByTagName('meta')['_token'].content
                };
                $.post("/delKey", senddata, function (result) {
                    if (eval(result).code) {
                        vm1.childlist(vm1.fid, vm1.ftype);
                    }
                });
            },
            fudelKey: function () {
                senddata = {
                    id: $("#fu").val(),
                    _token: document.getElementsByTagName('meta')['_token'].content
                };
                $.post("/delKey", senddata, function (result) {
                    if (eval(result).code) {
                        vm1.list();
                    }
                });
            },
            titleFormat: function () {
                this.$http.get('/gettitleformat', function (data) {
                    this.$set('titles', eval(JSON.stringify(data)));
                })
            },
            next: function () {
                $('#tab4').click();
                $("#tab_41").load('/tokey', function () {
                            $("#tab_41").fadeIn(100);
                        }
                );
            }
        }
    })
</script>