var path = window.location.pathname;
console.log(path);
var result = path.split("/");
var type = result[2];
var id = result[3];

function sk_comment_getValue(id) {
  const textarea = document.getElementById(id);
  const v = textarea.value;
  if (v == "") {
    return null;
  } else {
    return v;
  }
}

function sk_comment_loginout() {
  axios.post("/api/loginOut").then(function (res) {
    if (res.data.code == 200) {
      window.location.href = "";
    } else {
      alert(res.data.msg);
    }
  });
}

function sk_comment_send() {
  var comment = sk_comment_getValue("sk-comment");

  // 评论为空
  if (comment == null) {
    alert("请输入评论内容！");
  } else {
    var data = JSON.stringify({
      uid: 1,
      type: type,
      cid: id,
      content: comment,
      time: Date.now(),
    });

    // 发送post请求
    axios.post("/api/comment/post", Base64.encode(data)).then(function (res) {
      if (res.data.code == 200) {
        alert("评论成功");
        window.location.href = "";
      } else {
        if (res.data.code == 403) {
          alert("请先登陆");
        } else {
          alert(res.data.msg);
        }
      }
    });
  }
}

function sk_comment_reply() {
  console.log("回复");
}
