<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5">
            <div class="card-header">
                <h4>用户登录</h4>
            </div>
            <div class="card-body">
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">用户名</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密码</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">登录</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        if (result.success) {
            window.location.href = '/user/profile';
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('登录失败: ' + error.message);
    }
});
</script>
