# 用户中心系统

![系统架构图](https://via.placeholder.com/800x400?text=System+Architecture+Diagram)

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
git clone https://github.com/xiaoheczy/frame.git
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

## 配置说明

### 邮件配置
在`.env`文件中配置：
```ini
MAIL_DRIVER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
```

### 支付配置
```php
// config/payment.php
return [
    'alipay' => [
        'app_id' => 'your-app-id',
        'public_key' => 'your-public-key'
    ]
];
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

### 余额不更新？
请检查支付回调配置是否正确

### 如何联系客服？
发送邮件至 support@example.com
