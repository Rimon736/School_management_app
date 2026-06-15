<div id="resultView" class="view active">
    <div class="result-container">
        <div id="termResultsContainer">
            <?php foreach ($results['terms'] as $term): ?>
                <div class="term-result-card" onclick="toggleResultBreakdown(this)">
                    <div class="term-result-header">
                        <div>
                            <div class="term-result-term"><?php echo htmlspecialchars($term['term']); ?></div>
                            <div class="term-result-note"><?php echo htmlspecialchars($term['note']); ?></div>
                        </div>
                        <div class="term-result-grade"><?php echo htmlspecialchars($term['grade']); ?></div>
                    </div>
                    <div class="term-result-grid">
                        <div>
                            <span>Total</span>
                            <strong><?php echo htmlspecialchars($term['total']); ?></strong>
                        </div>
                        <div>
                            <span>GPA</span>
                            <strong><?php echo htmlspecialchars($term['gpa']); ?></strong>
                        </div>
                        <div>
                            <span>Position</span>
                            <strong><?php echo htmlspecialchars($term['position']); ?></strong>
                        </div>
                    </div>
                    <div class="term-result-details" style="display: none;" onclick="event.stopPropagation()">
                        <h4>Subject-wise breakdown</h4>
                        <table class="breakdown-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                    <th>Grade</th>
                                    <th>GPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($term['subjects'] as $s): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($s['name']); ?></td>
                                        <td><?php echo htmlspecialchars($s['marks']); ?></td>
                                        <td><strong><?php echo htmlspecialchars($s['grade']); ?></strong></td>
                                        <td><?php echo number_format($s['gpa'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="term-result-toggle-hint">Tap to show subject details</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
