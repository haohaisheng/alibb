@include('admin.common.head')
<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<style>
    .radio-inline input[type=radio] {
        position: relative;
        margin-left: 0px
    }
</style>
<!-- END PAGE HEADER-->
<div class="row" id="sets" style="background-color:white;margin-left: 0;margin-right: 0;">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey" style="margin-bottom: 0">
            <div class="portlet-body">
                <div style="height: 245px;overflow-y:auto;border-bottom: 1px solid #ddd">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th class="table-checkbox"
                                style="width:25%;text-align:center;padding-top: 10px;vertical-align: middle">
                                <div>
                                    <input type="hidden" id="id" value="@{{set.id}}">
                                    <span>关键词匹配设置</span>
                                </div>
                            </th>
                            <th>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="radio1" id="matching_set" value="1"> 顺序匹配 </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radio1" id="matching_set" value="2"> 随机匹配 </label>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th class="table-checkbox"
                                style="width:23%;text-align:center;padding-top: 10px;vertical-align: middle">
                                <div>
                                    <input type="hidden" id="uid" value="">
                                    <span>关键词匹配模式</span>
                                </div>
                            </th>
                            <th>
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="radio2" id="matching_model" value="1"> 自定义 </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radio2" id="matching_model" value="2"> 三重匹配 </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="radio2" id="matching_model" value="3"> 叠加匹配
                                    </label>
                                </div>
                                <p style="font-weight: 300;margin-top: 5px;">采用三个相同的关键词增强匹配程度，有效提高排名</p>
                            </th>
                        </tr>
                        <tr>
                            <th class="table-checkbox"
                                style="width:23%;text-align:center;padding-top: 10px;vertical-align: middle">
                                <div>
                                    <input type="hidden" id="uid" value="">
                                    <span>要匹配的关键词</span>
                                </div>
                            </th>
                            <th>
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover "
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="key1" value="1"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    主关键词
                                </label>
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="key2" value="2"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    次关键词1
                                </label>
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="key3" value="3"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    次关键词2
                                </label>
                                <label style="width: 150px;">
                                    <div class="icheckbox_square-grey hover"
                                         style="position: relative;">
                                        <input type="checkbox" class="icheck" name="chk"
                                               id="key4" value="4"
                                               v-on:click="check"
                                               data-checkbox="icheckbox_square-grey"
                                               style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper"
                                             style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                    </div>
                                    只匹配空的关键词
                                </label>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="form-actions" style="text-align: center;margin-top: 8px;">
                    <input type="hidden" id="rid">
                    <button type="button" v-on:click="save" class="btn green-haze">保 存</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" v-on:click="cancel" class="btn default">取 消</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/layer/layer.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    var matkey = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#sets',
        data: {
            set: '',
        },
        ready: function () {
            this.info();
        },
        methods: {
            check: function (event) {
                if (event.target.checked) {
                    $("#" + event.target.id).parents("div").addClass("checked");
                } else {
                    $("#" + event.target.id).parents("div").removeClass("checked");
                }
            },
            info: function () {
                this.$http.get('/keysetinginfo', function (data) {
                    this.$set('set', eval(data));
                })
            },
            save: function () {
                var match_set = $("#matching_set").val();
                var match_model = $("#matching_model").val();
                var match_key = '';
                var id = $("#id").val();
                $("input[name='chk']").each(function () {
                    if ($(this).prop('checked') == true) {
                        match_key += $(this).attr("value") + ",";
                    }
                });
                match_key = match_key.substring(0, match_key.length - 1);
                senddata = {id: id, match_set: match_set, match_model: match_model, match_key: match_key};
                this.$http.post('/advancedset', senddata, function (data) {
                    if (eval(data).code) {
                        Alert4('保存成功');
                    }
                })
            },
            cancel: function () {
                var index = getIndex();
                parent.layer.close(index);
            }
        }
    })
</script>