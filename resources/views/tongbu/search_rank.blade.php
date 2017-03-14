<div class="row" id="app">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom tabbable-noborder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="tab1" href="#tab_1" data-toggle="tab" v-on:click="tab_content('tab_11','fabu_count')">
                        查询关键词排名 </a>
                </li>
                <li>
                    <a id="tab2" href="#tab_2" data-toggle="tab" v-on:click="tab_content('tab_21','/batchkey')">
                        查询产品排名 </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="margin-top-10">
                        @include('tongbu.search_rank_key')
                    </div>
                </div>
                <div class="tab-pane" id="tab_2">
                    <div class="filter-v1 margin-top-10" id="tab_21">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var i = 0;
    jQuery(document).ready(function () {
    });
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
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