<div id="feesView" class="view active">
    <div class="fees-container">
        <div class="total-due-card">
            <h3 id="financeTitle"><?php echo htmlspecialchars($fees['title']); ?></h3>
            <div class="amount" id="financeAmount"><?php echo htmlspecialchars($fees['amount']); ?></div>
            <button class="pay-now-btn" onclick="showToast('Opening payment gateway')"><i class="ph ph-credit-card"></i> Pay Now</button>
        </div>
        <div id="financeHistoryContainer">
            <?php foreach ($fees['history'] as $item): ?>
                <div class="bkash-list-item" onclick="showToast('<?php echo htmlspecialchars(addslashes($item['title'])); ?> Details')">
                    <div class="bkash-list-icon" style="background: <?php echo $item['iconBg']; ?>; color: <?php echo $item['iconColor']; ?>;">
                        <i class="ph <?php echo $item['icon']; ?>"></i>
                    </div>
                    <div class="bkash-list-content">
                        <div class="bkash-list-title"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="bkash-list-subtitle"><?php echo htmlspecialchars($item['subtitle']); ?></div>
                    </div>
                    <div class="bkash-list-right">
                        <div class="bkash-list-value"><?php echo htmlspecialchars($item['value']); ?></div>
                        <div class="bkash-list-subvalue <?php echo $item['subStatus']; ?>"><?php echo htmlspecialchars($item['subvalue']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
