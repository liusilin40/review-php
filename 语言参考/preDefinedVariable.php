<?php
/**
* @file preDefinedVariable.php
* @brief 本文件是对“php手册-语言参考-预定义变量”部分的实践与理解
* @author 640
* @version 1.0
* @date 2017-06-28
 */

/**
 * 预定义变量
 * 		对于全部脚本而言，PHP 提供了大量的预定义变量。这些变量将所有的外部变量表示成内建环境变量，并且将错误信息表示成返回头。 
 *
 * 预定义变量分为以下几种：
 * 		1. 超全局变量		——		超全局变量是在全部作用域中始终可用的内置变量
 * 		2. $GLOBALS			——		引用全局作用域中可用的全部变量
 * 		3. $_SERVER			——		服务器和执行环境信息
 * 		4. $_GET			——		HTTP GET 变量
 * 		5. $_POST			——		HTTP POST 变量
 * 		6. $_FILES			——		HTTP文件上传变量 
 * 		7. $_REQUEST		——		HTTP Request 变量
 * 		8. $_SESSION		——		Session 变量
 * 		9. $_ENV			——		环境变量
 * 		10. $_COOKIE		——		HTTP Cookies
 * 		11. $php_errormsg	——		前一个错误信息
 * 		12. $HTTP_RAW_POST_DATA 	——	原生POST数据	
 * 		13. $http_response_header  	——	HTTP 响应头
 * 		14. $argc 		  	——		传递给脚本的参数数目
 * 		15. $argv 		  	——		传递给脚本的参数数组
 */

/**
 * 超全局变量
 * 		超全局变量是在全部作用域中始终可用的内置变量
 *
 * PHP 中的许多预定义变量都是“超全局的”，这意味着它们在一个脚本的全部作用域中都可用。在函数或方法中无需执行 global $variable; 就可以访问它们。 
 * 这些超全局变量是：
 *
 *		$GLOBALS
 *		$_SERVER
 *		$_GET
 *		$_POST
 *		$_FILES
 *		$_COOKIE
 *		$_SESSION
 *		$_REQUEST
 *		$_ENV
 */

/**
 * 其他内容详见文档。
 */
