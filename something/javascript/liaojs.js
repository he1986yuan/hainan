'use strict';
//
// function printTime（）
// ｛
//    throw new Error();
// ｝
// try{
//   setTimeout(printTime,1000);
//   console.log('done');
// }catch(e){
//   alert('error');
// }
//会先执行alert done 再执行printTime
// 编写JavaScript代码时，我们要时刻牢记，JavaScript引擎是一个事件驱动的执行引擎，代码总是以单线程执行，而回调函数的执行需要等到下一个满足条件的事件出现后，才会被执行。


function printTime(){
  console.log('it is time');
}

setTimeout(printTime,2000);
console.log('done');

//
alert(' alert it if you can');
