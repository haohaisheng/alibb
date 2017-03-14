<link href="../../admin/assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<script src="../../admin/assets/global/plugins/icheck/icheck.min.js"></script>
<script src="../../admin/assets/global/scripts/metronic.js" type="text/javascript"></script>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
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
            <li>
                <a href="#1" onclick="func_action('{{$action}}')">角色管理</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">角色权限</a>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->
<div class="row" id="func">
    <div class="col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box grey">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-user"></i>{{$rname}}->权限</div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    @foreach ($menus as $menu)
                        @if ($menu->fid==0)
                            <tr>
                                <th class="table-checkbox"
                                    style="width:10%;text-align:center;padding-top: 10px;vertical-align: middle">
                                    <div> {{$menu->menu_name}}
                                        <span></span>
                                    </div>
                                </th>
                                <th>
                                    <!--垂直排列 <div class="icheck-list"> -->
                                    <div class="icheck-inline">
                                        @foreach ($menus as $m)
                                            @if ($m->fid==$menu->menu_id)
                                                @if (in_array($m->menu_id,$funcs))
                                                    <label style="width: 150px;">
                                                        <div class="icheckbox_square-grey hover checked"
                                                             style="position: relative;">
                                                            <input type="checkbox" class="icheck" name="chk"
                                                                   id="{{$m->menu_id}}-{{$m->fid}}"
                                                                   v-on:click="check"
                                                                   checked
                                                                   data-checkbox="icheckbox_square-grey"
                                                                   style="position: absolute; opacity: 0;">
                                                            <ins class="iCheck-helper"
                                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                        </div>
                                                        {{$m->menu_name}}
                                                    </label>
                                                @else
                                                    <label style="width: 150px;">
                                                        <div class="icheckbox_square-grey hover"
                                                             style="position: relative;">
                                                            <input type="checkbox" class="icheck" name="chk"
                                                                   id="{{$m->menu_id}}-{{$m->fid}}"
                                                                   v-on:click="check"
                                                                   data-checkbox="icheckbox_square-grey"
                                                                   style="position: absolute; opacity: 0;">
                                                            <ins class="iCheck-helper"
                                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
                                                        </div>
                                                        {{$m->menu_name}}
                                                    </label>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </th>
                            </tr>
                        @endif
                    @endforeach
                    </thead>
                </table>
                <div class="form-actions">
                    <input type="hidden" id="rid" value="{{$rid}}">
                    <button type="button" v-on:click="save" class="btn green-haze">提 交</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn default" onclick="func_action('{{$action}}')">取 消</button>
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
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/vue-resource/dist/vue-resource.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/js/utils.js')}}"></script>
<script>
    /*jQuery(document).ready(function () {
     Metronic.init();
     });*/
    var vm = new Vue({
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementsByTagName('meta')['_token'].content
            },
        },
        el: '#func',
        data: {},
        ready: function () {

        },
        methods: {
            check: function (event) {
                var mid = event.target.id;
                if ($("#" + mid).attr("checked")) {
                    $("#" + mid).parents("div").addClass("checked");
                } else {
                    $("#" + mid).parents("div").removeClass("checked");
                }
            },
            save: function () {
                var rid = $("#rid").val();
                var mid = '';
                $("input[name='chk']").each(function () {
                    if ($(this).attr("checked")) {
                        mid += $(this).attr("id") + "-";
                    }
                })
                mid = mid.substring(0, mid.length - 1);
               // alert(mid);
                senddata = {rid: rid, mid: mid};
                this.$http.post('/savemenus', senddata, function (data) {
                    if (eval(data).code == '101') {
                        Alert2('操作成功', '/role')
                        //this.list(this.cur);
                    }
                }).error(function (data, status, request) {
                    console.log('fail' + status + "," + request);
                })
            }
        }
    })
</script>