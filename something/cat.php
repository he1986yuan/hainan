<?php
/**
 * cat
 */
class ClassName extends AnotherClass
{

  /**
      * 函数：addGoods
      * 功能：将物品放入购物车[SESSION]中
      * 简介：将指定物品信息$goods存入指定名$cartName的购物车中，默认在物品信息首部附加“购物车物品序号”$skey
      * 时间：2011年7月28日 23:51:40
      * 作者：zhjp
      * Enter description here ...
      * 待完善项：在存入购物车之前先进行判断所选物品是否已经存在，是：只修改购买数量、否：存入购物车
      * @param String $cartName
      * @param String $goodsStr
      */
     public function addGoods($cartName, $goodsStr){
         $skey=count($_SESSION[$cartName]);
         //处理物品信息
         $goodsStr=$skey.','.$goodsStr;
         switch ($cartName){
             case 'flyCart':
                 break;
             case 'mallCart':
                 //配置物品字段,返回可读性更强的数组格式的物品信息
                 $goodsArr=$this->_setGoodsFields($goodsStr);
                 break;
             case 'hotelCart':
                 break;
         }
         //物品存入购物车
         $_SESSION[$cartName][$skey]=$goodsArr;
         //更新购物车信息
         $this->_updateCart($cartName);
     }


     /**
     * 函数：delGoods
     * 功能：删除购物车[SESSION]中的某一物品
     * 简介：根据提供的购物车名$cartName及指定购物车物品序号$skey将该物品记录置空值
     * 时间：2011年7月30日 23:00:59
     * 作者：by zhjp
     * Enter description here ...
     * @param String $cartName
     * @param Int $skey
     */
    public function delGoods($cartName, $skey){
        if(!isset($_SESSION[$cartName])){ return ; }
        if($_SESSION[$cartName]['ITEMS']==1){
        //  $this->clearAll($cartName);
        }else{
            //删除指定物品
            $_SESSION[$cartName][$skey]=null;
        }
        //更新购物车信息
        $this->_updateCart($cartName);

    }
    /**
         * 函数：editCart
         * 功能：编辑购物车信息[物品购物数量+1-1]
         * 简介：根据提供的购物车名$cartName及操作名$action结合指定购物车物品序号$skey对指定物品的购买数量进行+1-1操作
         * 时间：2011年7月30日 23:09:27
         * 作者：by zhjp
         * Enter description here ...
         * @param String $cartName
         * @param String $action[plus+][minus-]
         * @param Int $skey
         */
        public function editCart($cartName, $action, $skey){
            if(!isset($_SESSION[$cartName])){return ;}
            switch ($action){
                case 'plus':
                    $this->_plusOne($cartName, $skey);
                    break;
                case 'minus':
                    $this->_minusOne($cartName, $skey);
                    break;
            }
            //更新购物车信息
            $this->_updateCart($cartName);
        }      
}




 ?>
