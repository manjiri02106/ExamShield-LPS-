<?php
$previewData = [
    ['status' => 'valid', 'name' => 'Alex Thompson', 'id' => 'S24001', 'dept' => 'Computer Science', 'deptBg' => 'bg-purple-light', 'deptColor' => 'text-purple', 'year' => '1st Year', 'email' => 'alex.t@edu.edu'],
    ['status' => 'error', 'name' => 'Sarah J. Miller', 'id' => '--', 'dept' => 'Physics', 'deptBg' => 'bg-red-light', 'deptColor' => 'text-danger', 'year' => '2nd Year', 'email' => 'sarah.m@edu.edu', 'emailClass' => 'text-danger'],
    ['status' => 'valid', 'name' => 'David Chen', 'id' => 'S24002', 'dept' => 'Economics', 'deptBg' => 'bg-orange-light', 'deptColor' => 'text-warning', 'year' => '1st Year', 'email' => 'd.chen@edu.edu'],
    ['status' => 'error', 'name' => 'Mark Williams', 'id' => 'S24003', 'dept' => 'Biology', 'deptBg' => 'bg-green-light', 'deptColor' => 'text-success', 'year' => '1st Year', 'email' => 'invalid_email', 'emailClass' => 'text-danger'],
    ['status' => 'valid', 'name' => 'Emily White', 'id' => 'S24004', 'dept' => 'Mathematics', 'deptBg' => 'bg-blue-light', 'deptColor' => 'text-info', 'year' => '3rd Year', 'email' => 'e.white@edu.edu']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Student Upload - EduAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        .page-header-bulk { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .stepper { display: flex; justify-content: space-between; position: relative; margin-bottom: 32px; max-width: 800px; margin-left: auto; margin-right: auto; padding: 24px 0; }
        .stepper::before { content: ''; position: absolute; top: 50%; left: 0; width: 100%; height: 2px; background: var(--border-color); z-index: 1; transform: translateY(-50%); }
        .step { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 8px; background: var(--bg-main); padding: 0 10px; }
        .step-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: 600; }
        .step-icon.completed { background: var(--success); color: white; }
        .step-icon.active { background: var(--primary); color: white; }
        .step-icon.pending { background: #f1f5f9; color: var(--text-secondary); border: 1px solid var(--border-color); }
        body.dark-theme .step-icon.pending { background: var(--bg-card); border-color: var(--border-color); }
        .step-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .step-subtitle { font-size: 11px; color: var(--text-secondary); }
        
        .bulk-grid { display: flex; gap: 24px; align-items: flex-start; }
        
        .panel-white { background: var(--bg-card); border-radius: 16px; border: 1px solid var(--border-color); padding: 24px; }
        .panel-dark { background: linear-gradient(135deg, #1e1b4b, #312e81); border-radius: 16px; padding: 24px; color: white; position: relative; overflow: hidden; }
        
        .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .summary-row:last-child { border-bottom: none; }
        
        .error-alert { background: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 16px; }
        body.dark-theme .error-alert { background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2); }
        
        .log-panel { background: var(--bg-card); width: 340px; height: 100vh; position: sticky; top: 0; overflow-y: auto; display: flex; flex-direction: column; border-left: 1px solid var(--border-color); }
        .log-header { padding: 23px 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; font-weight: 600; position: sticky; top: 0; background: var(--bg-card); z-index: 10; height: 70px; box-sizing: border-box; }
        .log-content { padding: 20px; flex: 1; }
        .log-success { background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 12px; padding: 16px; text-align: center; margin-bottom: 20px; position: relative; overflow: hidden; }
        body.dark-theme .log-success { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
        .timeline { position: relative; padding-left: 20px; margin-top: 20px; }
        .timeline::before { content: ''; position: absolute; left: 6px; top: 0; bottom: 0; width: 1px; background: var(--border-color); }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-icon { position: absolute; left: -20px; background: var(--bg-card); padding: 4px 0; color: var(--success); font-size: 14px; }
        .timeline-content { margin-left: 12px; }
        
        .action-list { display: flex; flex-direction: column; gap: 8px; margin-top: 24px; }
        .action-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 13px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .action-item:hover { background: var(--bg-main); }
        
        /* Progress Circle */
        .progress-circle { position: relative; width: 120px; height: 120px; margin: 24px auto; }
        .progress-circle svg { width: 100%; height: 100%; transform: rotate(-90deg); }
        .progress-circle circle { fill: none; stroke-width: 8; stroke-linecap: round; }
        .progress-circle .bg { stroke: rgba(255,255,255,0.1); }
        .progress-circle .progress { stroke: #06b6d4; stroke-dasharray: 339; stroke-dashoffset: 18; }
        .progress-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
        
        .tag { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .tag-valid { background: #ecfdf5; color: #10b981; border: 1px solid #d1fae5; }
        .tag-error { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
        body.dark-theme .tag-valid { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); }
        body.dark-theme .tag-error { background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); }
        
        @media (max-width: 1200px) {
            .bulk-grid { flex-direction: column; }
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
                <a href="student_profile.php" class="menu-item">
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
                <a href="bulk_upload.php" class="menu-item active">
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


            <div style="margin: 0 16px 20px;">
                <button style="width: 100%; background: var(--primary); color: #fff; border: none; padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer;"><i class="bx bx-plus"></i> New Record</button>
            </div>
            
            <div style="padding: 16px; border-top: 1px solid rgba(255,255,255,0.05);">
                <a href="#" style="color: #94a3b8; font-size: 14px; display: flex; align-items: center; gap: 12px; font-weight: 500;"><i class="bx bx-log-out" style="font-size: 20px;"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content" style="flex-direction: row; padding-right: 0;">
            <div style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
                <!-- Top Header -->
                <header class="topbar">
                    <div class="search-bar">
                        <i class="bx bx-search"></i>
                        <input type="text" placeholder="Search students, records, or anything...">
                        <span class="cmd-k">Ctrl /</span>
                    </div>
                    <div class="topbar-right">
                        <button class="icon-btn" id="theme-toggle"><i class="bx bx-sun"></i></button>
                        <button class="icon-btn has-badge">
                            <i class="bx bx-bell"></i>
                            <span class="badge" style="background-color: var(--danger);">5</span>
                        </button>
                        <button class="icon-btn has-badge">
                            <i class="bx bx-envelope"></i>
                            <span class="badge" style="background-color: var(--danger);">5</span>
                        </button>
                        <div class="user-profile">
                            <img src="https://i.pravatar.cc/150?img=11" alt="Admin User">
                            <div class="user-info">
                                <span class="user-name">Admin Portal</span>
                                <span class="user-role">Super Administrator</span>
                            </div>
                            <i class="bx bx-chevron-down profile-chevron"></i>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Content -->
                <div class="dashboard-content" style="padding-top: 30px;">
                    <div class="page-header-bulk">
                        <div>
                            <h1 style="font-size: 24px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">Bulk Student Upload 🚀</h1>
                            <p style="color: var(--text-secondary); font-size: 14px;">Streamline institutional enrollment with bulk CSV/XLSX processing.</p>
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <button class="btn btn-outline">Cancel Process</button>
                            <button class="btn btn-outline" style="color: var(--primary); border-color: var(--primary);"><i class="bx bx-book-open"></i> Guide</button>
                        </div>
                    </div>
                    
                    <!-- Stepper -->
                    <div class="stepper">
                        <div class="step">
                            <div class="step-icon completed"><i class="bx bx-check"></i></div>
                            <div class="step-title">Download Template</div>
                            <div class="step-subtitle">Completed</div>
                        </div>
                        <div class="step">
                            <div class="step-icon completed"><i class="bx bx-check"></i></div>
                            <div class="step-title">Upload File</div>
                            <div class="step-subtitle">Completed</div>
                        </div>
                        <div class="step">
                            <div class="step-icon active">3</div>
                            <div class="step-title" style="color: var(--primary);">Preview & Validate</div>
                            <div class="step-subtitle" style="color: var(--primary);">In Progress</div>
                        </div>
                        <div class="step">
                            <div class="step-icon pending">4</div>
                            <div class="step-title">Import</div>
                            <div class="step-subtitle">Pending</div>
                        </div>
                    </div>

                    <div class="bulk-grid">
                        <!-- Data Preview (Left) -->
                        <div class="panel-white" style="flex: 1.5; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                                <div style="display: flex; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="bx bx-table"></i></div>
                                    <div>
                                        <h3 style="font-size: 16px; font-weight: 600; color: var(--text-primary);">Data Preview</h3>
                                        <p style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Review the first 150 records from 'fall_semester_intake_v2.csv'</p>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    <span class="tag tag-valid"><i class="bx bx-check-circle"></i> 142 Valid</span>
                                    <span class="tag tag-error"><i class="bx bx-error-circle"></i> 8 Errors</span>
                                    <i class="bx bx-info-circle" style="color: var(--text-secondary); font-size: 18px; margin-left: 4px; cursor: pointer;"></i>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                                <div class="search-input" style="flex: 1; padding: 10px 16px;">
                                    <i class="bx bx-search"></i>
                                    <input type="text" placeholder="Search in preview..." style="width: 100%;">
                                </div>
                                <button class="btn btn-outline"><i class="bx bx-filter-alt"></i> Filter</button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="data-table" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>STATUS</th>
                                            <th>FULL NAME</th>
                                            <th>STUDENT ID</th>
                                            <th>DEPARTMENT</th>
                                            <th>YEAR</th>
                                            <th>EMAIL</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($previewData as $row): ?>
                                        <tr>
                                            <td>
                                                <?php if($row['status'] == 'valid'): ?>
                                                    <i class="bx bx-check-circle" style="color: var(--success); font-size: 18px;"></i>
                                                <?php else: ?>
                                                    <i class="bx bx-error-circle" style="color: var(--danger); font-size: 18px;"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="https://i.pravatar.cc/150?u=<?php echo urlencode($row['name']); ?>" style="width: 32px; height: 32px; border-radius: 50%;">
                                                    <div style="display: flex; flex-direction: column;">
                                                        <span style="font-weight: 600; <?php echo $row['status'] == 'error' ? 'color: var(--danger);' : ''; ?>"><?php echo explode(' ', $row['name'])[0]; ?></span>
                                                        <span style="font-weight: 600; <?php echo $row['status'] == 'error' ? 'color: var(--danger);' : ''; ?>"><?php echo implode(' ', array_slice(explode(' ', $row['name']), 1)); ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="font-weight: 500; color: var(--text-secondary);"><?php echo $row['id']; ?></td>
                                            <td><span style="background: var(--<?php echo str_replace('bg-', '', $row['deptBg']); ?>); color: var(--<?php echo str_replace('text-', '', $row['deptColor']); ?>); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600;"><?php echo str_replace(' ', '<br>', $row['dept']); ?></span></td>
                                            <td style="color: var(--text-secondary);"><?php echo str_replace(' ', '<br>', $row['year']); ?></td>
                                            <td style="<?php echo isset($row['emailClass']) ? 'color: var(--danger);' : 'color: var(--text-primary);'; ?> font-weight: 500;"><?php echo $row['email']; ?></td>
                                            <td><button style="border: none; background: transparent; color: var(--text-secondary); font-size: 18px; cursor: pointer;"><i class="bx bx-show"></i></button></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; font-size: 13px; color: var(--text-secondary);">
                                <span>Showing 1 to 5 of 150 records</span>
                                <div style="display: flex; gap: 4px; align-items: center;">
                                    <button style="border: none; background: transparent; padding: 4px; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-chevron-left" style="font-size: 18px;"></i></button>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: var(--primary); color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: transparent; color: var(--text-primary); border: none; font-weight: 500; cursor: pointer;">2</button>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: transparent; color: var(--text-primary); border: none; font-weight: 500; cursor: pointer;">3</button>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: transparent; color: var(--text-primary); border: none; font-weight: 500; cursor: pointer;">4</button>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: transparent; color: var(--text-primary); border: none; font-weight: 500; cursor: pointer;">5</button>
                                    <span>...</span>
                                    <button style="width: 28px; height: 28px; border-radius: 4px; background: transparent; color: var(--text-primary); border: none; font-weight: 500; cursor: pointer;">30</button>
                                    <button style="border: none; background: transparent; padding: 4px; color: var(--text-secondary); cursor: pointer;"><i class="bx bx-chevron-right" style="font-size: 18px;"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Middle Column (Validation & Templates) -->
                        <div style="flex: 1; display: flex; flex-direction: column; gap: 24px; min-width: 0;">
                            <div class="panel-dark">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                                    <i class="bx bx-check-shield" style="font-size: 20px;"></i>
                                    <h3 style="font-size: 16px; font-weight: 600;">Validation Summary</h3>
                                </div>
                                
                                <div class="summary-row">
                                    <div style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.8); font-size: 13px;">
                                        <i class="bx bx-box"></i> Total Records Detected
                                    </div>
                                    <div style="font-size: 16px; font-weight: 700;">150</div>
                                </div>
                                <div class="summary-row">
                                    <div style="display: flex; align-items: center; gap: 8px; color: #34d399; font-size: 13px;">
                                        <i class="bx bx-check-circle"></i> Ready to Import
                                    </div>
                                    <div style="font-size: 16px; font-weight: 700; color: #34d399;">142</div>
                                </div>
                                <div class="summary-row" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
                                    <div style="display: flex; align-items: center; gap: 8px; color: #f87171; font-size: 13px;">
                                        <i class="bx bx-error-circle"></i> Critical Errors
                                    </div>
                                    <div style="font-size: 16px; font-weight: 700; color: #f87171;">8</div>
                                </div>
                                
                                <div class="progress-circle">
                                    <svg>
                                        <circle class="bg" cx="60" cy="60" r="54"></circle>
                                        <circle class="progress" cx="60" cy="60" r="54"></circle>
                                    </svg>
                                    <div class="progress-text">
                                        <div style="font-size: 20px; font-weight: 700; color: white; line-height: 1;">94.7%</div>
                                        <div style="font-size: 10px; color: rgba(255,255,255,0.6); margin-top: 4px;">Valid Records</div>
                                    </div>
                                </div>
                                
                                <button style="width: 100%; background: var(--primary); color: white; border: none; border-radius: 8px; padding: 12px; font-size: 14px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer; margin-bottom: 12px; transition: background 0.2s;"><i class="bx bx-upload"></i> Import 142 Students</button>
                                <button style="width: 100%; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 12px; font-size: 14px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer; transition: background 0.2s;"><i class="bx bx-download"></i> Download Error Report</button>
                            </div>
                            
                            <div class="panel-white">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                    <h3 style="font-size: 14px; font-weight: 600;">Templates</h3>
                                    <a href="#" style="color: var(--primary); font-size: 12px; font-weight: 500;">View All</a>
                                </div>
                                <div style="display: flex; gap: 16px; align-items: flex-start; padding: 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                                    <div style="width: 40px; height: 40px; background: var(--info-light); color: var(--info); border-radius: 8px; display: flex; justify-content: center; align-items: center; font-size: 20px;"><i class="bx bx-file-blank"></i></div>
                                    <div style="flex: 1;">
                                        <h4 style="font-size: 13px; font-weight: 600; margin-bottom: 4px; color: var(--text-primary);">Institutional Template V2.4</h4>
                                        <p style="font-size: 11px; color: var(--text-secondary); margin-bottom: 8px;">Last updated 12 days ago</p>
                                        <span style="font-size: 11px; color: var(--success); background: var(--success-light); padding: 2px 8px; border-radius: 4px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;"><i class="bx bx-check-circle"></i> Recommended</span>
                                    </div>
                                </div>
                                <button style="width: 100%; background: var(--info-light); color: var(--primary); border: none; padding: 10px; border-radius: 8px; margin-top: 12px; font-size: 13px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer;"><i class="bx bx-download"></i> Download Again</button>
                            </div>
                            
                            <div class="error-alert">
                                <h4 style="font-size: 13px; font-weight: 600; color: #d97706; display: flex; align-items: center; gap: 8px; margin-bottom: 12px;"><i class="bx bx-error"></i> Common Validation Errors</h4>
                                <div style="margin-bottom: 12px;">
                                    <div style="font-size: 12px; font-weight: 600; color: #92400e; display: flex; align-items: flex-start; gap: 6px;"><i class="bx bx-error" style="color: #d97706; margin-top: 2px;"></i> Missing Student ID</div>
                                    <div style="font-size: 11px; color: #b45309; margin-left: 20px; margin-top: 2px;">Ensure every student has a unique institutional ID.</div>
                                </div>
                                <div>
                                    <div style="font-size: 12px; font-weight: 600; color: #92400e; display: flex; align-items: flex-start; gap: 6px;"><i class="bx bx-error" style="color: #d97706; margin-top: 2px;"></i> Invalid Email Format</div>
                                    <div style="font-size: 11px; color: #b45309; margin-left: 20px; margin-top: 2px;">Emails must follow 'username@institution.edu' protocol.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Import Log -->
            <div class="log-panel">
                <div class="log-header">
                    <span>Import Log</span>
                    <button style="border: none; background: transparent; cursor: pointer; color: var(--text-secondary); font-size: 18px;"><i class="bx bx-x"></i></button>
                </div>
                <div class="log-content">
                    <div class="log-success">
                        <i class="bx bx-check-circle" style="color: #10b981; font-size: 32px; margin-bottom: 8px; display: block;"></i>
                        <h3 style="font-size: 16px; font-weight: 600; color: #065f46; margin-bottom: 4px;">Success!</h3>
                        <p style="font-size: 12px; color: #047857;">142 records have been imported to Student Management.</p>
                        <div style="position: absolute; right: -10px; bottom: 10px; font-size: 60px; opacity: 0.3; transform: rotate(-15deg);">🎊</div>
                    </div>
                    
                    <h4 style="font-size: 13px; font-weight: 600; margin-bottom: 12px; color: var(--text-primary);">Detail Summary</h4>
                    <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                        <div style="flex: 1; border: 1px solid var(--border-color); border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="bx bx-building" style="color: var(--primary); font-size: 20px;"></i>
                            <div>
                                <div style="font-size: 10px; color: var(--text-secondary);">Department</div>
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">Comp. Science (45)</div>
                            </div>
                        </div>
                        <div style="flex: 1; border: 1px solid var(--border-color); border-radius: 8px; padding: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="bx bx-calendar" style="color: var(--primary); font-size: 20px;"></i>
                            <div>
                                <div style="font-size: 10px; color: var(--text-secondary);">Semester</div>
                                <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">Fall 2024</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h4 style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Operation Timeline</h4>
                        <span style="background: var(--success-light); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;"><i class="bx bxs-circle" style="font-size: 6px;"></i> Live</span>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="bx bx-check-circle timeline-icon"></i>
                            <div class="timeline-content">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Validation started</div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">14:20:05</div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">File structure analysis in progress...</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <i class="bx bx-check-circle timeline-icon"></i>
                            <div class="timeline-content">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">File integrity verified</div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">14:20:12</div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">CSV format validated successfully</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <i class="bx bx-check-circle timeline-icon"></i>
                            <div class="timeline-content">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Indexing new records</div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">14:20:18</div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">Preparing data for import...</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <i class="bx bx-check-circle timeline-icon"></i>
                            <div class="timeline-content">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Import completed</div>
                                    <div style="font-size: 11px; color: var(--text-secondary);">14:20:32</div>
                                </div>
                                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 2px;">142 records imported successfully</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 32px; margin-bottom: 12px; font-size: 13px; font-weight: 600; color: var(--text-primary);">Next Actions</div>
                    <div class="action-list">
                        <div class="action-item">
                            <div style="display: flex; align-items: center; gap: 10px; color: var(--text-primary);">
                                <i class="bx bx-user" style="color: var(--primary); font-size: 18px;"></i> View Imported Students
                            </div>
                            <i class="bx bx-right-arrow-alt" style="color: var(--text-secondary);"></i>
                        </div>
                        <div class="action-item">
                            <div style="display: flex; align-items: center; gap: 10px; color: var(--text-primary);">
                                <i class="bx bx-file" style="color: var(--primary); font-size: 18px;"></i> Generate Report
                            </div>
                            <i class="bx bx-right-arrow-alt" style="color: var(--text-secondary);"></i>
                        </div>
                        <div class="action-item">
                            <div style="display: flex; align-items: center; gap: 10px; color: var(--text-primary);">
                                <i class="bx bx-upload" style="color: var(--primary); font-size: 18px;"></i> Upload Another File
                            </div>
                            <i class="bx bx-right-arrow-alt" style="color: var(--text-secondary);"></i>
                        </div>
                    </div>
                    
                    <button style="width: 100%; background: var(--primary); color: white; border: none; border-radius: 8px; padding: 14px; font-size: 13px; font-weight: 600; margin-top: 24px; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer; transition: background 0.2s;"><i class="bx bx-check-circle"></i> Go to Student Management <i class="bx bx-right-arrow-alt"></i></button>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
