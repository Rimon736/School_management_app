<div id="teacherInboxView" class="view active">
    <!-- Push Notification Test Panel -->
    <div style="background: rgba(142, 124, 195, 0.06); border: 1px dashed var(--brand-color); border-radius: 14px; padding: 14px; margin: 16px 16px 8px; display: flex; flex-direction: column; gap: 8px;">
        <div style="font-size: 12px; font-weight: bold; color: var(--brand-color); display: flex; align-items: center; gap: 6px;">
            <i class="ph ph-bell-ringing"></i> Native Notification Tester
        </div>
        <div style="font-size: 11px; color: var(--text-light); line-height: 1.4;">
            Send commands to the host Flutter app over the bridge. Click below to trigger a notification.
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="triggerTestNotification('Teacher')" class="classroom-join-btn" style="margin: 0; padding: 8px 12px; font-size: 12px; border-radius: 8px; flex: 1; background: var(--brand-color); border-color: var(--brand-color);">
                <i class="ph ph-paper-plane"></i> Test Notification
            </button>
            <button id="delayBtn" onclick="simulateDelayedNotification('Teacher')" class="routine-day-btn" style="margin: 0; padding: 8px 12px; font-size: 12px; border-radius: 8px; flex: 1; border-color: var(--brand-color); color: var(--brand-color); background: white;">
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
        <div class="message-card unread" onclick="readMessage(this, 'msg_tch_1')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                KH
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Headmaster Kazi Hasan</span>
                    <span style="font-size: 9px; color: var(--text-light);">1h ago</span>
                </div>
                <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Emergency Staff Meeting in lounge
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    All teachers are requested to attend a short meeting...
                </div>
            </div>
            <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand-color); align-self: center; flex-shrink: 0;"></div>
        </div>

        <div class="message-card unread" onclick="readMessage(this, 'msg_tch_2')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(46,204,113,0.1); color: #2ecc71; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                AC
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Accounts Office</span>
                    <span style="font-size: 9px; color: var(--text-light);">2 days ago</span>
                </div>
                <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Salary Statement: October 2026
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Your salary slip for October has been generated...
                </div>
            </div>
            <div class="unread-dot" style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand-color); align-self: center; flex-shrink: 0;"></div>
        </div>

        <div class="message-card" onclick="readMessage(this, 'msg_tch_3')" style="background: white; border: 1px solid var(--border-color); border-left: 4px solid #ddd; border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease;">
            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(52,152,219,0.1); color: #3498db; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                IT
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                    <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">IT Support desk</span>
                    <span style="font-size: 9px; color: var(--text-light);">4 days ago</span>
                </div>
                <div style="font-weight: 500; color: var(--text-light); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Scheduled Maintenance: SMS Portal
                </div>
                <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    Database synchronization will take place this Friday...
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
                        KH
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
    "msg_tch_1": {
        sender: "Headmaster Kazi Hasan",
        senderInitials: "KH",
        subject: "Emergency Staff Meeting in lounge",
        time: "1 hour ago (Today, 3:30 PM)",
        body: "Dear Colleagues,\n\nPlease make it convenient to attend a short emergency staff meeting today at 4:15 PM in the teacher lounge.\n\nWe will discuss the upcoming board examinations registration process updates and local waterlogging rescheduling adjustments.\n\nYour presence is highly appreciated.\n\nRegards,\nKazi Hasan\nHeadmaster"
    },
    "msg_tch_2": {
        sender: "Accounts Office",
        senderInitials: "AC",
        subject: "Salary Statement: October 2026",
        time: "2 days ago",
        body: "Respected Teacher,\n\nYour salary slip for the month of October 2026 has been successfully generated and is available for review.\n\nThe net amount of BDT 45,000.00 has been credited to your linked Sonali Bank account.\n\nFor any queries regarding deductions or allowance structures, please write to our treasury head.\n\nSincerely,\nTreasury & Accounts Dept"
    },
    "msg_tch_3": {
        sender: "IT Support desk",
        senderInitials: "IT",
        subject: "Scheduled Maintenance: SMS Portal",
        time: "4 days ago",
        body: "Dear Teachers,\n\nPlease note that our school information management system database will undergo a scheduled maintenance and performance upgrade this Friday, June 20, 2026, from 8:00 AM to 4:00 PM.\n\nThe web dashboard and mark entry app might be temporarily unavailable during this time.\n\nIT Support Team"
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
            title: 'EduManage Teacher Alert 🔔',
            body: 'New staff memorandum has been published. Tap to open inbox.',
            payload: payload
        }));
        showToast("Sending notification trigger to Flutter...");
    } else {
        showToast("FlutterBridge not active. Simulating web local banner...");
        showWebMockNotification('EduManage Teacher Alert 🔔', 'New staff memorandum has been published. Tap to open inbox.');
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
        const newMsgId = 'msg_tch_dynamic_' + Date.now();
        messagesDb[newMsgId] = {
            sender: "Kazi Hasan (Headmaster)",
            senderInitials: "KH",
            subject: "Urgent: Weather warning class shifts",
            time: "Just now",
            body: "Attention Teachers,\n\nDue to the severe weather warnings, physical classes are suspended for today.\n\nPlease shift all scheduled lectures to online sessions and upload meeting links via your classroom dashboards."
        };

        const list = document.getElementById('inboxList');
        if (list) {
            const card = document.createElement('div');
            card.className = "message-card unread";
            card.style.cssText = "background: white; border: 1px solid var(--border-color); border-left: 4px solid var(--brand-color); border-radius: 12px; padding: 12px; display: flex; gap: 12px; cursor: pointer; transition: all 0.15s ease; animation: slideUp 0.3s ease-out;";
            card.onclick = function() { readMessage(this, newMsgId); };
            card.innerHTML = `
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #e6e0f8; color: var(--brand-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                    KH
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2px;">
                        <span style="font-weight: bold; color: var(--text-main); font-size: 12px;">Headmaster Hasan</span>
                        <span style="font-size: 9px; color: var(--text-light);">Just now</span>
                    </div>
                    <div style="font-weight: 600; color: var(--text-main); font-size: 12px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        Urgent: Weather warning class shifts
                    </div>
                    <div style="font-size: 11px; color: var(--text-light); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        Due to the severe weather warnings, physical classes...
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
        window.location.href = '?controller=teacher&action=inbox';
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
