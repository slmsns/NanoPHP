<h2>用户注册</h2>
<form method="post" action="/user/register">
    <div>
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="email">邮箱:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">密码:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">注册</button>
</form>
<p>已有账号？<a href="/user/login">立即登录</a></p>
