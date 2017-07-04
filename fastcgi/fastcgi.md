## FastCGI进程管理器(FPM)

FPM(FastCGI进程管理器)用于替换PHP FastCGI的大部分附加功能，对于高负载网站是非常有用的。

### 主要功能
1. 支持平滑停止/启动的高级进程管理功能； 
2. 可以工作于不同的 uid/gid/chroot 环境下，并监听不同的端口和使用不同的 php.ini 配置文件（可取代 safe_mode 的设置）； 
3. stdout 和 stderr 日志记录; 
4. 在发生意外情况的时候能够重新启动并缓存被破坏的 opcode; 
5. 文件上传优化支持; 
6. "慢日志" - 记录脚本（不仅记录文件名，还记录 PHP backtrace 信息，可以使用 ptrace或者类似工具读取和分析远程进程的运行数据）运行所导致的异常缓慢; 
7. fastcgi_finish_request() - 特殊功能：用于在请求完成和刷新数据后，继续在后台执行耗时的工作（录入视频转换、统计处理等）； 
8. 动态／静态子进程产生；
9. 基本 SAPI 运行状态信息（类似Apache的 mod_status）； 
10. 基于 php.ini 的配置文件。

### 配置文件php-fpm.conf
>详细见php-fpm.conf或http://php.net/manual/zh/install.fpm.configuration.php

#### 比较重要的几个配置指令
> pm string
> 设置进程管理器如何管理子进程。可用值：static，ondemand，dynamic。必须设置。 
> static - 子进程的数量是固定的（pm.max_children）。 
> ondemand - 进程在有需求时才产生（当请求时，与 dynamic 相反，pm.start_servers 在服务启动时即启动。 
> dynamic - 子进程的数量在下面配置的基础上动态设置：pm.max_children，pm.start_servers，pm.min_spare_servers，pm.max_spare_servers。 

-----

> pm.max_children int
>pm 设置为 static 时表示创建的子进程的数量，pm 设置为 dynamic 时表示最大可创建的子进程的数量。必须设置。
>该选项设置可以同时提供服务的请求数限制。类似 Apache 的 mpm_prefork 中 MaxClients 的设置和 普通PHP FastCGI中的 PHP_FCGI_CHILDREN 环境变量。

----

> pm.start_servers in
>设置启动时创建的子进程数目。仅在 pm 设置为 dynamic 时使用。默认值：min_spare_servers + (max_spare_servers - min_spare_servers) / 2。

----

>pm.min_spare_servers int
>设置空闲服务进程的最低数目。仅在 pm 设置为 dynamic 时使用。必须设置。

----

>pm.max_spare_servers int 
>设置空闲服务进程的最大数目。仅在 pm 设置为 dynamic 时使用。必须设置。

----
>pm.max_requests int 
>设置每个子进程重生之前服务的请求数。对于可能存在内存泄漏的第三方模块来说是非常有用的。如果设置为 '0' 则一直接受请求，等同于 PHP_FCGI_MAX_REQUESTS 环境变量。默认值：0。 

---
##### dynamic模式与ondemand模式比较：
dynamic模式，是这样工作的：启动时产生固定数量的子进程（有pm.start_servers控制）可以理解成最小进程，而最大子进程数则由pm.max_children去控制。除此以外，pm.min_spare_servers和pm.max_spare_servers控制闲置的子进程的最大值和最小值。
onedemand模式，工作模式则是：也是有pm.start_server，pm.max_childre控制子进程的最小、最大数目。同时对于每个闲置的进程，在持续闲置pm.process_idle_timeout秒后就会被杀掉。
由上可见，dynamic和onedemand模式分别采用了不同的闲置进程管理机制，dynamic通过维护更多的闲置进程来更好的保证了php-fpm对请求的响应时间。而ondemand则将内存放在第一位，对于超过闲置时间的子进程，采取直接杀死的策略。
两种方法，没有优劣之分，分别适合各自的场景。dynamic花费了更多的内存。而ondemand则节约了内存，但是面对请求高峰期或者当闲置时间设置的太小时，会刀子服务器频繁创建子进程的问题。
