#说明

修改来自[Opencart 1.5.5.1适用的第三方登录插件（qq和新浪微博）](http://www.opencart.cn/forum.php?mod=viewthread&tid=9515)，感谢原作者。

#QQ微博登录

用于Opencart，增加QQ与微博第三方登录。

QQ登录使用了 JS SDK，[开发文档](http://wiki.open.qq.com/wiki/website/JS_SDK%E4%BD%BF%E7%94%A8%E8%AF%B4%E6%98%8E)；

微博使用了 PHP SaeTOAuthV2类，[开发文档](http://open.weibo.com/wiki/%E9%A6%96%E9%A1%B5)，[JS SDK开发文档](http://open.weibo.com/wiki/index.php/Weibo-JS_V2)。

#安装

确保Opencart已经安装vamod。

安装xml文件，然后刷新并为管理员组添加权限，可以在Tools下找到。

#vqmod安装

下载[vqmod for opencart](http://www.opencart.com/index.php?route=extension/extension/info&extension_id=19501)，[vqmod](https://github.com/vqmod/vqmod)

把vqmod文件放到system同级的目录下，执行example.com/vqmod/install，注意权限；

把vqmod for opencart2 的文件解压替换。
