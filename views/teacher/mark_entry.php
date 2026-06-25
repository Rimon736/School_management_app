<div id="teacherMarkEntryView" class="view active" style="overflow-y: auto; padding: 16px; box-sizing: border-box; height: 100%;">
    <div class="mark-entry-container">
        <button id="markEntryBackBtn" class="see-more-btn" onclick="goBackMarkEntryStep()" style="display: none; margin-bottom: 12px; width: 100%; justify-content: center; border-radius: 12px; padding: 12px; border: 1px solid var(--border-color); background: #fff; color: var(--text-main); font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="ph ph-arrow-left"></i> Go Back
        </button>
        <div id="markEntryPanel"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Bind dynamic database states to the global scope variables declared in main.js
    window.dbMarks = <?php echo json_encode($marks); ?>;
    window.dbStudents = <?php echo json_encode($students); ?>;
    
    // Re-assign the global markEntryTests array to load from the SQLite database
    markEntryTests = <?php echo json_encode($tests); ?>;

    // Override selectMarkSubject to dynamically load marks/remarks from dbMarks for the selected test
    selectMarkSubject = function(sub) {
        var testId = 1;
        var testObj = markEntryTests.find(t => t.name === markEntryState.test);
        if (testObj) {
            testId = testObj.id;
        } else {
            if (markEntryState.test === 'Class Test 1') testId = 1;
            else if (markEntryState.test === 'Class Test 2') testId = 2;
            else if (markEntryState.test === 'Mid Term Quiz') testId = 3;
            else if (markEntryState.test === 'Final Exam Bangla') testId = 4;
        }

        markEntryStudents = window.dbStudents.map(function(s) {
            var record = window.dbMarks.find(m => m.student_id == s.id && m.test_id == testId);
            return {
                roll: parseInt(s.roll),
                name: s.name,
                marks: record ? parseInt(record.marks) : 0,
                remarks: record ? record.remarks : ''
            };
        });

        markEntryState.subject = sub;
        markEntryState.step = 7;
        renderMarkEntry();
    };

    // Override saveAllMarks to execute full stack ajax submission
    saveAllMarks = function() {
        var testId = 1;
        var testObj = markEntryTests.find(t => t.name === markEntryState.test);
        if (testObj) {
            testId = testObj.id;
        } else {
            if (markEntryState.test === 'Class Test 1') testId = 1;
            else if (markEntryState.test === 'Class Test 2') testId = 2;
            else if (markEntryState.test === 'Mid Term Quiz') testId = 3;
            else if (markEntryState.test === 'Final Exam Bangla') testId = 4;
        }

        var payload = {
            test_id: testId,
            marks: markEntryStudents.map(s => {
                return {
                    roll: s.roll,
                    marks: s.marks,
                    remarks: s.remarks || ''
                };
            })
        };

        fetch('?controller=teacher&action=save_marks_ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast("Marks submitted & locked successfully!");
                
                // Sync database cache locally
                markEntryStudents.forEach(s => {
                    var studentObj = window.dbStudents.find(ds => ds.roll == s.roll);
                    if (studentObj) {
                        var recordIndex = window.dbMarks.findIndex(m => m.student_id == studentObj.id && m.test_id == testId);
                        if (recordIndex !== -1) {
                            window.dbMarks[recordIndex].marks = s.marks;
                            window.dbMarks[recordIndex].remarks = s.remarks;
                        } else {
                            window.dbMarks.push({
                                student_id: studentObj.id,
                                test_id: testId,
                                marks: s.marks,
                                remarks: s.remarks
                            });
                        }
                    }
                });

                markEntryState.step = 1;
                renderMarkEntry();
            } else {
                showToast("Failed to save marks.");
            }
        })
        .catch(error => {
            showToast("Error saving marks.");
            console.error(error);
        });
    };

    // Override addMarkNewTest to save dynamically in DB
    addMarkNewTest = function() {
        const name = prompt("Enter Test Name:", "Class Test 3");
        if (!name) return;
        
        fetch('?controller=teacher&action=add_test_ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                category: markEntryState.category,
                term: markEntryState.term
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                markEntryTests.push({
                    id: data.id,
                    name: name,
                    category: markEntryState.category,
                    term: markEntryState.term
                });
                renderMarkEntry();
                showToast("New test added!");
            } else {
                showToast("Failed to add test.");
            }
        });
    };

    // Reset step wizard on view load and render
    markEntryState.step = 1;
    renderMarkEntry();
});
</script>
