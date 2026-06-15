<div id="loginView" class="view active login-wrapper">
    <div class="login-logo">
        <i class="ph-fill ph-graduation-cap"></i>
        <h2>EduManage</h2>
    </div>
    <h3>Welcome Back!</h3>
    <p>Select role to log in (Auth Bypass)</p>
    
    <form method="POST" action="?controller=auth&action=process" style="width: 100%; max-width: 300px; display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
        <button type="submit" name="role" value="student" style="width: 100%; background: var(--brand-color); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 10px rgba(142,124,195,0.25); transition: transform 0.1s;">
            Login as Student
        </button>
        <button type="submit" name="role" value="teacher" style="width: 100%; background: var(--brand-dark); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 10px rgba(103,78,167,0.25); transition: transform 0.1s;">
            Login as Teacher
        </button>
    </form>
</div>
