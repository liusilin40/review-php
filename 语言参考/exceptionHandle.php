<?php
/**
* @file exceptionHandle.php
* @brief 本文件是对“php手册-语言参考-异常处理“部分的实践与理解
* @author 640
* @version 1.0
* @date 2017-07-01
 */

/**
 * 异常处理
 * try {
 *
 * } catch {
 *
 * } finally {
 *
 * }
 *
 * catch 中，如果exception被抛出，但是没有匹配的catch时，php会产生一个fatal error with an “Uncaught Exception ...”,除非
 * 一个handler通过set_exception_handler()设置。
 *
 * finally中的代码不管是否抛出异常，都肯定会在try和catch后执行。
 */
