        </main>
        
        <?php if ($isLoggedIn && $action !== 'login'): ?>
            <?php
            $role = $_SESSION['role'];
            $homeActive = ($action === 'dashboard') ? 'active' : '';
            $classActive = ($action === 'classroom' || $action === 'online_class') ? 'active' : '';
            $qrActive = ($action === 'qr') ? 'active' : '';
            $inboxActive = ($action === 'inbox') ? 'active' : '';
            
            $classAction = ($role === 'teacher') ? 'online_class' : 'classroom';
            ?>
            <nav id="web-nav" class="bottom-nav">
                <div class="nav-item <?php echo $homeActive; ?>" id="navHome" onclick="window.location.href='?controller=<?php echo $role; ?>&action=dashboard'">
                    <i class="<?php echo $homeActive ? 'ph-fill ph-house' : 'ph ph-house'; ?>"></i>
                    <span>Home</span>
                </div>
                <div class="nav-item <?php echo $classActive; ?>" id="navClass" onclick="window.location.href='?controller=<?php echo $role; ?>&action=<?php echo $classAction; ?>'">
                    <i class="<?php echo $classActive ? 'ph-fill ph-chalkboard-teacher' : 'ph ph-chalkboard-teacher'; ?>"></i>
                    <span>My Class</span>
                </div>
                <div class="nav-item <?php echo $qrActive; ?>" id="navQr" onclick="window.location.href='?controller=<?php echo $role; ?>&action=qr'">
                    <i class="<?php echo $qrActive ? 'ph-fill ph-qr-code' : 'ph ph-qr-code'; ?>"></i>
                    <span>Scan QR</span>
                </div>
                <div class="nav-item <?php echo $inboxActive; ?>" id="navInbox" onclick="window.location.href='?controller=<?php echo $role; ?>&action=inbox'">
                    <i class="<?php echo $inboxActive ? 'ph-fill ph-envelope-simple' : 'ph ph-envelope-simple'; ?>"></i>
                    <span>Inbox</span>
                </div>
            </nav>
            
            <?php include 'views/layouts/sidebar.php'; ?>
        <?php endif; ?>
        
        <div class="toast" id="toastMsg">Action Clicked</div>
    </div>
</body>
</html>
