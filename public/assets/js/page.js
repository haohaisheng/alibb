/**
 * Created by hhs on 2015/10/26.
 */
$.getJSON("blackList.ce", function (data) {
    var totalCount = data.totalCount; // 总记录数
    var pageSize = 10; // 每页显示几条记录
    var pageTotal = Math.ceil(totalCount / pageSize); // 总页数
    var startPage = pageSize * (pn - 1);
    var endPage = startPage + pageSize - 1;
    var $ul = $("#json-list");
    $ul.empty();
    for (var i = 0; i < pageSize; i++) {
        $ul.append('<li class="li-tag"></li>');
    }
    var dataRoot = data.jsonRoot;
    if (pageTotal == 1) {     // 当只有一页时
        for (var j = 0; j < totalCount; j++) {
            $(".li-tag").eq(j).append("<span class='col1'><input type='checkbox' value='" + parseInt(j + 1) + "'/></span>")
                .append("<span class='col2'>" + parseInt(j + 1)
                + "</span>").append("<span class='col3'>" + dataRoot[j].mobile
                + "</span>").append("<span class='col4'>" + dataRoot[j].province
                + "</span>").append("<span class='col5'>" + dataRoot[j].gateway
                + "</span>").append("<span class='col6'>" + dataRoot[j].insertTime
                + "</span>").append("<span class='col7'>" + dataRoot[j].remark
                + "</span>")
        }
    } else {
        for (var j = startPage, k = 0; j < endPage, k < pageSize; j++, k++) {
            if (j == totalCount) {
                break;       // 当遍历到最后一条记录时，跳出循环
            }
            $(".li-tag").eq(k).append("<span class='col1'><input type='checkbox' value='" + parseInt(j + 1) + "'/></span>")
                .append("<span class='col2'>" + parseInt(j + 1)
                + "</span>").append("<span class='col3'>" + dataRoot[j].mobile
                + "</span>").append("<span class='col4'>" + dataRoot[j].province
                + "</span>").append("<span class='col5'>" + dataRoot[j].gateway
                + "</span>").append("<span class='col6'>" + dataRoot[j].insertTime
                + "</span>").append("<span class='col7'>" + dataRoot[j].remark
                + "</span>")
        }
    }
    $(".page-count").text(pageTotal);
})