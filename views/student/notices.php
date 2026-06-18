<div id="studentNoticesView" class="view active">
    <!-- Notice board search bar -->
    <div style="padding: 16px 16px 8px;">
        <div style="display: flex; align-items: center; background: rgba(142, 124, 195, 0.06); border: 1px solid rgba(142, 124, 195, 0.15); border-radius: 12px; padding: 10px 14px; gap: 8px;">
            <i class="ph ph-magnifying-glass" style="color: var(--brand-color); font-size: 18px;"></i>
            <input type="text" placeholder="Search notices..." style="border: none; background: none; outline: none; width: 100%; font-size: 13px; color: var(--text-main);" oninput="filterNotices(this.value)">
        </div>
    </div>

    <!-- Notices list -->
    <div style="padding: 8px 16px 24px; display: flex; flex-direction: column; gap: 12px;" id="noticesList">
        <?php foreach ($notices as $notice): ?>
            <div class="notice-card" onclick="viewNoticePdf('<?php echo htmlspecialchars($notice['file_name']); ?>')" style="background: white; border: 1px solid var(--border-color); border-radius: 14px; padding: 14px; display: flex; gap: 12px; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02); cursor: pointer; transition: transform 0.15s ease, box-shadow 0.15s ease;">
                <div class="notice-pdf-icon" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(231, 76, 60, 0.08); color: <?php echo $notice['color']; ?>; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="ph-fill <?php echo htmlspecialchars($notice['icon']); ?>"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: var(--text-main); font-size: 13px; line-height: 1.4; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <?php echo htmlspecialchars($notice['title']); ?>
                    </div>
                    <div style="font-size: 10px; color: var(--text-light); display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                        <span><?php echo htmlspecialchars($notice['date']); ?></span>
                        <span>•</span>
                        <span><?php echo htmlspecialchars($notice['file_size']); ?></span>
                        <span>•</span>
                        <span style="color: var(--brand-color); font-weight: 500;"><?php echo htmlspecialchars($notice['uploader']); ?></span>
                    </div>
                </div>
                <div class="notice-download-btn" style="width: 32px; height: 32px; border-radius: 50%; background: #f7f7f7; color: var(--text-main); display: flex; align-items: center; justify-content: center; font-size: 16px; border: 1px solid var(--border-color);">
                    <i class="ph ph-eye" style="color: var(--brand-color);"></i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- PDF Viewer Modal -->
    <div class="pdf-viewer-overlay" id="pdfViewerModal" onclick="closeNoticePdf(event)">
        <div class="pdf-viewer-container" onclick="event.stopPropagation()">
            <div class="pdf-viewer-header">
                <div class="pdf-viewer-title" id="pdfHeaderTitle">Notice Viewer</div>
                <button class="pdf-viewer-close" onclick="closeNoticePdfModal()"><i class="ph ph-x"></i></button>
            </div>
            <div class="pdf-viewer-toolbar">
                <div><span>File:</span> <span id="pdfToolbarFilename" style="font-weight: bold; color: var(--text-main);">document.pdf</span></div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="ph ph-download-simple" id="pdfToolbarDownload" style="font-size: 16px; cursor: pointer;" onclick="downloadNoticePdf()"></i>
                    <span>Page 1 of 1</span>
                </div>
            </div>
            <div class="pdf-page-view">
                <div class="pdf-document-paper">
                    <div class="pdf-watermark">OFFICIAL</div>
                    <div class="pdf-doc-header">
                        <div class="pdf-school-name" id="pdfDocSchoolName">EduManage Model High School</div>
                        <div class="pdf-school-sub" id="pdfDocSchoolSub">Dhaka, Bangladesh | ESTD: 1995</div>
                    </div>
                    <div class="pdf-doc-meta">
                        <span id="pdfDocRef">Ref: EMHS/ADMIN/2026/01</span>
                        <span id="pdfDocDate">Date: 15 June 2026</span>
                    </div>
                    <div class="pdf-doc-title" id="pdfDocTitle">Official Circular</div>
                    <div class="pdf-doc-body" id="pdfDocBody">Notice body content here...</div>
                    <div class="pdf-doc-footer">
                        <div id="pdfDocSigneeName">Principal</div>
                        <div class="pdf-signature-line">Authorized Signature</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const noticesContentDb = {
    "ssc_registration_guidelines_2026.pdf": {
        schoolName: "EduManage Model High School",
        schoolSub: "Dhaka, Bangladesh | ESTD: 1995",
        ref: "Ref: EMHS/SSC-2026/08",
        date: "10 June 2026",
        title: "SSC Exam Registration 2026 Guidelines",
        body: "All students of Class 10 (Session 2025-2026) are hereby notified that the registration process for the Secondary School Certificate (SSC) Examination 2026 will officially commence on July 1, 2026.\n\nRequired Documents:\n1. 3 copies of recent passport-size colored photographs.\n2. Attested copies of Class 8 (JSC) certificates and transcripts.\n3. Complete registration fee of Tk. 2,500.00.\n\nAll forms must be filled out and submitted to the school administration office before June 30, 2026. Failure to submit within the deadline will result in late fees and registration issues.",
        signee: "Kazi Hasan\nHeadmaster"
    },
    "midterm_routine_syllabus_2026.pdf": {
        schoolName: "EduManage Model High School",
        schoolSub: "Dhaka, Bangladesh | ESTD: 1995",
        ref: "Ref: EMHS/EXAM/MT-03",
        date: "05 June 2026",
        title: "Mid-Term Syllabus & Exam Routine (Class 6-10)",
        body: "The Mid-Term Examination for the academic year 2026 is scheduled to begin on July 10, 2026. Detail routines for Class 6 to Class 10 have been posted on the respective class boards and class diaries.\n\nThe exams will be held in two sessions:\n* Morning Session: 10:00 AM - 12:00 PM\n* Afternoon Session: 1:30 PM - 3:30 PM\n\nStudents are advised to collect their admit cards after clearing all academic dues up to June 2026. Detailed subject-wise syllabus is attached on the classroom dashboard.",
        signee: "Salma Begum\nAssistant Headmaster"
    },
    "holiday_notice_buddha_purnima.pdf": {
        schoolName: "EduManage Model High School",
        schoolSub: "Dhaka, Bangladesh | ESTD: 1995",
        ref: "Ref: EMHS/ADMIN/HOL-12",
        date: "26 May 2026",
        title: "Holiday Notice: Buddha Purnima",
        body: "This is to notify all students, teachers, and administrative personnel that the school will remain closed on Sunday, May 31, 2026, on the occasion of Buddha Purnima (holy festival), as per the official public holidays list of the Government of Bangladesh.\n\nAll academic and administrative offices will resume regular operations from Monday, June 1, 2026, following the regular class schedules.",
        signee: "General Administration\nEduManage School Board"
    },
    "special_notice_weather_reschedule.pdf": {
        schoolName: "EduManage Model High School",
        schoolSub: "Dhaka, Bangladesh | ESTD: 1995",
        ref: "Ref: EMHS/ADMIN/WEA-01",
        date: "20 May 2026",
        title: "Rain Advisory & Class Rescheduling",
        body: "Due to heavy monsoonal rain warnings and waterlogging advisory issued by the Bangladesh Meteorological Department (BMD), in-person classes for Saturday, May 23, 2026, are suspended.\n\nInstead, online interactive classes will be conducted according to the Saturday schedule. Respective teachers will share Google Meet class links on the virtual classroom dashboard before 8:30 AM. Attendance will be recorded as usual.",
        signee: "Prof. Anisul Islam\nPrincipal"
    },
    "cultural_sports_week_schedule.pdf": {
        schoolName: "EduManage Model High School",
        schoolSub: "Dhaka, Bangladesh | ESTD: 1995",
        ref: "Ref: EMHS/SPORTS/CSW-04",
        date: "15 May 2026",
        title: "Annual Sports & Cultural Week 2026",
        body: "The annual Sports & Cultural Week 2026 of EduManage School will take place from June 20 to June 25, 2026.\n\nEvents Category:\n1. Sports: Cricket, Football, Chess, Table Tennis.\n2. Cultural: Debate, Extempore Speech, Essay Writing, Song and Recitation.\n\nStudents who wish to participate must register their names with their respective House Coordinators (Padma, Meghna, Jamuna) by June 12, 2026. Winners will be awarded trophies in the prize-giving ceremony.",
        signee: "Physical Education Dept.\nEduManage School"
    }
};

let activeNoticeFile = "";

function filterNotices(val) {
    const query = val.toLowerCase();
    document.querySelectorAll('.notice-card').forEach(card => {
        const title = card.querySelector('div[style*="font-weight: 600"]').innerText.toLowerCase();
        const infoText = card.querySelector('div[style*="font-size: 10px"]').innerText.toLowerCase();
        if (title.includes(query) || infoText.includes(query)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function viewNoticePdf(file) {
    const noticeData = noticesContentDb[file];
    if (!noticeData) {
        showToast("PDF file error or not found.");
        return;
    }

    activeNoticeFile = file;

    // Populate PDF Viewer layout
    document.getElementById('pdfHeaderTitle').innerText = noticeData.title;
    document.getElementById('pdfToolbarFilename').innerText = file;
    document.getElementById('pdfDocSchoolName').innerText = noticeData.schoolName;
    document.getElementById('pdfDocSchoolSub').innerText = noticeData.schoolSub;
    document.getElementById('pdfDocRef').innerText = noticeData.ref;
    document.getElementById('pdfDocDate').innerText = "Date: " + noticeData.date;
    document.getElementById('pdfDocTitle').innerText = noticeData.title;
    document.getElementById('pdfDocBody').innerText = noticeData.body;
    document.getElementById('pdfDocSigneeName').innerText = noticeData.signee;

    // Open overlay
    document.getElementById('pdfViewerModal').classList.add('active');
}

function closeNoticePdfModal() {
    document.getElementById('pdfViewerModal').classList.remove('active');
}

function closeNoticePdf(event) {
    closeNoticePdfModal();
}

function downloadNoticePdf() {
    if (activeNoticeFile) {
        if (window.FlutterBridge) {
            window.FlutterBridge.postMessage(JSON.stringify({
                action: 'download_pdf',
                fileName: activeNoticeFile
            }));
        }
        showToast("Downloading " + activeNoticeFile);
    }
}
</script>
