//添加按钮操作
$("#button-add").click(function () {
    var url = SCOPE.add_url;
    window.location.href = url;
});

//提交表单操作
$("#singcms-button-submit").click(function () {
    var data = $("#singcms-form").serializeArray();
    var postData = {};
    $(data).each(function (i) {
        postData[this.name] = this.value;
    })

    $.post(SCOPE.save_url, postData, function (result) {
        if(result.status == 1) {
            dialog.success(result.message, SCOPE.jump_url);
        } else if(result.status == 0) {
            dialog.error(result.message);
        }
    }, 'json');
});

/**
 * 编辑操作
 */
$(".singcms-table #singcms-edit").on('click', function () {
    var id = $(this).attr('attr-id');
    var url = SCOPE.edit_url + '&id=' + id;
    //跳转
    window.location.href = url;

});

//删除操作
$(".singcms-table #singcms-delete").on('click', function () {
    var id = $(this).attr('attr-id');
    var a = $(this).attr('attr-a');
    var message = $(this).attr('attr-message');
    var url = SCOPE.delete_url;
    console.log(url);
    data = {};
    data['id'] = id;
    data['status'] = -1;
    layer.open({
        type: 0,
        title: '是否提交',
        btn: ['yes', 'no'],
        icon: 3,
        closeBtn : 2,
        content: '是否确定' + message,
        scrollbar: true,
        yes: function () {
            console.log(url);
            todelete(url, data);
        }
    })
});

function todelete(url, data) {
    $.post(url, data, function (s) {
        if(s.status == 1) {
            return dialog.success(s.message, '')
        } else {
            return dialog.error(s.message);
        }
    }, 'json');
}

//推送相关
$("#singcms-push").click(function () {
    var id = $("#select-push").val();
    if(id == 0) {
        return dialog.error("未选择推荐位");
    }

    push = {};
    postdata = {};
    $("input[name='pushcheck']:checked").each(function (i) {
        push[i] = $(this).val();
    });
    postdata['push'] = push;
    postdata['jump_url'] = SCOPE.jump_url;
    console.log(SCOPE.push_url);
    var url = SCOPE.push_url;

    $.post(url, postdata, function (result) {
        if(result.status == 1) {
            return dialog.success(result.message, result['data']['jump_url'])
        } else {
            return dialog.error(result.message);
        }
    }, 'json');
})
