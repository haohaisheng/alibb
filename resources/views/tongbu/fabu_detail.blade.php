<link rel="stylesheet" href="{{ URL::asset('assets/plugins/kindeditor-4.1.7/themes/default/default.css') }}"/>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/kindeditor-min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/lang/zh_CN.js') }}"></script>
<script charset="utf-8" src="{{ URL::asset('assets/plugins/kindeditor-4.1.7/plugins/code/prettify.js') }}"></script>

<script>
    var editor;
    function kedit(kedit) {
        editor = KindEditor.create(kedit, {
            cssPath: '{{ URL::asset('assets/plugins/kindeditor-4.1.7/plugins/code/prettify.css') }}',
            uploadJson: '{{ URL::route('upload.uploadimage1',['_token'=>''])}}' + "{{csrf_token()}}",
            allowImageUpload: true,
            resizeType: 1,
            readonlyMode: false,
            resizeMode: 0,
            allowFileManager: true,
            allowPreviewEmoticons: false,
            afterCreate: function () {
            },
            afterChange: function () {
                this.sync();
            },
            afterBlur: function () {
                this.sync();
            },
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', '|', 'image', 'link']
        });
    }
    $(function () {
        kedit('textarea[name="content"]');
    })
</script>
<ul class="mix-filter">
                            <textarea placeholder="" name="content" id="content"
                                      style="height: 400px;width:98%;"
                                      class="wt_c52"></textarea>

    <div class="form-actions" style="text-align: right;margin-top: 20px;">
        <input type="hidden" id="productid" value="{{$productid}}">
        <span style="color: red;margin-right: 40px;">提示：请控制详情中的图片个数在15张以内。</span>
        <button type="button" v-on:click="next" class="btn blue">下一步</button>
        <button type="button" class="btn default">返回</button>
    </div>
</ul>

<script>
    var vm2 = new Vue({
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
            productid = $("#productid").val();
            this.initinfo(productid);
        },
        methods: {
            initinfo: function (productid) {

                vm.$http.get('/getproductinfo/' + productid, function (data) {
                    if (eval(data).code) {
                        result = eval(data).data;
                        editor.html(result.description);
                    }
                })
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
                        $('#tab3').click();
                        $("#tab_31").load('/toparam', function () {
                                    $("#tab_31").fadeIn(100);
                                }
                        );
                    }
                })
            }
        }
    })
</script>