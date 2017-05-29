# larablog


> 一个 Laravel 5.2 的上手项目 —— 响应式个人博客系统，基于 Laravel 5.2 和 Bootstrap 3


### 特性


- 添加，编辑，和删除文章
- 无限级分类
- 根据文章标签，自动更新标签信息和引用计数
- 网站配置写入数据库，同步到配置文件 config/web.php
- 关键字搜索，自动识别标签，分类，作者名，文章标题，和文章概述
- 使用缓存
- 自定义分页样式，在 app/Customer 目录内
- 响应式，支持移动端


### 使用

1. 克隆项目 ```git clone https://github.com/itmingc/larablog.git```
2. 修改 .env 文件，配置数据库连接参数
3. 执行数据库迁移 ```php artisan migrate```
4. 执行数据填充 ```php artisan db:seed```
5. 更新自动加载 ```composer dump-autoload```
6. 后台管理员账号 ```admin``` 密码 ```admin```


### 插件

- 验证码生成 Gregwar/Captcha - https://github.com/Gregwar/Captcha
- Layer 弹层 - http://layer.layui.com/
- Debugbar 调试 - https://github.com/barryvdh/laravel-debugbar
- DbExporter 数据库导出 - https://github.com/nWidart/DbExporter
