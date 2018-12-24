/**
 * 前端登陆
 */
var login = {
    check: function () {
        var username = $('input[name="username"]').val()
        var password = $('input[name="password"]').val()

        if(!username) {
            dialog.error("用户名不能为空");
            return;
        }
        if(!password) {
            dialog.error("密码不能为空");
            return;
        }
        var url = "/index.php?m=admin&c=login&a=check";
        var data = {username: username, password: password};
        $.post(url, data, function (result) {
            if (result.status == 0) {
                return dialog.error(result.message);
            }
            if (result.status == 1) {
                delayRedirect();
                return dialog.success(result.message + ' 2秒后跳转', '/index.php?m=admin&c=index');
            }
        }, 'json');
    }
}
var direct_url = "index.php?m=admin&c=index";
var time = 1;
function delayRedirect() {
    setInterval("refer()", 1000);
}

function refer() {
    if(time == 0) {
        location.href = direct_url;
    }
    if(time >= 0) {
        //$("#location span").html(time);
    }
    time--;
}