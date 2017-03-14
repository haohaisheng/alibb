<style>
    .ic {
        background-color: darkcyan;
        border-radius: 3px;
    }

    .ico {
        margin-left: -40px;
        margin-top: 10px;
    }

</style>
<ul style="list-style:none;">
    <li class="ico">
        <i class="icon-home" id="checkico" style="font-size: 25px;" value="icon-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <a id="check">更改</a>
    </li>
</ul>
<ul style="list-style:none;display: none" id="ch">
    <li class="ico" id="iconc">
        <i class="icon-home" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-rocket" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-diamond" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-puzzle" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-settings" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-briefcase" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-wallet" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-bar-chart" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-docs" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-present" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-folder" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-user" style="font-size: 25px; cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        <i class="icon-pointer" style="font-size: 25px; cursor: pointer;"></i>
    </li>
</ul>
<script>
    jQuery(document).ready(function () {
        $("#iconc").on('click', "i", function () {
            $("#checkico").attr("class", $(this).attr("class"));
            $("#checkico").val($(this).attr("class"));
        });
        $("#check").click(function () {
            if ($("#ch").is(":hidden")) {
                $("#check").text("收起");
                $("#ch").show();
            } else {
                $("#check").text("更改");
                $("#ch").hide();
            }
        });
    });
</script>