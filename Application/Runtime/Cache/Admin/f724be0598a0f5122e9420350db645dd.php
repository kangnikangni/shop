<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle"><span>基本信息</span></div>
        <form action="" method="post">
            <ul class="forminfo">
                <li>
                    <label>权限名称</label>
                    <input name="auth_name" placeholder="请输入权限名称" type="text" class="dfinput" /></li>
                <li>
                    <label>父级权限</label>
                    <select name="auth_pid" class="dfinput">
                        <option value="0">作为顶级</option>
                        <?php if(is_array($parent)): $i = 0; $__LIST__ = $parent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["auth_id"]); ?>"><?php echo ($vol["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <i></i></li>
                <li>
                    <label>控制器名</label>
                    <input name="auth_c" placeholder="请输入控制器名称" type="text" class="dfinput" />
                </li>
                <li>
                    <label>方法名称</label>
                    <input name="auth_a" placeholder="请输入方法名称" type="text" class="dfinput" />
                </li>
                <li><label>作为导航</label>
                    <cite><input name="is_nav" type="radio" value="1" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_nav" type="radio" value="0" />否
                    </cite>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
//jQuery代码
$(function(){
    //给btnsubmit绑定点击事件
    $('#btnSubmit').on('click',function(){
        //表单提交
        $('form').submit();
    });

    //页面加载完成之后由于默认选中了“作为顶级”，所以需要隐藏c和a的表单项
    $('input[name=auth_c]').parent().hide();
    $('input[name=auth_a]').parent().hide();

    //给下拉框绑定事件，当下拉框值发生变化的时候改变
    $('select').change(function(){
        //获取下拉的值
        var _val = $(this).val();
        //在每次切换的时候都需要清空a和c的值
        $('input[name=auth_c]').val('');
        $('input[name=auth_a]').val('');
        //判断是否是顶级
        if(_val == '0'){
            //顶级，则隐藏a和c的input框
            $('input[name=auth_c]').parent().hide();
            $('input[name=auth_a]').parent().hide();
        }else{
            //不是顶级显示a和c的input框
            $('input[name=auth_c]').parent().show();
            $('input[name=auth_a]').parent().show();
        }
    });
});
</script>
</html>