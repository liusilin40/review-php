<?php
/**
* @file function.php
* @brief 本文件是对“php手册-语言参考-函数”部分的实践与理解
* @author 640
* @version 1.0
* @date 2017-06-29
 */

/**
 * 用户自定义的函数
 *
 * 需要注意的几点：(下面2种情况下的函数，需要再被调用前定义。而一般情况下是无需再调用前定义的。
 *  1. 有条件的函数
 *  2. 函数中的函数
 *
 * PHP 中的所有函数和类都具有全局作用域，可以定义在一个函数之内而在之外调用，反之亦然。
 *
 * PHP 不支持函数重载，也不可能取消定义或者重定义已声明的函数。 
 *
 * 函数名是大小写无关的。
 */
//正常情况下的函数调用，不需要提前定义。
fun();

function fun(){
    echo 'a';
}

//有条件的函数，需要提前定义
$makefoo = true;

/* 不能在此处调用foo()函数，
 *    因为它还不存在，但可以调用bar()函数。*/

bar();

if ($makefoo) {
    function foo()
    {
        echo "I don't exist until program execution reaches me.\n";
    }
}

/* 现在可以安全调用函数 foo()了，
 *    因为 $makefoo 值为真 */

if ($makefoo) foo();

function bar()
{
    echo "I exist immediately upon program start.\n";
}

//函数中的函数,只有在外层函数被执行后，里层函数才能不调用。
function foo()
{
    function bar()
    {
        echo "I don't exist until foo() is called.\n";
    }
}

/* 现在还不能调用bar()函数，因为它还不存在 */

foo();

/* 现在可以调用bar()函数了，因为foo()函数
 *    的执行使得bar()函数变为已定义的函数 */

bar();

/**
 * 函数的参数
 *
 * 1. 通过引用传递参数。略
 * 2. 默认参数的值。
 *      注意当使用默认参数时，任何默认参数必须放在任何非默认参数的右侧；否则，函数将不会按照预期的情况工作。
 * 3. 类型声明
 *      类型声明允许函数在调用时要求参数为特定类型。 如果给出的值类型不对，那么将会产生一个错误： 在PHP 5中，这将是一个
 *      可恢复的致命错误，而在PHP 7中将会抛出一个TypeError异常。 
 *
 *      为了指定一个类型声明，类型应该加到参数名前。这个声明可以通过将参数的默认值设为NULL来实现允许传递NULL。
 *
 *      有效的类型声明：
 *          php7.0之前：Class/interface name、self、array、callable
 *          php7.0之后：增加了bool、float、int、string (注意，这几个标量类型的别名并没有被支持)
 * 4. 严格类型
 *       默认情况下，如果能做到的话，PHP将会强迫错误类型的值转为函数期望的标量类型。例如，一个函数的一个参数期望是
 *       string，但传入的是integer，最终函数得到的将会是一个string类型的值。 
 *
 *       可以基于每一个文件开启严格模式。在严格模式中，只有一个与类型声明完全相符的变量才会被接受，否则将会抛出一个
 *       TypeError。唯一的一个例外是可以将integer传给一个期望float的函数。 
 *
 *       使用 declare 语句和strict_types 声明来启用严格模式: declare(strict_types=1);
 *
 *       注意1：严格类型适用于在启用严格模式的文件内的函数调用，而不是在那个文件内声明的函数。 一个没有启用严格模式的文
 *       件内调用了一个在启用严格模式的文件中定义的函数，那么将会遵循调用者的偏好（弱类型），而这个值将会被转换。 
 *       注意2: 严格类型仅用于标量类型声明，也正是因为如此，这需要PHP 7.0.0或更新版本，因为标量类型声明也是在那个版本中
 *       添加的。 
 * 5. 可变数量的参数列表
 *      1. php 5.5及更早的版本，使用函数 func_num_args()，func_get_arg()，和 func_get_args()实现。
 *      2. php 5.6及以后，由 ... 语法实现
 *          1. 用...标识符表示函数接受可变数量的参数。这些参数会以数组的形式传入。
 *          2. 也可以用...去拆开数组或者Traversable变量，形成一个参数列表。
 *          3. 也可以在...前使用类型提示。
 *      详细内容参见文档提供的例子。
 */

/**
 * 返回值
 *
 * 返回语句会立即中止函数的运行，并且将控制权交回调用该函数的代码行。
 *
 * 如果省略了 return，则返回值为 NULL。 
 * 如果return后没有值，返回值为NULL。
 *
 * 要注意的点：
 *      1. 函数不能返回多个值，但可以通过返回一个数组来得到类似的效果。 
 *      2. 从函数返回一个引用，必须在函数声明和指派返回值给一个变量时都使用引用运算符 &
 *
 * 返回类型申明:
 *      php7新增了返回类型申明，增加了申明后，函数将返回申明的类型的返回值。语法见下面的例子。
 *      强弱模式下不同的处理行为：
 *          1. 在default weak mode，如果返回值不是申明的类型，会将其转换为申明的类型
 *          2. 在strong mode，返回值得类型必须是申明的类型，不然会扔出TypeError
 *
 *      注意：在方法的继承中，子方法必须完全匹配父方法的类型。如果父方法没有定义返回类型，子方法可以定义返回类型。
 */
//通过数组返回多个值
function small_numbers()
{
    return array (0, 1, 2);
}
list ($zero, $one, $two) = small_numbers();

//函数返回引用
function &returns_reference()
{
    return $someref;
}
$newref =& returns_reference();

//返回类型申明
function sum($a, $b): float {
        return $a + $b;
}

// Note that a float will be returned.
var_dump(sum(1, 2));

declare(strict_types=1);        //开启strong mode

function sum($a, $b): int {
        return $a + $b;
}

var_dump(sum(1, 2));
var_dump(sum(1, 2.5));

/**
 * 可变函数
 * PHP 支持可变函数的概念。这意味着如果一个变量名后有圆括号，PHP 将寻找与变量的值同名的函数，并且尝试执行它。
 *
 * php7.0 'ClassName::methodName' is allowed as variable function. 
 */

/**
 * 匿名函数
 *
 * 匿名函数（Anonymous functions），也叫闭包函数（closures），允许临时创建一个没有指定名称的函数。最经常用作回调函数
 * （callback）参数的值。当然，也有其它应用的情况。 
 *
 * 匿名函数目前是通过 Closure 类来实现的。 
 * 
 * 要注意的点：
 *  1. 闭包可以从父作用域中继承变量。 任何此类变量都应该用 use 语言结构传递进去。 PHP 7.1 起，不能传入此类变量： 
 *  superglobals、 $this 或者和参数重名。
 *  2. 从php5.4起，在类的上下文中定义匿名函数，会自动把当前类绑定到匿名函数中，是$this在匿名函数域内是可用的。如果不希
 *  望自动绑定当前类，应该使用静态匿名函数。
 */
$message = 'hello';
// 继承 $message
$example = function () use ($message) {
    var_dump($message);
};
echo $example();

//类中的匿名函数
class Test
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}

$object = new Test;
$function = $object->testing();
$function();

//静态匿名函数
class Foo
{
    function __construct()
    {
        $func = static function() {
            var_dump($this);
        };
        $func();
    }
};
new Foo();
