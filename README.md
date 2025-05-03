# NanoPHP框架
# NanoPHP is a simple and lightweight PHP framework for building web applications.

## 介绍
当前已写了管理员后台和用户中心的示例代码，仅供参考

## 目录
- [功能特性](#功能特性)
- [安装指南](#安装指南)
- [配置说明](#配置说明)
- [使用教程](#使用教程)
- [API文档](#api文档)
- [常见问题](#常见问题)

## 功能特性
✅ 用户注册登录  
✅ 个人资料管理  
✅ 账户余额查询  
✅ 交易记录查看  
✅ 订单管理  

## 安装指南

### 环境要求
- PHP 8.0+
- MySQL 5.7+
- Composer

### 安装步骤
1. 克隆仓库：
```bash
git clone https://github.com/slmsns/NanoPHP.git
cd user-center
```

2. 安装依赖：
```bash
composer install
```

3. 配置数据库：
```bash
cp .env.example .env
# 修改.env文件中的数据库配置
```

4. 数据库迁移：
```bash
php artisan migrate --seed
```

5. 项目启动：
```bash
php -S localhost:8000 -t public
# 使用8000端口，按需修改，详情链接可以看路由设置
```

## 使用教程
### 控制器
Controller 目录下存放了所有控制器，每个控制器都对应着一个 URL 路由，控制器的命名规则为 `ControllerNameController`，例如 `HomeController` 对应着 `/` 路由，`UserController` 对应着 `/user` 路由。
- UserController：用户相关接口
- AdminController：管理员相关接口
- AuthController：登录相关接口
- BalanceController：账户充值相关接口


### 模型
Model 目录下存放了所有模型，每个模型都对应着一个数据表，模型的命名规则为 `ModelName`，例如 `User` 对应着 `users` 数据表。
- User：用户模型
- Admin：管理员模型
- Balance：账户模型

### 视图
View 目录下存放了所有视图，视图的命名规则为 `view.php`，例如 `home.php` 对应着 `/` 路由，`user.php` 对应着 `/user` 路由。

### 路由
路由文件 `routes/web.php` 中定义了所有 URL 路由，路由的命名规则为 `Route::get('/url', 'ControllerName@actionName')`，例如 `Route::get('/', 'HomeController@index')` 对应着 `/` 路由，`Route::get('/user', 'UserController@index')` 对应着 `/user` 路由。


## 常见问题

### 忘记密码怎么办？
访问`/user/forgot-password`重置密码

### 如何联系客服？
发送邮件至 admin@mail.slmnsn.com
