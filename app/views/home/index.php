<h1>欢迎使用PHP框架</h1>
<p>这是一个基于PHP和MySQL的简单框架，包含用户中心和管理员控制台功能。</p>
<?php if (isset($_SESSION['user'])): ?>
    <p>欢迎回来，<?= htmlspecialchars($_SESSION['user']['username']) ?>！</p>
<?php endif; ?>
