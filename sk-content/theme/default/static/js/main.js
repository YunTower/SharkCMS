if (!!window.ActiveXObject || "ActiveXObject" in window) {
  alert("你的浏览器版本太低了（关闭本弹窗将下载【Microsoft Edge】）");
  window.location.href =
    "https://www.microsoft.com/zh-cn/edge/download?form=MA13DC";
}
