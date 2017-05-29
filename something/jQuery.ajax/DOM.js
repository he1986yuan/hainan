--用javascript取得一个input的值？取得一个input的属性？
document.getElementById('name').value;
document.getElementById('name').type;

--用Jquery取得一个input的值？取得一个input的属性？
$("input[name='aa']").val();
$("input[name='aa']").attr('name');

--写一个简单的jquery显示隐藏代码？
$("#aa").hide();
$("#aa").show();

--层次选择器
$('a[title]');$("input[name='aa']")//[]代表元素的属性
//联合选择器
$('div,a');
//父元素>子元素
$('div>a');
//相邻选择器
$('div+a');
--过滤选择器
 $('array:first'); --匹配找到的第一个元素
 $('array:last'); --匹配找到的最后一个元素
 $('array:even'); --匹配索引是偶数的所有元素,索引从0开始
 $('array:odd ');--匹配索引是奇数的所有元素，索引从0开始
 $('array:eq(index)');--匹配索引等于index的所有元素
 $('array:header'); --获取网页中的标题元素

 --DOM
 $('<p></p>');--创建一个节点元素
 $('#div1').append('<p></p>');--div1中追加p
 $('<p></p>').prependTo('#div1')--p主动追加到div1中;

--绑定事件
$(function(){
  $('li').click(function(){
    alert('hello');
  })
  $('li').on('click',function(){
    alert('on click');
  });//第二种写法
  $("img").bind("click mousedown",function(){
    $(this).hide();
  });

});
