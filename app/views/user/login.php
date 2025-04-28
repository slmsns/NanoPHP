<div class="login-container">
    <div class="login-card">
        <h2>用户登录</h2>
        <?php if (isset($error)): ?>
            <div class="login-error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" action="/user/login" class="login-form">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" required class="form-input">
            </div>
            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" id="password" name="password" required class="form-input">
            </div>
            <div class="form-group remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">记住我</label>
            </div>
            <button type="submit" class="login-button">登录</button>
        </form>
        <div class="login-footer">
            <p>还没有账号？<a href="/user/register">立即注册</a></p>
            <p><a href="/user/forgot-password">忘记密码？</a></p>
        </div>
    </div>
</div>

<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #f5f5f5;
    }
    .login-card {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
    }
    .login-card h2 {
        margin-top: 0;
        color: #333;
        text-align: center;
    }
    .login-error {
        color: #c62828;
        background: #ffebee;
        padding: 0.5rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        text-align: center;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #555;
    }
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    .form-input:focus {
        border-color: #3498db;
        outline: none;
    }
    .remember-me {
        display: flex;
        align-items: center;
    }
    .remember-me input {
        margin-right: 0.5rem;
    }
    .login-button {
        width: 100%;
        padding: 0.75rem;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 1rem;
    }
    .login-button:hover {
        background: #2980b9;
    }
    .login-footer {
        margin-top: 1.5rem;
        text-align: center;
        color: #666;
    }
    .login-footer a {
        color: #3498db;
        text-decoration: none;
    }
    .login-footer a:hover {
        text-decoration: underline;
    }
    .login-footer p {
        margin: 0.5rem 0;
    }
</style>
