/**
 * Created by hhs on 2015/10/24.
 */

function setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {　　//先查询cookie是否为空，为空就return ""
        c_start = document.cookie.indexOf(c_name + "=")　　//通过String对象的indexOf()来检查这个cookie是否存在，不存在就为 -1　　
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1　　//最后这个+1其实就是表示"="号啦，这样就获取到了cookie值的开始位置
            c_end = document.cookie.indexOf(";", c_start)　　//其实我刚看见indexOf()第二个参数的时候猛然有点晕，后来想起来表示指定的开始索引的位置...这句是为了得到值的结束位置。因为需要考虑是否是最后一项，所以通过";"号是否存在来判断
            if (c_end == -1) c_end = document.cookie.length
            return unescape(document.cookie.substring(c_start, c_end))　　//通过substring()得到了值。想了解unescape()得先知道escape()是做什么的，都是很重要的基础，想了解的可以搜索下，在文章结尾处也会进行讲解cookie编码细节
        }
    }
    return ""
}
function delCookie(c_name) {
    var exdate = new Date();
    exdate.setTime(exdate.getTime() - 1);
    var cval = getCookie(c_name);
    if (cval != null) document.cookie = c_name + "=" + cval + ";expires=" + exdate.toGMTString();
}
function Alert(msg) {
    var d = dialog({
        content: msg
    });
    d.show();
    setTimeout(function () {
        d.close().remove();
    }, 1000);
}

function Alert1(msg) {
    layer.msg(msg, {
        icon: 1,
        time: 2000 //2秒关闭（如果不配置，默认是3秒）
    });
}

function Alert2(msg, action) {
    layer.msg(msg, {
        icon: 1,
        time: 1000 //2秒关闭（如果不配置，默认是3秒）,
    }, function () {
        $(".page-content").load(action, function () {
                $(".page-content").fadeIn(100);
            }
        );
    });
}

function Alert3(msg) {
    layer.msg(msg, {
        icon: 6,
        time: 0,//不自动关闭
        btn: ['确定', '取消'],
        yes: function (index) {
            layer.close(index);
        }
    });
}

function Alert4(msg) {
    var index = getIndex();
    layer.msg(msg, {
        icon: 1,
        time: 1000 //2秒关闭（如果不配置，默认是3秒）,
    }, function () {
        parent.layer.close(index);
    });
}

function Alert5(msg) {
    layer.msg(msg, {
        icon: 2,
        time: 2000 //2秒关闭（如果不配置，默认是3秒）
    });
}


function getIndex() {
    return parent.layer.getFrameIndex(window.name);
}
/**
 * 取消按钮
 * @returns {Array}
 */
function cancel(action) {
    $(".page-content").load(action, function () {
            $(".page-content").fadeIn(100);
        }
    );
}
//用户vue.js计算分页个数
var pageinit = function () {
    var left = 1
    var right = this.all
    var ar = []
    if (this.all >= 11) {
        if (this.cur > 5 && this.cur < this.all - 4) {
            left = this.cur - 5
            right = this.cur + 4
        } else {
            if (this.cur <= 5) {
                left = 1
                right = 10
            } else {
                right = this.all
                left = this.all - 9
            }
        }
    }
    while (left <= right) {
        ar.push(left)
        left++
    }
    return ar
}

/**
 * 菜单跳转路径
 * @param action
 */
function menu_action(action) {
    $(".page-content").load(action, function () {
            $(".page-content").fadeIn(100);
        }
    );
}
/**
 * 增删改查操作路径
 * @param action
 */
function func_action(action) {
    $(".page-content").load(action, function () {
            $(".page-content").fadeIn(100);
        }
    );
}

/**
 * 增删改查操作路径
 * @param action
 */
function func_action_data(action, data) {
    //setCookie('action1', action, 3600);
    $(".page-content").load(action, data, function () {
            $(".page-content").fadeIn(100);
        }
    );
}