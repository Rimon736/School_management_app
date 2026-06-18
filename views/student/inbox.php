<div id="studentInboxView" class="view active">
    <!-- Push Notification Test Panel -->
    <div style="background: rgba(142, 124, 195, 0.06); border: 1px dashed var(--brand-color); border-radius: 14px; padding: 14px; margin: 16px 16px 8px; display: flex; flex-direction: column; gap: 8px;">
        <div style="font-size: 12px; font-weight: bold; color: var(--brand-color); display: flex; align-items: center; gap: 6px;">
            <i class="ph ph-bell-ringing"></i> Native Notification Tester
        </div>
        <div style="font-size: 11px; color: var(--text-light); line-height: 1.4;">
            Send commands to the host Flutter app over the bridge. Click below to trigger a notification.
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="triggerTestNotification('Student')" class="classroom-join-btn" style="margin: 0; padding: 8px 12px; font-size: 12px; border-radius: 8px; flex: 1; background: var(--brand-color); border-color: var(--brand-color);">
                <i class="ph ph-paper-plane"></i> Test Notification
            </button>
            <button id="delayBtn" onclick="simulateDelayedNotification('Student')" class="routine-day-btn" style="margin: 0; padding: 8px 12px; font-size: 12px; border-radius: 8px; flex: 1; border-color: var(--brand-color); color: var(--brand-color); background: white;">
                <i class="ph ph-clock"></i> In 5 Seconds
            </button>
        </div>
    </div>

    <!-- Message Search -->
    <div style="padding: 8px 16px;">
        <div style="display: flex; align-items: center; background: #f7f7f7; border: 1px solid var(--border-color); border-radius: 12px; padding: 8px 12px; gap: 8px;">
            <i class="ph ph-magnifying-glass" style="color: var(--text-light); font-size: 16px;"></i>
            <input type="text" placeholder="Search inbox..." style="border: none; background: none; outline: none; width: 100%; font-size: 12px; color: var(--text-main);" oninput="filterInbox(this.value)">
        </div>
    </div>

    <!-- Messages list -->
    <div style="padding: 8px 16px 24px; display: flex; flex-direction: column; gap: 10px;" id="inboxList">
        <div class="message-card unread" onclick="readMessage(this, 'msg_stu_1')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                RI
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Mr. Rafiqul Islam</span>
                    <span style="font-size: 9px; color: var(--text-light);">2h ago</span>
                </div>
                <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Mathematics Homework Assignment
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Please solve the exercise 4.2 from your textbook...
                </div>
            </div>
            <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand-color); align-self: center; flex-shrink: 0;"></div>
        </div>

        <div class="message-card unread" onclick="readMessage(this, 'msg_stu_2')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(52,152,219,0.1); color: #3498db; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                SB
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Salma Begum (Asst. Head)</span>
                    <span style="font-size: 9px; color: var(--text-light);">Yesterday</span>
                </div>
                <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    SSC 2026 Registration Dates Extended
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    The Board of Secondary Education has extended form submission...
                </div>
            </div>
            <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand-color); align-self: center; flex-shrink: 0;"></div>
        </div>

        <div class="message-card" onclick="readMessage(this, 'msg_stu_3')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid #ddd; border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(46,204,113,0.1); color: #2ecc71; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                PO
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Principal's Office</span>
                    <span style="font-size: 9px; color: var(--text-light);">3 days ago</span>
                </div>
                <div style="font-weight: 500; color: var(--text-light); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Welcome to EduManage Mobile Portal
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Dear Jamil, welcome to the smart school portal...
                </div>
            </div>
            <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: transparent; align-self: center; flex-shrink: 0;"></div>
        </div>
    </div>

    <!-- Message Detail Overlay Modal -->
    <div class="pdf-viewer-overlay" id="messageDetailModal" onclick="closeMessageDetail(event)">
        <div class="pdf-viewer-container" style="height: 60%; background: white; margin-top: 10%;" onclick="event.stopPropagation()">
            <div class="pdf-viewer-header" style="background: var(--brand-color);">
                <div class="pdf-viewer-title">Message Details</div>
                <button class="pdf-viewer-close" onclick="closeMessageDetailModal()"><i class="ph ph-x"></i></button>
            </div>
            <div style="padding: 20px; display: flex; flex-direction: column; gap: 16px; overflow-y: auto; flex: 1;">
                <div style="display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
                    <div id="msgDetailAvatar" style="width: 44px; height: 44px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                        RI
                    </div>
                    <div>
                        <div id="msgDetailSender" style="font-weight: bold; color: var(--text-main); font-size: 14px;">Sender Name</div>
                        <div id="msgDetailTime" style="font-size: 11px; color: var(--text-light);">Time details</div>
                    </div>
                </div>
                <div>
                    <div id="msgDetailSubject" style="font-weight: bold; color: var(--text-main); font-size: 14px; margin-bottom: 8px;">Message Subject Line</div>
                    <div id="msgDetailBody" style="font-size: 12px; color: var(--text-main); line-height: 1.6; white-space: pre-wrap;">Message body contents...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const messagesDb = {
    "msg_stu_1": {
        sender: "Mr. Rafiqul Islam",
        senderInitials: "RI",
        subject: "Mathematics Homework Assignment",
        time: "2 hours ago (Today, 2:15 PM)",
        body: "Assalamu Alaikum Jamil,\n\nPlease complete the math assignment for exercises 4.2 (Algebraic Formulae, questions 1 to 10) from your textbook.\n\nYou are expected to show your working clearly in your class notebook and submit it to me before class starts tomorrow morning.\n\nRegards,\nMr. Rafiqul Islam\nSenior Math Faculty"
    },
    "msg_stu_2": {
        sender: "Salma Begum (Asst. Head)",
        senderInitials: "SB",
        subject: "SSC 2026 Registration Dates Extended",
        time: "Yesterday, 4:30 PM",
        body: "Dear Students of Class 10,\n\nPlease be informed that the Board of Intermediate and Secondary Education, Dhaka, has extended the registration date for the SSC 2026 candidates.\n\nThe revised deadline to submit your forms, copies of JSC transcripts, and dues to the admin office is now June 30, 2026.\n\nPlease complete this as soon as possible to avoid late registration charges.\n\nSalma Begum\nAssistant Headmaster"
    },
    "msg_stu_3": {
        sender: "Principal's Office",
        senderInitials: "PO",
        subject: "Welcome to EduManage Mobile Portal",
        time: "3 days ago (15 June 2026)",
        body: "Dear Jamil Mahmud,\n\nWelcome to the official EduManage mobile application!\n\nYou can now keep track of your daily routine, attendances, test results, monthly tuition fee dues, and directly message your course teachers via this app.\n\nShould you face any technical difficulties or bugs, please contact our ICT office during school hours.\n\nSincerely,\nPrincipal Office\nEduManage High School"
    }
};

function filterInbox(val) {
    const query = val.toLowerCase();
    document.querySelectorAll('.message-card').forEach(card => {
        const text = card.innerText.toLowerCase();
        if (text.includes(query)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function readMessage(element, msgId) {
    const msg = messagesDb[msgId];
    if (!msg) return;

    // Remove unread indicators
    element.classList.remove('unread');
    element.style.borderLeftColor = '#ddd';
    const dot = element.querySelector('.unread-dot');
    if (dot) dot.style.backgroundColor = 'transparent';

    // Populate modal
    document.getElementById('msgDetailAvatar').innerText = msg.senderInitials;
    document.getElementById('msgDetailSender').innerText = msg.sender;
    document.getElementById('msgDetailTime').innerText = msg.time;
    document.getElementById('msgDetailSubject').innerText = msg.subject;
    document.getElementById('msgDetailBody').innerText = msg.body;

    // Show modal
    document.getElementById('messageDetailModal').classList.add('active');
}

function closeMessageDetailModal() {
    document.getElementById('messageDetailModal').classList.remove('active');
}

function closeMessageDetail(event) {
    closeMessageDetailModal();
}

function triggerTestNotification(role) {
    const payload = JSON.stringify({
        action: 'open_inbox',
        role: role.toLowerCase()
    });

    if (window.FlutterBridge) {
        window.FlutterBridge.postMessage(JSON.stringify({
            action: 'push_notification',
            title: 'EduManage Alert 🔔',
            body: 'New urgent notice from Principal Office. Tap to open inbox.',
            payload: payload
        }));
        showToast("Sending notification trigger to Flutter...");
    } else {
        showToast("FlutterBridge not active. Simulating web local banner...");
        showWebMockNotification('EduManage Alert 🔔', 'New urgent notice from Principal Office. Tap to open inbox.');
    }
}

function simulateDelayedNotification(role) {
    const btn = document.getElementById('delayBtn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = `<i class="ph ph-spinner ph-spin"></i> Triggering...`;
    }

    setTimeout(() => {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = `<i class="ph ph-clock"></i> In 5 Seconds`;
        }

        // Add simulated unread message to local list
        const newMsgId = 'msg_stu_dynamic_' + Date.now();
        messagesDb[newMsgId] = {
            sender: "Principal Prof. Anisul",
            senderInitials: "PA",
            subject: "Emergency Notice: Rain advisory update",
            time: "Just now",
            body: "Attention Student,\n\nWe have received severe rain advisory warnings. Please stay home. Today's physical classes will be converted to online sections.\n\nLinks are active on the Classroom panel."
        };

        const list = document.getElementById('inboxList');
        if (list) {
            const card = document.createElement('div');
            card.className = "message-card unread";
            card.style.cssText = "background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease; animation: slideUp 0.3s ease-out;";
            card.onclick = function() { readMessage(this, newMsgId); };
            card.innerHTML = `
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                    PA
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                        <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Principal Anisul</span>
                        <span style="font-size: 9px; color: var(--text-light);">Just now</span>
                    </div>
                    <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        Emergency Notice: Rain advisory
                    </div>
                    <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        We have received severe rain advisory warnings...
                    </div>
                </div>
                <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand-color); align-self: center; flex-shrink: 0;"></div>
            `;
            list.insertBefore(card, list.firstChild);
        }

        // Trigger Notification
        triggerTestNotification(role);
    }, 5000);
}

function showWebMockNotification(title, body) {
    const webNotif = document.createElement('div');
    webNotif.style.cssText = "position: fixed; top: 12px; left: 50%; transform: translateX(-50%); width: 340px; background: white; border: 1px solid var(--brand-color); border-radius: 12px; padding: 14px; box-shadow: 0 8px 20px rgba(142,124,195,0.25); z-index: 2000; display: flex; gap: 12px; align-items: center; cursor: pointer; animation: slideDownNotif 0.3s cubic-bezier(0.4, 0, 0.2, 1);";
    webNotif.onclick = function() {
        webNotif.remove();
        window.location.href = '?controller=student&action=inbox';
    };
    webNotif.innerHTML = `
        <div style="width: 36px; height: 36px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-size: 18px;">
            <i class="ph ph-bell"></i>
        </div>
        <div style="flex: 1; min-width: 0;">
            <div style="font-weight: bold; font-size: 12px; color: var(--text-main); margin-bottom: 2px;">${title}</div>
            <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${body}</div>
        </div>
        <i class="ph ph-x" style="color: var(--text-light); cursor: pointer;" onclick="event.stopPropagation(); this.parentElement.remove();"></i>
    `;

    const styleEl = document.createElement('style');
    styleEl.innerHTML = `
        @keyframes slideDownNotif {
            from { top: -60px; opacity: 0; }
            to { top: 12px; opacity: 1; }
        }
    `;
    document.head.appendChild(styleEl);
    document.body.appendChild(webNotif);

    setTimeout(() => {
        webNotif.remove();
    }, 6000);
}
</script>
