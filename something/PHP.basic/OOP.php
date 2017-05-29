<?php
1. 抽象方法
在类中，没有方法体的方法就是抽象方法。
abstract 可见性 function 方法名称(参数1,.....);      // 如果没有显示地指定可见性，则默认为public
如：
public function hello($args);
abstract function work();            // 修饰符abstract，也可以省略

2. 抽象类
abstract class 类名{
        属性;
        方法;
        抽象方法;
}

抽象类的特点：
抽象类不能实例化，只能被继承。
抽象类不一定有抽象方法，有抽象方法的类，一定是抽象类。
抽象方法的可见性不能是private
抽象方法在子类中，需要重写。

什么时候需要用抽象类？
有个方法，方法体不知如何写，子类中还必须有这个方法时，封装成抽象方法，类为抽象类。
控制子类中必须封装某些方法时，可以用抽象方法。
当需要控制类只能被继承，不能被实例化时。

例子：
    声明一个人类，有一个抽象方法，工作。
    声明一个php讲师类，重写方法工作。
    abstract class People{
        protected $age=22;
        public $height=1.70;
        abstract function work();
    }
    class PhpTeacher extends People{
        function work(){
            echo "真不是php";
        }
    }

3. 接口
如果一个类中，所有的方法都是抽象方法，且没有成员属性，则这个类被称为接口（interface）。

interface Common{
    abstract function work();
    abstract function test($args);
}

接口的作用：虽然PHP的类是单继承，但可以通过接口来实现多继承。

接口的继承（extends）：
接口继承接口   interface 接口名称 extends 父接口名称

注意：类的继承是单继承（只能有一个父类），但接口的继承却是多继承，类对接口的实现也是多实现。

接口的实现（implements）：
类实现接口      class 类名 implements 接口名称1,接口名称2, ...

继承类同时实现接口：
类继承父类同时实现接口    class 类名 extends 父类名 implements 接口名称

4. 抽象类和接口的区别
接口是一种特殊的抽象类，接口中只包含抽象方法，没有成员属性。
类实现（implements）接口时，必须完全实现接口中的所有方法；类继承（extends）抽象类时，只需对需要用到的抽象方法进行重写。
抽象类只能单继承，但接口却是多继承，类对接口的实现也是多实现。

 ?>
