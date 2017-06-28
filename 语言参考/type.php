<?php
/**
* @file type.php
* @brief 本文件是对“php手册-语言参考-类型“部分的实践与理解
* @author liusilin
* @version 1.0
* @date 2017-06-27
 */

/**
 * PHP支持9种类型：
 * 4中标量类型：boolean,int,float,string
 * 3中复合类型：array,object,callable
 * 2中特殊类型：resource,NULL
 * 另外，还有以下伪类型：mixed,number,callback,void
 * 重要的是：变量类型根据该变量使用的上下文由运行时决定
 */

/**
 * var_dump() 查看表达式的值和类型
 * gettype()  得到一个易读懂的类型的表达方式用于调试
 * is_type()  用于检验某个类型
 */

$arr1 = [1,2,3,4];
echo gettype($arr1);  //输出：array
$fun1 = function(){ 
	//echo something
};
echo gettype($fun1);	//输出：object   输出的不是callable

/**
 * 整型interger
 * 表示方式：16进制、10进制、8进制、2进制
 * 			$a = 1234; // 十进制数
 * 			$a = -123; // 负数
 * 			$a = 0123; // 八进制数 (等于十进制 83)
 * 			$a = 0x1A; // 十六进制数 (等于十进制 26)
 * 			$a = 0b11111111; // 二进制数字 (等于十进制 255)
 * php不支持无符号interger
 * 整数的表示的范围：整型数的字长和平台有关，尽管通常最大值是大约二十亿（32 位有符号,即2E9）。64 位平台下的最大值通常是大约 9E18. 
 * 					Integer 值的字长可以用常量 PHP_INT_SIZE来表示;
 * 					自 PHP 4.4.0 和 PHP 5.0.5后，最大值可以用常量 PHP_INT_MAX 来表示;
 * 					最小值可以在 PHP 7.0.0 及以后的版本中用常量 PHP_INT_MIN 表示。 
 * 整数溢出：如果给定的一个数超出了 integer 的范围，将会被解释为 float。同样如果执行的运算结果超出了 integer 范围，也会返回 float。
 * PHP 中没有整除的运算符: 当除法运算不能整除时，会转换为float。可以用强制类型转换截取整数部分，或者使用round()函数四舍五入
 * 类型转换：(int) 、(integer) 、intval()
 * 			从boolean转换：false => 0  , true => 1
 * 			从float转换： 截取整数部分,即向下取整。因为浮点数不能精确的表示数值，在强制转换为整数时可能会产生不可预料的结果，见下面的
 * 						  例子。(如果浮点数超出了整数范围（32 位平台下通常为 +/- 2.15e+9 = 2^31，64 位平台下，除了 Windows,通常
 * 						  为 +/- 9.22e+18 = 2^63），则结果为未定义，因为没有足够的精度给出一个确切的整数结果。在此情况下没有警告，
 * 						  甚至没有任何通知)
 * 		    从string转换：
 * 		    从其他类型转换：
 */
echo PHP_INT_SIZE;	//64位机器  输出：8.即8个字节，对应64位
echo PHP_INT_MAX;	// 64位机器  输出：9223372036854775807 。 2^63 - 1 = 9223372036854775807

$num = PHP_INT_MAX;
var_dump($num);			//int(9223372036854775807)
$num++;
var_dump($num);			//float(9.2233720368548E+18)  被解释为浮点型

var_dump(25/7);         // float(3.5714285714286) 
var_dump((int) (25/7)); // int(3)
var_dump(round(25/7));  // float(4) 

echo (int) ( (0.1+0.7) * 10 ); // 显示 7!


/**
 * 浮点型 float
 * php 不区分float、double、real。实际上都是双精度double
 * 表示方式： $a = 1.234; 
 * 			  $b = 1.2e3; 
 * 			  $c = 7E-10;
 * 范围： 浮点数的字长和平台相关，尽管通常最大值是 1.8e308 并具有 14 位十进制数字的精度（64 位 IEEE 格式）。 
 * 精度： 浮点数的精度有限。尽管取决于系统，PHP 通常使用 IEEE 754 双精度格式，则由于取整而导致的最大相对误差为 1.11e-16。非基本数学运算
 * 		  可能会给出更大误差，并且要考虑到进行复合运算时的误差传递。 
 * 		  所以永远不要相信浮点数结果精确到了最后一位，也永远不要比较两个浮点数是否相等。如果确实需要更高的精度，应该使用任意精度数学函数或者 gmp 函数。 
 * 转换为浮点数：
 * 			从字符串转换：
 * 			从对象转换：导致E_NOTICE错误
 * 			从其他类型转换：先转换为整型，再转换为浮点
 * 浮点数比较：
 * 			应该采用abs($a - $b) < 0.00001的形式比较
 * NaN:   某些数学运算会产生一个由常量 NAN 所代表的结果。此结果代表着一个在浮点数运算中未定义或不可表述的值。任何拿此值与其它任何值（除了 TRUE）进行的
 * 		  松散或严格比较的结果都是 FALSE。 由于 NAN 代表着任何不同值，不应拿 NAN 去和其它值进行比较，包括其自身，应该用 is_nan() 来检查。 
 */

/**
 * 字符串string
 * 输入形式：
 * 		1. 单引号。		\只能转义单引号和“\”本身。其他任何字符都不能转义。
 * 		2. 双引号。		可以转义很多字符
 * 		3. heredoc。	形式： <<<EOT
 * 							   This is my file.
 * 							   EOT;
 * 						特点：双引号形式的扩展，可以直接使用双引号
 * 		4. nowdoc。		形式： <<<'EOT'
 * 							   This is my file.
 * 							   EOT;
 * 						特点：单引号形式的扩展。nowdoc结构可以使用在任意的静态数据环境中。
 * 变量解析：
 * 		1. 简单语法    $
 * 		2. 复杂语法	   {}
 * 其他类型转换为字符串：
 * 		bool：	true => "1"		false => ""
 * 		int | float:		直接转换为字面形式
 * 		array：		总是转换为“array”
 * 		object:		总是转换为“object”
 * 		resource:		总会被转变成 "Resource id #1" 这种结构的字符串
 * 		NULL:		""
 * 		注：可以使用serialize()、unserialize()实现串行化和反串行化
 * 字符串转换为数值：
 * 		如果该字符串没有包含 '.'，'e' 或 'E' 并且其数字值在整型的范围之内（由 PHP_INT_MAX 所定义），该字符串将被当成 integer 来取值。其它所有情况下都被作为
 * 		float 来取值。 
 * 		该字符串的开始部分决定了它的值。如果该字符串以合法的数值开始，则使用该数值。否则其值为 0（零）。合法数值由可选的正负号，后面跟着一个或多个数字（可能
 * 		有小数点），再跟着可选的指数部分。指数部分由 'e' 或 'E' 后面跟着一个或多个数字构成。 
 * 字符串本质：
 * 		PHP中string的实现方式：一个由字节组成的数组+一个整数（指明缓冲区的长度）。
 * 		这种实现方式中，并没有指明字节如何转换为字符的信息，这个转换过程有上层代码确定，程序员可以拥有控制权。因此，可以用string存储任何的值，这也是为什么php
 * 		没有byte类型的原因。例如，socket套接字读取的数据通过string返回。
 * 		PHP并没有指明字符串的编码，那么字符串到底是怎么编码的呢？
 * 		答案：字符串会安装与脚本相同的编码格式进行编码，如果脚本是utf-8编码，则字符串也以utf-8编码。如果以ISO-8859-1编码，则字符串也按该编码编码。不过这并不
 * 		适用于激活了 Zend Multibyte 时；此时脚本可以是以任何方式编码的（明确指定或被自动检测）然后被转换为某种内部编码，然后字符串将被用此方式编码。
 */
//本部分是对字符串本质部分的解释，string安装与脚本相同的编码格式编码。
//在vim中可以通过 set fileencoding=utf-8  或者 ISO-8859-1改变脚本的编码格式
var_dump(unpack("C*","á"));			//输出"á"的字节值。设置脚本不同的编码格式，输出不同。相关的函数：pack()、unpack()、base_convert()

/**
 * 数组array
 * PHP 中的数组实际上是一个有序映射。映射是一种把 values 关联到 keys 的类型。此类型在很多方面做了优化，因此可以把它当成真正的数组，或列表（向量），散列表（是
 * 映射的一种实现），字典，集合，栈，队列以及更多可能性。由于数组元素的值也可以是另一个数组，树形结构和多维数组也是允许的。 
 *
 * array( key => value,
 * 		...
 * 		)
 * 	或者
 * 	[ key => value,
 * 		...
 * 		]
 * 	key 可以是 integer 或者 string。value 可以是任意类型。 
 * 	此外 key 会有如下的强制转换：
 * 	1. 包含有合法整型值的字符串会被转换为整型。例如键名 "8" 实际会被储存为 8。但是 "08" 则不会强制转换，因为其不是一个合法的十进制数值。
 * 	2. 浮点数也会被转换为整型，意味着其小数部分会被舍去。例如键名 8.7 实际会被储存为 8。
 * 	3. 布尔值也会被转换成整型。即键名 true 实际会被储存为 1 而键名 false 会被储存为 0。 
 * 	4. Null 会被转换为空字符串，即键名 null 实际会被储存为 ""。 
 * 	5. 数组和对象不能被用为键名。坚持这么做会导致警告：Illegal offset type。 
 *
 * 	PHP 数组可以同时含有 integer 和 string 类型的键名，因为 PHP 实际并不区分索引数组和关联数组。 
 * 	如果对给出的值没有指定键名，则取当前最大的整数索引值，而新的键名将是该值加一。如果指定的键名已经有了值，则该值会被覆盖。 
 *
 * 	自 PHP 5.4 起可以用直接对函数或方法调用的结果进行数组解引用，之前只能通过一个临时变量。
 * 	自 PHP 5.5 起可以直接对一个数组原型进行数组解引用。 
 */
function getArray() {
	    return array(1, 2, 3);
}
$secondElement = getArray()[1];
list(, $secondElement) = getArray();

/** 
 * 对象object
 * 其他类型转换为object:
 *  如果将一个对象转换成对象，它将不会有任何变化。如果其它任何类型的值被转换成对象，将会创建一个内置类 stdClass 的实例。如果该值为 NULL，
 *  则新的实例为空。 array 转换成 object 将使键名成为属性名并具有相对应的值，除了数字键，不迭代就无法被访问。 
 *  对于其他值，会包含进成员变量名 scalar。
 */
$obj = (object) array('1' => 'foo');
var_dump(isset($obj->{'1'})); // outputs 'bool(false)'
var_dump(key($obj)); // outputs 'int(1)'

$obj = (object) 'ciao';
echo $obj->scalar;  // outputs 'ciao'

/**
 * 资源类型Resource
 * 资源 resource 是一种特殊变量，保存了到外部资源的一个引用。资源是通过专门的函数来建立和使用的。
 *
 * 释放资源：
 * 引用计数系统是 Zend 引擎的一部分，可以自动检测到一个资源不再被引用了（和 Java 一样）。这种情况下此资源使用的所有外部资源都会被垃圾回收系统释放。因此，很少需要手工释放内存。 
 *
 * get_resource_type()   获取资源类型。
 */
$c = mysql_connect();
echo get_resource_type($c)."\n";
// 打印：mysql link

$fp = fopen("foo","w");
echo get_resource_type($fp)."\n";
// 打印：file

/**
 * NULL
 * 特殊的 NULL 值表示一个变量没有值。NULL 类型唯一可能的值就是 NULL。 
 * 在下列情况下一个变量被认为是NULL： 
 * 1. 被赋值为NULL
 * 2. 尚未被赋值。
 * 3. 被unset()。 
 * 
 * 相关函数：is_null() 和 unset()。 
 */

/**
 * callback/callable类型
 * 一些函数如 call_user_func() 或 usort() 可以接受用户自定义的回调函数作为参数。回调函数不止可以是简单函数，还可以是对象的方法，包括静态类方法。 
 *
 * callback/callable的传递：
 * 1. 函数传递。将函数以string形式传递的。可以使用任何内置或用户自定义函数，但语言结构不能传递，如array()，echo，empty()，eval()，exit()，isset()，list()，print 或 unset()。
 * 2. 类方法传递。 一个已实例化的 object 的方法被作为 array 传递，下标 0 包含该 object，下标 1 包含方法名。 在同一个类里可以访问 protected 和 private 方法。 
 * 3. 静态类方法传递。静态类方法也可不经实例化该类的对象而传递，只要在下标 0 中包含类名而不是对象。自 PHP 5.2.3 起，也可以传递 'ClassName::methodName'。 
 * 4. 也可传递 匿名函数 给回调参数。
 */
function my_callback_function() {
	    echo 'hello world!';
}
class MyClass {
	static function myCallbackMethod() {
		echo 'Hello World!';
	}
}
call_user_func('my_callback_function'); 
call_user_func(array('MyClass', 'myCallbackMethod')); 
$obj = new MyClass();
call_user_func(array($obj, 'myCallbackMethod'));
// Static class method call (As of PHP 5.2.3)
 call_user_func('MyClass::myCallbackMethod');

// Type 5: Relative static class method call (As of PHP 5.3.0)
class A {
    public static function who() {
        echo "A\n";
    }
}

class B extends A {
    public static function who() {
        echo "B\n";
    }
}

call_user_func(array('B', 'parent::who')); // A

/**
 * 伪类型与变量
 * 1. mixed
 * 2. number
 * 3. callback
 * 4. array|object
 * 5. void
 * 6. ...
 */
