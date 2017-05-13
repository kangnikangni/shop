<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/ue/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/ue/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/ue/lang/zh-cn/zh-cn.js"></script>
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
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>商品名称</label>
                    <input name="name" placeholder="请输入商品名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>商品价格</label>
                    <input name="price" placeholder="请输入商品价格" type="text" class="dfinput" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="number" placeholder="请输入商品数量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="weight" placeholder="请输入商品重量" type="text" class="dfinput" />
                </li>
                <li>
                    <label>商品类型</label>
                    <select name="type_id" class="dfinput">
                        <option value="0">--请选择--</option>
                        <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["type_id"]); ?>"><?php echo ($vol["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <i></i>
                </li>
                <li>
                    <label>商品图片</label>
                    <input name="goods_logo" type="file"/>
                </li>
                <li><label>是否显示</label>
                    <cite><input name="show" type="radio" value="1" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="show" type="radio" value="0" />否
                    </cite>
                </li>
                <li>
                    <label>商品描述<textarea id="ue" name="introduce" placeholder="请输入商品描述" cols="" rows="" style="width: 560px;height: 240px;"></textarea></label>
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
    //实例化编辑器
    var ue = UE.getEditor('ue');
    //jQuery的页面载入事件
    $(function(){
        //给按钮绑定点击事件
        $('#btnSubmit').click(function(){
            //提交表单
            $('form').submit();
        });
    });

    //给商品类型下拉列表绑定change事件
    $('select[name=type_id]').change(function(){
        //事件的处理程序
        var type_id = $(this).val();
        //保存一份this
        var _this = this;
        //移除新增的标签
        $('.treenewbee').remove();
        //发送post请求
        $.post("<?php echo U('getAttr');?>",{type_id: type_id},function(data){
            //循环遍历操作
            $.each(data,function(index,el){
                var str = '';
                //判断表单项类型
                if(el.attr_sel == '0'){
                    //input框
                    str += "<li class='treenewbee'><label>" + el.attr_name + "</label><input name='attr_vals["+el.attr_id+"][]' placeholder='请输入" + el.attr_name + "' type='text' class='dfinput' /></li>";
                }else{
                    //下拉列表
                    str += "<li class='treenewbee'><label><a href='javascript:;' class='add'>[+]</a>" + el.attr_name + "</label><select name='attr_vals["+el.attr_id+"][]' class='dfinput'><option value='0'>--请选择--</option>";
                    //中间缺少类似于volist的遍历
                    var arr = el.attr_vals.split(',');
                    for(var i = 0;i < arr.length;i++){
                        str += "<option value='" + arr[i] + "'>" + arr[i] + "</option>";
                    }
                    //补全最后的字符串
                    str += "</select><i></i></li>";
                }
                //追加内容到模版
                $(_this).parent().after(str);
            });
        },'json');
    });

    //给新增元素绑定+号点击事件
    $(document).on('click','.add',function(){
        //事件的处理程序
        //准备符合条件字符串
        var li = $(this).parent().parent().clone();
        //先把里面的a节点删除掉
        li.find('a').remove();
        //再给li添加一个a节点
        li.find('label').prepend("<a href='javascript:;' class='remove'>[-]</a>");
        //追加
        $(this).parent().parent().after(li);
    });

    //给-号绑定点击事件，点击之后移除对应的表单项
    $(document).on('click','.remove',function(){
        //事件的处理程序
        $(this).parent().parent().remove();
    });
</script>
</html>