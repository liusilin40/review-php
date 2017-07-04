<?php
/**
* @file flowControl.php
* @brief 本文件是对“php手册-语言参考-流程控制”部分的实践与理解
* @author 640
* @version 1.0
* @date 2017-06-29
 */

/**
 * 值得注意的几点：
 *      1. 用 list() 给嵌套的数组解包
 *      2. break 可以接受一个可选的数字参数来决定跳出几重循环。 
 *      3. 同理，continue也可以接受一个可选的数字参数来决定跳过几重循环到循环结尾。默认值是 1，即跳到当前循环末尾。 
 *      4. switch/case 作的是松散比较==,而不是严格比较===。 
 *      5. declare 结构 （没看懂，不知道该怎么用）
 *      6. return 的几种应用场景，见下面对return的专题介绍。
 *      7. include、require、include_once、require_once，见下面的专题介绍
 *      8. goto 操作符可以用来跳转到程序中的另一位置。PHP 中的 goto 有一定限制，目标位置只能位于同一个文件和作用域.也无
 *      法跳入到任何循环或者 switch 结构中。
 *
 */
// 用 list() 给嵌套的数组解包
// PHP 5.5 增添了遍历一个数组的数组的功能并且把嵌套的数组解包到循环变量中，只需将 list() 作为值提供。
$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b)) {
    echo "A: $a; B: $b\n";
}
//list() 中的单元可以少于嵌套数组的，此时多出来的数组单元将被忽略
//如果 list() 中列出的单元多于嵌套数组则会发出一条消息级别的错误信息

//break num
$i = 0;
while (++$i) {
    switch ($i) {
    case 5:
        echo "At 5<br />\n";
        break 1;  /* 只退出 switch. */
    case 10:
        echo "At 10; quitting<br />\n";
        break 2;  /* 退出 switch 和 while 循环 */
    default:
        break;
    }
}

/**
 * return 
 * return 可以应用在以下场景中：
 *      1. 函数中调用return，将立即结束此函数的执行并将它的参数作为函数的值返回。
 *      2. eval()中使用return，立即终止eval()语句
 *      3. 在脚本文件中执行，则当前脚本文件中止运行。
 *          1.如果当前脚本文件是被 include 的或者 require 的，则控制交回调用文件。
 *          2.如果当前脚本是被 include 的，则 return 的值会被当作 include 调用的返回值。
 *          3.如果在主脚本文件中调用 return，则脚本中止运行。
 *          4.如果当前脚本文件是在 php.ini 中的配置选项 auto_prepend_file 或者 auto_append_file 
 *          所指定的，则此脚本文件中止运行。 
 */
$str = <<<EOT
echo "hello\n";
return;
echo "bye\n";
EOT;
eval($str);
echo 'end';

/**
 * require、include、requrie_once、include
 * 
 * 1. require与include的差别：
 *    require 和 include 几乎完全一样，除了处理失败的方式不同之外。require 在出错时产生 E_COMPILE_ERROR 
 *    级别的错误。换句话说将导致脚本中止而 include 只产生警告（E_WARNING），脚本会继续运行。 
 *
 * 2. 文件查找机制：
 *    1. 如果给出了路径（相对路径或者绝对路径），则按照路径查找,忽略include_path。
 *    2. 如果只给出了文件名，则按照include_path指定的目录寻找。如果在include_path下没找到该文件则include最后才在调用脚
 *    本文件所在的目录和当前工作目录下寻找。
 *
 *    如果最后仍未找到文件则 include 结构会发出一条警告；这一点和 require 不同，后者会发出一个致命错误。 
 *
 * 3. 代码的变量范围
 *    当一个文件被包含时，其中所包含的代码继承了 include 所在行的变量范围。从该处开始，调用文件在该行处可用的任何变量在
 *    被调用的文件中也都可用。(魔术变量是例外,它们是在发生包含之前就已被解析器处理的。)
 *
 * 4. 包含文件中定义的函数和类都具有全局作用域
 *    即在包含文件中定义的函数、类，在全局范围了都可以访问。不论被包含文件是在全局作用域被包含，还是在局部作用域被包含。
 *    又或者函数、类在return之后定义的。都可以在全局范围被访问。
 *    如果在包含文件中定义有函数，这些函数不管是在 return 之前还是之后定义的，都可以独立在主文件中使用。如果文件被包含
 *    两次，PHP 5 发出致命错误因为函数已经被定义，但是 PHP 4 不会对在 return 之后定义的函数报错。推荐使用 include_once 
 *    而不是检查文件是否已包含并在包含文件中有条件返回。 
 *
 * 5. 返回值
 *    1. 包含失败，include 返回false，并发出一个 E_WARNING 警告。require 直接E_COMPILE_ERROR 级别的错误，终止脚本
 *    2. 包含成功
 *          1. 被包含文件没有return时，返回值为1
 *          2. 被包含文件有return时，返回return的内容。如果return后面有值，返回该值。无值，返回null
 * 
 * 再次申明，requrie和include除了失败处理方式不同，其他的都一样。包括文件查找机制、代码的变量范文、函数和类的作用域、返
 * 回值。
 *
 *  *_once 指如果该文件中已经被包含过，则不会再次包含。
 */
//file tmp.php
echo 'a'."\n";
function fun1(){
    echo "fun1\n";
}
return;
function fun2(){
    echo "fun2\n";
}

$a = 'hello';

//file a.php
function test()
{
    include './tmp.php';
}
fun1();
fun2();
echo "$a\n";        //报错，因为在tmp.php中在申明$a之前已经return
include './tmp.php';    //报错，函数重复定义
