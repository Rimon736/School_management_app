<div id="dbInspectorView" class="view active" style="overflow-y: auto; padding: 16px; box-sizing: border-box; height: 100%;">
    <div style="background: white; border: 1px solid var(--border-color); padding: 16px; border-radius: 16px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
            <h3 style="margin: 0; color: var(--text-main); font-size: 16px; font-weight: bold; display: flex; align-items: center; gap: 8px;">
                <i class="ph ph-database" style="color: var(--brand-color); font-size: 20px;"></i> SQL DB Inspector
            </h3>
            <a href="?controller=auth&action=login" style="font-size: 12px; color: var(--brand-color); text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 4px;">
                <i class="ph ph-arrow-left"></i> Back to Login
            </a>
        </div>
        
        <form method="GET" action="index.php" id="dbTableForm" style="display: flex; flex-direction: column; gap: 8px;">
            <input type="hidden" name="controller" value="auth">
            <input type="hidden" name="action" value="db_inspector">
            
            <label style="font-size: 11px; font-weight: bold; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px;">Select Table to View</label>
            <select name="table" onchange="document.getElementById('dbTableForm').submit()" style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; background: #fff; color: var(--text-main); outline: none; cursor: pointer; box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);">
                <?php foreach ($tables as $t): ?>
                    <option value="<?php echo htmlspecialchars($t); ?>" <?php echo $selectedTable === $t ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- Data Table View -->
    <div style="background: white; border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.02); margin-bottom: 20px;">
        <div style="padding: 12px 16px; background: #fdfcff; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: bold; font-size: 12px; color: var(--brand-dark); text-transform: uppercase; letter-spacing: 0.5px;">
                Table Content
            </span>
            <span style="font-size: 11px; color: var(--text-light); font-weight: bold; background: #f4f0fa; padding: 4px 8px; border-radius: 12px;">
                <?php echo count($rows); ?> Rows
            </span>
        </div>
        
        <div style="overflow-x: auto; width: 100%;">
            <?php if (empty($rows)): ?>
                <div style="padding: 40px; text-align: center; color: var(--text-light); font-size: 13px;">
                    <i class="ph ph-folder-open" style="font-size: 24px; color: var(--border-color); margin-bottom: 5px; display: block;"></i>
                    This table is empty.
                </div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12px;">
                    <thead>
                        <tr style="background: #f4f0fa; border-bottom: 1px solid var(--border-color);">
                            <?php foreach ($columns as $col): ?>
                                <th style="padding: 12px 14px; color: var(--brand-dark); font-weight: bold; white-space: nowrap;"><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s; hover: background-color: #faf8fd;">
                                <?php foreach ($columns as $col): ?>
                                    <td style="padding: 12px 14px; color: var(--text-main); white-space: nowrap; max-width: 220px; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($row[$col] !== null ? $row[$col] : 'NULL'); ?>">
                                        <?php 
                                            if ($row[$col] === null) {
                                                echo '<span style="color: #ccc; font-style: italic;">NULL</span>';
                                            } else {
                                                echo htmlspecialchars($row[$col]); 
                                            }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
