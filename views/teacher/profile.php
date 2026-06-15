<div id="teacherProfileView" class="view active">
    <div class="profile-header-bg">
        <div class="profile-pic-large">
            <img id="teacherProfileAvatar" src="https://api.dicebear.com/7.x/avataaars/svg?seed=Anisul&backgroundColor=8E7CC3" alt="Profile">
        </div>
        <div class="profile-name" id="teacherProfileName"><?php echo htmlspecialchars($profile['name']); ?></div>
        <div class="profile-id" id="teacherProfileDesignation"><?php echo htmlspecialchars($profile['designation']); ?></div>
    </div>
    <ul class="info-list">
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-chalkboard"></i></div>
            <div class="info-label">Department</div>
            <div class="info-value" id="teacherProfileDept"><?php echo htmlspecialchars($profile['dept']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-users-three"></i></div>
            <div class="info-label">Section / Level</div>
            <div class="info-value" id="teacherProfileLevel"><?php echo htmlspecialchars($profile['level']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-envelope"></i></div>
            <div class="info-label">Email</div>
            <div class="info-value" id="teacherProfileEmail"><?php echo htmlspecialchars($profile['email']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-phone"></i></div>
            <div class="info-label">Contact No</div>
            <div class="info-value" id="teacherProfileContact"><?php echo htmlspecialchars($profile['phone']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-phone-call"></i></div>
            <div class="info-label">Office Phone</div>
            <div class="info-value" id="teacherProfileOffice"><?php echo htmlspecialchars($profile['officePhone']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-drop"></i></div>
            <div class="info-label">Blood Group</div>
            <div class="info-value" id="teacherProfileBlood"><?php echo htmlspecialchars($profile['bloodGroup']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-calendar-blank"></i></div>
            <div class="info-label">Joining Date</div>
            <div class="info-value" id="teacherProfileJoin"><?php echo htmlspecialchars($profile['joiningDate']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-map-pin"></i></div>
            <div class="info-label">Address</div>
            <div class="info-value" id="teacherProfileAddress"><?php echo htmlspecialchars($profile['address']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-calendar"></i></div>
            <div class="info-label">Date of Birth</div>
            <div class="info-value" id="teacherProfileDOB"><?php echo htmlspecialchars($profile['dob']); ?></div>
        </li>
        <li class="info-item">
            <div class="info-icon"><i class="ph-fill ph-identification-card"></i></div>
            <div class="info-label">NID Number</div>
            <div class="info-value" id="teacherProfileNID"><?php echo htmlspecialchars($profile['nid']); ?></div>
        </li>
    </ul>
</div>
