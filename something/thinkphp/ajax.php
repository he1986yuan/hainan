<?php
namespace Controller\Cotroler;
use Think\Controller;

/**
 * form ajax
 */
class ClassName extends AnotherClass
{
  public $list;

  public function index()
  {
    $Form =M("Form");
    $list =$Form->order('id desc')->limit('5')->select();
    $this->list = $list;
    $this->display();
  }
  //检校标题数据

  public function checkTitile($title='')
  {
    if (!empty($title)) {
      $Form =M("Form");
      if ($Form->getBytitle($title)) {
        $this->error('title is already exists');
      }else{
        $this->success('available');
      }else{
        $this->error('');
      }

     }
  public function insert()
  {
    $Form =D('Form');
    //自动验证
    if ($vo =$Form->create()) {
      if (false!==$Form->add()) {
        $vo['create_time'] =date('y-m-d',$vo['create_time']);
        $vo['content'] =n12br($vo,'表单数据保存');
        $this->ajaxReturn($vo,'sucess');
      }else{
        $this->error('error');
      }
    }
  }

}





 ?>
