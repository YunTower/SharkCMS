<div class="sk-update">
    <div class="layui-card btn" style="padding: 10px;">
        <div class="layui-btn-group">
            <button type="button" class="layui-btn layui-bg-blue">检查更新</button>
        </div>
    </div>
    <div class="layui-card">
        <div class="layui-collapse lay-accordion">
            <div class="layui-colla-item">
                <div class="layui-colla-title"><a class="sk-text-blue">v1.0.0-release</a> 【<a class="sk-text-blue">立即更新</a>】</div>
                <div class="layui-colla-content layui-show">
                    <p>版本号：</p>
                    <p>版本类型：release 发行版</p>
                    <p>更新类型：功能更新</p>
                    <p>发布时间：</p>
                    <p>更新内容：</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajax({
        url:'/api/update/check',
        success:function(data){
            console.log(data)
        }
    })
</script>