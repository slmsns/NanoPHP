<?php


return [
    // 用户路由
    ['GET', '/user/login', 'UserController', 'login'],
    ['POST', '/api/login', 'UserController', 'login'],
    ['POST', '/api/register', 'UserController', 'register'],
    ['GET', '/user', 'UserController', 'profile'],
    ['GET', '/user/profile', 'UserController', 'profile'],
    ['PUT', '/api/profile', 'UserController', 'updateProfile'],
    ['GET', '/user/balance', 'UserController', 'balance'],
    ['POST', '/api/recharge', 'UserController', 'recharge'],
    ['GET', '/user/dashboard', 'UserController', 'dashboard'],
    ['GET', '/user/orders', 'UserController', 'orders'],

    // 管理员路由
    ['GET', '/admin/login', 'AdminController', 'showLoginForm'],
    ['POST', '/admin/login', 'AdminController', 'login'],
    ['GET', '/admin/dashboard', 'AdminController', 'dashboard', ['Middleware', 'adminOnly']],
    ['GET', '/admin/users', 'AdminController', 'listUsers', ['Middleware', 'adminOnly']],
    ['PUT', '/admin/users', 'AdminController', 'editUser', ['Middleware', 'adminOnly']],
    ['DELETE', '/admin/users', 'AdminController', 'deleteUser', ['Middleware', 'adminOnly']],
    ['GET', '/admin/transactions', 'AdminController', 'listTransactions', ['Middleware', 'adminOnly']]
];
