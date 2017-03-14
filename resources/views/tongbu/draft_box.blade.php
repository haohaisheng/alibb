<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<div class="row" id="app1">
    <div class="col-md-12">
        <div class="tabbable tabbable-custom tabbable-noborder">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a id="tab1" href="#tab_1" data-toggle="tab" v-on:click="tab_content('tab_11','/editbox')">
                        编辑草稿箱 </a>
                </li>
                <li>
                    <a id="tab2" href="#tab_2" data-toggle="tab" v-on:click="tab_content('tab_21','/fabubox')">
                        发布草稿箱 </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="filter-v1 margin-top-10" id="tab_11">
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

<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app1',
        data: {
            productid: ''
        },
        ready: function () {
            this.tab_content('tab_11', '/editbox');
        },
        methods: {
            tab_content: function (tab, action) {
                $("#" + tab).load(action, function () {
                            $("#" + tab).fadeIn(100);
                        }
                );
            },
        }
    })
</script>