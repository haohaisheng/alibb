<style>
    .actions {
        float: inherit;
        /* display: inline-block; */
        padding: 0px 0;
    }

    .radio-inline {
        position: relative;
        display: inline-block;
        margin-bottom: 0;
        font-weight: 400;
        vertical-align: middle;
    }
</style>
<script src="{{ URL::asset('assets/plugins/freezeheader/js/jquery.freezeheader.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#title_table").freezeHeader({'height': '400px'});
    });
</script>
<div class="row" id="title">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>标题生成</div>
                <div class="actions" style="float: inherit;color: #333333;margin-left: 70px;">
                    <label style="margin-bottom:0px;line-height: 27px;float: left;color: #333333;margin-right: 5px;">生成设置：</label>

                    <div class="radio-list" style="float: left;line-height: 27px;">
                        <label class="radio-inline">
                            <input type="radio" name="radio1" id="matching_set" value="1" checked="true"> 顺序匹配 </label>
                        <label class="radio-inline" style="margin-left: 10px;">
                            <input type="radio" name="radio1" id="matching_set" value="2"> 随机匹配 </label>
                    </div>
                    {{-- <a v-on:click="generate()" class="btn blue"><i class="fa fa-pencil"></i> 自动生成</a>--}}
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="title_table">
                    <thead>
                    <tr style="background-color: #EEEEEE">
                        <th class="table-checkbox" style="width1:8px;background-color: #EEEEEE">
                            <div class="checker"><span>
                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"
                                   v-on:click="chk"/></span>
                            </div>
                        </th>
                        <th width="20%">产品标题</th>
                        <th>生成标题</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd gradeX" v-for="list in lists">
                        <td>
                            <div class="checker"><span><input type="checkbox" class="checkboxes" value="1"
                                                              v-on:click="chk"/></span></div>
                        </td>
                        <td>@{{list.subject}}</td>
                        <td><input type="text" class="form-control form-filter input-sm" id="@{{list.id}}"
                                   onblur="savetitle('@{{list.id}}')" value="@{{list.subject1}}">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-actions" style="text-align: right">
                    <button type="button" class="btn default" v-on:click="generate">马上生成
                    </button>
                </div>
            </div>
        </div>
        <div class="form-actions" style="text-align: right">
            <button type="button" class="btn blue" v-on:click="next">下一步</button>
            <button type="button" class="btn default">返回</button>
        </div>
    </div>
</div>

{{--<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>--}}
<script>
    function savetitle(id) {
        var title = $("#" + id).val();
        if (title != '') {
            senddata = {
                id: id,
                title: title,
                _token: document.getElementsByTagName('meta')['_token'].content
            };
            $.post("/savetitle", senddata, function (result) {
                if (eval(result).code) {
                    vm2.list();
                }
            });
        }
    }

    var vm2 = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#title',
        data: {
            lists: '',
            all: '',
            cur: 1,
            keys: ''
        },
        ready: function () {
            this.list(this.cur);
            // this.keyslist();
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
                id = $("input[name='radio1']:checked").val();
                this.$http.get('/titlegenerate/' + id, function (data) {
                    if (eval(data).code) {
                        this.list(this.cur);
                    }
                })
            },
            savetitle: function () {
                id = $("input[name='radio1']:checked").val();
                this.$http.get('/titlegenerate/' + id, function (data) {
                    if (eval(data).code) {
                        this.list(this.cur);
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
                $('#tab6').click();
                $("#tab_61").load('/towuliu', function () {
                            $("#tab_61").fadeIn(100);
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