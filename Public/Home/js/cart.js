/**
 * 
 * @authors itcast.cn (you@example.org)
 * @date    2017-04-22 10:49:35
 * @version 1.0
 */

/*
 * 根据元素的id获得其坐标(x轴和y轴)
 */
function getElementPos(elementId) {
    var ua = navigator.userAgent.toLowerCase();
    var isOpera = (ua.indexOf('opera') != -1);
    var isIE = (ua.indexOf('msie') != -1 && !isOpera); // not opera spoof
    var el = document.getElementById(elementId);
    if(el.parentNode === null || el.style.display == 'none') {
        return false;
    }
    var parent = null;
    var pos = [];
    var box;
    if(el.getBoundingClientRect) {   //IE
        box = el.getBoundingClientRect();
        var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
        var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
        return {
            x:box.left + scrollLeft, 
            y:box.top + scrollTop
        };
    }else if(document.getBoxObjectFor) {   // gecko
        box = document.getBoxObjectFor(el);
        var borderLeft = (el.style.borderLeftWidth)?parseInt(el.style.borderLeftWidth):0;
        var borderTop = (el.style.borderTopWidth)?parseInt(el.style.borderTopWidth):0;
        pos = [box.x - borderLeft, box.y - borderTop];
    }else {   // safari & opera
        pos = [el.offsetLeft, el.offsetTop];
        parent = el.offsetParent;
        if (parent != el) {
            while (parent) {
                pos[0] += parent.offsetLeft;
                pos[1] += parent.offsetTop;
                parent = parent.offsetParent;
            }
        }
        if (ua.indexOf('opera') != -1 || ( ua.indexOf('safari') != -1 && el.style.position == 'absolute' )) {
            pos[0] -= document.body.offsetLeft;
            pos[1] -= document.body.offsetTop;
        }
    }
    if (el.parentNode) {
        parent = el.parentNode;
    } else {
        parent = null;
    }
    while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML') { // account for any scrolled ancestors
        pos[0] -= parent.scrollLeft;
        pos[1] -= parent.scrollTop;
        if (parent.parentNode) {
            parent = parent.parentNode;
        } else {
            parent = null;
        }
    }
    return {
        x:pos[0], 
        y:pos[1]
    };
}

//关闭弹出层
function hideElement(eleID){
	//关闭
	$('#' + eleID).hide();
}

//商品数量的更改
function changeNumber(goods_id,flag){
	//获取原始的值
	var _val = $('#goods_' + goods_id).val();
	//判断
	if(flag == 'reduce'){
		if(_val == '1'){
			alert('至少购买1件商品');return;
		}else{
			_val--;
		}
	}else if(flag == 'add'){
		_val++;
	}else if(flag == 'amount'){
		//验证数字的合法性（正则）
	}else{
		alert('参数非法');return;
	}
	//发送ajax请求
	$.ajax({
		url:editUrl,
		data:{goods_id: goods_id,amount: _val},
		type: 'POST',
		dataType: 'json',
		success: function(data){
			//重新给input框赋值
			$('#goods_' + goods_id).val(_val);
			$('#total').html(data.total);	//总价
			$('#price_' + goods_id).html(data.xiaoji);	//小计价格
		}
	});

}

//jQuery页面载入事件
$(function(){
	//给按钮绑定点击事件
	$('#add_btn').click(function(){
		//发送ajax请求
		var goods_id = $(this).attr('data');	//商品id
		var amount = $('.amount').val();	//购买的数量
		$.get(addUrl,{goods_id: goods_id,amount: amount},function(data){
			//根据当前按钮的id获取其坐标
			var pos = getElementPos('add_btn');
			//将值在页面上进行展示
			$('#goods_number').html(data.number);
			$('#goods_totalprice').html(data.price);
			//根据坐标定位弹出层，并且显示
			$('#cartBox').css({left: pos.x,top: pos.y - 118,display: 'block'});
		},'json');
	});

	//给删除按钮绑定点击事件
	$('.del').click(function(){
		//事件的处理程序
		var goods_id = $(this).attr('data');	//商品id
		var _this = this;
		//发送ajax请求
		$.post(delUrl,{goods_id: goods_id},function(data){
			//判断返回值
			if(data.code == '0'){
				//失败
				alert('删除失败');
			}else{
				//成功，移除对应的行，更新总价
				$(_this).parent().parent().remove();
				$('#total').html(data.total);
			}
		},'json');
	});
});
