<?php
_check_syntax.session.save_handler = files

    * 1. session_start()这一部下完成了哪些工作
         1. session_start()是session机制的开始，它有一定概率开启垃圾回收,因为session是存放在【文件】中，
          PHP自身的垃圾回收是无效的，SESSION的回收是要删文件的，这个概率是根据php.ini的配置决定的，
          但是有的系统是 session.gc_probability = 0，这也就是说概率是0，而是通过cron脚本来实现垃圾回收。

            session.gc_probability = 1
            session.gc_divisor = 1000
            session.gc_maxlifetime = 1440//过期时间 默认24分钟
            //概率是 session.gc_probability/session.gc_divisor 结果 1/1000,
            //不建议设置过小，因为session的垃圾回收，是需要检查每个文件是否过期的。
            session.save_path = //好像不同的系统默认不一样，有一种设置是 "N;/path"
            //这是随机分级存储，这个样的话，垃圾回收将不起作用，需要自己写脚本

         2. session会判断当前是否有$_COOKIE[session_name()];session_name()返回保存session_id的COOKIE键值，
         这个值可以从php.ini找到//判断sessionid是否存在

            session.name = PHPSESSID //默认值PHPSESSID


         3. 如果不存在会生成一个session_id,然后把生成的session_id作为COOKIE的值传递到客户端.
        相当于执行了下面COOKIE 操作，注意的是，这一步执行了setcookie()操作，COOKIE是在【header】头中发送的，
        这之前是不能有输出的，PHP有另外一个函数 session_regenerate_id() 如果使用这个函数，这之前也是不能有输出的。
        //在这一部可以对session机制完成URL重写
                setcookie(session_name(),
                          session_id(),
                          session.cookie_lifetime,//默认0
                          session.cookie_path,//默认'/'当前程序跟目录下都有效
                          session.cookie_domain,//默认为空
                          )

         4. 如果存在那么session_id = $_COOKIE[session_name];
            然后去session.save_path指定的文件夹里去找名字为'SESS_' . session_id()的文件.
            读取文件的内容【反序列化】，然后放到$_SESSION中
  * 2. 为$_SESSION赋值
        比如新添加一个值$_SESSION['test'] = 'blah'; 那么这个$_SESSION只会维护在内存中，当脚本执行结束的时候，
        用把$_SESSION的值写入到session_id指定的文件夹中，然后关闭相关资源.      这个阶段有可能执行更改session_id的操作，
        比如销毁一个旧的的session_id，生成一个全新的session_id.一半用在自定义 session操作，角色的转换上，
        比如Drupal.Drupal的匿名用户有一个SESSION的，当它登录后需要换用新的session_id

        if (isset($_COOKIE[session_name()])) {
          setcookie(session_name(), '', time() - 42000, '/');//旧session cookie过期
        }
        session_regenerate_id();//这一步会生成新的session_id
       //session_id()返回的是新的值

      3.写入SESSION操作【持久化cookie】
      在脚本结束的时候会执行SESSION写入操作，把$_SESSION中值写入到session_id命名的文件中，可能已经存在，
      可能需要创建新的文件。
* 4. 销毁SESSION
      SESSION发出去的COOKIE一般属于即时COOKIE，保存在【内存】中，当浏览器关闭后，才会过期，假如需要人为强制过期，
      比如 退出登录，而不是关闭浏览器，那么就需要在代码里销毁SESSION，方法有很多，
          o 1. setcookie(session_name(), session_id(), time() - 8000000, ..);//退出登录前执行
          o 2. usset($_SESSION);//这会删除所有的$_SESSION数据，刷新后，有COOKIE传过来，但是没有数据。
          o 3. session_destroy();//这个作用更彻底，删除$_SESSION 删除session文件，和session_id

      当不关闭浏览器的情况下，再次刷新，2和3都会有COOKIE传过来，但是找不到数据

      2.session.save_handler = user

      用户自定义session处理机制，更加直观
      * session_set_save_handler('open', 'close', 'read', 'write', 'destroy', 'gc');
      1.session_start(),
      执行open($save_path, $session_name)打开session操作句柄
      $save_path 在session.save_handler = files的情况下它就是session.save_path，
      但是如果用户自定的话，这个两个参数都用不上，直接返回TRUE

      执行read($id)从中读取数据.//这个参数是自动传递的就是session_id(),可以通过这个值进行操作。
    * 2.脚本执行结束
      执行write($id, $sess_data) //两个参数，很简单
    * 3.假如用户需要session_destroy()
      先执行destroy.在执行第2步

      一个实际例子：

      //SESSION初始化的时候调用
      function open($save_path, $session_name)
      {
        global $sess_save_path;
        $sess_save_path = $save_path;
        return(true);
      }

      //关闭的时候调用
      function close()
      {
        return(true);
      }

      function read($id)
      {
        global $sess_save_path;
        $sess_file = "$sess_save_path/sess_$id";
        return (string) @file_get_contents($sess_file);
      }
      //脚本执行结束之前，执行写入操作
      function write($id, $sess_data)
      {
        echo "sdfsf";
        global $sess_save_path;

        $sess_file = "$sess_save_path/sess_$id";
        if ($fp = @fopen($sess_file, "w")) {
          $return = fwrite($fp, $sess_data);
          fclose($fp);
          return $return;
        } else {
          return(false);
        }

      }

      function destroy($id)
      {
        global $sess_save_path;

        $sess_file = "$sess_save_path/sess_$id";
        return(@unlink($sess_file));
      }

      function gc($maxlifetime)
      {
        global $sess_save_path;

        foreach (glob("$sess_save_path/sess_*") as $filename) {
          if (filemtime($filename) + $maxlifetime < time()) {
            @unlink($filename);
          }
        }
        return true;
      }
