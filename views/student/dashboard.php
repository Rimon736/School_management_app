<div id="dashboardView" class="view active">
    <div class="grid-menu">
        <div class="grid-item" onclick="window.location.href='?controller=student&action=classroom'">
            <div class="grid-icon ic-purple"><i class="ph ph-chalkboard-teacher"></i></div>
            <div class="grid-label">Classroom</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=routine'">
            <div class="grid-icon ic-orange"><i class="ph ph-clock"></i></div>
            <div class="grid-label">Routine</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=attendance'">
            <div class="grid-icon ic-green"><i class="ph ph-calendar-check"></i></div>
            <div class="grid-label">Attendance</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=results'">
            <div class="grid-icon ic-blue"><i class="ph ph-chart-bar"></i></div>
            <div class="grid-label">Results</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=profile'">
            <div class="grid-icon ic-teal"><i class="ph ph-user"></i></div>
            <div class="grid-label">Profile</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=fees'">
            <div class="grid-icon ic-purple"><i class="ph ph-credit-card"></i></div>
            <div class="grid-label">Fees</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=academic_calendar'">
            <div class="grid-icon ic-orange"><i class="ph ph-calendar"></i></div>
            <div class="grid-label">Academic Cal</div>
        </div>
        <div class="grid-item" onclick="window.location.href='?controller=student&action=teachers_list'">
            <div class="grid-icon ic-blue"><i class="ph ph-users-three"></i></div>
            <div class="grid-label">Teachers</div>
        </div>
    </div>
    
    <div class="banner-container">
        <div class="promo-banner" onclick="showToast('Semester Fee Offer Clicked')">
            <div class="promo-text">
                <h3>Semester Fee</h3>
                <p>Pay now & get 500 pts cashback</p>
            </div>
            <div class="promo-badge">PAY NOW</div>
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
        <div class="qf-card" onclick="showToast('School Picnic Event')" style="border-color: rgba(243, 156, 18, 0.4);">
            <i class="ph ph-confetti" style="color: #f39c12;"></i>
            <span>Events</span>
        </div>
        <div class="qf-card" onclick="showToast('Board Scholarship 2026')" style="border-color: rgba(52, 152, 219, 0.4);">
            <i class="ph ph-medal" style="color: #3498db;"></i>
            <span>Scholarship</span>
        </div>
        <div class="qf-card" onclick="showToast('Hostel Dues for June')" style="border-color: rgba(155, 89, 182, 0.4);">
            <i class="ph ph-house" style="color: #9b59b6;"></i>
            <span>Hostel Dues</span>
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
                labels: ['Bangla', 'English', 'Math', 'Science'],
                labelsShort: ['BAN', 'ENG', 'MAT', 'SCI'],
                datasets: [{
                    label: 'Performance (%)',
                    data: [88, 84, 95, 90],
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
