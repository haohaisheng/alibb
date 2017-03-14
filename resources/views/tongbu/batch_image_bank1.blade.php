<link href="../../admin/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../admin/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="../../admin/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="../../admin/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<meta name="_token" content="{{csrf_token()}}"/>
<style type="text/css">
    ul img {
        width: 70px;
        height: 70px;
    }

    li {
        list-style-type: none
    }
</style>
<div id="app" style="margin-top: 10px;">
    <div class="col-sm-12">
        <div>
            <label>
                <select class="" id="groupid" v-on:change="list1(1)"
                        style="height:27px;width:150px;line-height: 27px;padding:0 12px;">
                    <option value="">全部类目</option>
                    <option value="@{{g.albumID}}" v-for="g in group"
                    >@{{g.name}}</option>
                </select>
            </label>
        </div>
        <ul id="ul">
            <li>
                <div v-for="list in lists">
                    <div style="float: left;margin:0 10px 10px 0;border: #ddd solid 1px;padding: 5px;">
                        <label>
                            <input type="checkbox" name="chk" value="@{{list.url}}" v-on:click="chk(list.url)">
                            <img v-bind:src="list.url">
                        </label>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-7 col-sm-12" style="margin-bottom: 10px;">
        <div class="dataTables_paginate paging_bootstrap">
            <ul class="pagination" style="visibility: visible;">
                <li class="prev disabled"><a href="#" title="Previous"><i class="fa fa-angle-left"
                                                                          style="line-height: 19px;"></i></a>
                </li>
                <li v-for="index in indexs" v-bind:class="{ 'active': cur == index}">
                    <a v-on:click="list(index,'defa')">@{{ index }}</a>
                </li>
                <li class="next"><a href="#" title="Next"><i class="fa fa-angle-right"
                                                             style="line-height: 19px;"></i></a></li>
                <li><a>共<i>@{{all}}</i>页</a></li>
            </ul>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-actions" style="text-align: right;margin-bottom: 5px;margin-right: 20px;">
            <button type="button" class="btn blue" v-on:click="submit">确定</button>
            <button type="button" class="btn default" v-on:click="cancel">返回</button>
        </div>
    </div>
</div>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/layer/layer.js') }}"></script>
<script>
    jQuery(document).ready(function () {

    });
    var vm9_1 = new Vue({
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
            list: function (index) {
                this.cur = index;
                if (gid == 'defa') {
                    gid = this.groupid;
                } else {
                    this.$set('groupid', gid);
                }
                this.$http.get('/getimagelist/' + this.cur, function (data) {
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
            chk: function (id) {
                /*var chk_value = [];
                 $('input[name="chk"]:checked').each(function () {
                 if (chk_value.length >= 1) {
                 Alert5('只能选择一张图片');
                 return false;
                 }
                 chk_value.push($(this).val());
                 });
                 this.$set('chks', chk_value); */
                var chk_value = [];
                $('input[name="chk"]:checked').each(function () {
                    chk_value.push($(this).val());
                });
                this.$set('chks', chk_value);
            },
            submit: function (id) {
                count = 0;
                chkObjs = window.parent.document.getElementsByName("imgradio1");
                for (var i = 0; i < chkObjs.length; i++) {
                    if (chkObjs[i].checked) {
                        count = chkObjs[i].value;
                    }
                }
                selecttype = window.parent.document.getElementById("selecttype").value;
                senddata = {
                    count: count,
                    imags: this.chks,
                    selecttype: selecttype
                };
                this.$http.post('/savebatchproductimages', senddata, function (data) {
                    if (eval(data).code) {
                        parent.vm4.list(1);
                        parent.layer.closeAll();
                    }
                })
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
</script>