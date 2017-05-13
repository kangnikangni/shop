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
        <div class="formtitle"><span>基本信息【<a href="<?php echo U('showList');?>">返回</a>】</span></div>
        <form action="" method="post">
            <span style="font-size: 16px">您正在给【<label style="color: red;font-weight: bolder;"><?php echo ($role["role_name"]); ?></label>】设置权限</span>
            <ul class="forminfo">
                <table class="tablelist">
                    <thead>
                        <tr>
                            <th>权限分类</th>
                            <th>权限</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($top)): $i = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
                                <td>
                                    <input type="checkbox" class="chk" name="auth_id[]" value="<?php echo ($vol["auth_id"]); ?>" <?php if(in_array(($vol["auth_id"]), is_array($role["role_auth_ids"])?$role["role_auth_ids"]:explode(',',$role["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>><?php echo ($vol["auth_name"]); ?>
                                </td>
                                <td>
                                    <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["auth_pid"] == $vol["auth_id"] ): ?><input type="checkbox" class="child" name="auth_id[]" value="<?php echo ($vo["auth_id"]); ?>" <?php if(in_array(($vo["auth_id"]), is_array($role["role_auth_ids"])?$role["role_auth_ids"]:explode(',',$role["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>>
                                    <?php echo ($vo["auth_name"]); ?>&emsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <br/>
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
    //全选&反选
    $('.chk').click(function(){
    	var status = $(this).attr('checked');
    	if(status == 'checked'){
    		$(this).parent().parent().find("td:eq(1)").find("input").attr("checked","checked");
    	}else{
    		$(this).parent().parent().find("td:eq(1)").find("input").removeAttr("checked");
    	}
    });
    //补选父级
    $('.child').click(function(){
    	var currentChildStatus = $(this).attr('checked');
    	var _parent = $(this).parent().parent().find("td:eq(0)").find("input");
    	if(currentChildStatus == 'checked'){
    		_parent.attr("checked","checked");
    	}else{
    		var selectChkBox = $(this).parent().find(":checkbox:checked");
    		if(selectChkBox.length == '0'){
    			_parent.removeAttr("checked");
    		}
    	}
    });
});
</script>
</html>