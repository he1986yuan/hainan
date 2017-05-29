<?php  // 每日签到

// 数据表：会员积分（会员号，会员签到次数，会员签到总时间，会员上次签到时间，积分的数量）；会员币（会员号，会员币，会员积分）
// 如果是第一次签到（查询total时间==0）：创建积分表项，并且插入数据记录相关（同时关联模型添加会员积分币）；
// 如果不是第一次签到：（查询出会员积分表的数据）如果上次签到时间是今天返回不能重复签到，
//                   如果今天未签到查询是否连续签到（当前的时间戳time-totaltime不能大于一天）连续签到额外加5分；否则+1分；
        public function dailySign(){
            // 获取用户签到信息
            $merArr = M('merchant') -> where("MerID = '$this->UserId'") -> find();
            // 判断是否为注册后第一次签到
            if($merArr['totalTime'] == 0 && $merArr['totalnum'] == 0){
                // 获取签到设置
                $signArr = M('sign') -> where("num = 1") -> find();
                $Yunbi = $signArr['yun'];
                $score['Mertotal'] = array('exp',"Mertotal + $Yunbi");
                $score['totalnum'] = 1;
                $score['totalTime'] = time();
                $result = M('merchant') -> where("MerID = '$this->UserId'") -> save($score);
                if($result > 0){
                    echo "签到成功";
                }else{
                    echo "签到失败";
                }
            }else{
                // 获取登录用户签到信息
                $totalTime = $merArr['totalTime']; // 签到时间
                $totalnum = $merArr['totalnum']; // 签到次数
                $signTime = date('y-m-d',$totalTime); // 格式化签到时间
                // 判断今天是否已经签到
                if($signTime == date('y-m-d',time())){
                    echo "已签到";
                    exit;
                }else{
                    // 判断是否错过连续签到时间
                    if(time() - $totalTime > 60*60*24){
                        // 获取签到设置
                        $signArr = M('sign') -> where("num = 1") -> find();
                        $Yunbi = $signArr['yun'];
                        $score['Mertotal'] = array('exp',"Mertotal + $Yunbi");
                        $score['totalnum'] = 1;
                        $score['totalTime'] = time();
                        $result = M('merchant') -> where("MerID = '$this->UserId'") -> save($score);
                        if($result > 0){
                            echo "签到成功";
                        }else{
                            echo "签到失败";
                        }
                    }else{
                        // 获取签到设置
                        $signArr = M('sign') -> where("num = $totalnum + 1") -> find();
                        if($signArr != null){
                            $Yunbi = $signArr['yun'];
                        }else{
                            $maxYun = M('sign') -> Max('num');
                            $signArr = M('sign') -> where("num = $maxYun") -> find();
                            $Yunbi = $signArr['yun'];
                        }
                        $score['Mertotal'] = array('exp',"Mertotal + $Yunbi");
                        $score['totalnum'] = $totalnum + 1;
                        $score['totalTime'] = time();
                        $result = M('merchant') -> where("MerID = '$this->UserId'") -> save($score);
                        if($result > 0){
                            echo "签到成功";
                        }else{
                            echo "签到失败";
                        }
                    }
                }
            }
        }
复制代码
--
-- 表的结构 `web_sign`
--
CREATE TABLE IF NOT EXISTS `web_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` tinyint(4) NOT NULL,
  `yun` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='签到表' AUTO_INCREMENT=3 ;
--
-- 转存表中的数据 `web_sign`
--
INSERT INTO `web_sign` (`id`, `num`, `yun`) VALUES
(1, 1, 20),
(2, 2, 40);
