phpMyXSS
========

A XSS Project


### AUTHOR
[zeng.ambulong@gmail.com](mailto:zeng.ambulong@gmail.com)

### RELEASE INFORMATION
*phpMyXSS 1.0*

### SYSTEM REQUIREMENTS

PHP 5.3.9 or later; we recommend using the
latest PHP version whenever possible.

### INSTALLATION

Import the file `./phpmyxss.sql` to your MySQL database

Config the php file `./config.php`
```php
/** The username for phpMyXSS */
define ( 'PMX_USERNAME', 'root' );
/**
 * The password(phpass) for phpMyXSS
 */
define ( 'PMX_PASSWORD', '' );
```

If you want to use 'new message alert', you need to config PHPMailer in file `./includes/functions.php` at pmx_mail(...)

###Reporting Potential Security Issues

If you have encountered a potential security vulnerability in this project, please report it to us at [zeng.ambulong@gmail.com](mailto:zeng.ambulong@gmail.com). We will work with you to verify the vulnerability and patch it.
###常见问题

1.安装相关

   把phpmyxss.sql导入数据库并修改./config.php内的数据库连接信息即可

   PMX暂时不支持无多用户支持，如果需要更改用户名和密码需要到config.php修改(默认123456)，密码（PMX_PASSWORD）请自己用phpass生成，或者目录下的genpass.php生成。

   邮件提醒请到./includes/functions.php修改函数pmx_mail()内的配置
   
2.要了解项目可以看下doc里面的文档的第1～2页

3.项目截图在doc后面也有

4.如果有其它问题或者建议可发送邮件询问

###Want to contribute?

Fork us!

### LICENSE

This software is licenced under the [GPL 2.0](http://www.gnu.org/licenses/gpl-2.0.html). Please read LICENSE for information on the
software availability and distrib
