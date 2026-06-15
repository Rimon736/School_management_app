<div id="profileView" class="view active">
    <div class="profile-header-bg">
        <div class="profile-pic-large">
            <img id="innerProfileAvatar" src="https://api.dicebear.com/7.x/avataaars/svg?seed=Jamil&backgroundColor=8E7CC3" alt="Profile">
        </div>
        <div class="profile-name" id="innerProfileName">Jamil Mahmud</div>
        <div class="profile-id" id="innerProfileId">ID: <?php echo htmlspecialchars($profile['id']); ?></div>
    </div>
    <ul class="info-list">
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-student"></i></div>
            <div class="info-label">Class / Role</div>
            <div class="info-value" id="profileClass"><?php echo htmlspecialchars($profile['classRole']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-identification-card"></i></div>
            <div class="info-label"><?php echo htmlspecialchars($profile['rollLabel']); ?></div>
            <div class="info-value" id="profileRoll"><?php echo htmlspecialchars($profile['roll']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-user"></i></div>
            <div class="info-label"><?php echo htmlspecialchars($profile['field1Label']); ?></div>
            <div class="info-value" id="profileField1"><?php echo htmlspecialchars($profile['field1Val']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-user-circle"></i></div>
            <div class="info-label"><?php echo htmlspecialchars($profile['field2Label']); ?></div>
            <div class="info-value" id="profileField2"><?php echo htmlspecialchars($profile['field2Val']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-map-pin"></i></div>
            <div class="info-label">Address</div>
            <div class="info-value" id="profileAddress"><?php echo htmlspecialchars($profile['address']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-phone"></i></div>
            <div class="info-label">Mobile No</div>
            <div class="info-value" id="profilePhone"><?php echo htmlspecialchars($profile['phone']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-flag"></i></div>
            <div class="info-label">Nationality</div>
            <div class="info-value" id="profileNationality"><?php echo htmlspecialchars($profile['nationality']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-calendar"></i></div>
            <div class="info-label">Date of Birth</div>
            <div class="info-value" id="profileDOB"><?php echo htmlspecialchars($profile['dob']); ?></div>
        </li>
    </ul>
</div>
