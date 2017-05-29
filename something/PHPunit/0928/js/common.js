/*
 * 通过id查找节点对象
 * 参数：标签的id属性
 * 返回节点对象
 */
function $(id){
	return document.getElementById(id);
}
/*
 * 绑定事件的通用方法
 * 参数1：监视的节点对象 obj
 * 参数2：绑定的事件名称 eventType
 * 参数3：事件发生的时候要执行的函数 fn
 */
function bindEvent(obj,eventType,fn){
	if(obj.attachEvent){
		obj.attachEvent("on"+eventType, fn);
	}else{
		obj.addEventListener(eventType, fn, false);
	}	
}
//将来这样调用：bindEvent('button','click',function(){})

/*
 * 通过class属性查找节点对象
 * 参数1：parent 查找的范围
 * 参数2：查找的class属性的值
 * 返回 数组格式的数据
 */

function getByClass(parent,clsName){
	var elements = parent.getElementsByTagName('*');
	var arr = [];
	for(var i=0;i<elements.length;i++){
		if(elements[i].className==clsName){
			//arr[] = elements[i];
			arr.push(elements[i]);
		}
	}
	return arr;
}

/*
 * 该函数封装的鼠标拖拽效果
 * 参数1：obj 拖拽的对象
 * 参数2：scope 拖拽的范围(父元素)
 */

 function drag(obj,scope){
 	obj.onmousedown = function(){
		//移动的事件必须是鼠标按下之后的移动，这个时候才会生成拖拽的效果
		scope.onmousemove = function(e){
			var ev = e || window.event;
			//获得鼠标移动时的坐标
			var mouseX = ev.clientX - scope.offsetLeft;
			var mouseY = ev.clientY - scope.offsetTop; 

			//计算出图片的位置
			var imgX = mouseX - obj.clientWidth/2;
			var imgY = mouseY - obj.clientHeight/2;

			//先判断是否出界
			if(imgX<0){
				imgX = 0;
			}
			if(imgY<0){
				imgY = 0;
			}
			if(imgX+obj.clientWidth>scope.clientWidth){
				imgX = scope.clientWidth - obj.clientWidth;
			}
			if(imgY+obj.clientHeight>scope.clientHeight){
				imgY = scope.clientHeight - obj.clientHeight;
			}

			//计算拖拽的对象拖拽的距离
			var scale = obj.offsetLeft / (scope.clientWidth-obj.clientWidth);
			var contentY = -scale * (content.clientHeight - box.clientHeight);
			content.style.top = contentY +'px';

			//设置图像的位置
			obj.style.left = imgX +'px';
			obj.style.top = imgY +'px';

			if(obj.setCapture){
				//IE8以下的浏览器（释放捕获）
				obj.releaseCapture();
			}else{
				return false;
			}
		}
		//阻止浏览器默认的行为（主流浏览器）
		if(obj.setCapture){
			//IE8以下的浏览器（设置捕获）
			obj.setCapture();
		}else{
			return false;
		}
	}
	//鼠标抬起之后取消默认的行为
	document.onmouseup = function(){
		scope.onmousemove = null;
	}
 }

/*
 * 给某个对象设置多个样式
 * 参数1：对象
 * 参数2：json对象，样式列表
 */
function setStyle(obj,json){
	//遍历json对象
	for(var attr in json){
		obj.style[attr] = json[attr];
	}
}

/*
 * 获得元素任意属性的值
 * 参数1：对象
 * 参数2：属性名
 */
function getStyle(obj,attr){
	// alert(obj.currentStyle[attr]);
	// alert(getComputedStyle(obj,false)[attr]);	//Chrome  主流浏览器
	if(obj.currentStyle){
		return obj.currentStyle[attr];
	}else{
		return getComputedStyle(obj,false)[attr];
	}
}

/*
 * 删除某个元素的某个类
 * 参数1：元素对象  	element
 * 参数2：删除的类名	clsName
 * 测试："<div class='page show active'></div>" 
 */
function removeClass(element,clsName){
	//先获得所有的类
	var cName = element.className;	//"page show"
	//分割字符串成数组
	var arr = cName.split(' ');
	//遍历数组的每一个元素
	for(var i=0;i<arr.length;i++){
		if(arr[i]==clsName){
			//说明这个元素就是我们将要删除的
			arr.splice(i,1);
		}
	}
	//合并成字符串，并给元素对象重新赋值
	element.className = arr.join(' ');
}
 /*
 * 给某个元素增加一个类
 * 参数1：元素对象  element
 * 参数2：增加的类名 clsName
 */
 function addClass(element,clsName){
 	//如果该元素的class属性的值是空的
 	if(!element.className){
 		element.className = clsName;
 		return;
 	}
 	//如果有class属性值,要判断该对象身上有没有我们添加的类
 	var cName = element.className;
 	var arr = cName.split(' ');
 	for(var i=0;i<arr.length;i++){
 		//拿到每个类
 		if(arr[i]==clsName){
 			return;
 		}
 	}
 	//没有的时候
 	element.className += " "+clsName;
 }

//封装的ajax操作的方法
var $$ = {
	request:function(obj){
		//1. 获得xmlhttprequest对象兼容性处理
		var xhr;	//undefined未定义
		try{
			//主流浏览器里面的ajax对象
			xhr = new XMLHttpRequest();
		}catch(e){
			//IE低版本的浏览器
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}

		//2. 建立和服务器的连接
		if(obj.method=='get'){
			xhr.open(obj.method,obj.url+'?'+obj.data+'&'+Math.random(),true);
			xhr.send();
		}else if(obj.method=='post'){
			xhr.open(obj.method,obj.url,true);
			xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			xhr.send(obj.data);
		}
		//监视服务器的处理状态
		xhr.onreadystatechange = function(){
			if(xhr.readyState==4 && xhr.status==200){
				//说明请求成功了，输出服务器返回的数据
				obj.callback(xhr.responseText);
			}
		}
	}
}