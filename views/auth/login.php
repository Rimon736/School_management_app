<div id="loginView" class="view active login-wrapper" style="overflow-y: auto; justify-content: flex-start; padding-top: 40px; box-sizing: border-box;">
    <div class="login-logo" style="margin-bottom: 15px;">
        <i class="ph-fill ph-graduation-cap" style="font-size: 64px;"></i>
        <h2 style="margin-top: 5px;">EduManage</h2>
    </div>
    <h3 style="margin-bottom: 5px; font-size: 20px;">Welcome Back!</h3>
    <p style="margin-bottom: 20px; font-size: 13px; line-height: 1.4;">Enter school credentials to access your dashboard</p>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: rgba(231, 76, 60, 0.08); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.15); padding: 10px 12px; border-radius: 8px; font-size: 12px; margin-bottom: 15px; width: 100%; max-width: 320px; text-align: left; box-sizing: border-box; display: flex; align-items: center; gap: 8px;">
            <i class="ph ph-warning-circle" style="font-size: 18px; flex-shrink: 0;"></i>
            <span><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="?controller=auth&action=process" id="loginForm" style="width: 100%; max-width: 320px; display: flex; flex-direction: column; gap: 14px; box-sizing: border-box;">
        <div style="display: flex; flex-direction: column; text-align: left; gap: 5px;">
            <label for="school_code" style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px;">School Code</label>
            <div style="position: relative; display: flex; align-items: center;">
                <i class="ph ph-buildings" style="position: absolute; left: 12px; color: var(--text-light); font-size: 18px;"></i>
                <input type="text" name="school_code" id="school_code" required placeholder="e.g. DHAKA100" style="width: 100%; padding: 12px 12px 12px 38px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; background: #fff; color: var(--text-main); box-sizing: border-box; transition: border-color 0.2s;">
            </div>
        </div>
        
        <div style="display: flex; flex-direction: column; text-align: left; gap: 5px;">
            <label for="user_id" style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px;">User ID / Username</label>
            <div style="position: relative; display: flex; align-items: center;">
                <i class="ph ph-user" style="position: absolute; left: 12px; color: var(--text-light); font-size: 18px;"></i>
                <input type="text" name="user_id" id="user_id" required placeholder="e.g. EDU-STU-001" style="width: 100%; padding: 12px 12px 12px 38px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; background: #fff; color: var(--text-main); box-sizing: border-box; transition: border-color 0.2s;">
            </div>
        </div>
        
        <div style="display: flex; flex-direction: column; text-align: left; gap: 5px;">
            <label for="user_pass" style="font-size: 11px; font-weight: bold; color: var(--text-main); text-transform: uppercase; letter-spacing: 0.5px;">Password</label>
            <div style="position: relative; display: flex; align-items: center;">
                <i class="ph ph-lock" style="position: absolute; left: 12px; color: var(--text-light); font-size: 18px;"></i>
                <input type="password" name="user_pass" id="user_pass" required placeholder="Password (same as ID)" style="width: 100%; padding: 12px 12px 12px 38px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; outline: none; background: #fff; color: var(--text-main); box-sizing: border-box; transition: border-color 0.2s;">
            </div>
        </div>
        
        <button type="submit" style="width: 100%; background: var(--brand-color); color: white; border: none; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; box-shadow: 0 4px 10px rgba(142,124,195,0.2); transition: transform 0.1s, background-color 0.2s; margin-top: 5px; outline: none;">
            Login to Account
        </button>
    </form>

    <div style="margin-top: 25px; width: 100%; max-width: 320px; box-sizing: border-box;">
        <p style="font-size: 12px; color: var(--text-light); margin-bottom: 10px;">Demo Accounts Quick Autofill:</p>
        <div style="display: flex; gap: 10px;">
            <button type="button" onclick="autofill('student')" style="flex: 1; padding: 10px; font-size: 11px; border: 1px dashed var(--brand-color); background: rgba(142, 124, 195, 0.04); color: var(--brand-color); font-weight: bold; border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">
                Autofill Student
            </button>
            <button type="button" onclick="autofill('teacher')" style="flex: 1; padding: 10px; font-size: 11px; border: 1px dashed var(--brand-dark); background: rgba(103, 78, 167, 0.04); color: var(--brand-dark); font-weight: bold; border-radius: 8px; cursor: pointer; transition: background-color 0.2s;">
                Autofill Teacher
            </button>
        </div>
    </div>
</div>

<script>
function autofill(role) {
    document.getElementById('school_code').value = 'DHAKA100';
    if (role === 'student') {
        document.getElementById('user_id').value = 'EDU-STU-001';
        document.getElementById('user_pass').value = 'EDU-STU-001';
    } else {
        document.getElementById('user_id').value = 'EDU-TEA-001';
        document.getElementById('user_pass').value = 'EDU-TEA-001';
    }
}
</script>
