<?php
// Dummy data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Management - EduAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        .enrollment-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .panel-box {
            background: var(--bg-card);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 24px;
        }

        .panel-box-alt {
            background: var(--bg-main);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 24px;
        }

        .rules-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .rules-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .metric-card {
            background: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
        }
        
        .metric-card-warning {
            background: var(--warning-light);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 12px;
            padding: 16px;
        }

        @media (max-width: 1024px) {
            .enrollment-grid {
                grid-template-columns: 1fr;
            }
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
                <a href="#" class="menu-item menu-item-dashboard">
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
                <a href="student_profile.php" class="menu-item">
                    <i class="bx bx-user-pin"></i>
                    <span>Student Profile</span>
                </a>
                <a href="enrollment.php" class="menu-item active">
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
                    <i class="bx bx-upload"></i>
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

                <div class="menu-section">SYSTEM</div>
                <a href="#" class="menu-item">
                    <i class="bx bx-cog"></i>
                    <span>Settings</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-user-circle"></i>
                    <span>User Management</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bx bx-lock-alt"></i>
                    <span>Roles & Permissions</span>
                </a>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="topbar">
                <div class="search-bar">
                    <i class="bx bx-search"></i>
                    <input type="text" placeholder="Search students, courses or faculty...">
                    <span class="cmd-k">⌘ K</span>
                </div>
                <div class="topbar-right">
                    <button class="icon-btn" id="theme-toggle"><i class="bx bx-moon"></i></button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-bell"></i>
                        <span class="badge" style="background-color: var(--primary);">3</span>
                    </button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-envelope"></i>
                        <span class="badge" style="background-color: var(--primary);">1</span>
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

            <!-- Page Header -->
            <div class="page-header" style="align-items: flex-start; flex-direction: column; gap: 16px;">
                <div class="page-title" style="margin-bottom: 0;">
                    <h1 style="font-size: 24px; font-weight: 700; color: var(--text-primary);">Enrollment Management</h1>
                    <p style="color: var(--text-secondary); margin-top: 8px; font-size: 14px;">Assign students to departments, semesters, and individual subjects.</p>
                </div>
                <div class="page-actions" style="align-self: flex-end; margin-top: -45px;">
                    <button class="btn btn-outline"><i class="bx bx-download"></i> Export List</button>
                    <button class="btn btn-primary" style="background: var(--primary);"><i class="bx bx-history"></i> View Logs</button>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                
                <div class="enrollment-grid">
                    <!-- Left Panel: Student Assignment -->
                    <div class="panel-box">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                            <div style="background: var(--purple-light); color: var(--primary); width: 40px; height: 40px; border-radius: 8px; display: flex; justify-content: center; align-items: center; font-size: 20px;"><i class="bx bx-group"></i></div>
                            <h3 style="font-size: 16px; font-weight: 600;">Student Assignment Panel</h3>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.5px; margin-bottom: 8px; display: block;">SELECT STUDENT</label>
                            <div class="search-input" style="width: 100%; border: 1px solid var(--border-color); border-radius: 8px; justify-content: space-between; padding: 12px 16px; background: var(--bg-main);">
                                <div style="display: flex; align-items: center; width: 100%;">
                                    <i class="bx bx-search" style="margin-right: 12px; font-size: 18px; color: var(--text-secondary);"></i>
                                    <input type="text" value="Juliana V. Morales (STU-2024-0089)" style="width: 100%; font-size: 14px; font-weight: 500; background: transparent; border: none; outline: none; color: var(--text-primary);" readonly>
                                </div>
                                <i class="bx bx-chevron-down" style="color: var(--text-secondary); font-size: 18px;"></i>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.5px; margin-bottom: 8px; display: block;">DEPARTMENT</label>
                                <div class="select-wrapper" style="position: relative;">
                                    <select style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 8px; appearance: none; font-size: 14px; font-weight: 500; background: var(--bg-main); color: var(--text-primary); outline: none;">
                                        <option>Computer Science & Engineering</option>
                                    </select>
                                    <i class="bx bx-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 18px;"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.5px; margin-bottom: 8px; display: block;">SEMESTER</label>
                                <div class="select-wrapper" style="position: relative;">
                                    <select style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 8px; appearance: none; font-size: 14px; font-weight: 500; background: var(--bg-main); color: var(--text-primary); outline: none;">
                                        <option>Fall 2024</option>
                                    </select>
                                    <i class="bx bx-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: var(--text-secondary); font-size: 18px;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 28px;">
                            <label style="font-size: 11px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0.5px; margin-bottom: 8px; display: block;">SUBJECT SELECTION (MULTI-SELECT)</label>
                            <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 14px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; min-height: 58px; background: var(--bg-main);">
                                <span style="background: var(--purple-light); color: var(--primary); padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; display: flex; align-items: center; border: 1px solid rgba(92, 60, 230, 0.2);">Data Structures <i class="bx bx-x" style="margin-left: 6px; cursor: pointer; font-size: 16px;"></i></span>
                                <span style="background: var(--info-light); color: var(--info); padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; display: flex; align-items: center; border: 1px solid rgba(59, 130, 246, 0.2);">Algorithm Design <i class="bx bx-x" style="margin-left: 6px; cursor: pointer; font-size: 16px;"></i></span>
                                <span style="background: var(--success-light); color: var(--success); padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; display: flex; align-items: center; border: 1px solid rgba(16, 185, 129, 0.2);">Operating Systems <i class="bx bx-x" style="margin-left: 6px; cursor: pointer; font-size: 16px;"></i></span>
                                <button style="background: transparent; border: 1px dashed var(--border-color); color: var(--text-secondary); padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 4px; outline: none; cursor: pointer;"><i class="bx bx-plus"></i> Add Subject</button>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 12px;">
                            <button class="btn btn-outline" style="border-color: var(--primary); color: var(--primary); font-weight: 600;"><i class="bx bx-up-arrow-alt"></i> Promote Student</button>
                            <button class="btn btn-primary" style="background: var(--primary); font-weight: 600;"><i class="bx bx-check-circle"></i> Enroll Student</button>
                        </div>
                    </div>

                    <!-- Right Panels -->
                    <div style="display: flex; flex-direction: column; gap: 24px;">
                        <!-- Enrollment Rules -->
                        <div class="panel-box-alt" style="position: relative; overflow: hidden;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                                <i class="bx bx-shield-quarter" style="color: var(--primary); font-size: 24px;"></i>
                                <h3 style="font-size: 16px; font-weight: 600;">Enrollment Rules</h3>
                            </div>
                            <ul class="rules-list">
                                <li><i class="bx bxs-check-circle" style="color: var(--primary); font-size: 18px; margin-top: 2px;"></i> Max 18 credits per semester allowed.</li>
                                <li><i class="bx bxs-check-circle" style="color: var(--primary); font-size: 18px; margin-top: 2px;"></i> Prerequisites must be completed before enrollment.</li>
                                <li><i class="bx bxs-check-circle" style="color: var(--primary); font-size: 18px; margin-top: 2px;"></i> Financial clearance required for all students.</li>
                            </ul>
                            <!-- bg icon detail -->
                            <i class="bx bx-file-blank" style="position: absolute; right: -20px; bottom: -20px; font-size: 140px; color: var(--purple-light); opacity: 0.5; z-index: 0;"></i>
                        </div>

                        <!-- Quick Metrics -->
                        <div class="panel-box">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                                <i class="bx bx-line-chart" style="color: var(--primary); font-size: 24px;"></i>
                                <h3 style="font-size: 16px; font-weight: 600;">Quick Metrics</h3>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="metric-card">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                        <div style="background: var(--purple-light); color: var(--primary); width: 32px; height: 32px; border-radius: 6px; display: flex; justify-content: center; align-items: center;"><i class="bx bxs-user"></i></div>
                                        <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">New Students</span>
                                    </div>
                                    <div style="font-size: 28px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">124</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">This Semester</div>
                                </div>
                                <div class="metric-card-warning">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                        <div style="background: rgba(245, 158, 11, 0.2); color: var(--warning); width: 32px; height: 32px; border-radius: 6px; display: flex; justify-content: center; align-items: center;"><i class="bx bx-briefcase-alt-2"></i></div>
                                        <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">Pending Clearances</span>
                                    </div>
                                    <div style="font-size: 28px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">12</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">Requires Action</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Enrollments -->
                <div class="card directory-card" style="margin-bottom: 24px;">
                    <div class="card-header table-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="bx bx-check-shield" style="color: var(--success); font-size: 24px;"></i>
                            <h3 style="font-size: 18px; font-weight: 600;">Current Enrollments</h3>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <span style="font-size: 13px; color: var(--text-secondary);">Showing 4 Active Courses</span>
                            <div class="select-wrapper" style="position: relative;">
                                <select style="padding: 8px 32px 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; appearance: none; font-size: 13px; font-weight: 500; background: var(--bg-card); color: var(--text-primary);">
                                    <option>All Status</option>
                                </select>
                                <i class="bx bx-chevron-down" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>SUBJECT NAME & CODE</th>
                                    <th>INSTRUCTOR</th>
                                    <th>CREDITS</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="background: var(--primary-light); color: var(--primary); width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;"><i class="bx bx-code-alt"></i></div>
                                            <div>
                                                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">CS-302: Advanced Data Structures</div>
                                                <div style="font-size: 12px; color: var(--text-secondary);">Core Requirement</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://i.pravatar.cc/150?img=1" alt="Instructor" style="width: 28px; height: 28px; border-radius: 50%;">
                                            <span style="font-size: 14px; font-weight: 500;">Dr. Sarah Henderson</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 14px; font-weight: 500;">4.0</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;"><i class="bx bxs-circle" style="font-size: 8px;"></i> Active</span></td>
                                    <td class="actions-cell">
                                        <button class="action-icon" style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px; margin-right: 6px; background: transparent; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 4px; background: transparent; color: var(--danger); cursor: pointer;"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="background: var(--info-light); color: var(--info); width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;"><i class="bx bx-math"></i></div>
                                            <div>
                                                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">MAT-401: Discrete Mathematics</div>
                                                <div style="font-size: 12px; color: var(--text-secondary);">Elective</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://i.pravatar.cc/150?img=2" alt="Instructor" style="width: 28px; height: 28px; border-radius: 50%;">
                                            <span style="font-size: 14px; font-weight: 500;">Prof. Michael Chen</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 14px; font-weight: 500;">3.0</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;"><i class="bx bxs-circle" style="font-size: 8px;"></i> Active</span></td>
                                    <td class="actions-cell">
                                        <button class="action-icon" style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px; margin-right: 6px; background: transparent; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 4px; background: transparent; color: var(--danger); cursor: pointer;"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="background: var(--success-light); color: var(--success); width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;"><i class="bx bx-scale"></i></div>
                                            <div>
                                                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">HUM-105: Professional Ethics</div>
                                                <div style="font-size: 12px; color: var(--text-secondary);">Non-Major Required</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://i.pravatar.cc/150?img=3" alt="Instructor" style="width: 28px; height: 28px; border-radius: 50%;">
                                            <span style="font-size: 14px; font-weight: 500;">Dr. Angela White</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 14px; font-weight: 500;">2.0</td>
                                    <td><span style="background: var(--warning-light); color: var(--warning); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;"><i class="bx bxs-circle" style="font-size: 8px;"></i> Waitlisted</span></td>
                                    <td class="actions-cell">
                                        <button class="action-icon" style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px; margin-right: 6px; background: transparent; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 4px; background: transparent; color: var(--danger); cursor: pointer;"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            <div style="background: rgba(219, 39, 119, 0.15); color: #db2777; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;"><i class="bx bx-data"></i></div>
                                            <div>
                                                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">CS-310: Database Systems</div>
                                                <div style="font-size: 12px; color: var(--text-secondary);">Elective</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://i.pravatar.cc/150?img=4" alt="Instructor" style="width: 28px; height: 28px; border-radius: 50%;">
                                            <span style="font-size: 14px; font-weight: 500;">Prof. David Brown</span>
                                        </div>
                                    </td>
                                    <td style="font-size: 14px; font-weight: 500;">3.0</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;"><i class="bx bxs-circle" style="font-size: 8px;"></i> Active</span></td>
                                    <td class="actions-cell">
                                        <button class="action-icon" style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px; margin-right: 6px; background: transparent; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px; padding: 4px; background: transparent; color: var(--danger); cursor: pointer;"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enrollment History -->
                <div class="card directory-card">
                    <div class="card-header table-header" style="display: flex; align-items: center; gap: 12px; border-bottom: none; padding-bottom: 0;">
                        <i class="bx bx-history" style="color: var(--primary); font-size: 24px;"></i>
                        <h3 style="font-size: 18px; font-weight: 600;">Enrollment History</h3>
                    </div>
                    <div class="table-responsive" style="padding: 20px;">
                        <table class="data-table" style="border-top: 1px solid var(--border-color);">
                            <thead>
                                <tr>
                                    <th style="padding-top: 20px;">ACADEMIC CYCLE</th>
                                    <th style="padding-top: 20px;">DEPARTMENT</th>
                                    <th style="padding-top: 20px;">GPA RESULT</th>
                                    <th style="padding-top: 20px;">COMPLETION STATUS</th>
                                    <th style="padding-top: 20px;">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="font-size: 14px; font-weight: 500;">Spring 2024</td>
                                    <td style="font-size: 14px; color: var(--text-secondary);">Computer Science</td>
                                    <td style="font-size: 14px; font-weight: 700; color: var(--success);">3.85</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(16, 185, 129, 0.2);"><i class="bx bx-check-circle"></i> Successful</span></td>
                                    <td><button style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px 8px; color: var(--primary); background: transparent; cursor: pointer;"><i class="bx bx-show" style="font-size: 16px;"></i></button></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="font-size: 14px; font-weight: 500;">Fall 2023</td>
                                    <td style="font-size: 14px; color: var(--text-secondary);">Computer Science</td>
                                    <td style="font-size: 14px; font-weight: 700; color: var(--success);">3.92</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(16, 185, 129, 0.2);"><i class="bx bx-check-circle"></i> Successful</span></td>
                                    <td><button style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px 8px; color: var(--primary); background: transparent; cursor: pointer;"><i class="bx bx-show" style="font-size: 16px;"></i></button></td>
                                </tr>
                                <tr style="border-bottom: none;">
                                    <td style="font-size: 14px; font-weight: 500;">Summer 2023</td>
                                    <td style="font-size: 14px; color: var(--text-secondary);">Information Technology</td>
                                    <td style="font-size: 14px; font-weight: 700; color: var(--success);">3.78</td>
                                    <td><span style="background: var(--success-light); color: var(--success); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; border: 1px solid rgba(16, 185, 129, 0.2);"><i class="bx bx-check-circle"></i> Successful</span></td>
                                    <td><button style="border: 1px solid var(--border-color); border-radius: 6px; padding: 4px 8px; color: var(--primary); background: transparent; cursor: pointer;"><i class="bx bx-show" style="font-size: 16px;"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="text-align: center; margin-top: 16px;">
                            <button style="background: transparent; border: none; color: var(--primary); font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; cursor: pointer;">Load More History <i class="bx bx-chevron-down"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
