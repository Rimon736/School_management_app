<div id="dashboardView" class="view active">
    <div class="grid-menu">
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=profile'">
            <div class="grid-icon ic-teal"><i class="ph ph-user"></i></div>
            <div class="grid-label">Profile</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=online_class'">
            <div class="grid-icon ic-purple" style="position: relative;">
                <i class="ph ph-video-camera"></i>
                <span class="badge-count" style="background-color: var(--brand-color);">1</span>
            </div>
            <div class="grid-label">Online Class</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=mark_entry'">
            <div class="grid-icon ic-red"><i class="ph ph-clipboard-text"></i></div>
            <div class="grid-label">Mark Entry</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=student_attendance'">
            <div class="grid-icon ic-green"><i class="ph ph-calendar-plus"></i></div>
            <div class="grid-label">Take Attend</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=student_list'">
            <div class="grid-icon ic-blue"><i class="ph ph-list-numbers"></i></div>
            <div class="grid-label">Student List</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=routine'">
            <div class="grid-icon ic-orange"><i class="ph ph-clock"></i></div>
            <div class="grid-label">Routine</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=personal_attendance'">
            <div class="grid-icon ic-teal"><i class="ph ph-calendar-check"></i></div>
            <div class="grid-label">My Attendance</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=academic_calendar'">
            <div class="grid-icon ic-orange"><i class="ph ph-calendar"></i></div>
            <div class="grid-label">Academic Cal</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=notices'">
            <div class="grid-icon ic-red"><i class="ph ph-megaphone"></i></div>
            <div class="grid-label">Notices</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=teacher&action=inbox'">
            <div class="grid-icon ic-purple" style="position: relative;">
                <i class="ph ph-envelope-simple"></i>
                <span class="badge-count">2</span>
            </div>
            <div class="grid-label">Inbox</div>
        </div>
    </div>

    <div class="dashboard-container" style="padding: 16px;">
        <div class="dash-summary-grid">
            <?php foreach ($dashboard['stats'] as $stat): ?>
                <div class="dash-summary-card">
                    <div class="dash-summary-icon" style="background-color: rgba(142, 124, 195, 0.1); color: <?php echo $stat['color']; ?>;">
                        <i class="ph-fill <?php echo $stat['icon']; ?>"></i>
                    </div>
                    <div class="dash-summary-info">
                        <div class="dash-summary-value" style="color: <?php echo $stat['color']; ?>;"><?php echo htmlspecialchars($stat['value']); ?></div>
                        <div class="dash-summary-label"><?php echo htmlspecialchars($stat['label']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="chart-card">
            <h3 id="dashChartTitle" style="font-size: 14px; font-weight: 500; margin-bottom: 12px; color: var(--text-main);"><?php echo htmlspecialchars($dashboard['chartTitle']); ?></h3>
            <div style="position: relative; height: 220px; width: 100%;">
                <canvas id="mainDashboardChart"></canvas>
            </div>
        </div>
        
        <div class="section-header" style="padding-left: 0; margin-top: 20px;" id="dashListTitle"><?php echo htmlspecialchars($dashboard['listTitle']); ?></div>
        <div id="dashActivityList">
            <?php foreach ($dashboard['activities'] as $act): ?>
                <div class="bkash-list-item" onclick="showToast('<?php echo htmlspecialchars(addslashes($act['title'])); ?> Details')">
                    <div class="bkash-list-icon" style="background: <?php echo $act['iconBg']; ?>; color: <?php echo $act['iconColor']; ?>;">
                        <i class="ph <?php echo $act['icon']; ?>"></i>
                    </div>
                    <div class="bkash-list-content">
                        <div class="bkash-list-title"><?php echo htmlspecialchars($act['title']); ?></div>
                        <div class="bkash-list-subtitle"><?php echo htmlspecialchars($act['subtitle']); ?></div>
                    </div>
                    <div class="bkash-list-right">
                        <div class="bkash-list-value"><?php echo htmlspecialchars($act['value']); ?></div>
                        <div class="bkash-list-subvalue <?php echo $act['subStatus']; ?>"><?php echo htmlspecialchars($act['subvalue']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="section-header">Quick Features</div>
    <div class="quick-features">
        <div class="qf-card" onclick="showToast('Staff Meeting Agenda')" style="border-color: rgba(243, 156, 18, 0.4);">
            <i class="ph ph-users" style="color: #f39c12;"></i>
            <span>Staff Meet</span>
        </div>
        <div class="qf-card" onclick="showToast('Teacher Training Workshop')" style="border-color: rgba(52, 152, 219, 0.4);">
            <i class="ph ph-presentation-chart" style="color: #3498db;"></i>
            <span>Training</span>
        </div>
        <div class="qf-card" onclick="showToast('Academic Research Plan')" style="border-color: rgba(155, 89, 182, 0.4);">
            <i class="ph ph-flask" style="color: #9b59b6;"></i>
            <span>Research</span>
        </div>
    </div>
    <div style="height: 20px;"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('mainDashboardChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['CS101', 'CS102', 'MATH201', 'PHY101'],
                datasets: [{
                    label: 'Attendance (%)',
                    data: [85, 92, 78, 88],
                    backgroundColor: '#8E7CC3',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
            }
        });
    }
});
</script>
