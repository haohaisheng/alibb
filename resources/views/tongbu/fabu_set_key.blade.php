<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>
<style>
</style>
<script>
    $(document).ready(function () {
        $("#key_table").freezeHeader({'height': '400px'});
    });
</script>
<div class="row" id="key">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>产品管理</div>
                <div class="actions">
                  <!--  <label style="line-height: 27px;float: left;color: #0a0a0a;margin-right: 5px;">请选择关键词集合</label>

                    <div class="icheck-list" style="float:left;margin-right: 8px;">
                        <label>
                            <select class="form-control" id="keyid" onchange=""
                                    style="height:27px;width:150px;line-height: 27px;padding:0 12px;">
                                <option value="@{{k.id}}" v-for="k in keys">@{{k.title_key}}</option>
                            </select>
                        </label>
                    </div> -->
                    <a v-on:click="generate()" class="btn blue"><i class="fa fa-pencil"></i> 自动生成</a>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="key_table">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th class="table-checkbox">
                            <div class="checker" style="position:static;"><span>
                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"
                                   v-on:click="chk"/></span>
                            </div>
                        </th>
                        <th>产品标题</th>
                        <th>主关键词</th>
                        <th>次关键词</th>
                       <!-- <th>次关键词</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"
                                                              v-on:click="chk"/></span></div>
                        </td>
                        <td>@{{list.subject}}</td>
                        <td><input type="text" class="form-control form-filter input-sm" value="@{{list.key1}}"></td>
                        <td><input type="text" class="form-control form-filter input-sm" value="@{{list.key2}}"></td>
                       <!-- <td><input type="text" class="form-control form-filter input-sm" value="@{{list.key3}}"></td> -->
                    </tr>
                    </tbody>
                </table>
                <div class="form-actions">
                    <button type="button" class="btn default" v-on:click="func">高级设置
                    </button>
                </div>
                <div class="form-actions" style="text-align: right">
                    <button type="button" class="btn blue" v-on:click="next">下一步</button>
                    <button type="button" class="btn default">返回</button>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
<!-- END PAGE CONTENT-->
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var vm2 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#key',
        data: {
            lists: '',
            all: '',
            cur: 1,
            keys: ''
        },
        ready: function () {
            this.list(this.cur);
            this.keyslist();
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
            generate: function () {
                $id = $("#keyid").val();
                $id=0;
                this.$http.get('/keygenerate/' + $id, function (data) {
                    if (eval(data).code == '101') {
                        this.list(this.cur);
                    } else if (eval(data).code == '102') {
                        Alert5('请先在高级设置中设置生成规则！');
                    }
                })
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
                $('#tab5').click();
                $("#tab_51").load('/totitle', function () {
                            $("#tab_51").fadeIn(100);
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
</script>