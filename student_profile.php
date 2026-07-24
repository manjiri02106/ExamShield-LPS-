<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - EduAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        .profile-header-card {
            background: #f8f5ff;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            gap: 24px;
            position: relative;
            margin-bottom: 24px;
            border: 1px solid rgba(99, 102, 241, 0.1);
        }
        body.dark-theme .profile-header-card {
            background: var(--bg-card);
            border-color: var(--border-color);
        }
        .profile-image-container {
            width: 140px;
            height: 140px;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .camera-btn {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);
        }
        .profile-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .profile-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .profile-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .status-badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #ecfdf5;
            color: #10b981;
            border: 1px solid #d1fae5;
        }
        body.dark-theme .status-badge {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
        }
        .roll-no {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }
        .profile-actions {
            display: flex;
            gap: 12px;
        }
        .profile-stats {
            display: flex;
            gap: 32px;
            margin-top: 24px;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: white;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        body.dark-theme .stat-icon {
            background: var(--bg-main);
            color: var(--primary-light);
        }
        .stat-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .stat-label {
            font-size: 11px;
            color: var(--text-secondary);
        }
        .stat-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .profile-tabs {
            display: flex;
            gap: 32px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 24px;
        }
        .tab-item {
            padding: 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tab-item.active {
            color: var(--primary);
        }
        .tab-item.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }
        .info-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border-color);
        }
        .info-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .info-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .info-card-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .info-list-item {
            display: flex;
            gap: 16px;
        }
        .info-list-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--bg-main);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .info-list-content {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-list-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .info-list-label {
            font-size: 11px;
            color: var(--text-secondary);
        }
        .info-list-value {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }
        
        .bottom-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }
        
        .overview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .overview-item {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .overview-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .overview-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .overview-label {
            font-size: 10px;
            color: var(--text-secondary);
        }
        .overview-value {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .tag-verified {
            background: #ecfdf5;
            color: #10b981;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
            border: 1px solid #d1fae5;
        }
        .tag-unverified {
            background: #fffbeb;
            color: #d97706;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
            border: 1px solid #fef3c7;
        }
        body.dark-theme .tag-verified { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
        body.dark-theme .tag-unverified { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2); }
        
        .empower-card {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border-radius: 16px;
            padding: 24px 16px;
            text-align: center;
            color: white;
            margin: 0 16px 20px;
            position: relative;
            overflow: hidden;
        }
        .empower-img {
            height: 80px;
            margin-bottom: 16px;
        }
        
        @media (max-width: 1200px) {
            .info-grid { grid-template-columns: repeat(2, 1fr); }
            .bottom-grid { grid-template-columns: 1fr; }
            .overview-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 900px) {
            .info-grid { grid-template-columns: 1fr; }
            .profile-stats { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="bx bxs-graduation"></i>
                    <div>
                        <h2>EduAdmin</h2>
                        <p>Higher Education Portal</p>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <a href="index.php" class="menu-item menu-item-dashboard">
                    <i class="bx bx-home-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="menu-section">ACADEMIC MANAGEMENT</div>
                <a href="index.php" class="menu-item">
                    <i class="bx bx-group"></i>
                    <span>Faculty Management</span>
                </a>
                <a href="students.php" class="menu-item">
                    <i class="bx bx-user"></i>
                    <span>Student Management</span>
                </a>
                <a href="student_profile.php" class="menu-item active">
                    <i class="bx bx-user-pin"></i>
                    <span>Student Profile</span>
                </a>
                <a href="enrollment.php" class="menu-item">
                    <i class="bx bx-id-card"></i>
                    <span>Enrollment</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-building"></i>
                    <span>Department Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-book-open"></i>
                    <span>Subject Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-event"></i>
                    <span>Timetable Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-x"></i>
                    <span>Leave Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-line-chart"></i>
                    <span>Performance Review</span>
                </a>

                <div class="menu-section">OPERATIONS</div>
                <a href="bulk_upload.php" class="menu-item">
                    <i class="bx bx-cloud-upload"></i>
                    <span>Bulk Upload</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-file"></i>
                    <span>Exam Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-chalkboard"></i>
                    <span>Notice Board</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-calendar-star"></i>
                    <span>Event Management</span>
                </a>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-message-rounded-dots"></i>
                    <span>Communication</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>

                <div class="menu-section">ANALYTICS & REPORTS</div>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-bar-chart-alt-2"></i>
                    <span>Reports & Analytics</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>
                <a href="#" class="menu-item has-submenu">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    <span>Data Insights</span>
                    <i class="bx bx-chevron-right submenu-icon"></i>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-history"></i>
                    <span>Audit Logs</span>
                </a>
            </div>


            <div style="margin: 0 16px 20px;">
                <button style="width: 100%; background: #10b981; color: white; border: none; padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer;"><i class="bx bx-plus"></i> New Record</button>
            </div>
            
            <div style="padding: 16px; border-top: 1px solid rgba(255,255,255,0.05);">
                <a href="#" style="color: #94a3b8; font-size: 14px; display: flex; align-items: center; gap: 12px; font-weight: 500;"><i class="bx bx-log-out" style="font-size: 20px;"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="topbar">
                <div class="search-bar">
                    <i class="bx bx-search"></i>
                    <input type="text" placeholder="Search by Roll No, Name or Department...">
                    <span class="cmd-k">Ctrl /</span>
                </div>
                <div class="topbar-right">
                    <button class="icon-btn" id="theme-toggle"><i class="bx bx-sun"></i></button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-bell"></i>
                        <span class="badge" style="background-color: var(--primary);">4</span>
                    </button>
                    <button class="icon-btn">
                        <i class="bx bx-envelope"></i>
                    </button>
                    <div class="user-profile">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin User">
                        <div class="user-info">
                            <span class="user-name">Admin User</span>
                            <span class="user-role">Super Administrator</span>
                        </div>
                        <i class="bx bx-chevron-down profile-chevron"></i>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content" style="padding-top: 30px;">
                <div style="margin-bottom: 24px;">
                    <h1 style="font-size: 24px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px;">Student Profile</h1>
                    <div style="color: var(--text-secondary); font-size: 13px; display: flex; gap: 8px; align-items: center;">
                        <span>Dashboard</span> <i class="bx bx-chevron-right" style="font-size: 16px;"></i> <span>Student Profile</span>
                    </div>
                </div>

                <!-- Profile Header Card -->
                <div class="profile-header-card">
                    <div class="profile-image-container">
                        <img src="https://i.pravatar.cc/300?img=12" alt="Siddharth Sharma">
                        <div class="camera-btn">
                            <i class="bx bx-camera"></i>
                        </div>
                    </div>
                    
                    <div class="profile-info">
                        <div class="profile-title-row">
                            <div>
                                <h2 class="profile-name">
                                    Siddharth Sharma 
                                    <span class="status-badge"><i class="bx bxs-circle" style="font-size: 8px;"></i> Active Student</span>
                                </h2>
                                <div class="roll-no">
                                    <i class="bx bx-id-card"></i> Roll No: <span style="font-weight: 700; color: var(--text-primary);">U19CS102</span>
                                </div>
                            </div>
                            <div class="profile-actions">
                                <button class="btn btn-primary" style="padding: 10px 20px; font-size: 13px;"><i class="bx bx-edit-alt"></i> Edit Profile</button>
                                <button class="btn btn-outline" style="padding: 10px 20px; font-size: 13px; background: var(--bg-card);"><i class="bx bx-lock-open-alt"></i> Reset Password</button>
                                <button class="btn btn-outline" style="padding: 10px; background: var(--bg-card);"><i class="bx bx-dots-vertical-rounded"></i></button>
                            </div>
                        </div>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-icon"><i class="bx bx-building"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Department</span>
                                    <span class="stat-value">Computer Science & Eng.</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="bx bx-cart"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Current Semester</span>
                                    <span class="stat-value">7th Semester</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="bx bx-plus-circle"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Admission Year</span>
                                    <span class="stat-value">2019</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon"><i class="bx bx-phone"></i></div>
                                <div class="stat-info">
                                    <span class="stat-label">Contact</span>
                                    <span class="stat-value">+91 98765 43210</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="profile-tabs">
                    <div class="tab-item active"><i class="bx bx-user"></i> Personal Details</div>
                    <div class="tab-item"><i class="bx bx-book-open"></i> Academic Details</div>
                    <div class="tab-item"><i class="bx bx-book"></i> Enrolled Subjects</div>
                    <div class="tab-item"><i class="bx bx-file"></i> Exam History</div>
                    <div class="tab-item"><i class="bx bx-folder"></i> Documents</div>
                </div>

                <!-- Information Grid -->
                <div class="info-grid">
                    <!-- Contact Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon"><i class="bx bx-user"></i></div>
                            <h3 class="info-card-title">Contact Information</h3>
                        </div>
                        <div class="info-list">
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-envelope"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Email Address</span>
                                        <span class="info-list-value">siddharth.s@university.edu</span>
                                    </div>
                                    <span class="tag-verified">Verified</span>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-phone"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Phone Number</span>
                                        <span class="info-list-value">+91 98765 43210</span>
                                    </div>
                                    <span class="tag-verified">Verified</span>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-envelope"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Alternative Email</span>
                                        <span class="info-list-value">sid.sharma@gmail.com</span>
                                    </div>
                                    <span class="tag-unverified">Unverified</span>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-phone-call"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Emergency Contact</span>
                                        <span class="info-list-value">+91 98765 43211<br><span style="font-weight: normal; color: var(--text-secondary);">(Father)</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Demographics -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon" style="background: var(--info-light); color: var(--info);"><i class="bx bx-user-pin"></i></div>
                            <h3 class="info-card-title">Demographics</h3>
                        </div>
                        <div class="info-list">
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-calendar"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Date of Birth</span>
                                        <span class="info-list-value">March 14, 2001</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-user-circle"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Gender</span>
                                        <span class="info-list-value">Male</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-water"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Blood Group</span>
                                        <span class="info-list-value">B+ Positive</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-globe"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Nationality</span>
                                        <span class="info-list-value">Indian</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-category"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Category</span>
                                        <span class="info-list-value">General</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item">
                                <div class="info-list-icon"><i class="bx bx-id-card"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Aadhar Number</span>
                                        <span class="info-list-value">XXXX XXXX 6789</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Residential Address -->
                    <div class="info-card" style="background: #f8fafc; border-color: rgba(16, 185, 129, 0.1);">
                        <style>body.dark-theme .info-card[style*="f8fafc"] { background: var(--bg-main) !important; }</style>
                        <div class="info-card-header">
                            <div class="info-card-icon" style="background: var(--success-light); color: var(--success);"><i class="bx bx-home"></i></div>
                            <h3 class="info-card-title">Residential Address</h3>
                        </div>
                        <div class="info-list">
                            <div class="info-list-item">
                                <div class="info-list-icon" style="background: white; color: var(--success);"><i class="bx bx-home-alt"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Primary Address</span>
                                        <span class="info-list-value" style="line-height: 1.5; margin-top: 4px;">42/A, Tech Park Residency,<br>Whitefield, Bangalore,<br>KA - 560066</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item" style="margin-top: 10px;">
                                <div class="info-list-icon" style="background: white; color: var(--success);"><i class="bx bx-building-house"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Hostel / Accommodation</span>
                                        <span class="info-list-value">Day Scholar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="info-list-item" style="margin-top: 10px;">
                                <div class="info-list-icon" style="background: white; color: var(--success);"><i class="bx bx-map-pin"></i></div>
                                <div class="info-list-content">
                                    <div class="info-list-text">
                                        <span class="info-list-label">Permanent Address</span>
                                        <span class="info-list-value" style="line-height: 1.5; margin-top: 4px;">221/B, Park Street,<br>Kolkata, West Bengal - 700016</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="bottom-grid">
                    <div class="info-card">
                        <div class="info-card-header">
                            <div class="info-card-icon"><i class="bx bx-user-pin"></i></div>
                            <h3 class="info-card-title">Quick Overview</h3>
                        </div>
                        
                        <div class="overview-grid">
                            <div class="overview-item">
                                <div class="overview-icon" style="background: var(--bg-main); color: var(--primary);"><i class="bx bx-calendar"></i></div>
                                <div class="overview-content">
                                    <span class="overview-label">Academic Year</span>
                                    <span class="overview-value">2024-25</span>
                                </div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon" style="background: var(--bg-main); color: var(--primary);"><i class="bx bx-file"></i></div>
                                <div class="overview-content">
                                    <span class="overview-label">Current CGPA</span>
                                    <span class="overview-value" style="position: relative;">
                                        8.67
                                        <svg style="position: absolute; bottom: -8px; left: 0; width: 40px; height: 10px; stroke: var(--primary); fill: none; stroke-width: 2px;" viewBox="0 0 40 10">
                                            <path d="M0 5 Q 10 10 20 5 T 40 5"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon" style="background: var(--info-light); color: var(--info);"><i class="bx bx-user-check"></i></div>
                                <div class="overview-content">
                                    <span class="overview-label">Attendance</span>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="overview-value">92%</span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" style="transform: rotate(-90deg);">
                                            <circle cx="12" cy="12" r="10" fill="none" stroke="rgba(16, 185, 129, 0.2)" stroke-width="3"></circle>
                                            <circle cx="12" cy="12" r="10" fill="none" stroke="#10b981" stroke-width="3" stroke-dasharray="62.8" stroke-dashoffset="5"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="overview-item">
                                <div class="overview-icon" style="background: var(--success-light); color: var(--success);"><i class="bx bx-check"></i></div>
                                <div class="overview-content">
                                    <span class="overview-label">Backlogs</span>
                                    <span class="overview-value">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card" style="background: #fffbeb; border-color: rgba(245, 158, 11, 0.2);">
                        <style>body.dark-theme .info-card[style*="fffbeb"] { background: rgba(245, 158, 11, 0.05) !important; border-color: rgba(245, 158, 11, 0.1) !important; }</style>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                            <div class="info-card-header" style="margin-bottom: 0;">
                                <div class="info-card-icon" style="background: white; color: #f59e0b;"><i class="bx bx-notepad"></i></div>
                                <h3 class="info-card-title">Important Notes</h3>
                            </div>
                            <button style="width: 32px; height: 32px; border-radius: 8px; background: white; border: 1px solid rgba(0,0,0,0.05); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                <i class="bx bx-pencil"></i>
                            </button>
                        </div>
                        <div style="font-size: 13px; color: var(--text-secondary); line-height: 1.6; display: flex; flex-direction: column; gap: 16px;">
                            <p>Excellent performance in Data Structures and Algorithm Design.</p>
                            <p>Eligible for placement drive 2025.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
