var path = window.location.pathname;
console.log(path);
var result = path.split("/");
var type=result[2];
var id = result[3];

function getValue(id) {
    const textarea = document.getElementById(id);
    const v = textarea.value;
    if (v == "") {
        return null;
    } else {
        return v;
    }
}

function sk_comment_send() {
    var comment = getValue("sk-comment");

    // 评论为空
    if (comment == null) {
        alert("请输入评论内容！");
    } else {

        var data = JSON.stringify({
            uid: 1,
            type:type,
            cid: id,
            content: comment,
            time: Date.now()
        });

        // 发送post请求
        $.ajax({
            type: "POST",
            url: "/api/comment/post",
            dataType: "json",
            data: Base64.encode(data),
            contentType: "application/json",
            success: function (data) {
                if (data.data.login==false){
                    alert('请先登陆')
                } else if (data.data.status==true){
                    alert('评论成功')
                    window.location.href=''
                }else{
                    alert(data.data.error)
                }
            },
        });

    }
}

function sk_comment_reply() {
    console.log("回复");
}
