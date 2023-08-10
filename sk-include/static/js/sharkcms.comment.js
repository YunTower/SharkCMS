var path = window.location.pathname;
console.log(path);
var result = path.split("/");
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
    $.ajax({
      type: "POST",
      url: "/api/user/token",
      dataType: "json",
      contentType: "application/jsoan",
      success: function (res) {
        if (res.data.login == false) {
          alert("请先登陆！");
        } else {
          var data = JSON.stringify({
            uid: 1,
            id:id,
            comment: comment,
            time: Date.now(),
            token: res.data.token,
          });
          var data = Base64.encode(data);

          // 发送post请求
          $.ajax({
            type: "POST",
            url: "/api/comment/post",
            dataType: "json",
            data: data,
            contentType: "application/jsoan",
            success: function (data) {
              return data;
            },
          });
        }
      },
    });
  }
}

function sk_comment_reply() {
  console.log("回复");
}
