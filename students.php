<?php
// --- DUMMY DATA FOR DASHBOARD ---

$kpiCards = [
    [
        'title' => 'Total Students',
        'value' => '1,240',
        'trend' => '<i class="bx bx-up-arrow-alt"></i> 8.5%',
        'trendClass' => 'positive',
        'subtitle' => 'vs last month',
        'subtitleClass' => '',
        'icon' => 'bx-group',
        'iconColor' => 'icon-purple',
        'chartId' => 'chartTotalStudents'
    ],
    [
        'title' => 'Active Students',
        'value' => '1,102',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => '88.9% of total',
        'subtitleClass' => '',
        'icon' => 'bx-user-check',
        'iconColor' => 'icon-green',
        'chartId' => 'chartActiveStudents'
    ],
    [
        'title' => 'Departments',
        'value' => '12',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => 'Across all programs',
        'subtitleClass' => '',
        'icon' => 'bxs-bank',
        'iconColor' => 'icon-blue',
        'chartId' => 'chartDepartments'
    ],
    [
        'title' => 'On Probation',
        'value' => '38',
        'trend' => '',
        'trendClass' => '',
        'subtitle' => '3.1% of total',
        'subtitleClass' => '',
        'icon' => 'bx-user-x',
        'iconColor' => 'icon-orange',
        'chartId' => 'chartOnProbation'
    ]
];

$studentDirectory = [
    [
        'name' => 'Ethan Sterling',
        'class' => 'Class of 2025',
        'rollNo' => 'CS-2022-042',
        'dept' => 'Computer Science',
        'deptDot' => '#6366f1',
        'semester' => 'Semester 4',
        'email' => 'e.sterling@edu.com',
        'status' => 'Active',
        'statusClass' => 'badge-green',
        'avatar' => 'https://i.pravatar.cc/150?img=11'
    ],
    [
        'name' => 'Sophia Chen',
        'class' => 'Class of 2024',
        'rollNo' => 'BA-2021-118',
        'dept' => 'Business Admin',
        'deptDot' => '#f59e0b',
        'semester' => 'Semester 6',
        'email' => 's.chen89@edu.com',
        'status' => 'Active',
        'statusClass' => 'badge-green',
        'avatar' => 'https://i.pravatar.cc/150?img=5'
    ],
    [
        'name' => 'Marcus Thorne',
        'class' => 'Class of 2026',
        'rollNo' => 'EE-2023-009',
        'dept' => 'Electrical Eng.',
        'deptDot' => '#3b82f6',
        'semester' => 'Semester 2',
        'email' => 'm.thorne@edu.com',
        'status' => 'Probation',
        'statusClass' => 'badge-warning',
        'avatar' => 'https://i.pravatar.cc/150?img=12'
    ],
    [
        'name' => 'Olivia Bennett',
        'class' => 'Class of 2025',
        'rollNo' => 'CE-2022-154',
        'dept' => 'Civil Engineering',
        'deptDot' => '#10b981',
        'semester' => 'Semester 4',
        'email' => 'o.bennett@edu.com',
        'status' => 'Active',
        'statusClass' => 'badge-green',
        'avatar' => 'https://i.pravatar.cc/150?img=9'
    ],
    [
        'name' => 'Liam Patel',
        'class' => 'Class of 2024',
        'rollNo' => 'ME-2021-077',
        'dept' => 'Mechanical Eng.',
        'deptDot' => '#8b5cf6',
        'semester' => 'Semester 6',
        'email' => 'l.patel@edu.com',
        'status' => 'Active',
        'statusClass' => 'badge-green',
        'avatar' => 'https://i.pravatar.cc/150?img=15'
    ],
    [
        'name' => 'Ava Rodriguez',
        'class' => 'Class of 2025',
        'rollNo' => 'IT-2022-201',
        'dept' => 'Information Tech.',
        'deptDot' => '#ec4899',
        'semester' => 'Semester 4',
        'email' => 'a.rodriguez@edu.com',
        'status' => 'Active',
        'statusClass' => 'badge-green',
        'avatar' => 'https://i.pravatar.cc/150?img=20'
    ]
];

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management - EduAdmin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css?v=' . time() . '">
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
                <a href="students.php" class="menu-item active">
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
                    <input type="text" placeholder="Search faculty by name, ID, department, expertise...">
                    <span class="cmd-k">⌘ /</span>
                </div>
                <div class="topbar-right">
                    <button class="icon-btn" id="theme-toggle"><i class="bx bx-moon"></i></button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-bell"></i>
                        <span class="badge">7</span>
                    </button>
                    <button class="icon-btn has-badge">
                        <i class="bx bx-envelope"></i>
                        <span class="badge">3</span>
                    </button>
                    <div class="user-profile">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin User">
                        <div class="user-info">
                            <span class="user-name">Admin User</span>
                            <span class="user-role">System Administrator</span>
                        </div>
                        <i class="bx bx-chevron-down profile-chevron"></i>
                    </div>
                </div>
            </header>

            <!-- Page Header -->
            <div class="page-header" style="align-items: flex-start; flex-direction: column; gap: 16px;">
                <div class="page-title" style="margin-bottom: 0;">
                    <h1 style="display: flex; align-items: center; gap: 12px;">Student Management <span class="badge badge-purple-light" style="font-size: 13px; font-weight: 500;">1,240 Total Students</span></h1>
                    <p style="color: var(--text-secondary); margin-top: 8px; font-size: 14px;">Oversee academic records, track performance, and manage student information.</p>
                </div>
                <div class="page-actions" style="align-self: flex-end; margin-top: -45px;">
                    <button class="btn btn-outline" style="background: var(--bg-card);"><i class="bx bx-download"></i> Export Students</button>
                    <div class="split-btn">
                        <button class="btn btn-primary main-btn add-student-trigger"><i class="bx bx-plus"></i> Add Student</button>
                        <button class="btn btn-primary split-icon-btn"><i class="bx bx-chevron-down"></i></button>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- KPI Cards -->
                <div class="kpi-grid">
';

foreach($kpiCards as $card) {
    echo '
                    <div class="kpi-card">
                        <div class="kpi-card-content">
                            <div class="kpi-top">
                                <h3 class="kpi-title">' . $card['title'] . '</h3>
                                <div class="kpi-icon ' . $card['iconColor'] . '">
                                    <i class="bx ' . $card['icon'] . '"></i>
                                </div>
                            </div>
                            <div class="kpi-middle">
                                <div class="kpi-value-row">
                                    <span class="number">' . $card['value'] . '</span>';
    
    if($card['trend']) {
        echo '
                                    <span class="trend ' . $card['trendClass'] . '">' . $card['trend'] . '</span>';
    }
    
    echo '
                                </div>
                                <span class="kpi-subtitle ' . $card['subtitleClass'] . '">' . $card['subtitle'] . '</span>
                            </div>
                        </div>
                        <div class="kpi-chart">
                            <canvas id="' . $card['chartId'] . '"></canvas>
                        </div>
                        <div class="kpi-hover-panel">
                            <h5>' . $card['title'] . ' Breakdown</h5>
                            <div class="pie-container">
                                <canvas id="pie_' . $card['chartId'] . '"></canvas>
                            </div>
                        </div>
                    </div>
';
}

echo '
                </div>                <!-- Filters Row -->
                <div class="filters-row" style="display: flex; align-items: center; justify-content: space-between; background: var(--bg-card); padding: 16px 24px; border-radius: 12px; margin-bottom: 24px; border: 1px solid var(--border-color);">
                    <div class="filters-left" style="display: flex; align-items: center; gap: 16px;">
                        <button class="btn btn-outline" style="border-color: var(--border-color); color: var(--text-primary);"><i class="bx bx-filter"></i> Filters</button>
                        <select class="filter-select" style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; background: transparent; color: var(--text-secondary); outline: none;">
                            <option>All Departments</option>
                        </select>
                        <select class="filter-select" style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; background: transparent; color: var(--text-secondary); outline: none;">
                            <option>All Semesters</option>
                        </select>
                        <select class="filter-select" style="padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px; background: transparent; color: var(--text-secondary); outline: none;">
                            <option>Status: All</option>
                        </select>
                        <button class="btn btn-outline" style="border-color: var(--danger); color: var(--danger);"><i class="bx bx-trash"></i> Delete Selected</button>
                    </div>
                    <div class="filters-right">
                        <button class="btn btn-text" style="color: var(--text-secondary); background: transparent; border: none; display: flex; align-items: center; gap: 8px;"><i class="bx bx-refresh"></i> Clear all filters</button>
                    </div>
                </div>

                <!-- Student Directory Table -->
                <div class="card directory-card">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"><input type="checkbox"></th>
                                    <th>STUDENT</th>
                                    <th>ROLL NO</th>
                                    <th>DEPARTMENT</th>
                                    <th>SEMESTER</th>
                                    <th>EMAIL</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
';

foreach($studentDirectory as $student) {
    echo '
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="' . $student['avatar'] . '" alt="User">
                                            <div>
                                                <div class="name">' . $student['name'] . '</div>
                                                <div class="email" style="font-size: 12px; color: var(--text-secondary);">' . $student['class'] . '</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-secondary); font-size: 14px;">' . $student['rollNo'] . '</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: ' . $student['deptDot'] . ';"></span>
                                            <span style="color: var(--text-secondary); font-size: 14px;">' . $student['dept'] . '</span>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-secondary); font-size: 14px;">' . $student['semester'] . '</td>
                                    <td style="color: var(--text-secondary); font-size: 14px;">' . $student['email'] . '</td>
                                    <td><span class="status-dot dot-green" style="display: none;"></span><span class="badge ' . $student['statusClass'] . '"><i class="bx bxs-circle" style="font-size: 8px; margin-right: 4px;"></i> ' . $student['status'] . '</span></td>
                                    <td class="actions-cell">
                                        <button class="action-icon"><i class="bx bx-show"></i></button>
                                        <button class="action-icon"><i class="bx bx-edit-alt"></i></button>
                                        <button class="action-icon" style="color: var(--danger);"><i class="bx bx-trash"></i></button>
                                        <button class="action-icon"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    </td>
                                </tr>
';
}

echo '
                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        <div class="showing-entries">Showing 1 to 10 of 1,240 results</div>
                        <div class="pagination">
                            <button class="page-btn"><i class="bx bx-chevron-left"></i></button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <span class="page-dots">...</span>
                            <button class="page-btn">124</button>
                            <button class="page-btn"><i class="bx bx-chevron-right"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Add/Edit Student Side Panel -->
    <div id="studentSidePanel" class="side-panel">
        <div class="side-panel-overlay" id="closePanelOverlay"></div>
        <div class="side-panel-content">
            <div class="panel-header">
                <div>
                    <h2>Edit Student Profile</h2>
                    <p>Updating record for #CS-2022-042</p>
                </div>
                <button class="close-panel" id="closePanelBtn"><i class="bx bx-x"></i></button>
            </div>
            
            <form action="" method="POST" class="panel-form">
                <div class="panel-body">
                    <div class="profile-header">
                        <div class="profile-avatar-upload">
                            <img src="https://i.pravatar.cc/150?img=11" alt="Avatar">
                            <button type="button" class="upload-btn"><i class="bx bx-camera"></i></button>
                        </div>
                        <div class="profile-info">
                            <h3>Ethan Sterling</h3>
                            <p>Last updated: 2 days ago</p>
                        </div>
                    </div>

                    <div class="form-group-full">
                        <label>FULL NAME</label>
                        <input type="text" name="full_name" value="Ethan Sterling" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>ROLL NO</label>
                            <input type="text" name="roll_no" value="CS-2022-042" required>
                        </div>
                        <div class="form-group">
                            <label>DATE OF BIRTH</label>
                            <div class="date-input-wrapper">
                                <input type="text" name="dob" value="05/14/2003" required>
                                <i class="bx bx-calendar"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-full">
                        <label>INSTITUTIONAL EMAIL</label>
                        <input type="email" name="email_address" value="e.sterling@edu.com" required>
                    </div>

                    <div class="form-group-full">
                        <label>PHONE NUMBER</label>
                        <input type="text" name="phone_number" value="+1 (555) 012-3456" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>DEPARTMENT</label>
                            <div class="select-wrapper">
                                <select name="department" required>
                                    <option value="cs" selected>Computer Science</option>
                                    <option value="eng">Engineering</option>
                                    <option value="hum">Humanities</option>
                                </select>
                                <i class="bx bx-chevron-down select-icon"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>CURRENT SEMESTER</label>
                            <div class="select-wrapper">
                                <select name="semester" required>
                                    <option value="4" selected>Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                </select>
                                <i class="bx bx-chevron-down select-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="info-box">
                        <i class="bx bx-info-circle"></i>
                        <div class="info-content">
                            <h4>Academic Standing</h4>
                            <p>This student is currently in good standing. Changing the semester may trigger course enrollment requirements for the upcoming term.</p>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <button type="button" class="btn-cancel" id="cancelPanelBtn">Cancel</button>
                    <button type="submit" name="save_student" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
';
?>
