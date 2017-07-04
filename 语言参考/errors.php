<?php
/**
* @file error.php
* @brief 本文件是对“php手册-语言参考-Errors“部分的实践与理解
* @author 640
* @version 1.0
* @date 2017-07-01
 */

/**
 * Errors
 * PHP通过报告errors来处理内部一系列的错误情况。这些被报告的错误能够用来通知使用者一系列不同的状况，也能根据需求用于显
 * 示或日志。
 *
 * PHP产生的每一个error都包含一个类型。类型如下：
 * E_ERROR|E_WARNING|E_PARSE|E_NOTICE|E_CORE_ERROR|E_CORE_WARNING |E_COMPILE_ERROR |E_COMPILE_WARNING |E_USER_ERROR |
 * E_USER_WARNING |E_USER_NOTICE |E_STRICT |E_RECOVERABLE_ERROR |E_DEPRECATED|E_USER_DEPRECATED| E_ALL
 *
 * 如果没有error handle被设置，php根据配置文件来处理errors。
 *  1. error_reporting      指明哪些错误被忽略、哪些错误被报告。另外也可以通过error_reporting()在运行时控制
 *  2. display_errors       控制error是否作为脚本的输出显示。在生产环境下应该disable，因为这样可能会导致内部信息的泄露
 *  3. log_errors           当log_errors是enabled时，php会记录errors在日志中，日志文件有error_log指定。
 *
 *  如果php默认的error handling 不能满足需求，我们可以通过set_error_handler()自定义我们需要的错误处理方式。不过有一些
 *  error不能以这种方式处理。
 *
 *  PHP7 错误处理：
 *      PHP 7 改变了大多数错误的报告方式。不同于传统（PHP 5）的错误报告机制，现在大多数错误被作为 Error 异常抛出。 
 *      这种 Error 异常可以像 Exception 异常一样被第一个匹配的 try / catch 块所捕获。如果没有匹配的 catch 块，则调用异
 *      常处理函数（事先通过 set_exception_handler() 注册）进行处理。如果尚未注册异常处理函数，则按照传统方式处理：被报
 *      告为一个致命错误（Fatal Error）。 
 *
 *      Error 类并非继承自 Exception 类，所以不能用 catch (Exception $e) { ... } 来捕获 Error。你可以用 catch (Error $e) 
 *      { ... }，或者通过注册异常处理函数（ set_exception_handler()）来捕获 Error。 
 *
 *      Error、Exception 继承自Throwable
 */
