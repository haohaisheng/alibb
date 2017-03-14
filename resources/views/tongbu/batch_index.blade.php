<div class="row" id="app_index">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom tabbable-noborder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="tab1" href="#tab_1" data-toggle="tab" v-on:click="tab_content('tab_11','/batchtitle')">
                        编辑标题 </a>
                </li>
               <!-- <li>
                    <a id="tab2" href="#tab_2" data-toggle="tab" v-on:click="tab_content('tab_21','/batchkey')">
                        编辑关键词 </a>
                </li> -->
                <li>
                    <a id="tab3" href="#tab_3" data-toggle="tab" v-on:click="tab_content('tab_31','/batchcategory')">
                        编辑类目 </a>
                </li>
                <li>
                    <a id="tab4" href="#tab_4" data-toggle="tab" v-on:click="tab_content('tab_41','/batchimg')">
                        编辑图片 </a>
                </li>
                <li>
                    <a id="tab5" href="#tab_5" data-toggle="tab" v-on:click="tab_content('tab_51','/batchprice')">
                        编辑价格 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_6" data-toggle="tab" v-on:click="tab_content('tab_61','/batchminorder')">
                        编辑最小起定量 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_7" data-toggle="tab" v-on:click="tab_content('tab_71','/batchunit')">
                        编辑最小计量单位 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_8" data-toggle="tab" v-on:click="tab_content('tab_81','/batchpricerange')">
                        修改价格区间 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_9" data-toggle="tab" v-on:click="tab_content('tab_91','/batchdetail')">
                        编辑详情 </a>
                </li>
                <li>
                    <a id="tab6" href="#tab_10" data-toggle="tab" v-on:click="tab_content('tab_101','/batchdetailimg')">
                        编辑详情图片 </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="margin-top-10">
                        @include('tongbu.batch_title', array('ids'=>$ids))
                    </div>
                </div>
             <!--   <div class="tab-pane" id="tab_2">
                    <div class="filter-v1 margin-top-10" id="tab_21">
                    </div>
                </div> -->
                <div class="tab-pane" id="tab_3">
                    <div class="filter-v1 margin-top-10" id="tab_31">
                    </div>
                </div>
                <div class="tab-pane" id="tab_4">
                    <div class="filter-v1 margin-top-10" id="tab_41">
                    </div>
                </div>
                <div class="tab-pane" id="tab_5">
                    <div class="filter-v1 margin-top-10" id="tab_51">
                    </div>
                </div>
                <div class="tab-pane" id="tab_6">
                    <div class="filter-v1 margin-top-10" id="tab_61">
                    </div>
                </div>
                <div class="tab-pane" id="tab_7">
                    <div class="filter-v1 margin-top-10" id="tab_71">
                    </div>
                </div>
                <div class="tab-pane" id="tab_8">
                    <div class="filter-v1 margin-top-10" id="tab_81">
                    </div>
                </div>
                <div class="tab-pane" id="tab_9">
                    <div class="filter-v1 margin-top-10" id="tab_91">
                    </div>
                </div>
                <div class="tab-pane" id="tab_10">
                    <div class="filter-v1 margin-top-10" id="tab_101">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../admin/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script>
    var i = 0;
    var total = 0;
    var count = 0;
    var d = 0;
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app_index',
        data: {
            productid: ''
        },
        ready: function () {

        },
        methods: {
            tab_content: function (tab, action) {
                $("#" + tab).load(action, function () {
                            $("#" + tab).fadeIn(100);
                        }
                );
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
                        $('#tab2').click();
                        $("#tab_21").load('/batchkey', function () {
                                    $("#tab_21").fadeIn(100);
                                }
                        );
                    }
                })
            }
        }
    })
</script>