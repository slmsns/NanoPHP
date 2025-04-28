# 用户中心系统

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

### 用户注册
1. 访问`/user/register`
2. 填写注册表单
3. 验证邮箱

### 账户充值
1. 登录后访问`/user/balance`
2. 点击"充值"按钮
3. 选择支付方式完成支付

## API文档

### 用户登录
```http
POST /api/login
Content-Type: application/json

{
    "username": "testuser",
    "password": "test123"
}
```

响应示例：
```json
{
    "success": true,
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

## 常见问题

### 忘记密码怎么办？
访问`/user/forgot-password`重置密码

### 如何联系客服？
发送邮件至 admin@mail.slmnsn.com
