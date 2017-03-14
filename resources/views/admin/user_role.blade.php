@include('admin.common.head')
<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<!-- END PAGE HEADER-->
<div class="row" id="app" style="background-color:white;margin-left: 0;margin-right: 0;">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey" style="margin-bottom: 0">
            <div class="portlet-body">
                <div style="height: 245px;overflow-y:auto;border-bottom: 1px solid #ddd">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th class="table-checkbox"
                                style="width:23%;text-align:center;padding-top: 10px;vertical-align: middle">
                                <div>
                                    <input type="hidden" id="uid" value="{{$uid}}">
                                    <span>角色列表</span>
                                </div>
                            </th>
                            <th>
                                <!--垂直排列 <div class="icheck-list"> -->
                                <div class="icheck-list">
                                    @foreach ($roles as $r)
                                        @if (in_array($r->role_id,$userRole))
                                            <label style="width: 150px;">
                                                <div class="icheckbox_square-grey hover checked"
                                                     style="position: relative;">
                                                    <input type="checkbox" class="icheck" name="chk"
                                                           id="{{$r->role_id}}"
                                                           v-on:click="check" checked
                                                           data-checkbox="icheckbox_square-grey"
                                                           style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper"
                                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                </div>
                                                {{$r->role_name}}
                                            </label>
                                        @else
                                            <label style="width: 150px;">
                                                <div class="icheckbox_square-grey hover"
                                                     style="position: relative;">
                                                    <input type="checkbox" class="icheck" name="chk"
                                                           id="{{$r->role_id}}"
                                                           v-on:click="check"
                                                           data-checkbox="icheckbox_square-grey"
                                                           style="position: absolute; opacity: 0;">
                                                    <ins class="iCheck-helper"
                                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                </div>
                                                {{$r->role_name}}
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
</div>
</div>
<!-- END PAGE CONTENT-->
</div>
<script src="../../admin/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('layer.bak.js') }}"></layer.bak.js
    <script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
    <
    script >
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#app',
        methods: {
            check: function (event) {
                if (event.target.checked) {
                    $("#" + event.target.id).parents("div").addClass("checked");
                } else {
                    $("#" + event.target.id).parents("div").removeClass("checked");
                }
            },
            save: function () {
                var uid = $("#uid").val();
                var rid = '';
                $("input[name='chk']").each(function () {
                    if ($(this).prop('checked') == true) {
                        rid += $(this).attr("id") + ",";
                    }
                })
                rid = rid.substring(0, rid.length - 1);
                senddata = {uid: uid, rid: rid};
                this.$http.post('/saveuserroles', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert4('操作成功');
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